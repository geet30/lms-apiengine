<?php

namespace App\Repositories\Affiliate;


use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;

trait CommissionStructureMethods
{
    public static function getCommission($affiliate_id)
    {
        try {
            $affiliate = Affiliate::whereUserId(decryptGdprData($affiliate_id))->first();
            $user = $affiliate->user;

            $states = DB::table('states')->select('state_id', 'state_code')->get();

            $providers = [];
            $providers_enc = self::getProviders(1, decryptGdprData($affiliate_id));
            foreach ($providers_enc as $key => $provider) {
                $providers[$key]['id'] = $provider['provider_primary_id'];
                $providers[$key]['user_id'] = $provider['source_user_id'];
                $providers[$key]['name'] = $provider['name'];
            }
            $services = $user->services()->where('services.status', 1)->where('user_services.status', 1)->get()->toArray();

            return view('pages.affiliates.commission.list', compact('states', 'providers', 'services', 'affiliate'));
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public static function getCommissionAjax($request, $affiliate_id, $service_id)
    {
        try {
            $affiliate = Affiliate::whereUserId(decryptGdprData($affiliate_id))->first();
            $user = $affiliate->user;

            $provider_ids = [];
            if ($request->has('providers')) {
                foreach ($request->providers as $provider_id) {
                    $provider_ids[] = decryptGdprData($provider_id);
                }
            }

            $providers_enc = self::getProviders(1, decryptGdprData($affiliate_id), $service_id, $provider_ids);
            $providers = [];
            if (count($providers_enc)) {
                foreach ($providers_enc as $key => $provider) {
                    $providers[$key]['id'] = $provider['provider_primary_id'];
                    $providers[$key]['user_id'] = $provider['source_user_id'];
                    $providers[$key]['name'] = $provider['name'];
                }
            }

            $services = $user->services()->where('services.status', 1)->where('user_services.status', 1);
            if (!empty($service_id)) {
                $services = $services->where('services.id', $service_id);
            }
            $services = $services->get()->toArray();

            // filter commission
            if ($request->year) {
                if (date('Y') - 1 == $request->year) { // 1=previous_year, 2=current_year, 3=upcoming_year
                    $year = 1;                                // 1=previous_time, 2=current_time, 3=upcoming_time
                } else if (date('Y') == $request->year) {
                    $year = 2;
                } else {
                    $year = 3;
                }

                // $commission = $commission->where('year', $year);
            }

            if ($request->month) {
                // $commission = $commission->where('month', $request->month);
            }

            if ($request->state) {
                // $commission = $commission->where('state_id', $request->state);
            }

            if ($request->sale == 'both') {
                $sale = ['1' => 'Ret', '2' => 'Aq'];
            } elseif ($request->sale == 'aquisition') {
                $sale = ['2' => 'Aq'];
            } else {
                $sale = ['1' => 'Ret'];
            }

            if ($request->property == 'both') {
                $property = ['1' => 'Res', '2' => 'Bus'];
            } elseif ($request->property == 'residential') {
                $property = ['1' => 'Res'];
            } else {
                $property = ['2' => 'Bus'];
            }

            $energy_types = [
                ['service_title' => 'Electricity'],
                ['service_title' => 'Gas'],
                ['service_title' => 'LPG'],
            ];

            $rows = [];
            if (count($services)) {
                $add = false;
                // remove Energy
                foreach ($services as $key => $service) {
                    if ($service['id'] == 1) {
                        $add = true;
                        array_splice($services, $key, 1);
                    }
                }

                if ($add) {
                    $services = array_merge($services, $energy_types);
                }

                foreach ($services as $key => $service) {
                    foreach ($property as $property_type => $prop) {
                        $temp_data[ucfirst(substr(trim($service['service_title']), 0, 3)).'-'.$prop] = [];
                    }
                }

                foreach ($temp_data as $key => $d) {
                    foreach ($sale as $sale_type => $s) {
                        $temp_data1[$key.'-'.$s] = [];
                    }
                }

                $states = DB::table('states')->select('state_id', 'state_code');
                if ($request->state) {
                    $states = $states->where('state_id', $request->state);
                }
                $states = $states->get();
                foreach ($temp_data1 as $key => $value) {
                    foreach ($states as $s) {
                        $commission = DB::table('affiliate_commision_structure')
                            ->where(['user_id' => decryptGdprData($affiliate_id), 'service_id' => $service_id]);

                        if ($request->month) {
                            $commission = $commission->where('month', $request->month);
                        }

                        if ($request->state) {
                            $commission = $commission->where('state_id', $request->state);
                        }

                        $keys = explode('-', $key);
                        if ($add) {
                            if ($keys[0] == 'Ele') {
                                $commission = $commission->where('energy_type', '1');
                            } elseif ($keys[0] == 'Gas') {
                                $commission = $commission->where('energy_type', '2');
                            } elseif ($keys[0] == 'LPG') {
                                $commission = $commission->where('energy_type', '3');
                            }
                        }

                        if ($keys[1] == 'Res') {
                            $commission = $commission->where('property_type', '1');
                        } else {
                            $commission = $commission->where('property_type', '2');
                        }

                        if ($keys[2] == 'Aq') {
                            $commission = $commission->where('sale_type', '1');
                        } else {
                            $commission = $commission->where('sale_type', '2');
                        }
                        // $commission = $commission->where('state_id', $s->state_id)->get();
                        $rows[$key.'-'.trim(strtoupper($s->state_code))] = $commission->where('state_id', $s->state_id);
                    }
                }
            }

            return view('pages.affiliates.commission.components.ajax-table', compact('providers', 'rows'));
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public static function getProviders($realationType, $id, $serviceId = null, $providers = [])
    {
        $query = DB::table('assigned_users as au')
            ->selectRaw('au.*,services.service_title,assigned_users.first_name as aname,assigned_users.last_name as alname,providers.id as providerPrimaryID, providers.name,au.source_user_id,affiliates.company_name')
            ->leftJoin("services", "services.id", "=", "au.service_id")
            ->leftJoin("users as assigned_users", "assigned_users.id", "=", "au.assigned_by")
            ->leftJoin("affiliates", "affiliates.user_id", "=", "au.source_user_id")
            ->leftJoin("providers", "providers.user_id", "=", "au.relational_user_id")
            ->where('relation_type', $realationType)
            ->where('source_user_id', $id)
            ->where('providers.status', 1)
            ->where('au.status', 1);

        if (count($providers)) {
            $query->whereIn('providers.id', $providers);
        }

        if (!empty($serviceId)) {
            $query->where('au.service_id', $serviceId);
        }

        $query = $query->get()->toArray();
        return self::modifyProviderResult($query);
    }

    public static function modifyProviderResult($usersdata)
    {
        $data = [];
        foreach ($usersdata as $value) {
            $data[] = [
                'id'                  => encryptGdprData($value->id),
                'provider_primary_id' => encryptGdprData($value->providerPrimaryID),
                'source_user_id'      => encryptGdprData($value->source_user_id),
                'name'                => ucfirst($value->name),
                'assignedby'          => ucfirst(decryptGdprData($value->aname)).' '.ucfirst(decryptGdprData($value->alname)),
                'rolename'            => 'Provider',
                'service'             => $value->service_title,
                'created'             => $value->created_at,
                'servive_id'          => encryptGdprData($value->service_id),
                'relationaluser'      => encryptGdprData($value->relational_user_id),
                'status'              => $value->status,
                'company_name'        => $value->company_name,
            ];
        }
        return $data;
    }

    public static function addCommission($request, $affiliate_id, $service_id)
    {
        \DB::beginTransaction();
        try {
            if (date('Y') - 1 == $request->year) { // 1=previous_year, 2=current_year, 3=upcoming_year
                $year = 1;                                // 1=previous_time, 2=current_time, 3=upcoming_time
                $commission_time = 1;
            } else if (date('Y') == $request->year) {
                $year = 2;
                if (date('m') > $request->month) {
                    $commission_time = 1;
                } elseif (date('m') == $request->month) {
                    $commission_time = 2;
                } else {
                    $commission_time = 3;
                }
            } else {
                $year = 3;
                $commission_time = 3;
            }

            $data = [
                'user_id'         => decryptGdprData($request->affiliate_id),
                'service_id'      => $service_id,
                'commission_time' => $commission_time,
                'year'            => $year,
                'month'           => $request->month,
                'comment'         => $request->comment,
                'created_by'      => auth()->id(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];

            $states = DB::table('states')->get();

            foreach ($request->providers as $provider) {
                foreach ($states as $state) {
                    if ($request->service_id == 1) { // 1=energy // 1=electricity, 2=gas, 3=lpg // 1=residential, 2=business // 1=retension, 2=aquisition
                        $electricity['1']['1'] = $request->get('Ele-Res-Ret');
                        $electricity['1']['2'] = $request->get('Ele-Res-Aq');
                        $electricity['2']['1'] = $request->get('Ele-Bus-Ret');
                        $electricity['2']['2'] = $request->get('Ele-Bus-Aq');

                        $gas['1']['1'] = $request->get('Gas-Res-Ret');
                        $gas['1']['2'] = $request->get('Gas-Res-Aq');
                        $gas['2']['1'] = $request->get('Gas-Bus-Ret');
                        $gas['2']['2'] = $request->get('Gas-Bus-Aq');

                        $lpg['1']['1'] = $request->get('LPG-Res-Ret');
                        $lpg['1']['2'] = $request->get('LPG-Res-Aq');
                        $lpg['2']['1'] = $request->get('LPG-Bus-Ret');
                        $lpg['2']['2'] = $request->get('LPG-Bus-Aq');

                        foreach ($electricity as $property_type => $value) {
                            foreach ($value as $sale_type => $amount) {
                                $data_electricity = [
                                    'state_id'      => $state->state_id,
                                    'provider_id'   => decryptGdprData($provider),
                                    'energy_type'   => 1, // 1=electricity, 2=gas, 3=lpg
                                    'property_type' => $property_type, // 1=residential, 2=business
                                    'sale_type'     => $sale_type, // 1=retension, 2=aquisition
                                    'amount'        => $amount,
                                ];
                                DB::table('affiliate_commision_structure')->insert(array_merge($data, $data_electricity));
                            }
                        }

                        foreach ($gas as $property_type => $value) {
                            foreach ($value as $sale_type => $amount) {
                                $data_gas = [
                                    'state_id'      => $state->state_id,
                                    'provider_id'   => decryptGdprData($provider),
                                    'energy_type'   => 2, // 1=electricity, 2=gas, 3=lpg
                                    'property_type' => $property_type, // 1=residential, 2=business
                                    'sale_type'     => $sale_type, // 1=retension, 2=aquisition
                                    'amount'        => $amount,
                                ];
                                DB::table('affiliate_commision_structure')->insert(array_merge($data, $data_gas));
                            }
                        }

                        foreach ($lpg as $property_type => $value) {
                            foreach ($value as $sale_type => $amount) {
                                $data_lpg = [
                                    'state_id'      => $state->state_id,
                                    'provider_id'   => decryptGdprData($provider),
                                    'energy_type'   => 3, // 1=electricity, 2=gas, 3=lpg
                                    'property_type' => $property_type, // 1=residential, 2=business
                                    'sale_type'     => $sale_type, // 1=retension, 2=aquisition
                                    'amount'        => $amount,
                                ];
                                DB::table('affiliate_commision_structure')->insert(array_merge($data, $data_lpg));
                            }
                        }
                    }

                    if ($request->service_id == 2) { // 2=mobile
                        $mobile['1']['1'] = $request->get('Mob-Res-Ret');
                        $mobile['1']['2'] = $request->get('Mob-Res-Aq');
                        $mobile['2']['1'] = $request->get('Mob-Bus-Ret');
                        $mobile['2']['2'] = $request->get('Mob-Bus-Aq');

                        foreach ($mobile as $property_type => $value) {
                            foreach ($value as $sale_type => $amount) {
                                $data_lpg = [
                                    'state_id'      => $state->state_id,
                                    'provider_id'   => decryptGdprData($provider),
                                    'property_type' => $property_type, // 1=residential, 2=business
                                    'sale_type'     => $sale_type, // 1=retension, 2=aquisition
                                    'amount'        => $amount,
                                ];
                                DB::table('affiliate_commision_structure')->insert(array_merge($data, $data_lpg));
                            }
                        }
                    }

                    if ($request->service_id == 3) { // 3=broadband
                        $broadband['1']['1'] = $request->get('Mob-Res-Ret');
                        $broadband['1']['2'] = $request->get('Mob-Res-Aq');
                        $broadband['2']['1'] = $request->get('Mob-Bus-Ret');
                        $broadband['2']['2'] = $request->get('Mob-Bus-Aq');

                        foreach ($broadband as $property_type => $value) {
                            foreach ($value as $sale_type => $amount) {
                                $data_lpg = [
                                    'state_id'      => $state->state_id,
                                    'provider_id'   => decryptGdprData($provider),
                                    'property_type' => $property_type, // 1=residential, 2=business
                                    'sale_type'     => $sale_type, // 1=retension, 2=aquisition
                                    'amount'        => $amount,
                                ];
                                DB::table('affiliate_commision_structure')->insert(array_merge($data, $data_lpg));
                            }
                        }
                    }
                }
            }

            \DB::commit();
            return response()->json(['status' => '1', 'message' => 'Commission added successfully'], 200);
        } catch
        (\Exception $err) {
            \DB::rollback();
            return response()->json(['status' => '0', 'message' => 'Unable to add commission.', 'exception' => $err->getMessage()], 500);
        }
    }
}

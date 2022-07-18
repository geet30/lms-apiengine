<?php

namespace App\Traits\Provider;

use Carbon\Carbon;
use App\Repositories\SparkPost\NodeMailer;
use Illuminate\Support\Facades\{View, DB};
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\{Storage};
use App\Models\{ApiResponse, ProviderSftp, SaleProductsEnergy, ProviderSaleEmail, MoveInCalender};

trait SchemaMethods
{
    public $isTest = false;
    /**
     * Common provider method for all providers.
     * Author: Sandeep Bangarh
     * @param  array  $data
     * @param  mixed  $leadId
     * @return \Illuminate\Http\JsonResponse
     */
    function sendProviderLeads($data, $leadId = null)
    {   

        if ($leadId) {
            DB::select("set @where_clause='where l.lead_id = $leadId'");
            $this->isTest = true;
        } else {
            $currentTime = date('H:i:s'); // current time
            $perviousTime = date('H:i:s', strtotime('-10 minutes +1 minutes'));
            // ['time', '>=', $perviousTime],['time', '<=', $currentTime],['sale_submission_type', $data['saleSubmissionType']]
            $emailData = ProviderSaleEmail::getData([['time', '>=', $perviousTime], ['time', '<=', $currentTime], ['sale_submission_type', $data['saleSubmissionType']]], ['provider_id']);
            $providerIds = array_column($emailData->toArray(), 'provider_id');
            $providerIds = [124];

            if (empty($providerIds)) {
                return response()->json(['success' => true, 'error' => 'Not able to find provider in given time']);
            }
            $providerIdsString = implode(',', $providerIds);
            DB::select("set @where_clause='where spe.provider_id in ($providerIdsString) '");
        }

        $data['isTest'] = $this->isTest;

        DB::select("set @SL=0");
        DB::select("set @NOR=1000");
        $providerLeads = DB::select('call GetProvidersLeads(@where_clause , @SL, @NOR)');

        $providerLeadsArray = collect($providerLeads)->unique('sale_product_id')->groupBy('sale_product_provider_id');
        $isOk = false;
        
        foreach ($providerLeadsArray as $providerId => $providerLeads) {
            // $providerId = 124;
            switch ($providerId) {
                case config('env.ALINTA_ID'):
                    $isOk = $this->alintaEnergySchema($providerLeads, $data);
                    break;
                case config('env.ACTEWAGL_ID'):
                    $isOk = $this->actewAglSchema($providerLeads, $data);
                    break;
                case config('env.FIRSTENERGY_ID'):
                    $isOk = $this->firstEnergySchema($providerLeads, $data);
                    break;
                case config('env.SUMOPOWER_ID'):
                    $isOk = $this->sumoPowerSchema($providerLeads, $data);
                    break;
                case config('env.SIMPLYENERGY_ID'):
                    $isOk = $this->simplyEnergySchema($providerLeads, $data);
                    break;
                case config('env.MOMENTUMENERGY_ID'):
                    $isOk = $this->momentumEnergySchema($providerLeads, $data);
                    break;
                case config('env.AGL_ID'):
                    $isOk = $this->AGLSchema($providerLeads, $data);
                case config('env.TANGO_ID'):
                    $isOk = $this->tangoSchema($providerLeads, $data);
                    break;
                case config('env.ENERGYLOCALS_ID'):
                    $isOk = $this->energyLocalsSchema($providerLeads, $data);
                    break;
                case config('env.BLUENRG_ID'):
                    $isOk = $this->BlueNRGSchema($providerLeads, $data);
                    break;
                case config('env.DODOENERGY_ID'):
                    $isOk = $this->dodoRetailerSchema($providerLeads, $data);
                    break;
                case config('env.ENERGY_AUSTRALIA'):
                    $isOk = $this->energyAustraliaSchema($providerLeads, $data);
                    break;
                case config('env.POWERSHOP'):
                    $isOk = $this->powerShopSchema($providerLeads, $data);
                    break;
                default:
                    # code...
                    break;
            }
        }
        if ($isOk) {
            return response()->json(['success' => true, 'message' => 'Schema sent successfully']);
        }

        return response()->json(['success' => false, 'error' => 'Something went wrong'], 400);
    }

    /**
     * Common provider method for generate excel, storing excel in s3, upload file via ftp and send email.
     * Author: Sandeep Bangarh
     * @return boolean
     */
    public function finalizeCaf($providerLead, $fileName, $data, $headings)
    {
        $path = $this->getDirectory($data);
        $excel = Excel::store($headings, $path . '/' . $fileName);

        if ($excel) {
            $fileFullPath = storage_path('app/' . $path . '/' . $fileName);
            Storage::disk('s3')->put($path . '/' . $fileName, file_get_contents($fileFullPath), 'private');
            $data['fileName'] = $fileName;
            $emailData = ProviderSaleEmail::getData(['provider_id' => $providerLead->sale_product_provider_id], '*');

            if ($providerLead->p_sftp_enable == 1) {
                $sftpData = ProviderSftp::getData($providerLead->sale_product_provider_id);
                $this->uploadFileOnSftp($sftpData, $fileFullPath, $fileName, $data['providerName']);
            }
            $isSent = $this->sendEmail($data, $fileFullPath, $emailData);
            if ($isSent) {
                if (!$this->isTest) {
                    SaleProductsEnergy::updateData(['lead_id' => $providerLead->l_lead_id], ['schema_status' => 1]);
                }

                return true;
            }
        }
        return false;
    }

    /**
     * Create directory locally and on s3 bucket with defined structure.
     * Author: Sandeep Bangarh
     * @return string
     */
    public function getDirectory($data)
    {
        $directoryArr = [];
        $directoryArr['year'] = Carbon::now()->format('Y'); //year
        $directoryArr['month'] = Carbon::now()->format('m'); //month
        $directoryArr['date'] = Carbon::now()->format('d'); //date
        $directoryArr['provider'] = trim(strtolower(str_replace(' ', '_', $data['providerName']))); //provider name
        $directoryArr['sale_submission_type'] = $data['saleSubmissionType']; //for COR,Solar_COR, Moving,Solar_moving
        $directoryArr['sale_type'] = strtolower($data['requestType']); //submit=fulfillment,resubmit=resubmission

        $directoryArr['file_type'] = 'file_conslidate';
        if ($data['mailType'] == 'test') {
            $directoryArr['file_type'] = 'manual';
            if ($data['referenceNo'] != '') {
                $directoryArr['refrence_number'] = $data['referenceNo'];
            }
        }
        $directoryArr['timestamp'] = date('H_i_s') . '_' . Carbon::now()->timestamp;
        $dirPath = 'provider_schema';

        foreach ($directoryArr as  $value) {
            $dirPath = $dirPath . '/' . $value;
        }

        return $dirPath;
    }

    /**
     * Get file name offset for different types of CAF.
     * Author: Sandeep Bangarh
     * @return integer
     */
    public function getFileNameOffset($saleType = null, $saleSubmissionType = null)
    {
        if ($saleType == 'Fulfilment' && $saleSubmissionType == 'solar_moving')
            return 1;
        elseif ($saleType == 'Resubmission' && $saleSubmissionType == 'solar_moving')
            return 2;
        elseif ($saleType == 'Fulfilment' && $saleSubmissionType == 'solar_cor')
            return 3;
        elseif ($saleType == 'Resubmission' && $saleSubmissionType == 'solar_cor')
            return 4;
        elseif ($saleType == 'Fulfilment' && $saleSubmissionType == 'moving')
            return 5;
        elseif ($saleType == 'Resubmission' && $saleSubmissionType == 'moving')
            return 6;
        elseif ($saleType == 'Fulfilment' && $saleSubmissionType == 'cor')
            return 7;
        else
            return 8;
    }

    /**
     * Send mail using Node sparkpost module.
     * Author: Sandeep Bangarh
     * @return boolean
     */
    public function sendEmail($providerData, $filePath, $emailData)
    {
        $html = View::make('emails.welcome_mail.providersale', $providerData)->render();
        $ccEmails = $bccEmails = $toEmails = [];
        foreach ($emailData as $emailD) {
            if ($emailD->cc_emails) {
                array_push($ccEmails, $emailD->cc_emails);
            }
            if ($emailD->bcc_emails) {
                array_push($bccEmails, $emailD->bcc_emails);
            }
            if ($emailD->to_emails) {
                array_push($toEmails, $emailD->to_emails);
            }
        }
        $mailData = [];
        $mailData['text'] = '';
        $mailData['from_email'] = 'support@cimet.com.au';
        $mailData['from_name'] = 'CIMET Support Team';
        $mailData['service_id'] = 1;
        $mailData['subject'] = str_replace('_', ' ', $providerData['subject']);
        $mailData['cc_mail'] = $ccEmails;
        $mailData['bcc_mail'] = $bccEmails;
        $mailData['html']  = $html;
        $mailData['user_email'] = !empty($toEmails) ? $toEmails[0] : '';

        if (isset($providerData['toEmail'])) {
            $mailData['user_email'] = $providerData['toEmail'];
        }

        $attachMents = [];
        $extension = File::extension($filePath);
        $fileTypes = [
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'csv' => 'text/csv'
        ];
        $csvFile = file_get_contents($filePath);
        array_push($attachMents, (object) ['name' => $providerData['fileName'], 'type' => $fileTypes[$extension], 'data' => base64_encode($csvFile)]);
        $mailData['attachments'] = $attachMents;

        $nodeMailer = new NodeMailer();
        $response  = $nodeMailer->sendMail($mailData, true);
        /** Create API responses **/
        $this->createResponse($providerData['leadIds'], $response, $toEmails, $providerData['providerName'], $providerData['fileName']);
        if ($response && $response->getStatusCode() == 200) {
            unlink($filePath);
            return true;
        }

        return false;
    }

    /**
     * Convert comma seperated emails into array.
     * Author: Sandeep Bangarh
     * @return array
     */
    public function explodeMultipleEmailAddress($emails)
    {
        $mailAddress[] = $emails;
        if (strpos($emails, ',') !== false) {
            $explodeRegularEmails = explode(',', $emails);

            $mailAddress = [];
            foreach ($explodeRegularEmails as $explodeRegularEmail) {
                $mailAddress[] = $explodeRegularEmail;
            }
        }
        return $mailAddress;
    }

    /**
     * Upload file on SFTP.
     * Author: Sandeep Bangarh
     * @return array
     */
    public function uploadFileOnSftp($sftps, $filePath, $fileName, $providerName)
    {
        if (!$sftps->isEmpty()) {
            foreach ($sftps as $v) {
                $logFileName = '';
                $arr = [];

                $arr = [
                    'host' => $v->remote_host,
                    'port' => $v->port ? $v->port : 22,
                    'username' => $v->username,
                    'password' => base64_decode($v->password),
                    'root' => $v->directory ? $v->directory : '/',
                    'timeout' => $v->timeout ? $v->timeout : 30
                ];
                $logFileName = 'sftp_file_' . str_replace(' ', '_', $v->destination_name) . '_' . date('Y-m-d') . '.log';

                try {
                    $adapter = new Adapter($arr);
                    $adapter->connect();

                    if ($adapter->isConnected()) {
                        $filesystem = new Filesystem($adapter);
                        $res = $filesystem->put($fileName, file_get_contents($filePath . '/' . $fileName));
                        \Log::info($res);
                        \Log::info('Provider is: ' . $providerName);
                        $adapter->disconnect();
                    }
                } catch (\Exception $e) {
                    \Log::info($filePath . $logFileName . '  Status:' . $e->getMessage() . ' : in sftp upload. Provider is: ' . $providerName);
                }
            }
        }
    }

    /**
     * Get last business day.
     * Author: Sandeep Bangarh
     * @return array
     */
    public function getLastBusinessDay($state, $moving_date)
    {
        //get all national holidays and selected state holidays also
        $holidays = MoveInCalender::where('holiday_type', 'national')
            ->orWhere(function ($q) use ($state) {
                $q->where('holiday_type', 'state')
                    ->where('state', trim($state));
            })
            ->pluck('date');

        //enter here if current time not passed the master closing time
        $sub_days = Carbon::createFromFormat('d/m/Y', $moving_date);
        $last_selectable_date = $sub_days->toDateString();

        //keep on checking for holiday
        $sub_day = 1;
        $required_sub_days = 0;

        while ($required_sub_days < 2) {
            //if min selectable date is a holiday add 1 more day
            if (in_array($last_selectable_date, $holidays->toArray()) || $sub_days->isWeekend()) {
                $sub_day++;
            } else {
                $sub_day++;
                $required_sub_days++;
            }

            if ($required_sub_days < 2) {
                $time_now = Carbon::createFromFormat('d/m/Y', $moving_date);
                $sub_days = $time_now->subDays($sub_day - 1);
                $last_selectable_date = $sub_days->toDateString();
            }
        }
        $last_selectable_date = $sub_days->format('d/m/Y');

        return $last_selectable_date;
    }

    /**
     * Create response or logs for emails.
     * Author: Sandeep Bangarh
     * @return array
     */
    function createResponse($leadIds, $response, $sentTo, $providerName, $fileName, $test = false)
    {
        if (!$response) return false;
        $apiResponse = [];
        $currentTime = Carbon::now();
        $content = $response->getBody();
        $currDate = $currentTime->toDateTimeString();

        $message = 'Schema sent successfully';
        if ($response->getStatusCode() != 200) {
            $message = 'Something went wrong with mail, please look into API response';
        }
        $api_reference = 'Something went wrong';
        if ($response->getStatusCode() == 200) {
            $content = json_decode($content);
            $content->filename = $fileName;
            $content->sentTo = $sentTo;
            $api_reference = $content->data->results->id;
            $content = json_encode($content);
        }
        $api_name = 'Cron Sale schema (' . $providerName . ')';
        if ($test) {
            $api_name = 'Manual Sale schema (' . $providerName . ')';
        }
        foreach (array_unique($leadIds) as $leadId) {
            $apiRes = ['lead_id' => $leadId, 'api_name' => $api_name, 'api_reference' => $api_reference, 'response_text' => $content, 'api_response' => $content, 'message' => $message, 'created_at' => $currDate, 'api_request' => json_encode(app('request')->all()), 'service_id' => 1];
            array_push($apiResponse, $apiRes);
        }
        ApiResponse::insert($apiResponse);
    }
}

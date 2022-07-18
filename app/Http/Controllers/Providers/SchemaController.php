<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{Providers, Lead};

class SchemaController extends Controller
{

    /**
     * @var object
     */
    protected $provider;

    public function __construct(Providers $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Send provider movein sale schema.
     * @return mixed
     */
    public function sendProviderMoveInSaleSchema()
    {
        try {
            $data = [];
            $data['saleSubmissionType'] = 'moving';
            $data['salesType'] = 'moving';
            $data['movingHouse'] = "yes";
            return $this->provider->sendProviderLeads($data);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 400;
            $result = [
                'exception_message' => $e->getMessage() . ' on line: ' . $e->getLine() . ' in file: ' . $e->getFile()
            ];
            echo response()->json($result, $status);
        }
    }

    /**
     * Send provider cor sale schema.
     * @return mixed
     */
    public function sendProviderCorSaleSchema()
    {
        try {
            $data = [];
            $data['saleSubmissionType'] = 'cor';
            $data['salesType'] = 'cor';
            $data['movingHouse'] = "no";
            return $this->provider->sendProviderLeads($data);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 400;
            $result = [
                'exception_message' => $e->getMessage() . ' on line: ' . $e->getLine() . ' in file: ' . $e->getFile()
            ];
            echo response()->json($result, $status);
        }
    }

    /**
     * Send schema manually.
     * Author: Sandeep Bangarh
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $leadId
     * @return mixed
     */
    public function sendSchema(Request $request, $leadId)
    {
         
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        
        $leadData = Lead::getProductData(['leads.lead_id' => $leadId], ['moving_house'], true);

        $data = [];
        $isMoving = ($leadData && $leadData->moving_house);
        $data['saleSubmissionType'] = $isMoving?'moving':'cor';
        $data['salesType'] = $isMoving?'moving':'cor';
        $data['movingHouse'] = $isMoving?'yes':'no';
        $data['toEmail'] = $request->email;
        return $this->provider->sendProviderLeads($data, $leadId);
    }
}

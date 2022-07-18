<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Repositories\Address\GetAddressDetail;

class SearchAddressController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addressRepository = new GetAddressDetail();
    }



    public function searchAddress(Request $request){
       try{

            $result = $this->addressRepository->searchAddressDetails($request->address);
            if (empty($result)) {
                return response()->json(['status' => 400, 'message' => trans('affiliates.addressempty')]);
            }
           
            return response()->json(['status' => 200, 'result' => $result]);
        }
        catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    
    
}

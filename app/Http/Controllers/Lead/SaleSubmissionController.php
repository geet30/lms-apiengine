<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lead\SaleSubmissions\EA\EASaleSubmissionRepo;
use App\Repositories\Lead\SaleSubmissions\Ovo\OvoRepository;
use App\Repositories\Lead\SaleSubmissions\Powershop\FluxRepository;
use App\Repositories\Lead\SaleSubmissions\RedAndLumo\RLSaleSubmission;
use  App\Repositories\Lead\SaleSubmissions\origin\originSubmission;

class SaleSubmissionController extends Controller
{
    function postChangeLeadStatus(Request $request)
    {
        // $energyObj = new EASaleSubmissionRepo;
        // $response = $energyObj->submitEASale($request,'gas');

        // $ovoObj = new OvoRepository;
        // $response = $ovoObj->setDataForOvoApi(370, 'gas', 5, true, 5,'leads');

        $fluxObj = new FluxRepository;
        $response = $fluxObj->getFluxData(370, 'both', 'leads');
        $energyObj = new EASaleSubmissionRepo;
        $response = $energyObj->submitEASale($request, 'gas');
        return $response;
    }
    function postRLSubmission(Request $request)
    {
        $obj = new originSubmission;
        $response = $obj->getCSRFToken('dev');
        return $response;
        // $energyObj = new RLSaleSubmission;
        // $response = $energyObj->submitData('370', 'single', 'energy');
        // return $response;
    }
}

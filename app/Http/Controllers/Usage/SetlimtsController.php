<?php

namespace App\Http\Controllers\Usage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Usage\UsageRequest;
use App\Models\{Suburbusagelimits};

class SetlimtsController extends Controller
{
    public function index(){
        $result = Suburbusagelimits::getUsage();
        return view('pages.usagelimits.list',compact('result'));
    }

    public function store(UsageRequest $request){
        return Suburbusagelimits::add($request);
    }

    public function updateUsage(UsageRequest $request){
        return Suburbusagelimits::updateUsageData($request);
    }

    public function searchUsageData(Request $request){
        return Suburbusagelimits::getUsage($request->usagetype);
    }
}

<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\ExportSettingRequest;
use App\Repositories\Settings\ExportSetting\Basic;
use App\Models\{
    Tag,
};
use DB;

class ExportSettingsController extends Controller
{
    public function index(){
        $saleExportData=$this->getExportSaleData();
      
        $exportSettingData=array_column($saleExportData->toArray(),'value','key');

        return view('pages.settings.export-settings.index',compact('exportSettingData'));
    }

    public function resetLeadSaleExportPassword(ExportSettingRequest $request){
        return Basic::updateLeadSalePassword($request);
    }
    public function getExportSaleData(){
        return Basic::getExportSaleData();
    }
}
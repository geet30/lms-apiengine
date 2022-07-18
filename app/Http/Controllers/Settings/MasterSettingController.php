<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller; 

class MasterSettingController extends Controller
{
    /**
     * upload plans.
     *
      * @return \Illuminate\View\View
     */
    public function getSettings(){ 
        return view('pages.settings.master-settings.index');
     }
}

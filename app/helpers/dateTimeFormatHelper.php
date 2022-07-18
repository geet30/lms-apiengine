<?php
use Carbon\Carbon;
if (!function_exists('dateTimeFormat')) {

    function dateTimeFormat($dateTime)
    {
        return Carbon::parse($dateTime)->format('d/m/Y H:i:s');
    }
  }

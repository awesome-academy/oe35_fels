<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('customDateFormat')) {
    function customDateFormat($value)
    {
        $locale = Session::has('locale') ? Session::get('locale') : app()->getLocale();

        if ($locale == config('const.locale.vi')) {
            return \Carbon\Carbon::parse($value)->format('H:i d-m-Y');
        }

        return \Carbon\Carbon::parse($value)->format('H:i m-d-Y');
    }
}

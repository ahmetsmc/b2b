<?php

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return \App\Services\Facades\Settings::get($key, $default);
    }
}

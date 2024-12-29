<?php

use Illuminate\Support\Facades\File;


if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return \App\Services\Facades\Settings::get($key, $default);
    }
}

if (!function_exists('modelToSelectComponentOptions')) {
    function modelToSelectComponentOptions($model, $key, $label)
    {
        $options = [];

        foreach ($model as $item) {
            if ($item->$key && $item->$label) {
                $options[$item->$key] = $item->$label;
            }
        }

        return $options;
    }
}

if (!function_exists('checkAndCreateFolder')) {
    function checkAndCreateFolder($dir)
    {
        if (!File::exists(public_path('storage' . DIRECTORY_SEPARATOR . $dir))) {
            File::makeDirectory(public_path('storage' . DIRECTORY_SEPARATOR . $dir), 0755, true);
        }
    }
}

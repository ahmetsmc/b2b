<?php

namespace App\Services\Repositories;

use App\Models\Setting;

class SettingRepository
{
    protected array $cache = [];

    public function get($key, $default = null)
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $setting = Setting::where('key', $key)->first();
        $this->cache[$key] = $setting ? $setting->value : $default;

        return $this->cache[$key];
    }

    public function set($key, $value)
    {
        $setting = Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        $this->cache[$key] = $value;

        return $setting;
    }

    public function all()
    {
        return Setting::pluck('value', 'key')->toArray();
    }
}

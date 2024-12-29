<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasUpload
{
    public function uploadFile($file, $dir): ?string
    {
        $dir = $this->normalizePath($dir);

        checkAndCreateFolder($dir);

        $fileName = date('YmdHi') . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        return $this->normalizePath($file->storeAs($dir, $fileName, 'public'), true);
    }

    public function normalizePath($path, $readableLink = false): string|null
    {
        return $readableLink
            ? preg_replace('/\\\\/', '/', $path)
            : str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $path);
    }
}

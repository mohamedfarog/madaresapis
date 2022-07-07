<?php

namespace App\Traits;

trait fileUpload
{
    public function uploadFile($file, $path = "files")
    {
        if ($file) {
            $path = $file->store('public/' . $path);
            $name = $file->getClientOriginalName();
            $filePath = "/storage/" . explode("public/", $path)[1];
            return $filePath;
        }
    }
}

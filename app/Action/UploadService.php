<?php
namespace App\Action;

use App\Models\Upload;
use Illuminate\Http\UploadedFile;

Class UploadService 
{
    
    public function execute(UploadedFile $file, string $basepath)
    {
        $file->store($basepath, 'public');
        return Upload::create(['url' => $basepath . $file->hashName()]);
    }
}
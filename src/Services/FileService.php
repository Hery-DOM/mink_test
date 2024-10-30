<?php

namespace App\Services;

class FileService
{
    public function removeFile(string $path)
    {
        if(is_dir($path)){
            foreach(scandir($path) as $f){
                $this->removeFile($path."/".$f);
            }
        }else{
            if(file_exists($path)){
                unlink($path);
            }
        }
    }

}
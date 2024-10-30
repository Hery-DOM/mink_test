<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileService extends AbstractController
{

    const CONTSTRAINTS_SIZE = 3;

    const CONSTRAINTES_TYPE = ["image/jpeg","image/png"];


    public function __construct(
        private readonly SecureInputService $secureInputService
    )
    {
    }

    public function removeFile(string $path)
    {

        if(is_dir($path)){
            foreach(scandir($path) as $f){
                if($f === "." || $f === "..") continue;
                $this->removeFile($path."/".$f);
            }

            rmdir($path);
        }else{
            if(file_exists($path)){
                unlink($path);
            }
        }

    }


    public function saveFile($entity): array
    {
        $destinatonPath = $this->getParameter("animal_media")."/animal-".$entity->getId();

        /** Create directory for entity **/
        $this->createDirectory($destinatonPath);

        /** Get $_FILES **/
        $files = $this->secureInputService->secureArray($_FILES);
        $files = $this->reorganization($files);
        $newNamesPictures = [];

        foreach($files as $f){
            if(!$this->checkMedia($f)){
                continue;
            }

            /** Secure and uniq name **/
            $newName = SecureInputService::safeName($f["name"]);
            $newNamesPictures[] = $newName;

            /** Try to move the file **/
            try {
                $move = move_uploaded_file($f["tmp_name"],$destinatonPath."/".$newName);

                if(!$move){
                    throw new FileException();
                }

            } catch (FileException $e) {
                // ... catch FileException $e
                return [false,"L'image n'a pas pu être enregistrée"];
            }


            /** Copy to mini **/
            $this->resizeAbsolute(
                $newName,
                $destinatonPath,
                $destinatonPath,
                600,
                "mini-".$newName
            );


            /** Copy original + mini in webp **/
            foreach(scandir($destinatonPath) as $pic){
                $this->imgToWebp(
                    $destinatonPath."/".$pic,
                    $destinatonPath
                );
            }



        }

        if(!empty($newNamesPictures)){
            return [true,$newNamesPictures];

        }else{
            return [false,""];
        }

    }





    /*******************************************************************
     **********************  PRIVATE FUNCTIONS   *********************
     ******************************************************************/

    public function createDirectory(string $path): ?bool
    {
        if(!file_exists($path)){
            try{
                mkdir($path) ?? throw new FileException();

            }catch (FileException $e) {
                // ... catch FileException $e
                return false;
            }

            return true;
        }

        return null;
    }


    private function checkMedia(array $file): bool
    {
        if(empty($file["name"])) return false;

        $size = $file["size"]/1000000;
        $type = mime_content_type($file["tmp_name"]);

        /** Constraints size **/
        if($size > self::CONTSTRAINTS_SIZE){
            $this->addFlash("error","L'image est trop volumineuse");
            return false;
        }

        /** Constraints types **/
        if(!in_array($type,self::CONSTRAINTES_TYPE)){
            $this->addFlash("error","Le type ne convient pas");
            return false;
        }

        return true;

    }


    /**
     * @param string $name = picture's name
     * @param string $param_original = dir to original directory
     * @param string $param_destination = dir to destination
     * @param int $x = width new img
     * @param string|null $newName
     * @return bool|null
     */
    private function resizeAbsolute(string $name, string $param_original, string $param_destination,int $x, string $newName = null): ?bool
    {

        // get extension
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        // get size
        $size = getimagesize($param_original."/".$name);
        if(!$size){
            return null;
        }
        // get the propotrionnality
        $ratio = $size[0]/$size[1];

        $y = $x/$ratio;

        switch ($ext){
            case 'jpg':
            case 'jpeg':
                $new_img = imagecreatefromjpeg($param_original."/".$name);
                $mini_img = imagecreatetruecolor($x,$y);
                imagecopyresampled($mini_img,$new_img,0,0,0,0,$x,$y,$size[0],$size[1]);
                imagejpeg($mini_img,$param_destination.'/'.$newName,90);
                break;

            case 'png':
                $new_img = imagecreatefrompng($param_original."/".$name);
                imagesavealpha($new_img,true);
                $mini_img = imagecreatetruecolor($x,$y);
                imagesavealpha($mini_img,true);
                $black = imagecolorallocatealpha($mini_img,0,0,0,127);
                imagefill($mini_img,0,0,$black);
                imagecopyresized($mini_img,$new_img,0,0,0,0,$x,$y,$size[0],$size[1]);
                imagesavealpha($mini_img,true);
                imagepng($mini_img,$param_destination.'/'.$newName,9);
                break;
        }

        return true;
    }


    /**
     * @param string $fileOrigin
     * @param string $directoryDestination
     * @return void
     */
    private function imgToWebp(string $fileOrigin, string $directoryDestination): void
    {
        // get ext
        $ext = pathinfo($fileOrigin, PATHINFO_EXTENSION);

        switch ($ext){
            case 'jpg':
            case 'jpeg':
                $new_img = imagecreatefromjpeg($fileOrigin);
                break;

            case 'png':
                $new_img = imagecreatefrompng($fileOrigin);
                imagesavealpha($new_img,true);
                break;

            default:
                $new_img = null;
        }

        if(!is_null($new_img)){
            // get original name of img
            $arr = explode("/",$fileOrigin);
            $nameOrigin = explode(".",$arr[count($arr)-1])[0];
            imagewebp($new_img,$directoryDestination."/".$nameOrigin.".webp");
        }

    }


    private function reorganization(array $files)
    {
        $r = [];

        foreach($files["files"]["name"] as $key => $value){
            $r[] = [
                "name" => $value,
                "type" => $files["files"]["type"][$key],
                "tmp_name" => $files["files"]["tmp_name"][$key],
                "size" => $files["files"]["size"][$key]
            ];
        }

        return $r;
    }
}
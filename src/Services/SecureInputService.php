<?php

namespace App\Services;

class SecureInputService
{
    public function secureInput($input): string
    {
        $type = gettype($input);
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_NOQUOTES, 'UTF-8');

        switch($type){

            case "integer":
                $input = intval($input);
                break;

            case "double":
                $input = floatval($input);
                break;

            case "boolean":
                $input = boolval($input);
                break;

            case "NULL":
                $input = null;
                break;

        }

        return $input;
    }

    public function secureAndFind(int $id,$repository): array
    {
        $id = $this->secureInput($id);

        return [$id,$repository->find($id)];

    }


    public function secureArray(array $form): array
    {
        $result = [];

        foreach($form as $key => $value){
            // secure input
            $key = $this->secureInput($key);
            if(!is_array($value)){
                $value = $this->secureInput($value);
            }
            $result[$key] = $value;

        }

        return $result;

    }

    static public function safeName(string $inputName): string
    {
        $name = pathinfo($inputName, PATHINFO_FILENAME);
        $ext = pathinfo($inputName, PATHINFO_EXTENSION);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_-] remove; Lower()', $name);
        return $safeFilename.'-'.uniqid().'.'.$ext;
    }



}
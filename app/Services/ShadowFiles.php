<?php

namespace App\Services;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Payment;

use Illuminate\Support\Facades\Storage;

class ShadowFiles
{

    public function moveFile($fileName, $professional){

        if(!$this->checkFile($fileName, $professional))
            return $data = ["data" => false, "code" => "304", "message" => "File not found"];

        $file = Storage::disk('ftp')->get("/TORG/" . $fileName);
        Storage::disk('local')->put($professional->id . '/' . $fileName, $file);

        /* DELETE COMING SOON */

        // $file = Storage::disk('ftp')->delete("/TORG/" . $fileName);

        return true;

    }

    public function checkFile($file, $professional){

        $files = $this->getFiles($professional);

        if(!$files)
            return false;

        return array_key_exists($file, $files);
    }

    public function getFiles($professional)
    {

        // FTP files
        $ftp = Storage::disk('ftp');
        $files = $ftp->files('/TORG');
        
        // keys and file names for files with $professional->user
        foreach ($files as $key => $value) {
            if (strpos($value, $professional->user) !== false && strpos($value, '.SHW') !== false) {
                $filesUserKeys[] = $key;
                $filesUserNames[] = substr($value, strpos($value, "TORG/") + 5);
            }
        }
        
        if (!isset($filesUserKeys))
            return;

        for ($i = 0; $i < count($filesUserKeys); $i++) {
            // File
            $file = $ftp->get($files[$filesUserKeys[$i]]);

            // File lines
            $file = explode("\n", $file);
            $cont = 0;
            $fileFields = array();

            for ($j = 0; $j < count($file); $j++) {
                // On those lines we extract the exact data info
                $lines = ["Fecha del archivo:", "Hora del archivo:", "Marca:", "Modelo:", "Tipo:", "Protocolo:"];
                $substring = ": ";

                foreach ($lines as $line) {

                    if (strpos($file[$j], $line) !== false){ 
                        $fileFields[$cont] = substr($file[$j], strpos($file[$j], $substring) + 2, -1);
                        $cont++;
                    }
                }
            }

            if(!isset($fileFields))
                return;

            $data[$filesUserNames[$i]] = [
                "date" => $fileFields[0],
                "time" => $fileFields[1],
                "manufacturer" => $fileFields[2],
                "model" => $fileFields[3],
                "type" => $fileFields[4],
                "protocol" => $fileFields[5],
            ];
        }

        return $data;
    }
}

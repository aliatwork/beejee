<?php

namespace App;

class Storage
{

    static private function open($filename)
    {
        if (file_exists($filename)) {
            return fopen($filename, "r+");
        } else {
            return false;
        }
    }

    static private function close($handle)
    {
        fclose($handle);
    }

    static private function getText($handle)
    {
        $text = '';
        while (!feof($handle)) {
            $text .= str_replace("\r\n", null, fgets($handle));
        }
        return trim($text);
    }

    static public function fileToArray($filename)
    {
        $result = [];
        try {
            if ($handle = self::open(Helper::getDir() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $filename . ".txt")) {
                $filetext = self::getText($handle);
                $result = json_decode($filetext, true);
                self::close($handle);
            }
        } catch (\Exception $e) {

        }
        return $result;
    }

    static public function saveArrayParam($filename, $key, $value)
    {
        $result = false;
        try {
            if ($handle = self::open(Helper::getDir() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $filename . ".txt")) {
                $filetext = self::getText($handle);
                $data = json_decode($filetext, true);
                $data[$key] = $value;
                $filetext = json_encode($data);
                ftruncate($handle, 0);
                fwrite($handle, $filetext);
                self::close($handle);
            }
        } catch (\Exception $e) {
            exit;
        }
        return $result;
    }

}
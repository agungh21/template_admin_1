<?php

namespace App\MyClass;

class Helper
{
    public static function makeDirectoryStorage(string $path)
    {
        $result = [];

        if (!\File::exists($path)) {
            $result = \File::makeDirectory($path);
        }

        return $result;
    }

    public static function idPhoneNumberFormat($phone)
    {
        $output = $phone;
        $output = substr($output, 0, 1) == '0' ? "62" . substr($output, 1) : $output;
        $output = substr($output, 0, 3) == '+62' ? substr($output, 1) : $output;
        $output = substr($output, 0, 2) != '62' ? "62" . $output : $output;

        return $output;
    }
}

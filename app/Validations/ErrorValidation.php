<?php

namespace App\Validations;
use App\Helpers\Func;

class ErrorValidation
{
    public static function arrange_error($data, $props)
    {
        $res_data = [];
        global $error_data;
        $error_data = $data;

        foreach ($props as $value) {
            if (isset($error_data->$value)) {
                $curr = $error_data->$value;
                foreach ($curr as $value) {
                    array_push($res_data, $value);
                }
            }
        }

        return $res_data;
    }

   
}

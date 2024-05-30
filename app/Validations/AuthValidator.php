<?php


namespace App\Validations;
use App\Helpers\Func;

class AuthValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'login' => [
                'email' => 'required|email',
                'password' => 'required',
            ],

            'register' => [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ],
          
        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}

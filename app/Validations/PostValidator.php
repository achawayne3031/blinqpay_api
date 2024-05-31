<?php


namespace App\Validations;
use App\Helpers\Func;

class PostValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'create_post' => [
                'title' => 'required|unique:posts',
                'description' => 'required',
                'post' => 'required'
            ],
            'update_post' => [
                'title' => 'required|unique:posts',
                'description' => 'required',
                'post' => 'required',
                'post_id' => 'required'
            ],
            'delete_post' => [
                'post_id' => 'required'
            ],
            
        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Validations\PostValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\Post;
use App\Helpers\DBHelpers;
use App\Helpers\Func;

class PostController extends Controller
{
    //


    public function delete_post(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'delete_post');

            if (!$validate->fails() && $validate->validated()) {
                try {


                    if (!DBHelpers::exists(Post::class, [
                            'id' => $request->post_id,
                        ])) {
                        return ResponseHelper::error_response(
                            'Post not found',
                            null,
                            401
                        );
                    }
    
                    if (!DBHelpers::exists(Post::class, [
                            'id' => $request->post_id,
                            'user_id' => auth()->id(),
                        ])) {
                        return ResponseHelper::error_response(
                            'Post not in your collections',
                            null,
                            401
                        );
                    }


                    $delete = DBHelpers::delete_query_multi(Post::class, ['id' => $request->post_id, 'user_id' => auth()->id()]);

                    if (!$delete) {
                        return ResponseHelper::error_response(
                            'Registration failed, Database delete issues',
                            $validate->errors(),
                            401
                        );
                    }

                    return ResponseHelper::success_response(
                        'Post deleted successfully',
                        null
                    );

                } catch (Exception $e) {
                    return ResponseHelper::error_response(
                        'Server Error',
                        $e->getMessage(),
                        401
                    );
                }
            } else {
                $errors = json_decode($validate->errors());
                $props = [
                    'post_id'
                ];
                $error_res = ErrorValidation::arrange_error($errors, $props);

                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }




    public function update_post(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'update_post');

            if (!$validate->fails() && $validate->validated()) {
                try {


                    if (
                        !DBHelpers::exists(Post::class, [
                            'id' => $request->post_id,
                        ])
                    ) {
                        return ResponseHelper::error_response(
                            'Post not found',
                            null,
                            401
                        );
                    }
    
                    if (
                        !DBHelpers::exists(Post::class, [
                            'id' => $request->post_id,
                            'user_id' => auth()->id(),
                        ])
                    ) {
                        return ResponseHelper::error_response(
                            'Post not in your collections',
                            null,
                            401
                        );
                    }


                    $data = [
                        'title' => $request->title,
                        'description' => $request->description,
                        'post' => $request->post,
                        'user_id' => auth()->id()
                    ];


                    $update = DBHelpers::update_query_v3(Post::class, $data, ['id' => $request->post_id, 'user_id' => auth()->id()]);

                    if (!$update) {
                        return ResponseHelper::error_response(
                            'Registration failed, Database update issues',
                            $validate->errors(),
                            401
                        );
                    }

                    return ResponseHelper::success_response(
                        'Post updated successfully',
                        null
                    );

                } catch (Exception $e) {
                    return ResponseHelper::error_response(
                        'Server Error',
                        $e->getMessage(),
                        401
                    );
                }
            } else {
                $errors = json_decode($validate->errors());
                $props = [
                    'title',
                    'post',
                    'description',
                    'post_id'
                ];
                $error_res = ErrorValidation::arrange_error($errors, $props);

                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }



    public function create_post(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'create_post');

            if (!$validate->fails() && $validate->validated()) {
                try {


                    $data = [
                        'title' => $request->title,
                        'description' => $request->description,
                        'post' => $request->post,
                        'user_id' => auth()->id()
                    ];



                    $register = DBHelpers::create_query(Post::class, $data);

                    if (!$register) {
                        return ResponseHelper::error_response(
                            'Registration failed, Database insertion issues',
                            $validate->errors(),
                            401
                        );
                    }

                    return ResponseHelper::success_response(
                        'Post created successfully',
                        null
                    );

                } catch (Exception $e) {
                    return ResponseHelper::error_response(
                        'Server Error',
                        $e->getMessage(),
                        401
                    );
                }
            } else {
                $errors = json_decode($validate->errors());
                $props = [
                    'title',
                    'post',
                    'description',
                ];
                $error_res = ErrorValidation::arrange_error($errors, $props);

                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }
    }
}

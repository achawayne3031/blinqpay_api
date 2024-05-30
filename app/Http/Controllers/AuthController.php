<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Validations\AuthValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Helpers\DBHelpers;
use App\Helpers\Func;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = AuthValidator::validate_rules($request, 'register');

            if (!$validate->fails() && $validate->validated()) {
                try {

                    $data = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                    ];

                    $register = DBHelpers::create_query(User::class, $data);

                    if (!$register) {
                        return ResponseHelper::error_response(
                            'Registration failed, Database insertion issues',
                            $validate->errors(),
                            401
                        );
                    }

                    return ResponseHelper::success_response(
                        'Registration was successful',
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
                    'name',
                    'email',
                    'password',
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

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = AuthValidator::validate_rules($request, 'login');

            if (!$validate->fails() && $validate->validated()) {
                if (auth()->attempt($request->all())) {
                    $token = auth()->user()->createToken(env('TOKENKEY'))->accessToken;
                   /// return response()->json(['token' => $token], 200);

                    return ResponseHelper::success_response(
                        'Login Successful',
                        auth()->user(),
                        $token
                    );

                } else {

                    return ResponseHelper::error_response(
                        'Invalid login credentials',
                        null,
                        401
                    );

                }


                // if (
                //     $token = Auth::guard('api')->attempt([
                //         'email' => $request->email,
                //         'password' => $request->password,
                //     ])
                // ) {


                //     $token = $this->respondWithToken($token);
                //     $user = $this->me();
                //     $check_user = auth()->user();
            
                //     return ResponseHelper::success_response(
                //         'Login Successful',
                //         $user,
                //         $token
                //     );
                // } else {
                //     return ResponseHelper::error_response(
                //         'Invalid login credentials',
                //         null,
                //         401
                //     );
                // }


            } else {
                $errors = json_decode($validate->errors());
                $props = ['email', 'password'];
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

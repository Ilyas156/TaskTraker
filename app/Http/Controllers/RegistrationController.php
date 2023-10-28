<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RegistrationController extends Controller
{
    public function test(): string
    {
        return 'test-registration';
    }

    /**
     * @throws Throwable
     */
    public function registration(UserRegistrationRequest $request): JsonResponse
    {
        /** @var $data array{
         *   login: string,
         *   password: string
         * }
         */
        $data = $request->post();
        $request->validated();
        $validator = Validator::make($request->post(), [
            'login' => 'required|max:255',
            'password' => 'required|max: 255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->login = $data['login'];
        $user->password = $data['password'];
        $user->saveOrFail();

        return response()->json(['success' => true]);
    }
}

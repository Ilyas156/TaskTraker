<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
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
        /** @var array{
         *   login: string,
         *   password: string
         * } $data
         */
        $data = $request->post();
        $request->validated();
        $validator = Validator::make($data, [
            'login' => 'required|max:255',
            'password' => 'required|max: 255'
        ]);
        if ($validator->fails()) {
            /** @phpstan-ignore-next-line  */
            return response()->json([
                'status' => ResponseAlias::HTTP_BAD_REQUEST,
                'errors' => $validator->errors()
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->login = $data['login'];
        $user->password = $data['password'];
        $user->saveOrFail();

        /** @phpstan-ignore-next-line  */
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Facades\AppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends \Orchid\Platform\Http\Controllers\LoginController
{

    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'token' => 'sometimes|required|string',
        ]);

        if ($request->has('token')) {
            AppService::init($request->only(['email', 'password', 'token']));
        }

        $auth = $this->guard->attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($auth) {
            return $this->sendLoginResponse($request);
        }

        throw ValidationException::withMessages([
            'email' => __('The details you entered did not match our records. Please double-check and try again.'),
        ]);
    }

}

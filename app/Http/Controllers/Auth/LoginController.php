<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Entity\User\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class LoginController extends Controller
{
    public function showLoginForm(): View|Factory
    {
        return view('auth.login');
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $authenticate = Auth::attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            /** @var User $user */
            $user = Auth::user();

            if ($user->isWait()) {
                Auth::logout();
                return back()->with('error', 'You need to confirm your account. Please check your email.');
            }

            return redirect()->intended(route('cabinet.home'));
        }

        throw ValidationException::withMessages(['email' => [trans('auth.failed')]]);
    }

    public function phone(): View|Factory
    {
        return view('auth.phone');
    }

    /**
     * @throws ValidationException
     */
    public function verify(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'token' => 'required|string',
        ]);

        if (!$session = $request->session()->get('auth')) {
            throw new BadRequestHttpException('Missing token info.');
        }

        /** @var User $user */
        $user = User::findOrFail($session['id']);

        if ($request['token'] === $session['token']) {
            $request->session()->flush();
            Auth::login($user, $session['remember']);
            return redirect()->intended(route('user.home'));
        }

        throw ValidationException::withMessages(['token' => ['Invalid auth token.']]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }
}

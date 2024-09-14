<?php

namespace App\Http\Controllers;

use App\Helpers\SignatureGenerator;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Google_Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginForm(Request $request): View|RedirectResponse|string
    {
        return view('home.index');
    }

    public function login(LoginRequest $request): View|RedirectResponse|string
    {
        $user = $request->getUserModel();
        if ($user !== null) {
            Auth::login($user);
        }
        return redirect()->route('account');
    }

    public function registrationForm(Request $request): View|RedirectResponse|string
    {
        return view('home.index');
    }

    public function register(RegistrationRequest $request): View|RedirectResponse|string
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->first_name = '';
        $user->second_name = '';
        $user->username = '';
        if ($user->save()) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('auth.emailVerificationSent');
        }
        return back();
    }

    public function getAuthMessage(): string|array
    {
        $signatureGenerator = new SignatureGenerator(config('app.secretKey'));
        if (Auth::check()) {
            return $signatureGenerator->createAuthMessage(Auth::id());
        } else {
            return "";
        }
    }

    public function changePassword(ChangePasswordRequest $request): string|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return $request->ajax() ? 'OK' : redirect()->route('account.profile');
    }

    public function sendEmailVerification(): string
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return response('Already verified', 406);
        }
        if (!is_null($user->email_verified_at) && time() - strtotime($user->email_verified_at) > 60) {
            return response('Wait a little before sending new email', 429);
        }
        $user->sendEmailVerificationNotification();
        return 'OK';
    }

    public function verifyEmail(Request $request, string $token)
    {
        /** @var User $user */
        $user = User::where('email_verification_token', $token)->first();
        if ($user !== null) {
            $user->markEmailAsVerified();
            $user->save();
            return view('auth.emailVerified');
        }
        abort(404);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home');
    }


    public function loginByGoogle(Request $request)
    {
        $token = $request->post('token', '');
        if (empty($token)) abort(404);

        $client = new Google_Client([
            'client_id' => config('auth.google_client_id'),
            'client_secret' => config('auth.google_client_secret')
        ]);

        $payload = $client->verifyIdToken($token);
        if ($payload) {

            $user = User::where('social_id', 'google_'.$payload['sub'])->first();
            if ($user === null) {
                $user = new User();
                $user->social_id = 'google_'.$payload['sub'];
                $user->username = $payload['given_name'];
                $user->first_name = $payload['given_name'];
                $user->second_name = $payload['family_name'];
                $user->email = $payload['email'];
                $user->password = User::DUMMY_PASSWORD;
                if ($payload['email_verified']) {
                    $user->email_verified_at = $user->freshTimestamp();
                }
                if (!empty($payload['picture'])) {
                    $user->setFromFile($payload['picture']);
                }
                $user->save();
            }

            Auth::login($user);

            Log::info(var_export($payload, true));
            return redirect()->route('account');
        } else {
            abort(404);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->post('email', ''))->first();
        if ($user !== null) {
            $token = PasswordResetToken::where('email', $user->email)->first();
            if ($token === null) {
                $token = new PasswordResetToken();
                $token->email = $user->email;
                $token->token = Str::random(32);
                $token->save();
            }
            Mail::send(new ResetPasswordEmail($user, $token->token));
            return 'OK';
        }
        abort(403);
    }

    public function resetPasswordPage(Request $request, string $token)
    {
        /** @var PasswordResetToken $token */
        $token = PasswordResetToken::where('token', $token)->first();
        if ($token !== null) {
            return view('auth.resetPassword', ['token' => $token->token]);
        }
        abort(404);
    }

    public function resetPassword(ResetPasswordRequest $request, string $token)
    {
        $token = PasswordResetToken::where('token', $token)->first();
        if ($token !== null) {
            User::where('email', $token->email)->update(['password' => Hash::make($request->post('password'))]);
            return view('auth.passwordResetSuccess');
        }
        abort(403);
    }
}

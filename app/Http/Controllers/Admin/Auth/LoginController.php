<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\User\Auth\SendUserPasswordResetMailJob;
use App\Models\PasswordReset\PasswordReset;
use App\Services\AdminUser\AdminUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(AdminUserService $user)
    {
        $this->user = $user;

        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (url()->previous()) {
            session()->put('previous_url', url()->previous());
        }
        if (empty(\auth()->guard('admin')->user())) {
            return view('admin.auth.login');
        }
        else {
            return redirect()->route('admin.dashboard');
        }
    }

    public function login(Request $request)
    {
        if ($this->attemptLogin($request)) {
            $user = auth()->guard('admin')->user();
            $user->token = Str::random('75');
            return response(['data' => $user,'url'=>route('admin.dashboard')]);
        } else {
            return response([
                'errors' => ['The provided credentials are incorrect.'],
            ], 401);
        }

    }


    public function logout(Request $request)
    {
        if (auth()->guard('admin')->user()) {
            auth()->guard('admin')->user()->tokens()->delete();
            if ($response = $this->loggedOut($request)) {
                return $response;
            }
            auth()->guard('admin')->logout();

            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.login');
    }

    public function setupLogin(Request $request)
    {
        $user = auth()->user();
        $user->user_name = $request->get('user_name');
        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            return response([
                'success' => 'Setup successful.',
            ], 200);
        }
    }


    public function verify()
    {
        $user = auth()->user();
        if (!empty($user)) {
            $user->token = Str::random('75');
            return response(['data' => $user]);
        }
        return response(false,401);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $user = $this->user->findByColumn('email', $request->get('email'));
        if (empty($user)) {
            return response([
                'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);
        } else {
            $passwordReset = PasswordReset::whereEmail($user->email)->first();
            if (empty($passwordReset)) {
                $token = getToken('email');
                $resetData['email'] = $user->email;
                $resetData['token'] = $token;
                $passwordReset = PasswordReset::create($resetData);
                $link = $this->passwordResetUrl($passwordReset->token, $passwordReset->email);
                SendUserPasswordResetMailJob::dispatch($passwordReset, $link)->delay(now()->addSeconds(5));

                return response([
                    'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);

            } else {
                if (Carbon::now()->diffInMinutes($passwordReset->updated_at) < 3) {
                    return response([
                        'msg' => 'You can retry in next three minutes.'], 200);
                } else {
                    $token = getToken('email');
                    $passwordReset->email = $user->email;
                    $passwordReset->token = $token;
                    $passwordReset->save();
                    $link = $this->passwordResetUrl($passwordReset->token, $passwordReset->email);
                    //Mail::to($passwordReset->email)->send(new SendUserPasswordResetMail($passwordReset,$link));
                    SendUserPasswordResetMailJob::dispatch($passwordReset, $link)->delay(now()->addSeconds(5));
                    return response([
                        'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);
                }
            }
        }
    }

    protected function passwordResetUrl($token, $email)
    {
        $url = env('ADMIN_URL');
        $params = [
            'email' => $email,
            'token' => $token,
        ];
        return  $url . '?' . http_build_query($params);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function checkResetPassword(Request $request)
    {
        $passwordReset = PasswordReset::whereEmail($request->get('email'))->whereToken($request->get('token'))->first();
        if (empty($passwordReset) || $passwordReset->updated_at->addMinute(15)->isPast()) {
            return response([
                'status'=>'EXPIRED',
                'url'=>route('user.forgot-password'),
                'message' => 'Your password reset token has expired. Please request again'], 200);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function doResetPassword(Request $request)
    {

        if ($request->has('email') && $request->has('password')) {
            $passwordReset = PasswordReset::whereEmail($request->get('email'))->whereToken($request->get('token'))->first();
            $user = $this->user->findByColumn('email', $passwordReset->email);
            $user->password = bcrypt($request->get('password'));
            $user->save();
            $passwordReset->delete();
            Auth::login($user);
            return response([
                'status'=>'OK',
                'message' => 'Your password has been changed. Please login to continue.'], 200);

        } else {
            return response([
                'status'=>'ERROR',
                'message' => 'Unable to reset password. Please try again'], 200);
        }
    }
}

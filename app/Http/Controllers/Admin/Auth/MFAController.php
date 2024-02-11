<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

use App\Http\Resources\AdminUser\AdminUserResource;
use App\Mail\Admin\Auth\LoginVerificationCodeMail;

use App\Services\AdminUser\AdminUserService;
use App\Services\Authenticator\Authenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MFAController extends Controller
{
    protected $user;
    protected $authenticator;

    function __construct(AdminUserService $user, Authenticator $authenticator)
    {
        $this->user = $user;
        $this->authenticator = $authenticator;
    }

    public function checkVerificationEnabled(Request $request)
    {
        $user = $this->user->getUserForLogin($request->get('email'), $request->get('password'));

        if ($user) {

            if ($user->is_email_authentication_enabled && !$user->is_mfa_enabled)
                $this->requestEmailVerificationCode($request);

            return response(["status" => "OK", 'data' => new AdminUserResource($user)], 200);
        } elseif ($user && !$user->is_login_verified) {
            return response([
                'errors' => 'Email not verified. Please verify your email',
                'status' => 'NOT_VERIFIED'
            ], 200);
        } else {
            return response([
                'errors' => 'The provided credentials are incorrect.',
                'status' => 'NOT_FOUND'
            ], 200);
        }

    }

    function getMfaAuthenticatorCode(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $secret = $this->authenticator->createSecret();
        $qrCodeUrl = $this->authenticator->getQRCodeUrl($user->email, $secret, env('APP_NAME'));
        $oneCode = $this->authenticator->getCode($secret);
        $data = array(
            'account' => $user->email,
            'secret_key' => $secret,
            'image_url' => $qrCodeUrl
        );
        return response($data);
    }

    function activateEmailAuthenticator()
    {
        try {
            $user = auth()->guard('admin')->user();
            $user->is_email_authentication_enabled = true;
            $user->save();
            return $user;
        } catch (\Exception $ex) {
            return false;
        }
    }

    function deactivateEmailAuthenticator()
    {
        try {
            $user = auth()->guard('admin')->user();
            if ($user->is_mfa_enable == 0) {
                $data['mfa_secret_code'] = null;
            }
            $user->is_email_authentication_enabled = false;
            $user->save();
            return $user;
        } catch (\Exception $ex) {
            return false;
        }
    }

    function activateMfaAuthenticator(Request $request)
    {
        $secret = $request->get('secret_key');
        $verificationCode = $request->get('verification_code');
        $image_url = $request->get('image_url');
        $checkResult = $this->authenticator->verifyCode($secret, $verificationCode, 2);
        if ($checkResult) {
            $user = auth()->guard('admin')->user();
            $user->is_mfa_enabled = true;
            $user->mfa_secret_code = $secret;
            $user->mfa_authentication_image = $image_url;
            $user->save();
            return response(["status" => "OK"], 200);
        }
        return response(["status" => $checkResult], 200);
    }
    function deactivateMfaAuthenticator(Request $request)
    {
        $user = auth()->guard('admin')->user();
        if ($user->is_email_authentication_enabled == 0) {
            $user->mfa_secret_code = null;
        }
        $user->is_mfa_enabled = false;
        $user->mfa_authentication_image = null;
        if ($user->save())
            return response(["status" => "OK"], 200);
        return response(["status" => 'ERROR'], 200);
    }



    function verifyMfaVerificationCode(Request $request)
    {

        $user = $this->user->getUserForLogin($request->get('email'), $request->get('password'));
        if ($user) {
            if ($this->authenticator->verifyCode($user->mfa_secret_code, $request->get('verification_code'), 2)) {
                return response(["status" => "OK", 'data' => $user], 200);
            } else {
                return response([
                    "status" => "ERROR",
                    'errors' => 'The verification code is not valid.',
                ], 200);
            }

        } else {
            return response([
                "status" => "ERROR",
                'errors' => ['The provided credentials are incorrect.'],
            ], 200);
        }
    }

    function requestEmailVerificationCode(Request $request)
    {

        $user = $this->user->getUserForLogin($request->get('email'), $request->get('password'));
        if ($user) {
            $secret = !empty($user->mfa_secret_code) ? $user->mfa_secret_code : $user->email;
            $code = $this->authenticator->getCode($secret);
            Mail::to($user->email)->send(new LoginVerificationCodeMail($user, $code));
            return response(["status" => "OK"], 200);
        } else {
            return response([
                'errors' => 'The provided credentials are incorrect.',
            ], 401);
        }

    }

    function verifyEmailVerificationCode(Request $request)
    {
        $user = $this->user->getUserForLogin($request->get('email'), $request->get('password'));
        if ($user) {
            $secret = !empty($user->mfa_secret_code) ? $user->mfa_secret_code : $user->email;
            if ($this->authenticator->verifyCode($secret, $request->get('verification_code'), 4)) {
                return response(["status" => "OK", 'data' => $user], 200);
            } else {
                return response([
                    'status' => 'ERROR',
                    'errors' => 'The verification code is not valid.',
                ], 200);
            }

        } else {
            return response([
                'status' => 'ERROR',
                'errors' => 'The provided credentials are incorrect.',
            ], 200);
        }
    }
}

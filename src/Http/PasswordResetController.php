<?php


namespace ShinHyungJune\SocialLogin\Http;

use App\Mail\PasswordResetCreated;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class PasswordResetController extends Controller
{
    public function create()
    {
        return Inertia::render("PasswordResets/Create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email|string|max:500"
        ]);

        $message = "";

        if(!User::where("email", $request->email)->exists()) {
            $message = __("socialLogin.passwordReset.send_fail");

            return Inertia::render("PasswordResets/Create", ["message" => $message]);
        }

        $token = random_int(100000000,999999999);

        $passwordReset = PasswordReset::where("email", $request->email)->first();

        $passwordReset ? $passwordReset->update([
            "email" => $request->email,
            "token" => $token
        ]) : $passwordReset = PasswordReset::create([
            "email" => $request->email,
            "token" => $token
        ]);

        Mail::to($request->email)->send(new PasswordResetCreated(User::where("email", $request->email)->first(), $passwordReset));

        $message = __("socialLogin.passwordReset.send_success");

        return Inertia::render("PasswordResets/Create", ["message" => $message]);
    }

    public function edit(Request $request)
    {
        return Inertia::render("PasswordResets/Edit", [
            "email" => $request->email,
            "token" => $request->token
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:500",
            "token" => "required|string|max:5000",
            "password" => "required|string|min:8|max:500|confirmed"
        ]);


        $passwordReset = PasswordReset::where("email", $request->email)
            ->where("token", $request->token)
            ->first();

        $user = User::where("email", $request->email)->first();

        $message = __("socialLogin.passwordReset.reset_fail");

        if($user && $passwordReset){
            $user->update(["password" => Hash::make($request->password)]);

            $message = __("socialLogin.passwordReset.reset_success");
        }

        return Inertia::render("PasswordResets/Edit", ["message" => $message]);
    }
}
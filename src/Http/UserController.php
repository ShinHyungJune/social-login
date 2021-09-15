<?php


namespace ShinHyungJune\SocialLogin\Http;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render("Users/Login");
    }

    public function openSocialLoginPop($social)
    {
        return Socialite::driver($social)->redirect();
    }
    
    public function socialLogin(Request $request, $social)
    {
        $socialUser = Socialite::driver($social)->user();

        // 일단 네이버
        $user = User::where("social_id", $socialUser->id)->where("social_platform", $social)->first();

        if(!$user)
            $user = User::create([
                "name" =>  $social.Carbon::now()->format("Y.m.d.H.i.s"),
                "social_id" => $socialUser->id,
                "social_platform" => $social
            ]);

        Auth::login($user);

        return redirect()->intended();
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|string|max:500",
            "password" => "required|string|max:500",
        ]);

        if(auth()->attempt($request->all())) {
            session()->regenerate();

            return Inertia::render("Home");
        }

        return Inertia::render("Users/Login", [
            "errors" => [
                "email" => __("socialLogin.invalid")
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return Inertia::render("Home");
    }

    public function create()
    {
        return Inertia::render("Users/Create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:500|unique:users",
            "email" => "required|string|email|max:500|unique:users",
            "password" => "required|string|max:500|min:8|confirmed",
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return Inertia::render("Home");
    }
}
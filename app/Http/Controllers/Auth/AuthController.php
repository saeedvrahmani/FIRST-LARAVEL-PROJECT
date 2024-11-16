<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
public function redirectToprovider($provider) {
    
return  Socialite::driver($provider)->redirect();
}
public function handleProvidercallback($provider) {
    
    try {
        $user_socialite = Socialite::driver($provider)->user();
    } catch (\Exception $ex) {
      return redirect()->route('login');
    }
   
  $user = User::where('email' , $user_socialite->getEmail())->first();
  if (!$user) {
User::create([

    'name' => $user_socialite->getName(),
    'provider_name' => $provider,
    'email' => $user_socialite->getEmail(),
    'password' => Hash::make($user_socialite->getId()),
    'avatar' => $user_socialite->getAvatar(),
    'provider_name' => Carbon::now()

]);
auth()->login($user , $remember = true);
alert()->success('با تشکر','ورود شما موفقیت آمیز بود')->persistent('حله');
  }
}
}

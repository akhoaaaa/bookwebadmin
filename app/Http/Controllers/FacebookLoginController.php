<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class FacebookLoginController extends Controller
{
    //
    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = DB::table('social')
            ->where('provider', 'facebook')
            ->where('provider_user_id', $provider->getId())
            ->first();

        if ($account) {
            $account_name = DB::table('user')
                ->where('id', $account->user)
                ->first();

            Session::put('username', $account_name->username);
            Session::put('id', $account_name->id);

            return redirect('/trang-chu')->with('message', '');
        } else {
            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook',
            ]);

            $orang = DB::table('user')
                ->where('email', $provider->getEmail())
                ->first();

            if (!$orang) {
                $orang = DB::table('user')->insert([
                    'username' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'pass' => '',
                    'sdt' => '',
                    'chucnang' => 'user',
                ]);
            }

            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = DB::table('user')
                ->where('id', $account->user)
                ->first();

            Session::put('username', $account_name->username);
            Session::put('id', $account_name->id);

            return redirect('/trang-chu')->with('message', '');
        }
    }
}

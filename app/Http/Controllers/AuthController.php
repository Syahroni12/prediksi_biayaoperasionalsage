<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginaction(Request $request)
    {
        Alert::toast('Welcome back!', 'success');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->messages());
            return redirect()->back()->withInput();
        }

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];
        try {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                Alert::success('Success', 'Login Berhasil di lakukan')->flash();
                return redirect()->route('dashboard');
            } else {
                Alert::error('Gagal', "email atau password salah");
                return back();
            }
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', $th->getMessage());
            return back();
            //     alert()->error('Gagal',"nis/nip atau password salah");
            // return back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::toast('Logout Berhasil', 'success');
        return redirect()->route('login');
    }
}

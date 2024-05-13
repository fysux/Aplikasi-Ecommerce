<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\error;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            return redirect('/');
        } else {
            $errors = 'Email atau Password salah';
            return redirect('/login', 302)->withErrors($errors);
        }
    }

    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Lakukan cek apakah email sudah terdaftar sebelumnya
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return redirect('/register')->with('error', 'Email sudah terdaftar. Silakan gunakan email lain.');
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password_hash;
        if ($user->save()) {
            return redirect('login');
        }

        return redirect('/login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}

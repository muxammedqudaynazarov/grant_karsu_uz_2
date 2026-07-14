<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = Http::post('https://student.karsu.uz/rest/v1/auth/login', [
            'login' => $request->username,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['success']) && $data['success'] == true) {
                $token = $data['data']['token'];
                $query = Http::withToken($token)->get('https://student.karsu.uz/rest/v1/account/me');
                if ($query->successful()) {
                    $profileData = $query->json()['data'];
                    $user = User::updateOrCreate(
                        ['id' => $profileData['student_id_number']],
                        [
                            'name' => $profileData['short_name'],
                            'token' => $token,
                            'data' => $profileData,
                        ]
                    );
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->route('home')->with('success', 'Tizimga muvaffaqiyatli kirdingiz!');
                }
            }
        }
        return back()->withErrors([
            'username' => 'Talaba ID yoki parol noto‘g‘ri, yoxud HEMIS tizimi bilan aloqa yo‘q.',
        ])->withInput();
    }
}

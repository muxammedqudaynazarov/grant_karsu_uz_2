<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public static function middleware(): array
    {
        return ['auth',];
    }

    public function index()
    {
        return view('home.index');
    }

    public function lang($locale)
    {
        if (in_array($locale, ['uz', 'kaa', 'ru'])) {
            session()->put('locale', $locale);
            $user = auth()->user();
            $user->update([
                'lang' => $locale,
            ]);
        }
        return redirect()->back();
    }
}

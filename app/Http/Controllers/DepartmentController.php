<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $tests = Test::where('status', '3')->paginate(30);
        return view('home.results.index', compact(['tests']));
    }
}

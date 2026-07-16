<?php

namespace App\Http\Controllers;

use App\Exports\TestsExport;
use App\Models\Test;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index()
    {
        $tests = Test::where('status', '3')->paginate(30);
        return view('home.results.index', compact(['tests']));
    }

    public function export()
    {
        $tests = Test::where('status', '3')->get();
        return Excel::download(new TestsExport($tests), 'Natijalar_' . date('dmY-His') . '.xlsx');
    }
}

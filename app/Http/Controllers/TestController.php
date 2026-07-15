<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Category;
use App\Models\Test;
use App\Models\UserBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function show(Test $test)
    {
        if ($test->user_id !== auth()->id()) abort(403);
        if ($test->status !== '2') {
            $test->update([
                'status' => '2',
                'finished_at' => Carbon::now()->addMinutes(50)
            ]);
        }
        if (Carbon::now()->gt($test->finished_at)) {
            return redirect()->route('tests.index', $test->id)->with('error', 'Test vaqti yakunlangan.');
        }
        $attempts = Attempt::with(['question', 'question.answers'])
            ->where('test_id', $test->id)->orderBy('pos')->get();
        return view('home.tests.show', compact(['test', 'attempts']));
    }

    // TestController.php

    public function uploadAnswer(Request $request)
    {
        try {
            $test = Test::find($request->test_id);
            if (!$test || $test->user_id !== auth()->id()) {
                return response()->json(['status' => 'error', 'message' => 'Xavfsizlik xatosi!']);
            }
            $attempt = Attempt::where('id', $request->attempt_id)->where('test_id', $test->id)->first();
            if ($attempt) {
                $attempt->update(['answer_id' => $request->answer_id]);
                return response()->json(['status' => 'success']);
            }
            return response()->json(['status' => 'error', 'message' => 'Savol topilmadi.']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tizim xatoligi: ' . $e->getMessage()
            ]);
        }
    }

    public function index()
    {
        $test = Test::where('user_id', auth()->id())->first();
        return view('home.tests.index', compact('test'));
    }

    public function create()
    {
        $test = Test::where('user_id', auth()->id())->first();
        $categories = Category::with('books')->where('status', '1')->get();
        if ($test) {
            return redirect()->route('tests.edit', $test->id);
        }
        return view('home.tests.create', compact(['categories']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'books' => ['required', 'array', 'size:12'],
        ], [
            'books.required' => 'Iltimos, kitoblarni tanlang.',
            'books.size' => 'Aynan 12 ta kitob tanlashingiz shart!',
        ]);
        DB::beginTransaction();
        try {
            $test = Test::firstOrCreate(
                ['user_id' => auth()->id()],
                ['uuid' => Str::uuid(), 'status' => '0']
            );
            UserBook::where('test_id', $test->id)->delete();
            $insertData = [];
            foreach ($request->books as $item) {
                $parts = explode('|', $item);
                if (count($parts) === 2) {
                    $insertData[] = [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'category_id' => $parts[0],
                        'book_id' => $parts[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            if (!empty($insertData)) {
                UserBook::insert($insertData);
            }
            DB::commit();
            return redirect()->route('tests.index')->with('success', 'Tanlangan kitoblar muvaffaqiyatli saqlandi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Tizimda xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function edit(Test $test)
    {
        if ($test->user_id !== auth()->id()) abort(403, 'Sizda bu sahifaga kirish huquqi yo‘q.');
        if ($test->status != '0') return redirect()->route('tests.index')->with('error', 'Sizda bu sahifaga kirish huquqi yo‘q.');

        $categories = Category::with('books')->where('status', '1')->get();
        $selectedBooks = UserBook::where('test_id', $test->id)->pluck('book_id')->toArray();
        return view('home.tests.update', compact(['categories', 'test', 'selectedBooks']));
    }

    public function update(Request $request, Test $test)
    {
        if ($test->user_id !== auth()->id()) abort(403);
        if ($test->status != '0') return redirect()->route('tests.index')->with('error', 'Sizda bu sahifaga kirish huquqi yo‘q.');

        $request->validate([
            'books' => ['required', 'array', 'size:12'],
        ], [
            'books.required' => 'Iltimos, kitoblarni tanlang.',
            'books.size' => 'Aynan 12 ta kitob tanlashingiz shart!',
        ]);

        DB::beginTransaction();

        try {
            UserBook::where('test_id', $test->id)->delete();
            $insertData = [];
            foreach ($request->books as $item) {
                $parts = explode('|', $item);
                if (count($parts) === 2) {
                    $insertData[] = [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'category_id' => $parts[0],
                        'book_id' => $parts[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            if (!empty($insertData)) {
                UserBook::insert($insertData);
            }
            DB::commit();
            return redirect()->route('tests.index')->with('success', 'Kitoblar ro‘yxati muvaffaqiyatli yangilandi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Tizimda xatolik yuz berdi: ' . $e->getMessage());
        }
    }
}

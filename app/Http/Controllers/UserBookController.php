<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Limit;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserBook;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserBookController extends Controller
{
    public function check($uuid)
    {
        $test = Test::where('uuid', $uuid)->first();
        $limit = null;
        if ($test) {
            $test->increment('checks');
            $limit = Limit::where('min', '<=', $test->score)->where('max', '>=', $test->score)->first();
        }
        return view('home.check', compact(['test', 'limit']));
    }

    public function download($uuid)
    {
        $test = Test::where('uuid', $uuid)->firstOrFail();
        $checkUrl = route('certificates.check', $test->uuid);
        $qrcode = QrCode::size(135)->format('svg')->color(30, 41, 59)->margin(1)->generate($checkUrl);
        $qrcodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrcode);
        $limit = Limit::where('min', '<=', $test->score)->where('max', '>=', $test->score)->first();
        $data = [
            'name' => $test->user->name,
            'test_name' => $limit->name ?? 'Kitobxonlik madaniyati',
            'score' => $test->score,
            'date' => $test->created_at->format('d.m.Y'),
            'uuid' => $test->uuid,
            'qrcode' => $qrcodeBase64,
            'test' => $test,
        ];
        $test->increment('downloads');
        $pdf = Pdf::loadView('home.certificate', $data)->setPaper('a4', 'landscape');
        $name = str_replace(' ', '_', Str::ascii($test->user->data['full_name'] ?? $test->user->name));
        $filename = preg_replace('/[^A-Za-z0-9_]/', '', $name);
        return $pdf->download('sertifikat_' . $filename . '_' . time() . '.pdf');
        //return $pdf->stream();
    }

    public function update(Request $request, Test $userbook)
    {
        if ($userbook->user_id !== auth()->id()) {
            abort(403, 'Sizda bu amalni bajarish huquqi yo‘q.');
        }

        if ($userbook->status === '1' || Attempt::where('test_id', $userbook->id)->exists()) {
            return redirect()->route('tests.index')->with('warning', 'Savollar allaqachon tayyorlangan!');
        }

        $selectedBookIds = UserBook::where('user_id', auth()->id())->pluck('book_id')->toArray();
        if (empty($selectedBookIds)) {
            return back()->with('error', 'Siz test ishlash uchun kitob tanlamagansiz.');
        }
        DB::beginTransaction();

        try {
            $allQuestions = collect();
            foreach ($selectedBookIds as $bookId) {
                $questions = Question::where('book_id', $bookId)
                    ->where('status', '1')->inRandomOrder()->limit(4)->get();
                $allQuestions = $allQuestions->merge($questions);
            }

            $neededQuestionsCount = 50 - $allQuestions->count();
            if ($neededQuestionsCount > 0) {
                $alreadyFetchedIds = $allQuestions->pluck('id')->toArray();
                $extraQuestions = Question::whereIn('book_id', $selectedBookIds)
                    ->whereNotIn('id', $alreadyFetchedIds)
                    ->where('status', '1')->inRandomOrder()
                    ->limit($neededQuestionsCount)->get();
                $allQuestions = $allQuestions->merge($extraQuestions);
            }
            $finalQuestions = $allQuestions->shuffle()->take(50);
            $attemptsData = [];
            $pos = 1;
            foreach ($finalQuestions as $question) {
                $attemptsData[] = [
                    'user_id' => auth()->id(),
                    'test_id' => $userbook->id,
                    'question_id' => $question->id,
                    'answer_id' => null,
                    'pos' => $pos++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Attempt::insert($attemptsData);
            $userbook->update([
                'status' => '1'
            ]);
            DB::commit();
            return redirect()->route('tests.index')->with('success', 'Test savollari muvaffaqiyatli tayyorlandi. Testni boshlashingiz mumkin!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Savollarni tayyorlashda xatolik yuz berdi: ' . $e->getMessage());
        }
    }
}

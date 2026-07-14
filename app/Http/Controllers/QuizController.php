<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function finish(Request $request, Test $test)
    {
        if ($test->user_id !== auth()->id() || $test->status !== '2') {
            return redirect()->route('tests.index')->with('error', 'Test yakunlangan yoki ruxsat yo‘q.');
        }

        $qCount = 50;
        $maxPoints = 20;
        $perPoint = $maxPoints / $qCount;

        DB::transaction(function () use ($test, $perPoint) {
            $attempts = Attempt::where('test_id', $test->id)->get();
            $correctCount = 0;
            foreach ($attempts as $attempt) {
                if ($attempt->answer_id) {
                    $isCorrect = Answer::where('id', $attempt->answer_id)->where('correct', '1')->exists();
                    if ($isCorrect) $correctCount++;
                }
            }

            $totalPoint = $correctCount * $perPoint;
            $test->update([
                'status' => '3',
                'finished_at' => now(),
                'score' => $totalPoint
            ]);
        });
        return redirect()->route('tests.index')->with('success', 'Test muvaffaqiyatli yakunlandi!');
    }
}

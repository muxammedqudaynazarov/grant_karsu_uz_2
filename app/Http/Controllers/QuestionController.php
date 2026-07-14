<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function create()
    {
        $categories = Category::where('status', '1')->get();
        return view('home.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'category' => 'required',
            'file' => 'required|array',
            'file.*' => 'file|mimes:txt',
        ], [
            'file.*.mimes' => 'Savollar fayli faqat .txt formatida bo‘lishi shart!'
        ]);

        DB::beginTransaction();

        try {
            $book = Book::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'status' => '1'
            ]);
            $languages = ['uz', 'kaa', 'ru'];
            $parsedData = [];
            $allErrors = [];
            $questionCounts = [];

            foreach ($languages as $lang) {
                if ($request->hasFile("file.{$lang}")) {
                    $file = $request->file("file.{$lang}");
                    $lines = file($file->getRealPath(), FILE_IGNORE_NEW_LINES);
                    $parseResult = $this->parseAikenWithErrors($lines);
                    $parsedData[$lang] = $parseResult['valid'];
                    $questionCounts[$lang] = count($parseResult['valid']);
                    if (!empty($parseResult['errors'])) {
                        $allErrors[$lang] = $parseResult['errors'];
                    }
                }
            }

            if (empty($parsedData)) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Fayllar topilmadi.');
            }

            $counts = array_values($questionCounts);
            if (count(array_unique($counts)) > 1) {
                DB::rollBack();
                $msg = "Xatolik: Yuklangan fayllardagi savollar soni bir xil emas (Masalan: ";
                foreach ($questionCounts as $l => $c) {
                    $msg .= strtoupper($l) . "=$c ta, ";
                }
                $msg = rtrim($msg, ", ") . "). Tillar orasida savollar ketma-ketligi buzilmasligi uchun ularning soni bir xil bo‘lishi shart.";
                return redirect()->back()->with('error', $msg);
            }

            $totalQuestions = $counts[0] ?? 0;
            if ($totalQuestions === 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Fayllardan biron-bir to‘g‘ri savol topilmadi. Formatni tekshiring.');
            }

            $uploadedLangs = array_keys($parsedData);
            for ($i = 0; $i < $totalQuestions; $i++) {
                $questionTranslations = [];
                foreach ($uploadedLangs as $lang) {
                    $questionTranslations[$lang] = $parsedData[$lang][$i]['question'];
                }
                $question = Question::create([
                    'question' => $questionTranslations,
                    'book_id' => $book->id,
                    'status' => '1'
                ]);
                $firstLang = $uploadedLangs[0];
                $correctKey = $parsedData[$firstLang][$i]['correct'];
                $answerKeys = array_keys($parsedData[$firstLang][$i]['answers']);

                foreach ($answerKeys as $key) {
                    $answerTranslations = [];
                    foreach ($uploadedLangs as $lang) {
                        $answerTranslations[$lang] = $parsedData[$lang][$i]['answers'][$key] ?? '';
                    }
                    Answer::create([
                        'answer' => $answerTranslations,
                        'question_id' => $question->id,
                        'correct' => ($key === $correctKey) ? '1' : '0',
                        'status' => '1',
                    ]);
                }
            }

            DB::commit();
            $successMsg = "Jami {$totalQuestions} ta savol muvaffaqiyatli yuklandi va tillar bo‘yicha birlashtirildi.";
            /*if (!empty($allErrors)) {
                $errorHtml = "<br><br><b>Ba’zi e’tiborsizliklar (qoldirib ketilgan qatorlar) kuzatildi:</b><br>";
                foreach ($allErrors as $lang => $errs) {
                    $errorHtml .= "<b>[{$lang}] faylida:</b><br>" . implode('<br>', array_slice($errs, 0, 5)) . "<br>";
                }
                return redirect()->back()->with('warning', $successMsg . $errorHtml);
            }*/
            return redirect()->back()->with('success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Savollarni guruhli yuklashda xatolik: " . $e->getMessage());
            return redirect()->back()->with('error', 'Tizim xatoligi: ' . $e->getMessage());
        }
    }

    private function detectQuestionType($text)
    {
        if (preg_match('/\\\\\(|\\\\\[|\$\$|\\\\begin\{equation\}/', $text)) {
            return 'math';
        }
        if (preg_match('/\\\(frac|sqrt|int|sum|lim|sin|cos|tan|cot|log|ln|pi|infty|theta|alpha|beta|gamma)/', $text)) {
            return 'math';
        }
        if (preg_match('/[a-zA-Z0-9]\^[a-zA-Z0-9\{]|\_[a-zA-Z0-9\{]/', $text)) {
            return 'math';
        }

        return 'text';
    }

    private function parseAikenWithErrors($lines)
    {
        $validQuestions = [];
        $errors = [];
        $buffer = [];
        $blockStartLine = 1;
        $lines[] = "";

        foreach ($lines as $index => $line) {
            $line = trim($line);
            $currentLineNum = $index + 1;

            if ($line === '') {
                if (!empty($buffer)) {
                    $result = $this->processBlock($buffer);
                    if ($result['status'] === 'success') {
                        $validQuestions[] = $result['data'];
                    } else {
                        $errors[] = "Qator {$blockStartLine}-{$index}: " . $result['message'];
                    }
                    $buffer = [];
                }
                $blockStartLine = $currentLineNum + 1;
            } else {
                $buffer[] = $line;
            }
        }
        return ['valid' => $validQuestions, 'errors' => $errors];
    }

    private function processBlock($lines)
    {
        if (count($lines) < 3) {
            return ['status' => 'error', 'message' => 'Format noto‘g‘ri yoki qatorlar yetarli emas.'];
        }

        $lastLine = array_pop($lines);
        if (!preg_match('/^ANSWER:\s*([A-Z])\s*$/i', $lastLine, $answerMatch)) {
            return ['status' => 'error', 'message' => "ANSWER qatori topilmadi yoki noto‘g‘ri: '$lastLine'"];
        }

        $correctOption = strtoupper($answerMatch[1]);
        $answers = [];
        $questionTextArr = [];
        $isOptionSection = false;

        foreach ($lines as $line) {
            if (!$isOptionSection && preg_match('/^([A-Z])[\.\)]\s+(.+)/', $line, $optMatch)) {
                $isOptionSection = true;
            }
            if ($isOptionSection) {
                if (preg_match('/^([A-Z])[\.\)]\s+(.+)/', $line, $optMatch)) {
                    $key = strtoupper($optMatch[1]);
                    $value = trim($optMatch[2]);
                    $answers[$key] = $value;
                } else {
                    $keys = array_keys($answers);
                    if (!empty($keys)) {
                        $lastParams = end($keys);
                        $answers[$lastParams] .= " " . $line;
                    }
                }
            } else {
                $questionTextArr[] = $line;
            }
        }

        $questionText = implode(" ", $questionTextArr);

        if (empty($questionText)) {
            return ['status' => 'error', 'message' => 'Savol matni topilmadi.'];
        }
        if (count($answers) < 2) {
            return ['status' => 'error', 'message' => 'Variantlar yetarli emas (kamida 2 ta).'];
        }
        if (!array_key_exists($correctOption, $answers)) {
            return ['status' => 'error', 'message' => "To‘g‘ri javob ($correctOption) variantlar orasida mavjud emas."];
        }

        $fullContentToCheck = $questionText . " " . implode(" ", $answers);
        $detectedType = $this->detectQuestionType($fullContentToCheck);

        return [
            'status' => 'success',
            'data' => [
                'question' => $questionText,
                'answers' => $answers,
                'correct' => $correctOption,
                'type' => $detectedType
            ]
        ];
    }
}

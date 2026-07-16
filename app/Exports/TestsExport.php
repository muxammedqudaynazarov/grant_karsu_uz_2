<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TestsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $tests;

    // Controller'dan kolleksiyani qabul qilib olamiz
    public function __construct($tests)
    {
        $this->tests = $tests;
    }

    public function collection()
    {
        return $this->tests;
    }

    // Sarlavhalarni belgilash (Blade faylingizdagi <thead> qismi)
    public function headings(): array
    {
        return [
            '#',
            __('main.Student name'),
            __('main.Faculty'),
            __('main.Course of Study'),
            __('main.Level'),
            __('main.Group'),
            __('main.Result'),
            __('main.Correct answers'),
            '%',
            __('main.Time'),
            __('main.Status'),
        ];
    }

    // Har bir qator (row) uchun ma'lumotlarni map qilish (Blade dagi <tbody> qismi)
    public function map($test): array
    {
        // Mutaxassislik kod va nomini birlashtirish
        $specialtyCode = $test->user->data['specialty']['code'] ?? '-';
        $specialtyName = $test->user->data['specialty']['name'] ?? '-';
        $courseOfStudy = $specialtyCode . ' - ' . $specialtyName;

        // Ballni hisoblash (Blade'dagi mantiq bo'yicha)
        $scoreValue = number_format($test->score, 2);
        $correctAnswers = $scoreValue / 0.4;
        $resultText = number_format(($correctAnswers / 50) * 100, 2);

        return [
            $test->id,
            $test->user->data['full_name'] ?? '-',
            $test->user->data['faculty']['name'] ?? '-',
            $courseOfStudy,
            $test->user->data['level']['name'] ?? '-',
            $test->user->data['group']['name'] ?? '-',
            $scoreValue,
            $correctAnswers,
            $resultText,
            $test->finished_at ? $test->finished_at->format('d.m.Y H:i:s') : '-',
            __('main.Finished'),
        ];
    }

    // Excel jadvaliga ozgina dizayn (stil) berish
    public function styles(Worksheet $sheet)
    {
        return [
            // 1-qator (Sarlavha) qalin harflarda va markazlashgan bo'ladi
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
}

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikatni tekshirish | Grant.KarSU.uz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-slate-100">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-slate-800" style="text-transform: uppercase">Sertifikatni tekshirish</h1>
        <p class="text-slate-500 mt-2" style="font-size: 11px;">
            «Kitobxonlik madaniyati» mezoni bo‘yicha ko‘rsatilgan natija
        </p>
    </div>

    @isset($test)
        <div class="mt-8 p-6 bg-green-50 rounded-xl border border-green-200 shadow-sm animate-in fade-in duration-500">
            <div class="flex flex-col items-center mb-6">
                <div
                    class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white mb-3 shadow-lg shadow-green-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 border border-green-100 space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Talabaning F.I.Sh:</span>
                    <span class="text-slate-800 font-semibold text-sm">
                        {{ $test->user->data['full_name'] ?? $test->user->name }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Fakultet</span>
                    <span class="text-slate-800 font-semibold text-sm">
                        {{ $test->user->data['faculty']['name'] }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Ta’lim yo‘nalishi</span>
                    <span class="text-slate-800 font-semibold text-sm">
                    {{ $test->user->data['specialty']['code'] }} – {{ $test->user->data['specialty']['name'] }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Kursi</span>
                    <span class="text-slate-800 font-semibold text-sm">
                    {{ $test->user->data['level']['name'] }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Ta’lim guruhi</span>
                    <span class="text-slate-800 font-semibold text-sm">
                    {{ $test->user->data['group']['name'] }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">To‘plagan ball:</span>
                    <span class="text-green-600 font-bold text-sm">{{ number_format($test->score, 2) }} ball</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Moslik mezoni:</span>
                    <span class="text-slate-800 font-bold text-sm">
                        {{ $limit->name ?? 'Kitobxonlik madaniyati' }}
                    </span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500 font-medium text-sm">Berilgan sana:</span>
                    <span class="text-slate-800 font-semibold text-sm">
                    {{ $test->finished_at ? \Carbon\Carbon::parse($test->finished_at)->format('d.m.Y H:i') : '---' }}
                </span>
                </div>
                <div class="flex justify-between text-xs text-slate-400 pt-2">
                    <span>Yuklab olingan: {{ $test->downloads ?? 0 }} marta</span>
                    <span>Tekshirilgan: {{ $test->checks ?? 0 }} marta</span>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('certificate.download', $test->uuid) }}"
                   class="inline-flex items-center justify-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition shadow-md hover:shadow-lg">
                    <i class="bi bi-download me-2"></i> Sertifikatni yuklab olish
                </a>
            </div>
        </div>
    @else
        <div class="mt-8 p-6 bg-red-50 rounded-xl border border-red-200 text-center shadow-sm">
            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-red-800 font-bold uppercase tracking-wide">Tasdiqlanmadi</h2>
            <p class="text-red-600 text-sm mt-1">
                Ushbu sertifikat tizim bazasida topilmadi va qonuniyligi tasdiqlanmadi.
            </p>
        </div>
    @endisset
</div>

</body>
</html>

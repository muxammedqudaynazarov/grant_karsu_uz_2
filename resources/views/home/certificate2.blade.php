<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        @font-face {
            font-family: 'Kanit';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("assets/fonts/arialbd.ttf.ttf") }}') format('truetype');
        }

        @font-face {
            font-family: 'Saira Stencil';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("assets/fonts/cour.ttf") }}') format('truetype');
        }

        @font-face {
            font-family: 'DM Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("assets/fonts/times.ttf") }}') format('truetype');
        }

        @font-face {
            font-family: 'DM Sans';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path("assets/fonts/timesbd.ttf") }}') format('truetype');
        }

        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background-image: url('{{ public_path("assets/images/crtbg.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            height: 100%;
            position: relative;
            text-align: center;
        }

        .student-name {
            position: absolute;
            top: 48%;
            left: 0;
            width: 100%;
            font-size: 28pt;
            font-weight: bold;
            color: #1e293b;
            font-family: "Kanit", sans-serif;
        }

        .student-name-sm {
            position: absolute;
            top: 52%;
            left: 0;
            width: 100%;
            font-size: 15pt;
            color: #888;
            font-family: "Kanit", sans-serif;
        }

        .text-content {
            position: absolute;
            top: 60%;
            left: 10%;
            width: 80%;
            font-size: 14px;
            color: #475569;
            font-family: "DM Sans", sans-serif;
        }

        .uuid {
            position: absolute;
            left: 5%;
            top: 1%;
            font-size: 12pt;
            color: #94a3b8;
            font-family: "Saira Stencil", sans-serif;
        }

        .qr-code-box {
            position: absolute;
            top: 74.5%;
            left: 43%;
        }

        .logo {
            position: absolute;
            top: 10%;
            left: 43%;
        }

        .header-content {
            position: absolute;
            top: 30%;
            left: 10%;
            width: 80%;
            font-size: 17px;
            color: #475569;
            font-family: "DM Sans", sans-serif;
        }

        .president-content {
            position: absolute;
            top: 74%;
            text-align: justify;
            left: 5%;
            width: 30%;
            font-size: 10px;
            color: #475569;
            font-family: "DM Sans", sans-serif;
        }

        .fake-content {
            position: absolute;
            top: 74%;
            text-align: justify;
            right: 5%;
            width: 30%;
            font-size: 10px;
            color: #475569;
            font-family: "DM Sans", sans-serif;
        }
    </style>

</head>
<body>

<div class="container">
    <div class="logo">
        <img src="{{ $karsu_logo }}" alt="">
    </div>
    <div class="header-content">
        {!! __('certificate.header_text', [
            'faculty' => $test->user->data['faculty']['name'] ?? '',
            'specialty_code' => $test->user->data['specialty']['code'] ?? '',
            'specialty_name' => $test->user->data['specialty']['name'] ?? '',
            'level' => $test->user->data['level']['name'] ?? '',
            'group' => $test->user->data['group']['name'] ?? ''
        ]) !!}
    </div>
    <div class="student-name">
        {{ $name }}
    </div>
    <div class="student-name-sm">
        {{ $test->user->data['full_name'] }}
    </div>

    <div class="text-content">
        {!! __('certificate.result_text', [
            'score' => number_format($score, 2),
            'test_name' => $test_name
        ]) !!}
    </div>
    <div class="president-content">
        {!! __('certificate.president_quote') !!}
    </div>
    <div class="fake-content">
        {!! __('certificate.warning_text') !!}
    </div>
    <div class="qr-code-box">
        <img src="{{ $qrcode }}" alt="QR Code" width="135">
    </div>
    <div class="uuid">ID: {{ $uuid }} / {{ $date }}</div>
</div>

</body>
</html>

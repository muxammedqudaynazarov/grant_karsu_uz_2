@extends('layouts.app')

@section('style')
    <style>
        .test-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-top: 4px solid #007bff;
            scroll-margin-top: 100px;
        }

        .test-card-header {
            padding: 25px;
            display: flex;
            align-items: flex-start;
            background: #fcfcfd;
        }

        .q-number {
            background: #007bff;
            color: #fff;
            min-width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .q-text {
            font-size: 1.15rem;
            color: #2d3436;
            font-weight: 500;
        }

        .test-card-body {
            padding: 0 25px 25px 25px;
        }

        .options-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border: 2px solid #edf2f7;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 0;
        }

        .option-item:hover {
            background: #f8faff;
            border-color: #cbd5e0;
        }

        .option-item input[type="radio"] {
            display: none;
        }

        .option-indicator {
            width: 22px;
            height: 22px;
            border: 2px solid #cbd5e0;
            border-radius: 50%;
            margin-right: 15px;
            position: relative;
            flex-shrink: 0;
        }

        .option-item input[type="radio"]:checked + .option-indicator {
            border-color: #007bff;
            background: #007bff;
        }

        .option-item input[type="radio"]:checked + .option-indicator::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .option-item input[type="radio"]:checked ~ .option-text {
            color: #007bff;
            font-weight: 600;
        }

        .option-item input[type="radio"]:checked {
            background: #f0f7ff;
            border-color: #007bff;
        }

        .quiz-map {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(35px, 1fr));
            gap: 6px;
        }

        .map-item {
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none !important;
            transition: 0.2s;
        }

        .map-item:hover {
            background: #e2e8f0;
        }

        .map-item.answered {
            background: #007bff;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        #timerDisplay {
            color: #2d3436;
            font-variant-numeric: tabular-nums;
        }

        .text-blink {
            animation: blinker 1s linear infinite;
            color: #e74c3c !important;
        }

        @keyframes blinker {
            50% {
                opacity: 0.3;
            }
        }

        body {
            scroll-behavior: smooth;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/polyfill/3.30.1/polyfill.min.js"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="content-wrapper bg-white">
        <section class="content">
            <div class="container-fluid">
                <form id="examForm" action="{{ route('tests.finish', $test->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div id="questions-container">
                                @foreach($attempts as $attempt)
                                    <div class="test-card mb-5 question-card" id="q_{{ $attempt->id }}">
                                        <div class="test-card-header">
                                            <span class="q-number">{{ $attempt->pos }}</span>
                                            <div class="q-text">
                                                @php
                                                    $qText = is_array($attempt->question->question) ? ($attempt->question->question['uz'] ?? '') : $attempt->question->question;
                                                @endphp
                                                {!! $qText !!}
                                                <br>
                                                <div style="font-size: 10px" class="text-muted">
                                                    {!! $attempt->question->book->name !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="test-card-body">
                                            <div class="options-container">
                                                @foreach($attempt->question->answers->shuffle() as $answer)
                                                    @php
                                                        $ansText = is_array($answer->answer) ? ($answer->answer['uz'] ?? '') : $answer->answer;
                                                    @endphp
                                                    <label class="option-item" for="opt_{{ $answer->id }}">
                                                        <input type="radio"
                                                               name="attempt[{{ $attempt->question_id }}]"
                                                               id="opt_{{ $answer->id }}"
                                                               value="{{ $answer->id }}"
                                                               class="answer-radio"
                                                               data-attempt-id="{{ $attempt->id }}"
                                                               data-question-id="{{ $attempt->question_id }}"
                                                               data-index="{{ $attempt->pos }}"
                                                               @if($attempt->answer_id == $answer->id) checked @endif>
                                                        <span class="option-indicator"></span>
                                                        <span class="option-text">{!! $ansText !!}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="sticky-top" style="top: 80px; z-index: 1000;">

                                <div class="card shadow-sm border-0 mb-3 rounded-lg">
                                    <div class="card-body p-3 text-center">
                                        <p class="text-muted mb-1 text-uppercase small font-weight-bold">{{ __('main.Time left') }}</p>
                                        <h2 class="font-weight-bold mb-0" id="timerDisplay">00:00:00</h2>
                                    </div>
                                </div>

                                <div class="card shadow-sm border-0 mb-3 rounded-lg">
                                    <div class="card-header bg-transparent border-0 pt-3 pb-0">
                                        <h6 class="font-weight-bold mb-0 text-sm text-center text-uppercase">
                                            {{ __('main.Question map') }}
                                        </h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="quiz-map">
                                            @foreach($attempts as $att)
                                                <a href="#q_{{ $att->id }}"
                                                   id="map_btn_{{ $att->pos }}"
                                                   class="map-item {{ $att->answer_id ? 'answered' : '' }}">
                                                    {{ $att->pos }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                        class="btn btn-success btn-block btn-lg shadow-sm font-weight-bold rounded-lg py-3 w-100"
                                        onclick="finishExam()">
                                    <i class="fas fa-paper-plane mr-2"></i> {{ __('main.Conclusion') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('.answer-radio');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const testId = {{ $test->id }};
                    const attemptId = this.getAttribute('data-attempt-id');
                    const answerId = this.value;
                    const index = this.getAttribute('data-index');
                    const mapBtn = document.getElementById('map_btn_' + index);
                    if (mapBtn) mapBtn.classList.add('answered');
                    fetch('{{ route('tests.answer.upload') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            test_id: testId,
                            attempt_id: attemptId,
                            answer_id: answerId
                        })
                    }).then(response => response.json())
                        .then(data => {
                            console.log("{{ __('main.Information returned from the server') }}: ", data);
                            if (data.status === 'error') {
                                Swal.fire('Xato!', data.message, 'error');
                                if (mapBtn) mapBtn.classList.remove('answered');
                            }
                        })
                        .catch(error => {
                            console.error('{{ __('main.Error saving via AJAX') }}: ', error);
                        });
                });
            });

            let endTime = {{ \Carbon\Carbon::parse($test->finished_at)->timestamp * 1000 }};
            let serverTime = {{ time() * 1000 }};
            let clientTime = new Date().getTime();
            let timeDiff = serverTime - clientTime;

            let timerInterval = setInterval(function () {
                let now = new Date().getTime() + timeDiff;
                let distance = endTime - now;

                if (distance <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById("timerDisplay").innerHTML = "00:00:00";
                    submitExam(true);
                    return;
                }

                let hours = Math.floor(distance / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("timerDisplay").innerHTML =
                    (hours < 10 ? "0" + hours : hours) + ":" +
                    (minutes < 10 ? "0" + minutes : minutes) + ":" +
                    (seconds < 10 ? "0" + seconds : seconds);

                if (distance < 60000) {
                    document.getElementById("timerDisplay").classList.add("text-blink");
                }
            }, 1000);
        });

        function finishExam() {
            Swal.fire({
                title: '{{ __('main.End the test?') }}',
                text: "{{ __('main.Recheck your answers.') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('main.Yes, completion') }}',
                cancelButtonText: '{{ __('main.No') }}',
                confirmButtonColor: '#28a745'
            }).then(res => {
                if (res.isConfirmed) submitExam(false);
            });
        }

        function submitExam(isAuto = false) {
            window.onbeforeunload = null;
            document.getElementById('examForm').submit();
        }

        window.onbeforeunload = function () {
            return "{{ __('main.Refreshing the page may stop the test!') }}";
        };
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => {
            e.preventDefault();
            Swal.fire('!!!!!!', '{{ __('main.Copying is strictly prohibited.') }}!', 'warning');
        });
        document.addEventListener('selectstart', e => e.preventDefault());

        let violationCount = 0;
        const MAX_VIOLATIONS = 3;
        document.addEventListener("visibilitychange", function () {
            if (document.hidden) {
                if (++violationCount >= MAX_VIOLATIONS) {
                    Swal.fire({
                        title: '{{ __('main.The test has been stopped!') }}',
                        text: '{{ __('main.You have exceeded the window switching limit.') }}',
                        icon: 'error',
                        timer: 4000,
                        showConfirmButton: false
                    }).then(() => submitExam(true));
                } else {
                    Swal.fire({
                        title: '{{ __('main.Warning!') }}',
                        text: `{{ __('main.Switching to another window is prohibited. Your remaining chance') }} ${MAX_VIOLATIONS - violationCount}`,
                        icon: 'warning'
                    });
                }
            }
        });
    </script>
@endsection

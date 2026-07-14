@extends('layouts.app')

@section('style')
    <style>
        .custom-accordion .accordion-item {
            overflow: hidden;
            border-color: #e2e8f0 !important;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .custom-accordion .accordion-button {
            font-weight: 600;
        }

        .custom-accordion .accordion-button:not(.collapsed) {
            background-color: #f8fafc;
            color: #4f46e5;
            box-shadow: none;
        }

        .custom-accordion .accordion-button:focus {
            box-shadow: none;
        }

        .custom-checkbox-btn {
            border-color: #cbd5e1;
            color: #475569;
            transition: all 0.2s ease;
            background-color: #fff;
            user-select: none;
        }

        .custom-checkbox-btn:hover {
            background-color: #f1f5f9;
        }

        .btn-check:checked + .custom-checkbox-btn {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transform: translateY(-2px);
        }

        .btn-check:disabled + .custom-checkbox-btn {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f8fafc;
            transform: none;
            box-shadow: none;
        }

        .sticky-counter-box {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #4f46e5;
            transition: all 0.3s ease;
        }

        html[data-theme="dark"] .sticky-counter-box {
            background: rgba(30, 41, 59, 0.95);
            border-color: #334155;
            border-left-color: #4f46e5;
            color: white;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('tests.update', $test->id) }}" method="POST" id="bookSelectionForm">
        @csrf
        @method('PUT')
        <div class="container-fluid py-4" style="padding-bottom: 100px !important;">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom py-3 rounded-top-4">
                    <h2 class="h5 mb-0 text-primary d-flex align-items-center gap-2 fw-bold">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>{{ __('main.Choose books') }}</span>
                    </h2>
                </div>

                <div class="card-body p-4">
                    <div class="accordion accordion-flush custom-accordion" id="categoryAccordion">
                        @foreach($categories as $cat)
                            <div class="accordion-item border rounded mb-3 shadow-sm">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed px-4 py-3" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseCat{{ $cat->id }}" aria-expanded="false"
                                            aria-controls="collapseCat{{ $cat->id }}">

                                        {{ $cat->name }}
                                        <span class="badge bg-primary rounded-pill ms-auto" style="margin-right: 10px;">
                                            {{ $cat->books->count() }}
                                        </span>
                                    </button>
                                </h3>

                                <div id="collapseCat{{ $cat->id }}" class="accordion-collapse collapse"
                                     data-bs-parent="#categoryAccordion">
                                    <div class="accordion-body p-4 bg-light rounded-bottom">
                                        @if($cat->books->count() > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($cat->books->sortBy('name') as $book)
                                                    <div>
                                                        <input type="checkbox" class="btn-check book-checkbox"
                                                               name="books[]"
                                                               id="book{{ $book->id }}"
                                                               value="{{ $cat->id }}|{{ $book->id }}"
                                                               autocomplete="off"
                                                            {{ in_array($book->id, $selectedBooks) ? 'checked' : '' }}>
                                                        <label
                                                            class="btn btn-outline-primary rounded-pill px-4 py-2 custom-checkbox-btn"
                                                            for="book{{ $book->id }}">
                                                            {{ $book->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted text-center py-4">
                                                {{ __('main.There are currently no books in this section.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-counter-box" id="counterBox">
            <div>
                <span id="counterText">0</span>
                <span>/ 12</span>
            </div>
            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" disabled>
                {{ __('main.Save') }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.book-checkbox');
            const counterText = document.getElementById('counterText');
            const submitBtn = document.getElementById('submitBtn');
            const REQUIRED_COUNT = 12;

            function updateCounter() {
                const checkedCount = document.querySelectorAll('.book-checkbox:checked').length;
                counterText.textContent = checkedCount;
                checkboxes.forEach(cb => {
                    if (!cb.checked) {
                        cb.disabled = (checkedCount >= REQUIRED_COUNT);
                    }
                });
                if (checkedCount === REQUIRED_COUNT) {
                    submitBtn.disabled = false;
                    counterText.classList.remove('text-primary');
                    counterText.classList.add('text-success');
                    submitBtn.classList.replace('btn-primary', 'btn-success');
                } else {
                    submitBtn.disabled = true;
                    counterText.classList.add('text-primary');
                    counterText.classList.remove('text-success');
                    submitBtn.classList.replace('btn-success', 'btn-primary');
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCounter);
            });

            document.getElementById('bookSelectionForm').addEventListener('submit', function (e) {
                const checkedCount = document.querySelectorAll('.book-checkbox:checked').length;
                if (checkedCount !== REQUIRED_COUNT) {
                    e.preventDefault();
                    let alertMessage = "{{ __('main.Please select exactly required books! You currently have checked books selected.') }}";
                    alertMessage = alertMessage.replace(':required', REQUIRED_COUNT).replace(':checked', checkedCount);
                    alert(alertMessage);
                }
            });
            updateCounter();
        });
    </script>
@endsection

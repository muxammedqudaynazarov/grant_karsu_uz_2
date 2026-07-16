@extends('layouts.app')

@section('style')
    <style>
        /* Mobil qurilmalar uchun jadvalni Card ko'rinishiga o'tkazish */
        @media (max-width: 767.98px) {
            .responsive-mobile-table {
                display: block;
                width: 100%;
            }

            .responsive-mobile-table thead,
            .responsive-mobile-table tbody,
            .responsive-mobile-table tr,
            .responsive-mobile-table th,
            .responsive-mobile-table td {
                display: block;
                width: 100%;
            }

            /* Sarlavhalarni yashirish (ko'zdan, lekin ekranni o'qigichlar uchun qoladi) */
            .responsive-mobile-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            /* Har bir qator (tr) ni karta qilib shakllantirish */
            .responsive-mobile-table tr {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                margin-bottom: 1rem;
                padding: 0.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            /* Hujayralarni (td) moslashtirish */
            .responsive-mobile-table td {
                border: none;
                border-bottom: 1px solid #f1f5f9;
                position: relative;
                padding: 0.75rem 0.75rem 0.75rem 45% !important;
                text-align: right !important;
                min-height: 45px;
            }

            .responsive-mobile-table td:last-child {
                border-bottom: 0;
                padding-left: 0.75rem !important;
                text-align: center !important;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            /* "data-label" orqali qator nomlarini chap tomonga chiqarish */
            .responsive-mobile-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 40%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: 600;
                color: #64748b;
                font-size: 0.85rem;
                text-transform: uppercase;
            }

            .responsive-mobile-table td:last-child:before {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel bg-white rounded-4 shadow-sm border p-3">
        <table class="table text-center align-middle mb-0 responsive-mobile-table">
            <thead class="table-light">
            <tr>
                <th style="width: 15%">ID</th>
                <th>{{ __('main.Student name') }}</th>
                <th>{{ __('main.Result') }}</th>
                <th>{{ __('main.Time') }}</th>
                <th>{{ __('main.Status') }}</th>
                <th style="width: 20%">Amallar</th>
            </tr>
            </thead>
            <tbody>
            @if($test)
                <tr>
                    <td data-label="ID">
                        <code>{{ mb_substr(base64_encode($test->uuid), 0, 15) }}</code>
                    </td>

                    <td data-label="{{ __('main.Student name') }}" class="text-md-center text-end">
                        <div class="fw-bold text-dark">{{ $test->user->data['full_name'] }}</div>
                        <div class="text-muted small">
                            {{ $test->user->data['specialty']['code'] }} – {{ $test->user->data['level']['name'] }}
                        </div>
                    </td>

                    <td data-label="{{ __('main.Result') }}" class="fw-bold text-primary">
                        @if($test->status == '3')
                            {{ number_format($test->score, 2) }} ball
                        @else
                            --
                        @endif
                    </td>

                    <td data-label="{{ __('main.Time') }}">
                        <code class="text-muted">{{ $test->created_at->format('d.m.Y H:i') }}</code>
                    </td>

                    <td data-label="{{ __('main.Status') }}">
                        @if($test->status == '0')
                            <span class="badge bg-dark bg-opacity-10 text-dark">{{ __('main.Choosing books') }}</span>
                        @elseif($test->status == '1')
                            <span
                                class="badge bg-danger bg-opacity-10 text-danger">{{ __('main.Test is ready') }}</span>
                        @elseif($test->status == '2')
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ __('main.In process') }}</span>
                        @elseif($test->status == '3')
                            <span class="badge bg-success bg-opacity-10 text-success">{{ __('main.Finished') }}</span>
                        @endif
                    </td>

                    <td>
                        @if($test->status == '0')
                            <a href="{{ route('tests.edit', $test->id) }}"
                               class="btn btn-outline-primary btn-sm rounded-3 mb-1 w-100">
                                <i class="bi bi-pencil me-1"></i> {{ __('main.Change books') }}
                            </a>
                            <form action="{{ route('userbooks.update', $test->id) }}" class="d-inline-block w-100"
                                  method="POST" id="confirmBooksForm">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm rounded-3 mt-md-0 mt-2 w-100" type="button"
                                        onclick="confirmBooks()">
                                    <i class="bi bi-check2-circle me-1"></i> {{ __('main.Book approval') }}
                                </button>
                            </form>
                        @elseif($test->status == '1' || $test->status == '2')
                            <a href="{{ route('tests.show', $test->id) }}"
                               class="btn btn-danger btn-sm rounded-3 w-100">
                                <i class="bi bi-play-fill me-1"></i> {{ __('main.Start') }}
                            </a>
                        @elseif($test->status == '3')
                            <a href="{{ route('certificate.download', $test->uuid) }}"
                               class="btn btn-primary btn-sm rounded-3 w-100">
                                <i class="bi bi-patch-check-fill me-1"></i> {{ __('main.Certificate') }}
                            </a>
                        @endif
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <p class="text-danger mb-3">{{ __('main.Test info') }}</p>
                        <a href="{{route('tests.create')}}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-journal-plus me-2"></i> {{ __('main.Choose books') }}
                        </a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmBooks() {
            Swal.fire({
                title: '{{ __('main.Attention, can you confirm?') }}',
                html: `{{ __('main.Test questions will be formulated based on the books you choose.') }}`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: '{{ __('main.Yes, I confirm.') }}',
                cancelButtonText: '{{ __('main.Cancel') }}',
                reverseButtons: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('confirmBooksForm').submit();
                }
            });
        }
    </script>
@endsection

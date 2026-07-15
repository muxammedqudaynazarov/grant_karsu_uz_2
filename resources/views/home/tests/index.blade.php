@extends('layouts.app')

@section('content')
    <div class="panel">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th>{{ __('main.Student name') }}</th>
                    <th>{{ __('main.Result') }}</th>
                    <th>{{ __('main.Time') }}</th>
                    <th>{{ __('main.Status') }}</th>
                    <th style="width: 15%"></th>
                </tr>
                </thead>
                <tbody>
                @if($test)
                    <tr>
                        <td class="align-middle">
                            <code>
                                {{ mb_substr(base64_encode($test->uuid), 0, 15) }}
                            </code>
                        </td>
                        <td class="align-middle">
                            <div class="fw-bold">
                                {{ $test->user->data['full_name'] }}
                            </div>
                            <div class="text-muted small">
                                {{ $test->user->data['specialty']['code'] }} –
                                {{ $test->user->data['specialty']['name'] }},
                                {{ $test->user->data['level']['name'] }}
                            </div>
                        </td>
                        <td class="align-middle">
                            @if($test->status == '3')
                                {{ number_format($test->score, 2) }}
                                ({{ number_format($test->score, 2) }} / )
                            @else
                                --
                            @endif
                        </td>
                        <td class="align-middle">
                            <code>
                                {{ $test->created_at->format('d.m.Y H:i:s') }}
                            </code>
                        </td>
                        <td class="small align-middle">
                            @if($test->status == '0')
                                <div class="badge bg-dark">
                                    {{ __('main.Choosing books') }}
                                </div>
                            @elseif($test->status == '1')
                                <div class="badge bg-danger">
                                    {{ __('main.Test is ready') }}
                                </div>
                            @elseif($test->status == '2')
                                <div class="badge bg-primary">
                                    {{ __('main.In process') }}
                                </div>
                            @elseif($test->status == '3')
                                <div class="badge bg-success">
                                    {{ __('main.Finished') }}
                                </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($test->status == '0')
                                <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-primary btn-sm mb-1"
                                   style="font-weight: normal">
                                    <i class="bi bi-pencil me-1"></i> {{ __('main.Change books') }}
                                </a>
                                <form action="{{ route('userbooks.update', $test->id) }}"
                                      class="d-inline-block" method="POST" id="confirmBooksForm">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm mb-1"
                                            type="button" onclick="confirmBooks()"
                                            style="font-weight: 500; border-radius: 8px;">
                                        <i class="bi bi-check2-circle me-1"></i> {{ __('main.Book approval') }}
                                    </button>
                                </form>
                            @elseif($test->status == '1' || $test->status == '2')
                                <a href="{{ route('tests.show', $test->id) }}" class="btn btn-danger btn-sm mb-1"
                                   style="font-weight: normal">
                                    <i class="bi bi-play me-1"></i> {{ __('main.Start') }}
                                </a>
                            @elseif($test->status == '3')
                                <a href="{{ route('certificate.download', $test->uuid) }}"
                                   class="btn btn-outline-primary btn-sm" style="font-weight: normal">
                                    {{ __('main.Certificate') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="6" class="small text-danger">
                            <div>
                                {{ __('main.Test info') }}
                            </div>
                            <a href="{{route('tests.create')}}" class="btn btn-primary my-3">
                                {{ __('main.Choose books') }}
                            </a>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmBooks() {
            let bookCount = "{{ $selectedBooksCount ?? 12 }}";
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

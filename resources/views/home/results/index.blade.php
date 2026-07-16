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
                @forelse($tests as $test)
                    <tr>
                        <td class="align-middle">
                            <code>
                                #{{ $test->id }}
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
                            {{ number_format($test->score, 2) }}
                            <small class="text-danger">({{ ($test->score / 0.4) }} / 50)</small>
                        </td>
                        <td class="align-middle">
                            <code>
                                {{ $test->finished_at->format('d.m.Y H:i:s') }}
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
                            <a href="{{ route('certificate.download', $test->uuid) }}"
                               class="btn btn-outline-primary btn-sm" style="font-weight: normal">
                                {{ __('main.Certificate') }}
                            </a>
                        </td>
                    </tr>
                @empty
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
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $tests->links() }}
    </div>
@endsection

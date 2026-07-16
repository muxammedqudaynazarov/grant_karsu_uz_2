@extends('layouts.app')

@section('content')
    <div class="panel">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('main.Student name') }}</th>
                    <th>{{ __('main.Faculty') }}</th>
                    <th>{{ __('main.Course of Study') }}</th>
                    <th>{{ __('main.Level') }}</th>
                    <th>{{ __('main.Group') }}</th>
                    <th>{{ __('main.Result') }}</th>
                    <th>{{ __('main.Time') }}</th>
                    <th>{{ __('main.Status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($tests as $test)
                    <tr class="small">
                        <td class="align-middle">
                            <code>
                                #{{ $test->id }}
                            </code>
                        </td>
                        <td class="align-middle fw-bold">
                            {{ $test->user->data['full_name'] }}
                        </td>
                        <td class="align-middle">
                            {{ $test->user->data['faculty']['name'] }}
                        </td>
                        <td class="align-middle">
                            {{ $test->user->data['specialty']['code'] }} –
                            {{ $test->user->data['specialty']['name'] }}
                        </td>
                        <td class="align-middle">
                            {{ $test->user->data['level']['name'] }}
                        </td>
                        <td class="align-middle">
                            {{ $test->user->data['group']['name'] }}
                        </td>
                        <td class="align-middle">
                            <div class="badge bg-primary">
                                {{ number_format($test->score, 2) }}
                                <small class="text-dark">({{ ($test->score / 0.4) }} / 50)</small>
                            </div>
                        </td>
                        <td class="align-middle">
                            <code>
                                {{ $test->finished_at->format('d.m.Y H:i:s') }}
                            </code>
                        </td>
                        <td class="align-middle">
                            {{ __('main.Finished') }}
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

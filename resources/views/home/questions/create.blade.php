@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-bottom py-3 rounded-top-4">
            <h2 class="h5 mb-0 text-primary d-flex align-items-center fw-bold">
                {{ __('main.Upload questions to the system') }}
            </h2>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label for="category" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Categorization book') }}
                                </label>
                                <select name="category" id="category" class="form-select" required>
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="name_uz" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Book name') }} [UZ]
                                </label>
                                <input type="text" name="name[uz]" id="name_uz" class="form-control"
                                       placeholder="O‘zbek tilidagi nomini kiriting..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="file_uz" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Questions file') }} [UZ]
                                </label>
                                <input type="file" name="file[uz]" id="file_uz" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light border-0 mb-3 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="name_kaa" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Book name') }} [KAA]
                                </label>
                                <input type="text" name="name[kaa]" id="name_kaa" class="form-control"
                                       placeholder="Qoraqalpoq tilidagi nomini kiriting..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="file_kaa" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Questions file') }} [KAA]
                                </label>
                                <input type="file" name="file[kaa]" id="file_kaa" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light border-0 mb-4 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="name_ru" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Book name') }} [RU]
                                </label>
                                <input type="text" name="name[ru]" id="name_ru" class="form-control"
                                       placeholder="Rus tilidagi nomini kiriting..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="file_ru" class="form-label small fw-bold text-secondary">
                                    {{ __('main.Questions file') }} [RU]
                                </label>
                                <input type="file" name="file[ru]" id="file_ru" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> {{ __('main.Upload all questions to the server') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

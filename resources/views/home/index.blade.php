@extends('layouts.app')

@section('style')
    <style>
        /* Profil kartasi soyasi va shakli */
        .profile-card {
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
        }

        /* Talaba rasmi uchun halqa effekti */
        .avatar-ring {
            padding: 4px;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border-radius: 50%;
            display: inline-block;
        }

        .avatar-ring img {
            border: 4px solid #fff;
        }

        /* Gradient chaqiriq kartasi (Call to action) */
        .action-card {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Orqa fon bezaklari */
        .action-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(20px);
        }

        .action-card::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 20%;
            width: 200px;
            height: 200px;
            background: rgba(13, 110, 253, 0.2);
            border-radius: 50%;
            filter: blur(30px);
        }

        /* Kichik ma'lumot qutilari */
        .info-box {
            border-radius: 16px;
            transition: all 0.2s ease;
        }

        .info-box:hover {
            background-color: #f8fafc !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
        }

        .icon-wrapper {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-2">

        <div class="row mb-4 align-items-center">
            <div class="col-12">
                <h4 class="fw-bold text-dark mb-1">
                    {{ __('main.Home page') }}
                </h4>
                <p class="text-muted mb-0 small">
                    {{ __('main.Welcome to the personal account of the Student KPI platform!') }}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card profile-card border-0 shadow-sm h-100 bg-white">
                    <div class="card-body text-center p-4 p-xl-5">
                        <div class="avatar-ring mb-3 shadow-sm">
                            <img src="{{ auth()->user()->data['image'] ?? asset('images/default-avatar.png') }}"
                                 alt="Student Avatar"
                                 class="rounded-circle object-fit-cover"
                                 style="width: 120px; height: 120px;">
                        </div>

                        <h5 class="fw-bold text-dark mb-1">
                            {{ auth()->user()->data['full_name'] ?? auth()->user()->name }}
                        </h5>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-upc-scan me-1"></i> ID: <span
                                class="text-dark fw-semibold">{{ auth()->user()->data['student_id_number'] ?? 'Mavjud emas' }}</span>
                        </p>

                        <div class="d-flex justify-content-center gap-2 mb-4">
                        <span
                            class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-star-fill text-warning me-1"></i> GPA: {{ auth()->user()->data['avg_gpa'] ?? '0.00' }}
                        </span>
                            <span
                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-mortarboard-fill me-1"></i> {{ auth()->user()->data['level']['name'] ?? 'Noma\'lum' }}
                        </span>
                        </div>

                        <hr class="bg-light my-4">

                        <div class="text-start">
                            <div class="mb-3">
                                <span class="d-block text-muted small fw-semibold mb-1 text-uppercase">
                                    {{ __('main.Faculty') }}
                                </span>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    {{ auth()->user()->data['faculty']['name'] ?? __('main.No information') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <span
                                    class="d-block text-muted small fw-semibold mb-1 text-uppercase">
                                    {{ __('main.Course of Study') }}
                                </span>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    {{ auth()->user()->data['specialty']['name'] ?? __('main.No information') }}
                                </div>
                            </div>
                            <div class="mb-0">
                                <span class="d-block text-muted small fw-semibold mb-1 text-uppercase">
                                    {{ __('main.Group') }}
                                </span>
                                <div class="d-flex align-items-center text-dark fw-medium">
                                    {{ auth()->user()->data['group']['name'] ?? __('main.No information') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="card info-box border-0 bg-white h-100">
                            <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                                <div class="icon-wrapper bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="bi bi-clock-history fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-semibold mb-1 text-uppercase">{{ __('main.Form of education') }}</h6>
                                    <p class="fw-bold text-dark mb-0">{{ auth()->user()->data['educationForm']['name'] ?? __('main.No information') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card info-box border-0 bg-white h-100">
                            <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                                <div class="icon-wrapper bg-success bg-opacity-10 text-success me-3">
                                    <i class="bi bi-wallet2 fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-semibold mb-1 text-uppercase">{{ __('main.Payment method') }}</h6>
                                    <p class="fw-bold text-dark mb-0">{{ auth()->user()->data['paymentForm']['name'] ?? __('main.No information') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card info-box border-0 bg-white">
                            <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                                <div class="icon-wrapper bg-danger bg-opacity-10 text-danger me-3">
                                    <i class="bi bi-geo-alt-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small fw-semibold mb-1 text-uppercase">{{ __('main.Residential address') }}</h6>
                                    <p class="fw-bold text-dark mb-0">{{ auth()->user()->data['address'] ?? __('main.No information') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

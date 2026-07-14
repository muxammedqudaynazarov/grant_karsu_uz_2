<!doctype html>
<html lang="uz" dir="ltr">
<head>
    <title>Student KPI | Tizimga kirish</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon"/>

    <!-- Shriftlar va Ikonkalar -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>

    <!-- Tailwind CSS (Agar loyihangizda o'rnatilmagan bo'lsa CDN orqali ishlaydi) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Sozlamalari va Kichik Animatsiyalar -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'slide-in': 'slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'slide-out': 'slideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': {transform: 'translate(0px, 0px) scale(1)'},
                            '33%': {transform: 'translate(30px, -50px) scale(1.1)'},
                            '66%': {transform: 'translate(-20px, 20px) scale(0.9)'},
                            '100%': {transform: 'translate(0px, 0px) scale(1)'},
                        },
                        slideIn: {
                            '0%': {transform: 'translateX(100%)', opacity: '0'},
                            '100%': {transform: 'translateX(0)', opacity: '1'},
                        },
                        slideOut: {
                            '0%': {transform: 'translateX(0)', opacity: '1'},
                            '100%': {transform: 'translateX(100%)', opacity: '0'},
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Toast uchun maxsus z-index va joylashuv */
        #toast-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
    </style>
</head>

<body
    class="bg-slate-50 font-sans text-slate-800 antialiased selection:bg-primary-500 selection:text-white min-h-screen flex items-center justify-center relative overflow-hidden">

<!-- Orqa fon animatsiyalari (Bloklar) -->
<div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
    <div
        class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-purple-300 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob"></div>
    <div
        class="absolute top-[20%] right-[-10%] w-[35rem] h-[35rem] bg-blue-300 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob"
        style="animation-delay: 2s;"></div>
    <div
        class="absolute bottom-[-20%] left-[20%] w-[40rem] h-[40rem] bg-indigo-300 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob"
        style="animation-delay: 4s;"></div>
</div>

<!-- Asosiy Login Karta -->
<div class="relative z-10 w-full max-w-xl px-6 py-10 mx-auto">
    <div
        class="bg-white/80 backdrop-blur-xl border border-white/40 shadow-2xl shadow-indigo-500/10 rounded-3xl p-8 sm:p-10">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 p-3 mb-5 transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('assets/images/karsu_logo.png') }}" alt="KarSU Logo"
                     class="w-full h-full object-contain"/>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tizimga kirish</h2>
            <p class="text-sm text-slate-500 mt-1.5 font-medium">Student KPI platformasiga xush kelibsiz</p>
        </div>

        <!-- Forma -->
        <form action="{{ route('login') }}" method="post" class="space-y-6">
            @csrf

            <!-- HEMIS ID Input -->
            <div class="space-y-1.5">
                <label for="username" class="block text-sm font-semibold text-slate-700 ml-1">HEMIS ID</label>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="ti ti-id text-xl"></i>
                    </div>
                    <input type="text" id="username" name="username" required autocomplete="username"
                           class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 text-slate-900 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all duration-200 outline-none placeholder:text-slate-400"
                           placeholder="Talaba ID raqami"/>
                </div>
            </div>

            <!-- Parol Input -->
            <div class="space-y-1.5">
                <label for="password" class="block text-sm font-semibold text-slate-700 ml-1">Parol</label>
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="ti ti-lock text-xl"></i>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="block w-full pl-11 pr-12 py-3.5 bg-slate-50/50 border border-slate-200 text-slate-900 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all duration-200 outline-none placeholder:text-slate-400"
                           placeholder="Parolingizni kiriting"/>

                    <!-- Parolni ko'rish tugmasi -->
                    <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                        <i class="ti ti-eye text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Tugmasi -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 px-4 rounded-2xl shadow-lg shadow-primary-500/30 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-primary-500/50 flex items-center justify-center gap-2">
                    <span>Tizimga kirish</span>
                    <i class="ti ti-arrow-right text-lg"></i>
                </button>
            </div>
        </form>

        <!-- Admin sahifasiga o'tish -->
        <div class="mt-8 text-center pt-6 border-t border-slate-100">
            <a href="?start=1"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-primary-600 transition-colors">
                <i class="ti ti-shield-lock text-lg"></i>
                Admin sahifasiga o'tish
            </a>
        </div>

    </div>
</div>

<!-- Toast Konteyner -->
<div id="toast-container"></div>

<!-- Eski template skriptlari (agar boshqa sahifalar uchun kerak bo'lsa) -->
<script src="{{ asset('/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('/js/component.js') }}"></script>

<script>
    // Parolni ko'rsatish/yashirish funksiyasi
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        if (isPassword) {
            toggleIcon.classList.remove('ti-eye');
            toggleIcon.classList.add('ti-eye-off');
            toggleIcon.classList.add('text-primary-600');
        } else {
            toggleIcon.classList.remove('ti-eye-off');
            toggleIcon.classList.add('ti-eye');
            toggleIcon.classList.remove('text-primary-600');
        }
    });

    // Chiroyli Toast Xabarnomalar Logikasi (Tailwind klaslari bilan)
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        // Xabarnoma dizayni (Ranglar)
        const baseClasses = 'flex items-center w-full max-w-sm p-4 rounded-2xl shadow-xl animate-slide-in';
        const typeClasses = type === 'success'
            ? 'bg-emerald-500 text-white shadow-emerald-500/20'
            : 'bg-rose-500 text-white shadow-rose-500/20';

        toast.className = `${baseClasses} ${typeClasses}`;

        // Ikonka
        const iconHtml = type === 'success'
            ? '<i class="ti ti-circle-check-filled text-2xl"></i>'
            : '<i class="ti ti-alert-circle-filled text-2xl"></i>';

        toast.innerHTML = `
                <div class="inline-flex items-center justify-center shrink-0">
                    ${iconHtml}
                </div>
                <div class="ml-3 text-sm font-medium">${message}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white/10 text-white hover:bg-white/20 rounded-xl focus:ring-2 focus:ring-white p-1.5 inline-flex h-8 w-8 items-center justify-center transition-colors" onclick="this.parentElement.remove()">
                    <i class="ti ti-x text-lg"></i>
                </button>
            `;

        container.appendChild(toast);

        // 5 soniyadan so'ng animatsiya bilan o'chirish
        setTimeout(() => {
            toast.classList.replace('animate-slide-in', 'animate-slide-out');
            setTimeout(() => toast.remove(), 400); // Animatsiya tugashini kutish
        }, 5000);
    }

    // Laravel orqali keladigan xatolik va xabarlarni ushlab olish
    @error('username')
    showToast('{{ $message }}', 'error');
    @enderror

    @if (session('error'))
    showToast('{{ session('error') }}', 'error');
    @endif

    @if (session('success'))
    showToast('{{ session('success') }}', 'success');
    @endif
</script>
</body>
</html>

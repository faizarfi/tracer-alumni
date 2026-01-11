<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password - Tracer Alumni</title>
    <link rel="icon" href="{{ asset('img/uin.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:Inter, sans-serif}</style>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('img/uin.png') }}" class="mx-auto w-20 h-20" alt="logo">
            <h1 class="mt-4 text-2xl font-bold text-gray-800">Reset Password</h1>
            <p class="text-sm text-gray-500">Buat password baru untuk akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ request()->query('email') ?? old('email') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:ring-2 focus:ring-green-500">
            </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <div class="relative mt-1">
                        <input id="password" type="password" name="password" required aria-describedby="pw-help"
                            class="peer block w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 pr-12 focus:ring-2 focus:ring-green-500 transition-shadow" placeholder="Min. 8 karakter">
                        <button type="button" id="togglePassword" aria-label="Tampilkan/SEMBUNYIKAN password"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500 hover:text-gray-800">
                            <!-- eye icon -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3.172 3.172a4 4 0 015.656 0L12 6.343l3.172-3.171a4 4 0 115.656 5.656L17.657 12l3.171 3.172a4 4 0 11-5.656 5.656L12 17.657l-3.172 3.171a4 4 0 11-5.656-5.656L6.343 12 3.172 8.828a4 4 0 010-5.656z"/>
                            </svg>
                        </button>
                    </div>
                    <p id="pw-help" class="mt-2 text-xs text-gray-500">Gunakan minimal 8 karakter, kombinasi huruf, angka, dan simbol untuk kekuatan terbaik.</p>

                    <div class="mt-3" aria-hidden="true">
                        <div class="h-2 rounded bg-gray-200 overflow-hidden">
                            <div id="pw-strength" class="h-2 rounded transition-all duration-300 w-0 bg-red-400"></div>
                        </div>
                        <p id="pw-strength-text" class="mt-2 text-xs font-medium text-red-600">Kekuatan: Lemah</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="relative mt-1">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 pr-12 focus:ring-2 focus:ring-green-500 transition-shadow">
                        <button type="button" id="toggleConfirm" aria-label="Tampilkan/SEMBUNYIKAN konfirmasi password"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500 hover:text-gray-800">
                            <svg id="eyeOpenConf" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeClosedConf" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3.172 3.172a4 4 0 015.656 0L12 6.343l3.172-3.171a4 4 0 115.656 5.656L17.657 12l3.171 3.172a4 4 0 11-5.656 5.656L12 17.657l-3.172 3.171a4 4 0 11-5.656-5.656L6.343 12 3.172 8.828a4 4 0 010-5.656z"/>
                            </svg>
                        </button>
                    </div>
                </div>

            <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">Reset Password</button>

            <p class="text-center text-sm text-gray-500">Kembali ke <a href="{{ route('login') }}" class="text-green-700 font-semibold">Login</a></p>
        </form>
    </div>
    <script>
        (function(){
            const pwd = document.getElementById('password');
            const pwdConf = document.getElementById('password_confirmation');
            const toggle = document.getElementById('togglePassword');
            const toggleConf = document.getElementById('toggleConfirm');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            const eyeOpenConf = document.getElementById('eyeOpenConf');
            const eyeClosedConf = document.getElementById('eyeClosedConf');
            const strengthBar = document.getElementById('pw-strength');
            const strengthText = document.getElementById('pw-strength-text');

            function toggleInput(input, openIcon, closedIcon){
                if(input.type === 'password'){
                    input.type = 'text';
                    if(openIcon) openIcon.classList.add('hidden');
                    if(closedIcon) closedIcon.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    if(openIcon) openIcon.classList.remove('hidden');
                    if(closedIcon) closedIcon.classList.add('hidden');
                }
            }

            toggle && toggle.addEventListener('click', function(){
                toggleInput(pwd, eyeOpen, eyeClosed);
            });
            toggleConf && toggleConf.addEventListener('click', function(){
                toggleInput(pwdConf, eyeOpenConf, eyeClosedConf);
            });

            function scorePassword(s){
                let score = 0;
                if(!s) return score;
                if(s.length >= 8) score++;
                if(s.length >= 12) score++;
                if(/[a-z]/.test(s) && /[A-Z]/.test(s)) score++;
                if(/\d/.test(s)) score++;
                if(/[^A-Za-z0-9]/.test(s)) score++;
                return score; // 0..5
            }

            function updateStrength(){
                const val = pwd.value || '';
                const score = scorePassword(val);
                const pct = Math.min(100, Math.round((score/5)*100));
                strengthBar.style.width = pct + '%';
                // color and text
                if(score <= 1){
                    strengthBar.className = 'h-2 rounded transition-all duration-300 w-0 bg-red-400';
                    strengthText.textContent = 'Kekuatan: Lemah';
                    strengthText.className = 'mt-2 text-xs font-medium text-red-600';
                } else if(score <= 3){
                    strengthBar.className = 'h-2 rounded transition-all duration-300 w-0 bg-yellow-400';
                    strengthText.textContent = 'Kekuatan: Sedang';
                    strengthText.className = 'mt-2 text-xs font-medium text-yellow-600';
                } else {
                    strengthBar.className = 'h-2 rounded transition-all duration-300 w-0 bg-green-500';
                    strengthText.textContent = 'Kekuatan: Kuat';
                    strengthText.className = 'mt-2 text-xs font-medium text-green-600';
                }
            }

            pwd && pwd.addEventListener('input', updateStrength);
            // keep confirm match hint (optional)
            pwdConf && pwdConf.addEventListener('input', function(){
                if(pwdConf.value && pwd.value !== pwdConf.value){
                    pwdConf.classList.add('ring-2','ring-red-300');
                } else {
                    pwdConf.classList.remove('ring-2','ring-red-300');
                }
            });
        })();
    </script>
</body>
</html>

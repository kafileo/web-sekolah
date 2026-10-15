@extends('layouts.auth', ['title' => 'Login Portal Sekolah'])

@section('content')
<div class="w-full max-w-md">
    <!-- Header Logo & Title -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 mb-4 transform hover:scale-105 transition-transform duration-200">
            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Portal Informasi Sekolah</h1>
        <p class="text-slate-400 text-sm mt-1">Satu pintu masuk untuk Admin & Siswa</p>
    </div>

    <!-- Card Login Form -->
    <div class="glass-card rounded-2xl p-8 border border-white/20">
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="nama@sekolah.sch.id"
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all bg-slate-50/50 hover:bg-white focus:bg-white"
                    >
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                    Kata Sandi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all bg-slate-50/50 hover:bg-white focus:bg-white"
                    >
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <span class="text-slate-600 text-xs">Ingat saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold text-sm shadow-md shadow-indigo-600/30 hover:shadow-indigo-600/50 transform active:scale-[0.99] transition-all duration-150 flex items-center justify-center gap-2"
            >
                <span>Masuk ke Sistem</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </form>

        <!-- Testing Helper Box -->
        <div class="mt-6 pt-5 border-t border-slate-100">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2.5 text-center">
                Akun Pengujian Cepat (Seeder)
            </p>
            <div class="grid grid-cols-2 gap-2">
                <button 
                    type="button" 
                    onclick="fillCredentials('admin@sekolah.sch.id', 'password')" 
                    class="p-2.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-900 text-xs font-medium text-left transition flex flex-col"
                >
                    <span class="font-bold flex items-center gap-1 text-indigo-700">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span> Role Admin
                    </span>
                    <span class="text-[10px] text-indigo-600 mt-0.5 truncate">admin@sekolah.sch.id</span>
                </button>
                <button 
                    type="button" 
                    onclick="fillCredentials('siswa@sekolah.sch.id', 'password')" 
                    class="p-2.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-900 text-xs font-medium text-left transition flex flex-col"
                >
                    <span class="font-bold flex items-center gap-1 text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Role Siswa / User
                    </span>
                    <span class="text-[10px] text-emerald-600 mt-0.5 truncate">siswa@sekolah.sch.id</span>
                </button>
            </div>
            <p class="text-[10px] text-slate-400 text-center mt-2">Password default: <span class="font-mono text-slate-600 font-semibold">password</span></p>
        </div>
    </div>

    <!-- Footer Note -->
    <p class="text-center text-xs text-slate-500 mt-6">
        &copy; {{ date('Y') }} Sistem Informasi Penyampaian Informasi Sekolah
    </p>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection

<x-guest-layout>
    <div class="min-h-screen">
        {{-- Navbar --}}
        <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">C</span>
                        </div>
                        <span class="font-bold text-xl text-gray-800 dark:text-white">Campus<span class="font-light text-indigo-600 dark:text-indigo-400">LMS</span></span>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">Sign up</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-gradient-to-br from-indigo-200/30 to-purple-200/30 dark:from-indigo-500/5 dark:to-purple-500/5 rounded-full blur-3xl"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-flex items-center px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-medium mb-6">
                        Modern Learning Management System
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        Belajar Lebih Efektif dengan
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600">CampusLMS</span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                        Platform pembelajaran digital modern untuk dosen dan mahasiswa. Kelola kelas, materi, tugas, quiz, dan pantau progress belajar secara realtime.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="px-8 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl transition-all duration-200">
                                Mulai Belajar Gratis
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-3.5 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                Sudah Punya Akun? Masuk
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl transition-all duration-200">
                                Masuk ke Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Fitur Lengkap untuk Pembelajaran Modern</h2>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Semua yang Anda butuhkan untuk pengalaman belajar mengajar yang optimal</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Manajemen Kelas</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Buat dan kelola kelas online dengan kode unik, kategori, dan level pembelajaran.</p>
                    </div>
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Materi Digital</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Upload PDF, DOC, video, atau embed YouTube. Pantau progress belajar otomatis.</p>
                    </div>
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tugas & Penilaian</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Buat tugas dengan deadline, nilai otomatis untuk quiz, dan feedback untuk mahasiswa.</p>
                    </div>
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Quiz Online</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Quiz pilihan ganda dan essay dengan timer, random soal, dan koreksi otomatis.</p>
                    </div>
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Forum Diskusi</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Diskusikan materi dengan dosen dan mahasiswa lain dalam forum kelas interaktif.</p>
                    </div>
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Analitik & Laporan</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Pantau progress belajar, statistik kelas, dan hasil evaluasi dalam dashboard interaktif.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Stats --}}
        <section class="py-16 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <p class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400">4</p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Role Pengguna</p>
                    </div>
                    <div>
                        <p class="text-3xl sm:text-4xl font-bold text-purple-600 dark:text-purple-400">Unlimited</p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelas & Materi</p>
                    </div>
                    <div>
                        <p class="text-3xl sm:text-4xl font-bold text-emerald-600 dark:text-emerald-400">Real-time</p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Notifikasi & Progress</p>
                    </div>
                    <div>
                        <p class="text-3xl sm:text-4xl font-bold text-amber-600 dark:text-amber-400">100%</p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Berbasis Web</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="p-10 rounded-3xl bg-gradient-to-br from-indigo-500 to-purple-600">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Siap Memulai Pembelajaran Digital?</h2>
                    <p class="text-indigo-100 text-lg mb-8">Bergabunglah dengan ribuan pengguna yang sudah merasakan kemudahan belajar dengan CampusLMS.</p>
                    @guest
                        <a href="{{ route('register') }}" class="inline-block px-8 py-3.5 bg-white text-indigo-600 font-medium rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
                            Daftar Sekarang — Gratis
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3.5 bg-white text-indigo-600 font-medium rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
                            Masuk ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xs">C</span>
                        </div>
                        <span class="font-bold text-gray-800 dark:text-white">Campus<span class="font-light text-indigo-600 dark:text-indigo-400">LMS</span></span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} CampusLMS. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>

<section>
    <div class="flex items-center gap-3 mb-6">
        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-800">Informasi Profil</h3>
            <p class="text-xs text-gray-500">Perbarui informasi akun dan alamat email kamu</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <x-input-error class="mt-1" :messages="$errors->get('email')" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            @if($user->nim)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" value="{{ $user->nim }}" disabled
                       class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm text-gray-500 cursor-not-allowed">
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <input type="text" name="bio" value="{{ old('bio', $user->bio) }}"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                <p class="text-sm text-amber-700">
                    Email kamu belum terverifikasi.
                    <button form="send-verification" class="underline font-medium hover:text-amber-800">Klik untuk kirim ulang verifikasi</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">Link verifikasi baru telah dikirim ke email kamu.</p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-100">
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm">
                Simpan Perubahan
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-emerald-600 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>

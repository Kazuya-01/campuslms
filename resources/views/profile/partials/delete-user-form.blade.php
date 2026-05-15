<section>
    <div class="flex items-center gap-3 mb-6">
        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <div>
            <h3 class="font-semibold text-gray-800">Hapus Akun</h3>
            <p class="text-xs text-gray-500">Setelah dihapus, semua data tidak bisa dikembalikan</p>
        </div>
    </div>

    <div class="p-4 bg-red-50 border border-red-200 rounded-xl mb-4">
        <p class="text-sm text-red-700">
            Setelah akun dihapus, seluruh data dan resource akan dihapus secara permanen. Harap download data penting sebelum melanjutkan.
        </p>
    </div>

    <div>
        <button type="button" x-data="" @@click="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm">
            Hapus Akun
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Yakin ingin menghapus akun?</h2>
                <p class="text-sm text-gray-500">Tindakan ini tidak bisa dibatalkan. Masukkan password untuk konfirmasi.</p>
            </div>

            <div>
                <input type="password" name="password" placeholder="Masukkan password"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-red-500 focus:ring-red-500">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 mt-6">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>

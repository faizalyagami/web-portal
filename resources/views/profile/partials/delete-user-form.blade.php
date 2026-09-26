<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold" style="color: #dc2626 !important;">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm" style="color: #9ca3af !important;">
            {{ __('Setelah akun dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus, harap unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
        style="background: #dc2626 !important;" onmouseover="this.style.background='#b91c1c'"
        onmouseout="this.style.background='#dc2626'">
        {{ __('Hapus Akun') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold" style="color: #1f2937 !important;">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm" style="color: #9ca3af !important;">
                {{ __('Setelah akun dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#dc2626'; this.style.boxShadow='0 0 0 4px rgba(239, 68, 68, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                @error('password', 'userDeletion')
                    <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition"
                    style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;">
                    {{ __('Batal') }}
                </button>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition"
                    style="background: #dc2626 !important;">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

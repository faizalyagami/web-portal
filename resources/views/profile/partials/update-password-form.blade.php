<section>
    <header>
        <h2 class="text-lg font-bold" style="color: #1f2937 !important;">
            {{ __('Perbarui Password') }}
        </h2>
        <p class="mt-1 text-sm" style="color: #9ca3af !important;">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold mb-1.5"
                style="color: #1f2937 !important;">
                {{ __('Password Saat Ini') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('current_password', 'updatePassword')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold mb-1.5"
                style="color: #1f2937 !important;">
                {{ __('Password Baru') }}
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('password', 'updatePassword')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold mb-1.5"
                style="color: #1f2937 !important;">
                {{ __('Konfirmasi Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('password_confirmation', 'updatePassword')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm"
                    style="color: #00847c !important;">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>

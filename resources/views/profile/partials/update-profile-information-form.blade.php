<section>
    <header>
        <h2 class="text-lg font-bold" style="color: #1f2937 !important;">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm" style="color: #9ca3af !important;">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold mb-1.5" style="color: #1f2937 !important;">
                {{ __('Nama') }}
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                autofocus autocomplete="name" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('name')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold mb-1.5" style="color: #1f2937 !important;">
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('email')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2" style="color: #6b7280 !important;">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm transition"
                            style="color: #6B56A5 !important;">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm" style="color: #00847c !important;">
                            {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm"
                    style="color: #00847c !important;">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>

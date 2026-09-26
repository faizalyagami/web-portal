<x-guest-layout>
    <div class="mb-4 text-sm" style="color: #6b7280 !important;">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-semibold mb-1.5" style="color: #1f2937 !important;">
                Password
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            @error('password')
                <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>

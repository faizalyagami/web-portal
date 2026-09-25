@props(['user' => null, 'types', 'action', 'method' => 'POST'])

@php
    $isEdit = $user !== null;
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6" x-data="{ userType: '{{ old('user_type', $user->user_type->value ?? 'mahasiswa') }}' }">
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <x-card title="Informasi Akun" subtitle="Data login dan tipe akun">
        <div class="grid md:grid-cols-2 gap-4">
            <x-input name="name" label="Nama Lengkap" :value="$user->name ?? ''" required />

            <x-select name="user_type" label="Tipe User" required :value="$user->user_type->value ?? ''" :options="collect($types)->mapWithKeys(fn($t) => [$t->value => $t->label()])->toArray()"
                x-model="userType" />

            <x-input name="email" type="email" label="Email" :value="$user->email ?? ''" required
                placeholder="nama@unisba.ac.id" />

            <x-input name="phone" label="No. Telepon" :value="$user->phone ?? ''" placeholder="08xxxxxxxxxx" />
        </div>
    </x-card>

    <x-card title="Identitas" subtitle="Nomor identitas sesuai tipe user">
        <div class="grid md:grid-cols-3 gap-4">
            <div x-show="userType === 'mahasiswa'">
                <x-input name="identifier" label="NPM" :value="$user->identifier ?? ''" placeholder="10012345"
                    hint="Nomor Pokok Mahasiswa" />
            </div>
            <div x-show="userType === 'dosen'">
                <x-input name="nidn" label="NIDN" :value="$user->nidn ?? ''" placeholder="0412345678" />
            </div>
            <div x-show="userType === 'staff'">
                <x-input name="nik" label="NIK" :value="$user->nik ?? ''" placeholder="3273012345670001" />
            </div>
            <div x-show="userType === 'admin'">
                <x-input name="identifier" label="ID Admin" :value="$user->identifier ?? ''" placeholder="ADMIN-001" />
            </div>

            {{-- Identifier umum (fallback) --}}
            <div x-show="userType === 'mahasiswa' || userType === 'admin'">
                {{-- hanya tampil jika bukan dosen/staff --}}
            </div>
            <div x-show="userType === 'dosen' || userType === 'staff'">
                <x-input name="identifier" label="NIDN/NIK (fallback)" :value="$user->identifier ?? ''" hint="Digunakan untuk login" />
            </div>
        </div>
    </x-card>

    <x-card title="Data Akademik" subtitle="Fakultas, program studi, jabatan">
        <div class="grid md:grid-cols-2 gap-4">
            <x-input name="fakultas" label="Fakultas" :value="$user->fakultas ?? ''" placeholder="Contoh: Psikologi" />

            <x-input name="program_studi" label="Program Studi" :value="$user->program_studi ?? ''" placeholder="Contoh: Psikologi" />

            <x-input name="jabatan" label="Jabatan" :value="$user->jabatan ?? ''" :placeholder="'Contoh: Lektor Kepala / Staf TU'" />

            <div x-show="userType === 'mahasiswa'">
                <x-input name="angkatan" label="Angkatan" :value="$user->angkatan ?? ''" placeholder="2021" />
            </div>
        </div>
    </x-card>

    <x-card title="Keamanan"
        subtitle="{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah password' : 'Password default: password123' }}">
        <div class="grid md:grid-cols-2 gap-4">
            <x-input name="password" type="password" label="Password" :required="!$isEdit" :hint="$isEdit ? 'Kosongkan jika tidak diubah' : 'Min 8 karakter'" />
            <x-input name="password_confirmation" type="password" label="Konfirmasi Password" :required="!$isEdit" />
        </div>

        <div class="grid md:grid-cols-2 gap-4 mt-4">
            <label
                class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-gray-200 dark:border-gray-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-[#0d7a3f] focus:ring-[#0d7a3f]">
                <div>
                    <div class="text-sm font-semibold text-gray-800 dark:text-white">Akun Aktif</div>
                    <div class="text-xs text-gray-500">User bisa login ke portal</div>
                </div>
            </label>

            @if (auth()->user()->is_super_admin)
                <label
                    class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-gray-200 dark:border-gray-700">
                    <input type="hidden" name="is_super_admin" value="0">
                    <input type="checkbox" name="is_super_admin" value="1"
                        {{ old('is_super_admin', $user->is_super_admin ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-purple-600 focus:ring-purple-500">
                    <div>
                        <div class="text-sm font-semibold text-gray-800 dark:text-white">Super Admin</div>
                        <div class="text-xs text-gray-500">Akses penuh semua sistem</div>
                    </div>
                </label>
            @endif
        </div>
    </x-card>

    <div class="flex justify-end gap-3">
        <a href="{{ route('users.index') }}">
            <x-button variant="secondary">Batal</x-button>
        </a>
        <x-button type="submit" icon="check">
            {{ $isEdit ? 'Simpan Perubahan' : 'Tambah User' }}
        </x-button>
    </div>
</form>

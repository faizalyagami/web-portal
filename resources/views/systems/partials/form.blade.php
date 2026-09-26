@props(['system' => null, 'action', 'method' => 'POST'])

@php $isEdit = $system !== null; @endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <x-card title="Informasi Sistem">
        <div class="grid md:grid-cols-2 gap-4">
            <x-input name="name" label="Nama Sistem" :value="$system->name ?? ''" required />
            <x-input name="slug" label="Slug" :value="$system->slug ?? ''" required hint="Contoh: sirkel, roompsi" />
            <div class="md:col-span-2">
                <x-input name="url" type="url" label="URL Sistem" :value="$system->url ?? ''" required
                    placeholder="https://sistem.unisba.ac.id" />
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-1.5" style="color: #1f2937 !important;">
                    Deskripsi
                </label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('description', $system->description ?? '') }}</textarea>
            </div>
        </div>
    </x-card>

    <x-card title="Tampilan">
        <div class="grid md:grid-cols-3 gap-4">
            <x-input name="icon" label="Icon" :value="$system->icon ?? 'globe-alt'" required hint="Heroicon name" />
            <x-input name="color" type="color" label="Warna" :value="$system->color ?? '#6B56A5'" required />
            <x-input name="category" label="Kategori" :value="$system->category ?? ''" required placeholder="akademik/layanan/arsip" />
            <x-input name="order" type="number" label="Urutan" :value="$system->order ?? 0" />
        </div>
    </x-card>

    <x-card title="Hak Akses" subtitle="Tipe user yang boleh mengakses (kosong = semua)">
        @php
            $types = ['mahasiswa', 'dosen', 'staff', 'admin'];
            $selected = old('allowed_types', $system->allowed_types ?? []);
        @endphp
        <div class="flex flex-wrap gap-3">
            @foreach ($types as $t)
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer transition"
                    style="border-color: #e5e7eb !important;" onmouseover="this.style.borderColor='#6B56A5'"
                    onmouseout="this.style.borderColor='#e5e7eb'">
                    <input type="checkbox" name="allowed_types[]" value="{{ $t }}"
                        {{ in_array($t, $selected) ? 'checked' : '' }} style="accent-color: #6B56A5;">
                    <span class="text-sm capitalize" style="color: #1f2937 !important;">{{ $t }}</span>
                </label>
            @endforeach
        </div>

        <label class="flex items-center gap-2 mt-4">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $system->is_active ?? true) ? 'checked' : '' }} style="accent-color: #6B56A5;">
            <span class="text-sm font-medium" style="color: #1f2937 !important;">Aktif</span>
        </label>
    </x-card>

    <div class="flex justify-end gap-3">
        <a href="{{ route('systems.index') }}"
            class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition"
            style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;">
            Batal
        </a>
        <x-button type="submit" icon="check">{{ $isEdit ? 'Simpan' : 'Tambah' }}</x-button>
    </div>
</form>

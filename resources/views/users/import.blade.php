@extends('layouts.app')

@section('title', 'Import User')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1 text-sm font-medium mb-3 transition"
                style="color: #6b7280 !important;">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali ke Daftar User
            </a>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">
                        Import User Massal
                    </h1>
                    <p class="text-sm mt-1" style="color: #9ca3af !important;">
                        Upload file Excel/CSV untuk menambahkan banyak user sekaligus
                    </p>
                </div>

                <a href="{{ route('users.import.template') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition"
                    style="background: rgba(0, 167, 156, 0.1) !important; color: #00847c !important; border: 1px solid rgba(0, 167, 156, 0.25);">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                    Download Template
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded-xl text-sm flex items-start gap-3"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                <x-heroicon-o-check-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-xl text-sm flex items-start gap-3"
                style="background: rgba(239, 68, 68, 0.08) !important; border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626 !important;">
                <x-heroicon-o-x-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-xl text-sm"
                style="background: rgba(239, 68, 68, 0.08) !important; border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626 !important;">
                <div class="flex items-start gap-3">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Info Box --}}
        <div class="mb-6 p-5 rounded-2xl"
            style="background: linear-gradient(135deg, rgba(107, 86, 165, 0.06) 0%, rgba(0, 167, 156, 0.06) 100%) !important; border: 1px solid rgba(107, 86, 165, 0.15);">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: #6B56A5 !important;">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-white" />
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-sm mb-2" style="color: #1f2937 !important;">
                        Panduan Import User
                    </h3>
                    <ul class="space-y-1.5 text-xs" style="color: #6b7280 !important;">
                        <li class="flex items-start gap-2">
                            <span style="color: #00A79C;">•</span>
                            <span>Gunakan template yang sudah disediakan agar format kolom sesuai</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span style="color: #00A79C;">•</span>
                            <span>File yang didukung: <strong>XLSX, XLS, CSV</strong> (maks. 5 MB)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span style="color: #00A79C;">•</span>
                            <span>Password default user baru: <strong>password123</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span style="color: #00A79C;">•</span>
                            <span>Email & identifier harus unik — duplikat akan dilewati</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-base" style="color: #1f2937 !important;">Form Import</h2>
                <p class="text-xs mt-1" style="color: #9ca3af !important;">
                    Upload file dan pilih tipe user yang akan diimport
                </p>
            </div>

            <form method="POST" action="{{ route('users.import') }}" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                {{-- Tipe User --}}
                <div>
                    <label for="user_type" class="block text-sm font-semibold mb-2" style="color: #1f2937 !important;">
                        Tipe User <span style="color: #dc2626;">*</span>
                    </label>
                    <div class="relative">
                        <select name="user_type" id="user_type" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl text-sm outline-none transition appearance-none"
                            style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                            onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                            <option value="">-- Pilih Tipe User --</option>
                            @foreach ($types as $t)
                                <option value="{{ $t->value }}" {{ old('user_type') == $t->value ? 'selected' : '' }}>
                                    {{ $t->label() }}
                                </option>
                            @endforeach
                        </select>

                        <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #6B56A5;">
                            <x-heroicon-o-user-group class="w-5 h-5" />
                        </div>

                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #9ca3af;">
                            <x-heroicon-o-chevron-down class="w-5 h-5" />
                        </div>
                    </div>
                    @error('user_type')
                        <p class="text-xs mt-1.5" style="color: #dc2626 !important;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload File --}}
                <div>
                    <label for="file" class="block text-sm font-semibold mb-2" style="color: #1f2937 !important;">
                        File Excel / CSV <span style="color: #dc2626;">*</span>
                    </label>

                    <label for="file"
                        class="relative flex flex-col items-center justify-center w-full px-6 py-10 rounded-2xl cursor-pointer transition-all group"
                        style="background: #f9fafb !important; border: 2px dashed #e5e7eb !important;"
                        onmouseover="this.style.borderColor='#6B56A5'; this.style.background='rgba(107, 86, 165, 0.03)';"
                        onmouseout="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb';">

                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-3 transition group-hover:scale-110"
                            style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                            <x-heroicon-o-cloud-arrow-up class="w-7 h-7 text-white" />
                        </div>

                        <div class="text-center">
                            <p class="text-sm font-semibold mb-1" style="color: #1f2937 !important;">
                                <span style="color: #6B56A5 !important;">Klik untuk upload</span> atau drag & drop
                            </p>
                            <p class="text-xs" style="color: #9ca3af !important;">
                                XLSX, XLS, CSV · Maksimal 5 MB
                            </p>
                        </div>

                        <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required class="hidden"
                            onchange="updateFileName(this)">
                    </label>

                    {{-- File Preview --}}
                    <div id="filePreview" class="hidden mt-3 p-3 rounded-xl flex items-center gap-3"
                        style="background: rgba(0, 167, 156, 0.06) !important; border: 1px solid rgba(0, 167, 156, 0.2);">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: #00A79C !important;">
                            <x-heroicon-o-document-text class="w-5 h-5 text-white" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div id="fileName" class="text-sm font-semibold truncate"
                                style="color: #1f2937 !important;"></div>
                            <div id="fileSize" class="text-xs" style="color: #9ca3af !important;"></div>
                        </div>
                        <button type="button" onclick="clearFile()" class="p-1.5 rounded-lg transition"
                            style="color: #dc2626 !important;"
                            onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'"
                            onmouseout="this.style.background='transparent'">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>

                    @error('file')
                        <p class="text-xs mt-1.5" style="color: #dc2626 !important;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row justify-end gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold transition"
                        style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb;"
                        onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#ffffff'">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                        style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 10px 24px rgba(107, 86, 165, 0.35)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(107, 86, 165, 0.2)';">
                        <x-heroicon-o-arrow-up-tray class="w-4 h-4" />
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>

        {{-- Format Info --}}
        <div class="mt-6 p-5 rounded-2xl bg-white border border-gray-100"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: rgba(246, 147, 32, 0.1) !important;">
                    <x-heroicon-o-table-cells class="w-4 h-4" style="color: #F69320 !important;" />
                </div>
                <h3 class="font-bold text-sm" style="color: #1f2937 !important;">
                    Format Kolom Excel
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr style="background: #f9fafb !important;">
                            <th class="text-left px-3 py-2 font-semibold rounded-l-lg" style="color: #6b7280 !important;">
                                Kolom</th>
                            <th class="text-left px-3 py-2 font-semibold" style="color: #6b7280 !important;">Deskripsi
                            </th>
                            <th class="text-left px-3 py-2 font-semibold rounded-r-lg" style="color: #6b7280 !important;">
                                Wajib</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $columns = [
                                ['name', 'Nama lengkap user', true],
                                ['email', 'Email kampus', true],
                                ['identifier', 'NPM / NIDN / NIK', true],
                                ['fakultas', 'Nama fakultas', false],
                                ['program_studi', 'Program studi', false],
                                ['jabatan', 'Jabatan (dosen/staff)', false],
                                ['angkatan', 'Tahun angkatan (mahasiswa)', false],
                                ['phone', 'No. telepon', false],
                            ];
                        @endphp

                        @foreach ($columns as $col)
                            <tr class="border-t border-gray-100">
                                <td class="px-3 py-2 font-mono text-[11px]" style="color: #6B56A5 !important;">
                                    {{ $col[0] }}
                                </td>
                                <td class="px-3 py-2" style="color: #6b7280 !important;">
                                    {{ $col[1] }}
                                </td>
                                <td class="px-3 py-2">
                                    @if ($col[2])
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                            style="background: rgba(0, 167, 156, 0.1) !important; color: #00847c !important;">
                                            WAJIB
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                            style="background: rgba(107, 114, 128, 0.1) !important; color: #6b7280 !important;">
                                            OPSIONAL
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Warning --}}
        <div class="mt-4 p-4 rounded-xl flex items-start gap-3"
            style="background: rgba(246, 147, 32, 0.06) !important; border: 1px solid rgba(246, 147, 32, 0.2);">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #F69320 !important;" />
            <div class="text-xs" style="color: #b8690a !important;">
                <strong>Catatan:</strong> Fitur import memerlukan package
                <code class="px-1.5 py-0.5 rounded" style="background: rgba(0,0,0,0.05);">maatwebsite/excel</code>.
                Kalau belum terinstall, upload akan menampilkan pesan placeholder.
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateFileName(input) {
            const preview = document.getElementById('filePreview');
            const nameEl = document.getElementById('fileName');
            const sizeEl = document.getElementById('fileSize');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const sizeKB = (file.size / 1024).toFixed(1);
                const sizeMB = (file.size / 1024 / 1024).toFixed(2);

                nameEl.textContent = file.name;
                sizeEl.textContent = file.size < 1024 * 1024 ?
                    sizeKB + ' KB' :
                    sizeMB + ' MB';

                preview.classList.remove('hidden');
            }
        }

        function clearFile() {
            const input = document.getElementById('file');
            const preview = document.getElementById('filePreview');
            input.value = '';
            preview.classList.add('hidden');
        }
    </script>
@endpush

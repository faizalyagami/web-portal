@extends('layouts.app')

@section('title', 'Kelola Akses')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('users.show', $user) }}"
                class="inline-flex items-center gap-1 text-sm font-medium mb-3 transition" style="color: #6b7280 !important;"
                onmouseover="this.style.color='#6B56A5'" onmouseout="this.style.color='#6b7280'">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali
            </a>
            <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Kelola Akses Sistem</h1>
            <p class="text-sm mt-1" style="color: #9ca3af !important;">
                Atur hak akses <span class="font-semibold" style="color: #6B56A5 !important;">{{ $user->name }}</span> ke
                setiap sistem
            </p>
        </div>

        <form method="POST" action="{{ route('users.access.update', $user) }}">
            @csrf

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="p-6 space-y-3">
                    @foreach ($systems as $system)
                        @php $currentRole = $userAccess[$system->id] ?? ''; @endphp

                        <div class="flex items-center gap-4 p-3 rounded-xl border transition"
                            style="border-color: #f3f4f6 !important;" onmouseover="this.style.borderColor='#6B56A5'"
                            onmouseout="this.style.borderColor='#f3f4f6'">

                            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: {{ $system->color }}20 !important;">
                                <x-dynamic-component :component="'heroicon-o-' . $system->icon" class="w-5 h-5"
                                    style="color: {{ $system->color }} !important;" />
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm" style="color: #1f2937 !important;">
                                    {{ $system->name }}
                                </div>
                                <div class="text-xs truncate" style="color: #9ca3af !important;">
                                    {{ $system->description }}
                                </div>
                            </div>

                            <select name="access[{{ $system->id }}]" class="px-3 py-2 rounded-lg text-sm outline-none"
                                style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;">
                                <option value="">Tidak Ada</option>
                                <option value="viewer" {{ $currentRole === 'viewer' ? 'selected' : '' }}>Viewer</option>
                                <option value="operator" {{ $currentRole === 'operator' ? 'selected' : '' }}>Operator
                                </option>
                                <option value="admin" {{ $currentRole === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('users.show', $user) }}"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition"
                    style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;">
                    Batal
                </a>
                <x-button type="submit" icon="check">Simpan Akses</x-button>
            </div>
        </form>
    </div>
@endsection

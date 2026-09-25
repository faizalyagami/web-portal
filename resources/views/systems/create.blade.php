@extends('layouts.app')
@section('title', 'Tambah Sistem')
@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('systems.index') }}"
                class="text-sm text-gray-500 hover:text-[#0d7a3f] flex items-center gap-1 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Sistem</h1>
        </div>
        @include('systems.partials.form', ['system' => null, 'action' => route('systems.store')])
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1 text-sm font-medium mb-3 transition"
                style="color: #6b7280 !important;">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali
            </a>
            <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">
                Tambah User Baru
            </h1>
        </div>

        @include('users.partials.form', [
            'user' => null,
            'types' => $types,
            'action' => route('users.store'),
            'method' => 'POST',
        ])
    </div>
@endsection

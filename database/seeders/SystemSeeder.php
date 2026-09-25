<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        $systems = [
            [
                'name' => 'SIRKEL',
                'slug' => 'sirkel',
                'url' => 'https://sirkel.unisba.ac.id',
                'description' => 'Sistem Informasi Pengelolaan Sirkel & Kerja Praktik',
                'icon' => 'academic-cap',
                'color' => '#6B56A5',   // Primary Purple
                'category' => 'akademik',
                'allowed_types' => ['mahasiswa', 'dosen', 'staff'],
                'order' => 1,
            ],
            [
                'name' => 'SKSNondik PSI',
                'slug' => 'sksnondik',
                'url' => 'https://sksnondikpsi.unisba.ac.id',
                'description' => 'Sistem Konversi SKS Non-Diklat Program Studi Psikologi',
                'icon' => 'book-open',
                'color' => '#00A79C',   // Secondary Teal
                'category' => 'akademik',
                'allowed_types' => ['mahasiswa', 'dosen'],
                'order' => 2,
            ],
            [
                'name' => 'Room PSI',
                'slug' => 'roompsi',
                'url' => 'https://roompsi.unisba.ac.id',
                'description' => 'Sistem Reservasi & Manajemen Ruangan Fakultas Psikologi',
                'icon' => 'building-office',
                'color' => '#F69320',   // Accent Orange
                'category' => 'layanan',
                'allowed_types' => ['dosen', 'staff', 'mahasiswa'],
                'order' => 3,
            ],
            [
                'name' => 'Monitoring Kinerja Dosen',
                'slug' => 'monitoring-dosen',
                'url' => 'https://monitoring.unisba.ac.id',
                'description' => 'Sistem Monitoring Kinerja & Beban Kerja Dosen',
                'icon' => 'chart-bar',
                'color' => '#8b78c2',   // Primary Light
                'category' => 'akademik',
                'allowed_types' => ['dosen', 'staff'],
                'order' => 4,
            ],
            [
                'name' => 'Pelayanan Surat Terpadu',
                'slug' => 'surat-terpadu',
                'url' => 'https://surat.unisba.ac.id',
                'description' => 'Sistem Pelayanan Surat Menyurat Terpadu',
                'icon' => 'document-text',
                'color' => '#00847c',   // Secondary Dark
                'category' => 'layanan',
                'allowed_types' => ['mahasiswa', 'dosen', 'staff'],
                'order' => 5,
            ],
            [
                'name' => 'Arsip Surat',
                'slug' => 'arsip-surat',
                'url' => 'https://arsip.unisba.ac.id',
                'description' => 'Sistem Pengarsipan Surat Digital',
                'icon' => 'archive-box',
                'color' => '#d97a0a',   // Accent Dark
                'category' => 'arsip',
                'allowed_types' => ['staff', 'admin'],
                'order' => 6,
            ],
        ];

        foreach ($systems as $system) {
            System::updateOrCreate(['slug' => $system['slug']], $system);
        }
    }
}

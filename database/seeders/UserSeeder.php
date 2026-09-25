<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // === SUPER ADMIN ===
        User::updateOrCreate(
            ['email' => 'admin@unisba.ac.id'],
            [
                'name' => 'Super Administrator',
                'password' => 'password',
                'user_type' => UserType::ADMIN,
                'identifier' => 'ADMIN-001',
                'jabatan' => 'Staff Admin',
                'is_super_admin' => true,
                'is_active' => true,
            ]
        );

        // === MAHASISWA ===
        $mahasiswa = [
            [
                'npm' => '10012345',
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@student.unisba.ac.id',
                'fakultas' => 'Psikologi',
                'program_studi' => 'Psikologi',
                'angkatan' => '2021',
            ],
            [
                'npm' => '10012346',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@student.unisba.ac.id',
                'fakultas' => 'Psikologi',
                'program_studi' => 'Psikologi',
                'angkatan' => '2022',
            ],
            [
                'npm' => '10012347',
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@student.unisba.ac.id',
                'fakultas' => 'Teknik',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2021',
            ],
        ];

        foreach ($mahasiswa as $m) {
            User::updateOrCreate(
                ['email' => $m['email']],
                [
                    'name' => $m['name'],
                    'password' => 'password',
                    'user_type' => UserType::MAHASISWA,
                    'identifier' => $m['npm'],
                    'fakultas' => $m['fakultas'],
                    'program_studi' => $m['program_studi'],
                    'angkatan' => $m['angkatan'],
                    'jabatan' => 'Mahasiswa',
                ]
            );
        }

        // === DOSEN ===
        $dosen = [
            [
                'nidn' => '0412345678',
                'name' => 'Dr. Rina Marlina, M.Psi.',
                'email' => 'rina.marlina@unisba.ac.id',
                'fakultas' => 'Psikologi',
                'program_studi' => 'Psikologi',
                'jabatan' => 'Lektor Kepala',
            ],
            [
                'nidn' => '0412345679',
                'name' => 'Prof. Dr. Hendra Wijaya, M.Si.',
                'email' => 'hendra.wijaya@unisba.ac.id',
                'fakultas' => 'Psikologi',
                'program_studi' => 'Psikologi',
                'jabatan' => 'Guru Besar',
            ],
        ];

        foreach ($dosen as $d) {
            User::updateOrCreate(
                ['email' => $d['email']],
                [
                    'name' => $d['name'],
                    'password' => 'password',
                    'user_type' => UserType::DOSEN,
                    'identifier' => $d['nidn'],
                    'nidn' => $d['nidn'],
                    'fakultas' => $d['fakultas'],
                    'program_studi' => $d['program_studi'],
                    'jabatan' => $d['jabatan'],
                ]
            );
        }

        // === STAFF FAKULTAS ===
        $staff = [
            [
                'nik' => '3273012345670001',
                'name' => 'Dewi Lestari, S.Kom.',
                'email' => 'dewi.lestari@unisba.ac.id',
                'fakultas' => 'Psikologi',
                'jabatan' => 'Staf Administrasi Akademik',
            ],
            [
                'nik' => '3273012345670002',
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@unisba.ac.id',
                'fakultas' => 'Psikologi',
                'jabatan' => 'Staf Tata Usaha',
            ],
        ];

        foreach ($staff as $s) {
            User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => 'password',
                    'user_type' => UserType::STAFF,
                    'identifier' => $s['nik'],
                    'nik' => $s['nik'],
                    'fakultas' => $s['fakultas'],
                    'jabatan' => $s['jabatan'],
                ]
            );
        }
    }
}

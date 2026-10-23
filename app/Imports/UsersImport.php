<?php

namespace App\Imports;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    protected $type;
    protected $successCount = 0;
    protected $failedCount = 0;
    protected $errors = [];

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Skip jika baris kosong (nama & email kosong)
            if (empty($row['name']) && empty($row['email'])) {
                continue;
            }

            // Validasi dasar
            $validator = Validator::make($row->toArray(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
            ]);

            if ($validator->fails()) {
                $this->failedCount++;
                $this->errors[] = "Baris " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                continue;
            }

            $userType = UserType::from($this->type);

            // Siapkan data dasar (password dikosongkan dulu)
            $data = [
                'name' => $row['name'],
                'email' => $row['email'],
                'user_type' => $userType,
                'is_active' => true,
                'fakultas' => $row['fakultas'] ?? null,
                'program_studi' => $row['program_studi'] ?? null,
                'jabatan' => $row['jabatan'] ?? null,
                'angkatan' => $row['angkatan'] ?? null,
                'phone' => $row['phone'] ?? null,
            ];

            // Logic Identifier (NPM/NIK)
            $identifier = null;
            if ($this->type === 'mahasiswa' || $this->type === 'admin') {
                $identifier = $row['identifier'] ?? null;
            } elseif ($this->type === 'dosen' || $this->type === 'staff') {
                // Dosen dan Staff menggunakan NIK
                $identifier = $row['nik'] ?? null;
                $data['nik'] = $row['nik'] ?? null;
                $data['nidn'] = null; // Pastikan NIDN kosong jika tidak dipakai
            }

            // Cek unique identifier
            if (!empty($identifier)) {
                if (User::where('identifier', $identifier)->exists()) {
                    $this->failedCount++;
                    $this->errors[] = "Baris " . ($index + 2) . ": Identifier '{$identifier}' sudah terdaftar.";
                    continue;
                }
                $data['identifier'] = $identifier;

                // ✅ SET PASSWORD DEFAULT MENGGUNAKAN IDENTIFIER (NPM/NIK)
                $data['password'] = Hash::make($identifier);
            } else {
                // Fallback jika identifier kosong
                $data['password'] = Hash::make('password123');
            }

            // Simpan ke database
            User::create($data);
            $this->successCount++;
        }
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailedCount()
    {
        return $this->failedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

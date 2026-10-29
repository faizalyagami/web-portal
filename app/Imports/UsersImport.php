<?php

namespace App\Imports;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;

class UsersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    protected $type;
    protected $successCount = 0;
    protected $failedCount = 0;
    protected $errors = [];

    public function __construct($type)
    {
        $this->type = $type;
        set_time_limit(0);
        ini_set('memory_limit', '512M');
    }

    public function collection(Collection $rows)
    {
        $userType = UserType::from($this->type);

        $emailsInChunk = $rows->pluck('email')->filter()->map(fn($email) => trim((string)$email))->toArray();
        $existingEmails = User::whereIn('email', $emailsInChunk)->pluck('email')->toArray();

        $identifiersInChunk = [];
        foreach ($rows as $row) {
            $rawId = ($this->type === 'mahasiswa' || $this->type === 'admin') ? $row['identifier'] : $row['nik'];
            if (!empty($rawId)) {
                $identifiersInChunk[] = trim((string)$rawId);
            }
        }
        $existingIdentifiers = User::whereIn('identifier', $identifiersInChunk)->pluck('identifier')->toArray();

        $dataToInsert = [];
        $now = now();

        foreach ($rows as $index => $row) {
            $name = isset($row['name']) ? trim((string)$row['name']) : '';
            $email = isset($row['email']) ? trim((string)$row['email']) : '';

            if (empty($name) && empty($email)) continue;

            if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->failedCount++;
                continue;
            }

            if (in_array($email, $existingEmails)) {
                $this->failedCount++;
                continue;
            }

            $identifier = null;
            if ($this->type === 'mahasiswa' || $this->type === 'admin') {
                $identifier = isset($row['identifier']) ? trim((string)$row['identifier']) : null;
            } elseif ($this->type === 'dosen' || $this->type === 'staff') {
                $identifier = isset($row['nik']) ? trim((string)$row['nik']) : null;
            }

            if (!empty($identifier) && in_array($identifier, $existingIdentifiers)) {
                $this->failedCount++;
                continue;
            }

            $password = !empty($identifier) ? $identifier : 'password123';

            $dataToInsert[] = [
                'name' => $name,
                'email' => $email,
                'identifier' => $identifier,
                'nik' => ($this->type === 'dosen' || $this->type === 'staff') ? $identifier : null,
                'nidn' => null,
                'password' => Hash::make($password, ['rounds' => 4]),
                'user_type' => $userType->value,
                'is_active' => true,
                'fakultas' => isset($row['fakultas']) ? trim((string)$row['fakultas']) : null,
                'program_studi' => isset($row['program_studi']) ? trim((string)$row['program_studi']) : null,
                'jabatan' => isset($row['jabatan']) ? trim((string)$row['jabatan']) : null,
                'angkatan' => isset($row['angkatan']) ? trim((string)$row['angkatan']) : null,
                'phone' => isset($row['phone']) ? trim((string)$row['phone']) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $existingEmails[] = $email;
            if ($identifier) $existingIdentifiers[] = $identifier;
        }

        if (count($dataToInsert) > 0) {
            DB::table('users')->insert($dataToInsert);
            $this->successCount += count($dataToInsert);
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
    public function batchSize(): int
    {
        return 500;
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

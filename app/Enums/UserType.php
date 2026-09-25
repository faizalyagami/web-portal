<?php

namespace App\Enums;

enum UserType: string
{
    case MAHASISWA = 'mahasiswa';
    case DOSEN = 'dosen';
    case STAFF = 'staff';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::MAHASISWA => 'Mahasiswa',
            self::DOSEN => 'Dosen',
            self::STAFF => 'Staff / Tenaga Kependidikan',
            self::ADMIN => 'Administrator',
        };
    }

    public function identifierLabel(): string
    {
        return match ($this) {
            self::MAHASISWA => 'NPM',
            self::DOSEN => 'NIDN / NIP',
            self::STAFF => 'NIK / NIP',
            self::ADMIN => 'ID Admin',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::MAHASISWA => '#00A79C',  // Teal
            self::DOSEN => '#6B56A5',      // Purple (primary)
            self::STAFF => '#F69320',      // Orange
            self::ADMIN => '#56438a',      // Purple dark
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

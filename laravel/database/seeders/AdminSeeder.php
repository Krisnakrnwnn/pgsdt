<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', 'admin@pgsdt.org')->exists()) {
            $this->command->info('Admin user already exists!');
            return;
        }

        // Generate password acak yang aman
        $password = bin2hex(random_bytes(8)); // 16 karakter hex

        User::create([
            'name'               => 'Admin PGSDT',
            'email'              => 'admin@pgsdt.org',
            'password'           => Hash::make($password),
            'role'               => 'admin',
            'nik'                => '5106000000000001',
            'register_number'    => 'PGSDT-ADMIN-001',
            'kabupaten'          => 'KABUPATEN BANGLI',
            'kecamatan'          => 'TEMBUKU',
            'desa'               => 'PENINJOAN',
            'member_status'      => 'active',
            'email_verified_at'  => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email   : admin@pgsdt.org');
        $this->command->info('Password: ' . $password);
        $this->command->warn('PENTING: Simpan password ini sekarang, tidak akan ditampilkan lagi!');
    }
}

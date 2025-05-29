<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 1',
                'date_of_birth' => '2000-05-12',
                'address' => 'Jl. Surotokuntu no.52 Karawang, Jawa Barat',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin1234'),
                'name' => 'Admin 2',
                'date_of_birth' => '2000-12-17',
                'address' => 'Jl. Ubuntu no.12',
                'no_kk' => '000009438884343',
                'nik' => '009234806783',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin3@gmail.com',
                'password' => Hash::make('admin12345'),
                'name' => 'Admin 3',
                'date_of_birth' => '2000-10-12',
                'address' => 'Jl. Jeruk Manis no.52',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'karyawan',
                'date_of_birth' => '2000-05-12',
                'address' => 'Jl. Syeh Quro no.521',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
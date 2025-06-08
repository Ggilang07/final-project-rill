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
                'email' => 'karyawan1@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'karyawan',
                'date_of_birth' => '2000-05-12',
                'address' => 'Jl. Syeh Quro no.521',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin4@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 4',
                'date_of_birth' => '2000-05-12',
                'address' => 'Jl. Surotokuntu no.52 Karawang, Jawa Barat',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin5@gmail.com',
                'password' => Hash::make('admin1234'),
                'name' => 'Admin 5',
                'date_of_birth' => '2000-12-17',
                'address' => 'Jl. Ubuntu no.12',
                'no_kk' => '000009438884343',
                'nik' => '009234806783',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin6@gmail.com',
                'password' => Hash::make('admin12345'),
                'name' => 'Admin 6',
                'date_of_birth' => '2000-10-12',
                'address' => 'Jl. Jeruk Manis no.52',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan2@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'karyawan2',
                'date_of_birth' => '2000-05-12',
                'address' => 'Jl. Syeh Quro no.521',
                'no_kk' => '0003492344329843',
                'nik' => '0003492344329843',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin7@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 7',
                'date_of_birth' => '1999-01-01',
                'address' => 'Jl. Mawar No.1',
                'no_kk' => '1111111111111111',
                'nik' => '1111111111111111',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin8@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 8',
                'date_of_birth' => '1998-02-02',
                'address' => 'Jl. Melati No.2',
                'no_kk' => '2222222222222222',
                'nik' => '2222222222222222',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan3@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'Karyawan 3',
                'date_of_birth' => '1997-03-03',
                'address' => 'Jl. Kenanga No.3',
                'no_kk' => '3333333333333333',
                'nik' => '3333333333333333',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan4@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'Karyawan 4',
                'date_of_birth' => '1996-04-04',
                'address' => 'Jl. Anggrek No.4',
                'no_kk' => '4444444444444444',
                'nik' => '4444444444444444',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin9@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 9',
                'date_of_birth' => '1995-05-05',
                'address' => 'Jl. Dahlia No.5',
                'no_kk' => '5555555555555555',
                'nik' => '5555555555555555',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan5@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'Karyawan 5',
                'date_of_birth' => '1994-06-06',
                'address' => 'Jl. Teratai No.6',
                'no_kk' => '6666666666666666',
                'nik' => '6666666666666666',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'admin10@gmail.com',
                'password' => Hash::make('admin123'),
                'name' => 'Admin 10',
                'date_of_birth' => '1993-07-07',
                'address' => 'Jl. Sakura No.7',
                'no_kk' => '7777777777777777',
                'nik' => '7777777777777777',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'karyawan6@gmail.com',
                'password' => Hash::make('karyawan123'),
                'name' => 'Karyawan 6',
                'date_of_birth' => '1992-08-08',
                'address' => 'Jl. Flamboyan No.8',
                'no_kk' => '8888888888888888',
                'nik' => '8888888888888888',
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

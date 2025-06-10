<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        User::create([
            'name' => 'Dokter',
            'role_id' => '1',
            'nip' => 'dokter',
            'password' => Hash::make("dokter"),
        ]);
        User::create([
            'name' => 'Perawat',
            'role_id' => '2',
            'nip' => 'perawat',
            'password' => Hash::make("perawat"),
        ]);
        User::create([
            'name' => 'Sekretaris P2K3',
            'role_id' => '3',
            'nip' => 'sekretarisP2K3',
            'password' => Hash::make("sekretarisP2K3"),
        ]);
        User::create([
            'name' => 'Direksi',
            'role_id' => '4',
            'nip' => 'direksi',
            'password' => Hash::make("direksi"),
        ]);
        User::create([
            'name' => 'Psikolog',
            'role_id' => '5',
            'nip' => 'psikolog',
            'password' => Hash::make("psikolog"),
        ]);
        User::create([
            'name' => 'Apoteker',
            'role_id' => '6',
            'nip' => 'apoteker',
            'password' => Hash::make("apoteker"),
        ]);
        User::create([
            'name' => 'Petugas Rekam Medis',
            'role_id' => '7',
            'nip' => 'petugasRekamMedis',
            'password' => Hash::make("petugasRekamMedis"),
        ]);


        Role::create(['name' => 'Dokter']);
        Role::create(['name' => 'Perawat']);
        Role::create(['name' => 'Sekretaris P2K3']);
        Role::create(['name' => 'Direksi']);
        Role::create(['name' => 'Psikolog']);
        Role::create(['name' => 'Apoteker']);
        Role::create(['name' => 'Petugas Rekam Medis']);
    }
}

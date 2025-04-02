<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jabatan' => 'Manajer'],
            ['nama_jabatan' => 'Bendahara'],
            ['nama_jabatan' => 'Kasir'],
            ['nama_jabatan' => 'Kepala Unit'],
            ['nama_jabatan' => 'Staff'],
            ['nama_jabatan' => 'Farmasi'],
        ];

        DB::table('jabatans')->insert($data);
    }
}

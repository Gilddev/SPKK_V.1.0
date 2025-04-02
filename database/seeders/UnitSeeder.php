<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_unit' => 'IGD'],
            ['nama_unit' => 'VK'],
            ['nama_unit' => 'NIFAS'],
            ['nama_unit' => 'IBS'],
            ['nama_unit' => 'ANAK'],
            ['nama_unit' => 'INTERNA'],
            ['nama_unit' => 'NICU'],
            ['nama_unit' => 'FARMASI'],
            ['nama_unit' => 'CASEMIX'],
            ['nama_unit' => 'CENTRAL OPNAME'],
            ['nama_unit' => 'EVAKUATOR'],
            ['nama_unit' => 'LAUNDRY'],
            ['nama_unit' => 'CLEANING SERVICE'],
            ['nama_unit' => 'SECURITY'],
            ['nama_unit' => 'GIZI'],
            ['nama_unit' => 'LABORATORIUM'],
            ['nama_unit' => 'RADIOLOGI'],
            ['nama_unit' => 'PERENCANAAN & SDM'],
            ['nama_unit' => 'IPSRS'],
            ['nama_unit' => 'KESMAS / K3RS'],
            ['nama_unit' => 'SARPRAS'],
            ['nama_unit' => 'IT'],
            ['nama_unit' => 'PMKP'],
        ];

        DB::table('units')->insert($data);
    }
}

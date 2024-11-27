<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call(SettingTableSeeder::class);

        $data = [
            [
                'setting_key' => 'setting_name',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_logo',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_address',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_phone',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_email',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_ai_key',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_facebook',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_zalo',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_twitter',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_instagram',
                'setting_value' => 'Modia',
            ],
            [
                'setting_key' => 'setting_comment',
                'setting_value' => 'true',
            ],
            [
                'setting_key' => 'setting_paginate',
                'setting_value' => '1',
            ],


        ];

        DB::table('settings')->insert($data);
    }
}

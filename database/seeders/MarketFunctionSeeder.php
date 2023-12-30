<?php

namespace Database\Seeders;

use App\Models\MarketFunction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marketFunctions = [
            ['name' => 'login'],
            ['name' => 'signup'],
            ['name' => 'waiver'],
            ['name' => 'cashback'],
        ];

        foreach ($marketFunctions as $type) {
            MarketFunction::create($type);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Varietas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VarietasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buatkan varietas contoh
        $varietas = [
            "SAGE 1B",
            "SAGE 2",
            "SAGE 5",
            "SAGE 7"
        ];


        foreach ($varietas as $var) {
            Varietas::create([
                'varietas' => $var,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

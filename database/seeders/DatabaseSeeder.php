<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employees;
use Illuminate\Database\Seeder;
use App\Models\Positions;
use App\Models\Managers;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Positions::factory(50)->create();
            for($i=1; $i<=5; $i++) {
                Employees::factory(10000)->create();
            }
    }
}

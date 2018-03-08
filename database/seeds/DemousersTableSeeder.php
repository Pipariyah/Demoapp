<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemousersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Demouser::class, 100)->create();
    }
}

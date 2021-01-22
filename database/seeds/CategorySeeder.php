<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoris = [
            [
                'name' => 'Mobile',
                'description' => '',
            ],
            [
                'name' => 'Technology',
                'description' => '',
            ]
        ];


        DB::table('categories')->insert($categoris);
    }
}

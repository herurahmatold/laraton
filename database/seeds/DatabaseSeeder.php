<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $sql_default = base_path('database/sql/default.sql');
        DB::unprepared(file_get_contents($sql_default));
    }
}

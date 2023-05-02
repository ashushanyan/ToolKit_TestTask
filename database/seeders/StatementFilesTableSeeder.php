<?php

namespace Database\Seeders;

use App\Models\StatementFile;
use Illuminate\Database\Seeder;

class StatementFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatementFile::factory()->count(10)->create();
    }
}

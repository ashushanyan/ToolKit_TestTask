<?php

namespace Database\Factories;

use App\Models\StatementFile;
use Illuminate\Database\Eloquent\Factories\Factory;


class StatementFileFactory extends Factory
{
    protected $model = StatementFile::class;

    public function definition()
    {
        return [
            'file_name' => $this->faker->name . '.pdf',
            'file_path' => 'storage/statement_files/' . $this->faker->uuid . '.pdf',
            'statement_id' => \App\Models\Statement::factory()->create()->id,
        ];
    }
}


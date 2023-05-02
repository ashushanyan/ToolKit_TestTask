<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\StatementFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatementService
{
    public function index()
    {
        return Statement::all();
    }

    public function store(array $data, array $files)
    {
        $user = Auth::user();

        $statement = $user->statements()->create([
            'name' => $data['name'],
            'number' => $data['number'],
            'date' => $data['date'],
        ]);

        foreach ($files as $file) {
            $decodedFile = base64_decode($file['file']);
            $filePath = 'statements/' . uniqid() . '.pdf';
            Storage::put($filePath, $decodedFile);

            $statementFile = new StatementFile();
            $statementFile->file_name = $file['filename'];
            $statementFile->file_path = $filePath;
            $statement->files()->save($statementFile);
        }

        return $statement;
    }

    public function show(Statement $statement)
    {
        return $statement;
    }

    public function update(Statement $statement, array $data)
    {
        $statement->update($data);

        return $statement;
    }

    public function destroy(Statement $statement)
    {
        $statement->delete();
    }
}

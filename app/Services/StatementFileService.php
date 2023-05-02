<?php

namespace App\Services;

use App\Models\Statement;
use App\Models\StatementFile;
use Illuminate\Support\Facades\Storage;

class StatementFileService
{
    public function store(array $validatedData): StatementFile
    {
        $statement = Statement::findOrFail($validatedData['statement_id']);
        $statementFile = new StatementFile([
            'file_name' => $validatedData['filename'],
            'file_path' => $this->uploadFile($validatedData['file']),
        ]);
        $statement->statementFiles()->save($statementFile);

        return $statementFile;
    }

    public function update(StatementFile $statementFile, array $validatedData): StatementFile
    {
        $statementFile->file_name = $validatedData['filename'] ?? $statementFile->file_name;

        if (isset($validatedData['file'])) {
            Storage::delete($statementFile->file_path);
            $statementFile->file_path = $this->uploadFile($validatedData['file']);
        }

        $statementFile->save();

        return $statementFile;
    }

    public function delete(StatementFile $statementFile): void
    {
        $statementFile->delete();
    }

    private function uploadFile(string $file): string
    {
        $fileData = base64_decode($file);
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $fileName = uniqid('statement_') . '.' . $fileExtension;
        $filePath = Storage::putFileAs('statements', $fileData, $fileName);

        return $filePath;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatementFileRequest extends FormRequest
{
    public function authorize()
    {
        $statementFile = $this->route('statement_file');

        if (!$statementFile) {
            return false;
        }

        $statement = $statementFile->statement;

        return $this->user()->can('update', [$statementFile, $statement]);
    }

    public function rules()
    {
        return [
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
            'statement_id' => ['required', 'integer', 'exists:statements,id'],
        ];
    }
}

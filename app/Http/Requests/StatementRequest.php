<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatementRequest extends FormRequest
{
    public function authorize()
    {
        $user = auth()->user();
        $statement = $this->route('statement');

        if ($this->getMethod() === 'POST') {

            return $user !== null;
        } else if ($this->getMethod() === 'PUT' || $this->getMethod() === 'PATCH' || $this->getMethod() === 'DELETE') {
            return $user !== null && $statement->user_id === $user->id;
        }

        return false;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'statement_files' => 'required|array',
            'statement_files.*.file' => 'required|string',
            'statement_files.*.filename' => 'required|string|max:255',
        ];

    }
}

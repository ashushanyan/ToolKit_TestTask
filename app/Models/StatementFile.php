<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatementFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'statement_id',
    ];

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }
}

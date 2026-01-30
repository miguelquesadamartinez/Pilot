<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $connection = 'sqlsrv';

    use HasFactory;

    public function todo_item()
    {
        return $this->hasOne(Todo::class, 'id', 'id_todo');
    }

    public function error_code()
    {
        return $this->hasOne(ErrorCodes::class, 'errorCode', 'errorCode');
    }
}

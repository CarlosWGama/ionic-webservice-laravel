<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    //
    protected $fillable = ['titulo', 'data', 'usuario_id'];
    protected $hidden = ['created_at', 'updated_at', 'usuario_id'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $visible = ['id', 'titulo', 'descripcion', 'url_video'];

    public function scopeUltimos($query, int $limite, int $page)
    {
        $offset = ($page - 1) * $limite;

        return $query->limit($limite)
            ->offset($offset)
            ->get();
    }
}

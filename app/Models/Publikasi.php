<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $table = 'publikasi';

    protected $primaryKey = 'no';

    public $timestamps = false;

    protected $fillable = [
        'no',
        'judul',
        'tanggal_rilis',
        'sampul',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_rilis' => 'date',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{

    protected $table = "gedung";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_gedung', 'deskripsi',
    ];

    public function blok()
    {
        return $this->hasMany(Blok::class, 'gedung_id', 'id');
    }

}
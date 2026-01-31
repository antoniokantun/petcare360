<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['client_id', 'name', 'species', 'breed', 'age', 'weight'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

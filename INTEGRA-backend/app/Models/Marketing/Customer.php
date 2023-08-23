<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function leads() {
        return $this->belongsToMany(Lead::class);
    }

    public function exports() {
        return $this->hasMany(Export::class);
    }
}

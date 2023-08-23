<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaigns() {
        return $this->belongsToMany(Campaign::class);
    }

    public function emails() {
        return $this->belongsToMany(Email::class);
    }

    public function customers() {
        return $this->belongsToMany(Customer::class);
    }

}

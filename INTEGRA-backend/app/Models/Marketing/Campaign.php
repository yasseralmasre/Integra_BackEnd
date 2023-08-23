<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tvs() {
        return $this->hasMany(Tv::class);
    }

    public function socialmedia() {
        return $this->hasMany(SocialMedia::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function pdfs() {
        return $this->morphMany(PDFFile::class , 'pdfable');
    }

    public function leads() {
        return $this->belongsToMany(Lead::class);
    }
}

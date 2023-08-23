<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PDFFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pdfable() {
        return $this->morphTo();
    }
}

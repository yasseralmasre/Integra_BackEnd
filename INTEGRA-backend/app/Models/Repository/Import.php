<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Import extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products() : BelongsToMany {
        return $this->belongsToMany(ProductDetail::class)->withPivot('details', 'quantity' , 'total_amount');
    }

    public function pdf() {
        return $this->morphOne(PDFFile::class , 'pdf');
    }

    public function suppliers() {
        return $this->belongsTO(Supplier::class);
    }

    public function customers()  {
        return $this->belongsTo(Customer::class);
    }
}

<?php

namespace App\Models\Repository;

use App\Models\PDFFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Export extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()  {
        return $this->belongsToMany(ProductDetail::class)->withPivot('details', 'quantity' , 'total_amount');
    }

    public function pdf() {
        return $this->morphOne(PDFFile::class , 'pdf');
    }

    public function employees() {
        return $this->belongsTo(Employee::class);
    }

    public function customers()  {
        return $this->belongsTo(Customer::class);
    }

    public function getProductsTotalAmount()
    {
        return $this->products->sum(function ($product) {
            return $product->price;
        });
    }
}

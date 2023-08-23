<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function imports() : BelongsToMany {
        return $this->belongsToMany(Import::class)->withPivot('details', 'total_amount' , 'quantity');
    }
    
    public function exports() : BelongsToMany {
        return $this->belongsToMany(Export::class)->withPivot('details', 'total_amount' , 'quantity');
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value, true),
        );
    } 
}

<?php

namespace App\Models\Repository;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExportProductDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'export_product';

    public function products() : BelongsToMany {
        return $this->belongsToMany(Product::class)->withPivot('details', 'quantity' , 'total_amount');
    }
}

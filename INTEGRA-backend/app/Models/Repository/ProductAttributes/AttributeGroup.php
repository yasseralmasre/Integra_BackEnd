<?php

namespace App\Models\Repository\ProductAttributes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attributes() : HasMany {
        return $this->hasMany(Attribute::class, 'group_id');
    }
}

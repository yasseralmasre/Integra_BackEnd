<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Benefit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employees() : BelongsToMany {
        return $this->belongsToMany(Employee::class)->withPivot('enrollmentDate', 'coverageStartDate' , 'coverageEndDate');
    }
}

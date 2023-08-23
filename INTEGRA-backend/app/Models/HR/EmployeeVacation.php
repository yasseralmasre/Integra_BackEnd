<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeVacation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee() : BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}

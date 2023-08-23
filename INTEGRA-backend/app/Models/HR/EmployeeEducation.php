<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEducation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "employee_educations";

    public function employee() : BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}

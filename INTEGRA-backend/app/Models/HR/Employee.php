<?php

namespace App\Models\HR;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function employee() : HasOne {
        return $this->hasOne(Employee::class, 'id', 'supervisorId');
    }

    public function benefits() : BelongsToMany {
        return $this->belongsToMany(Benefit::class)
            ->withPivot('enrollmentDate', 'coverageStartDate', 'coverageEndDate')->withTimestamps();
    }

    public function employeeAttendances() : HasMany {
        return $this->hasMany(Employee::class);
    }

    public function employeeCertificates() : HasMany {
        return $this->hasMany(EmployeeCertificate::class);
    }

    public function employeeEducations() : HasMany {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function employeePerformances() : HasMany {
        return $this->hasMany(EmployeePerformance::class);
    }

    public function employeeVacations() : HasMany {
        return $this->hasMany(EmployeeVacation::class);
    }

    public function department() : HasOne {
        return $this->hasOne(department::class);
    }

    public function export() {
        return $this->hasMany(Export::class);
    }

    public function import() {
        return $this->hasMany(Import::class);
    }

    public function user() : HasOne {
        return $this->hasOne(User::class);
    }
}

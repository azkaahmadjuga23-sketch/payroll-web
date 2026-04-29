<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Employee.php
    protected $fillable = [
        'nik',
        'name',
        'position',
        'department',
        'join_date',
        'status',
        'basic_salary' // ← tambahkan ini
    ];

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}

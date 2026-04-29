<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    protected $fillable = [
        'payroll_id',
        'employee_id',
        'basic_salary',
        'transport_allowance',
        'meal_allowance',
        'tax_deduction',
        'bpjs_deduction',
        'total_income',
        'total_deduction',
        'net_salary',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // ← INI yang kurang, tambahkan!
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model {
    protected $fillable = ['period', 'status'];

    public function details() {
        return $this->hasMany(PayrollDetail::class);
    }
}

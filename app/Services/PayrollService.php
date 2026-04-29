<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\PayrollDetail;

class PayrollService
{

    // Konstanta tunjangan & potongan
    const TRANSPORT_ALLOWANCE = 500000;
    const MEAL_ALLOWANCE      = 300000;
    const BPJS_RATE           = 0.01;   // 1% dari gaji pokok
    const TAX_RATE            = 0.05;   // 5% dari gaji pokok (PPh21 disederhanakan)

    public function generatePayroll(string $period): Payroll
    {
        // Cek sudah ada belum
        $existing = Payroll::where('period', $period)->first();
        if ($existing) {
            throw new \Exception("Payroll periode {$period} sudah dibuat.");
        }

        // Buat header payroll
        $payroll = Payroll::create(['period' => $period, 'status' => 'draft']);

        // Ambil semua karyawan aktif beserta gaji pokok
        $employees = Employee::with('salary')->where('status', 'active')->get();

        foreach ($employees as $employee) {
            $basic      = $employee->salary->basic_salary ?? 0;
            $transport  = self::TRANSPORT_ALLOWANCE;
            $meal       = self::MEAL_ALLOWANCE;
            $bpjs       = $basic * self::BPJS_RATE;
            $tax        = $basic * self::TAX_RATE;

            $totalIncome     = $basic + $transport + $meal;
            $totalDeduction  = $bpjs + $tax;
            $netSalary       = $totalIncome - $totalDeduction;

            PayrollDetail::create([
                'payroll_id'          => $payroll->id,
                'employee_id'         => $employee->id,
                'basic_salary'        => $basic,
                'transport_allowance' => $transport,
                'meal_allowance'      => $meal,
                'bpjs_deduction'      => $bpjs,
                'tax_deduction'       => $tax,
                'total_income'        => $totalIncome,
                'total_deduction'     => $totalDeduction,
                'net_salary'          => $netSalary,
            ]);
        }

        return $payroll;
    }
}

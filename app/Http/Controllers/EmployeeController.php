<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('salary')
            ->orderBy('name')
            ->paginate(15);

        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik'          => 'required|unique:employees,nik',
            'name'         => 'required|string|max:100',
            'position'     => 'required|string|max:100',
            'department'   => 'required|string|max:100',
            'join_date'    => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
        ], [
            'nik.unique'      => 'NIK sudah terdaftar.',
            'basic_salary.min' => 'Gaji pokok tidak boleh negatif.',
        ]);

        $employee = Employee::create([
            'nik'        => $data['nik'],
            'name'       => $data['name'],
            'position'   => $data['position'],
            'department' => $data['department'],
            'join_date'  => $data['join_date'],
            'status'     => 'active',
        ]);

        $employee->salary()->create([
            'basic_salary' => $data['basic_salary'],
        ]);

        return redirect()->route('employees.index')
            ->with('success', "Karyawan {$employee->name} berhasil ditambahkan.");
    }

    public function edit(Employee $employee)
    {
        $employee->load('salary');
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'nik'          => "required|unique:employees,nik,{$employee->id}",
            'name'         => 'required|string|max:100',
            'position'     => 'required|string|max:100',
            'department'   => 'required|string|max:100',
            'join_date'    => 'required|date',
            'status'       => 'required|in:active,inactive',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        $employee->update([
            'nik'        => $data['nik'],
            'name'       => $data['name'],
            'position'   => $data['position'],
            'department' => $data['department'],
            'join_date'  => $data['join_date'],
            'status'     => $data['status'],
        ]);

        $employee->salary()->updateOrCreate(
            ['employee_id' => $employee->id],
            ['basic_salary' => $data['basic_salary']]
        );

        return redirect()->route('employees.index')
            ->with('success', "Data {$employee->name} berhasil diperbarui.");
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
            ->with('success', "Karyawan {$employee->name} berhasil dihapus.");
    }
}

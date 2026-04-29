<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Services\PayrollService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('details')
            ->orderByDesc('period')
            ->paginate(10);

        return view('payrolls.index', compact('payrolls'));
    }

    public function generate(Request $request, PayrollService $service)
    {
        $request->validate([
            'period' => 'required|date_format:Y-m',
        ], [
            'period.required'     => 'Periode wajib dipilih.',
            'period.date_format'  => 'Format periode tidak valid.',
        ]);

        try {
            $payroll = $service->generatePayroll($request->period);
            return redirect()->route('payrolls.show', $payroll)
                ->with('success', 'Payroll berhasil digenerate!');
        } catch (\Exception $e) {
            return back()->withErrors(['period' => $e->getMessage()]);
        }
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('details.employee');
        return view('payrolls.show', compact('payroll'));
    }

    public function finalize(Payroll $payroll)
    {
        $payroll->update(['status' => 'finalized']);
        return back()->with('success', 'Payroll berhasil difinalisasi.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil dihapus.');
    }

    public function slip(PayrollDetail $detail)
    {
        $detail->load('employee', 'payroll');

        $pdf = Pdf::loadView('payroll.slip', compact('detail'))
            ->setPaper('a4', 'portrait');

        $filename = "slip-{$detail->employee->nik}-{$detail->payroll->period}.pdf";

        return $pdf->download($filename);
    }
}

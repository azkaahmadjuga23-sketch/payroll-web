@extends('layouts.app')
@section('title', 'Detail Penggajian — ' . \Carbon\Carbon::parse($payroll->period . '-01')->format('F Y'))

@push('styles')
<style>
    .summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
    .summary-card { background: #f7f7f7; border-radius: 10px; padding: 16px 20px; }
    .summary-label { font-size: 12px; color: #888; margin-bottom: 6px; }
    .summary-value { font-size: 18px; font-weight: 600; color: #1a1a1a; }
</style>
@endpush

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <div>
        <h2 style="font-size:16px;font-weight:600;">Periode: {{ \Carbon\Carbon::parse($payroll->period . '-01')->format('F Y') }}</h2>
        <p style="font-size:12.5px;color:#888;margin-top:3px;">{{ $payroll->details->count() }} karyawan · Status: <span class="badge {{ $payroll->status === 'finalized' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($payroll->status) }}</span></p>
    </div>
    <a href="{{ route('payrolls.index') }}" class="btn" style="font-size:13px;">← Kembali</a>
</div>

<div class="summary">
    <div class="summary-card">
        <div class="summary-label">Total Pendapatan</div>
        <div class="summary-value">Rp {{ number_format($payroll->details->sum('total_income'), 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Total Potongan</div>
        <div class="summary-value" style="color:#A32D2D;">Rp {{ number_format($payroll->details->sum('total_deduction'), 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Total Gaji Bersih</div>
        <div class="summary-value" style="color:#185FA5;">Rp {{ number_format($payroll->details->sum('net_salary'), 0, ',', '.') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <div class="card-title">Detail Per Karyawan</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Potongan</th>
                <th>Gaji Bersih</th>
                <th>Slip</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payroll->details as $detail)
            <tr>
                <td>
                    <span class="emp-avatar">{{ strtoupper(substr($detail->employee->name, 0, 2)) }}</span>
                    <div style="display:inline-block;vertical-align:middle;">
                        <div style="font-weight:500;">{{ $detail->employee->name }}</div>
                        <div style="font-size:11.5px;color:#888;">{{ $detail->employee->position }}</div>
                    </div>
                </td>
                <td>Rp {{ number_format($detail->basic_salary, 0, ',', '.') }}</td>
                <td>
                    <div style="font-size:12px;color:#555;">
                        Transport: Rp {{ number_format($detail->transport_allowance, 0, ',', '.') }}<br>
                        Makan: Rp {{ number_format($detail->meal_allowance, 0, ',', '.') }}
                    </div>
                </td>
                <td>
                    <div style="font-size:12px;color:#A32D2D;">
                        BPJS: Rp {{ number_format($detail->bpjs_deduction, 0, ',', '.') }}<br>
                        PPh21: Rp {{ number_format($detail->tax_deduction, 0, ',', '.') }}
                    </div>
                </td>
                <td><strong style="color:#185FA5;">Rp {{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
                <td>
                    <a href="{{ route('payrolls.slip', $detail) }}" class="btn" style="font-size:12px;padding:5px 10px;">
                        <svg viewBox="0 0 16 16" style="width:13px;height:13px;stroke:currentColor;fill:none;"><path d="M8 2v8M5 7l3 3 3-3M3 13h10"/></svg>
                        PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

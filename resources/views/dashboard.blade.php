@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    .metrics { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .metric { background: #f7f7f7; border-radius: 10px; padding: 16px 20px; }
    .metric-label { font-size: 12px; color: #888; margin-bottom: 8px; }
    .metric-value { font-size: 24px; font-weight: 600; color: #1a1a1a; }
    .metric-sub { font-size: 11.5px; color: #aaa; margin-top: 4px; }
</style>
@endpush

@section('content')
<div class="metrics">
    <div class="metric">
        <div class="metric-label">Total Karyawan</div>
        <div class="metric-value">{{ $totalEmployees }}</div>
        <div class="metric-sub">Aktif bulan ini</div>
    </div>
    <div class="metric">
        <div class="metric-label">Total Penggajian</div>
        <div class="metric-value">Rp {{ number_format($totalPayroll / 1000000, 0) }} jt</div>
        <div class="metric-sub">{{ $latestPeriod ?? '-' }}</div>
    </div>
    <div class="metric">
        <div class="metric-label">Slip Diterbitkan</div>
        <div class="metric-value">{{ $totalSlips }}</div>
        <div class="metric-sub">Periode terakhir</div>
    </div>
    <div class="metric">
        <div class="metric-label">Status Payroll</div>
        <div class="metric-value" style="font-size:14px;margin-top:6px;">
            @if($latestPayroll)
                <span class="badge {{ $latestPayroll->status === 'finalized' ? 'badge-success' : 'badge-warning' }}">
                    {{ ucfirst($latestPayroll->status) }}
                </span>
            @else
                <span class="badge badge-danger">Belum ada</span>
            @endif
        </div>
        <div class="metric-sub">{{ $latestPeriod ?? '-' }}</div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <div class="card-title">Penggajian terbaru</div>
        @if($latestPayroll)
            <span class="badge badge-info">{{ \Carbon\Carbon::parse($latestPayroll->period . '-01')->format('F Y') }}</span>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Total Bersih</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestDetails as $detail)
            <tr>
                <td>
                    <span class="emp-avatar">{{ strtoupper(substr($detail->employee->name, 0, 2)) }}</span>
                    {{ $detail->employee->name }}
                </td>
                <td>{{ $detail->employee->position }}</td>
                <td>Rp {{ number_format($detail->basic_salary, 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
                <td>
                    <a href="{{ route('payrolls.slip', $detail) }}" class="btn" style="padding:5px 12px;font-size:12px;">
                        <svg viewBox="0 0 16 16"><path d="M8 2v8M5 7l3 3 3-3M3 13h10"/></svg>
                        Slip
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;color:#aaa;padding:30px;">Belum ada data penggajian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Penggajian')

@section('content')

{{-- Generate Payroll --}}
<div class="card">
    <div class="card-head">
        <div class="card-title">Generate Penggajian Baru</div>
    </div>
    <form action="{{ route('payrolls.generate') }}" method="POST">
        @csrf
        <div class="card-body" style="display:flex;align-items:flex-end;gap:14px;">
            <div class="form-group" style="margin-bottom:0;flex:1;max-width:240px;">
                <label class="form-label">Pilih Periode</label>
                <input type="month" name="period" class="form-control" value="{{ old('period', date('Y-m')) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 16 16" style="width:14px;height:14px;stroke:white;fill:none;"><circle cx="8" cy="8" r="6"/><path d="M8 5v3l2 2"/></svg>
                Generate Payroll
            </button>
        </div>
    </form>
</div>

{{-- Riwayat Payroll --}}
<div class="card">
    <div class="card-head">
        <div class="card-title">Riwayat Penggajian</div>
        <span style="font-size:12.5px;color:#888;">{{ $payrolls->total() }} periode</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th>Jumlah Karyawan</th>
                <th>Total Pendapatan</th>
                <th>Total Potongan</th>
                <th>Total Bersih</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $payroll)
            <tr>
                <td><strong>{{ \Carbon\Carbon::parse($payroll->period . '-01')->format('F Y') }}</strong></td>
                <td>{{ $payroll->details->count() }} karyawan</td>
                <td>Rp {{ number_format($payroll->details->sum('total_income'), 0, ',', '.') }}</td>
                <td>Rp {{ number_format($payroll->details->sum('total_deduction'), 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($payroll->details->sum('net_salary'), 0, ',', '.') }}</strong></td>
                <td>
                    <span class="badge {{ $payroll->status === 'finalized' ? 'badge-success' : 'badge-warning' }}">
                        {{ $payroll->status === 'finalized' ? 'Finalized' : 'Draft' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('payrolls.show', $payroll) }}" class="btn" style="font-size:12px;padding:5px 10px;">Lihat Detail</a>
                        @if($payroll->status === 'draft')
                        <form action="{{ route('payrolls.finalize', $payroll) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-primary" style="font-size:12px;padding:5px 10px;">Finalize</button>
                        </form>
                        @endif
                        <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" onsubmit="return confirm('Hapus payroll ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="font-size:12px;padding:5px 10px;">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Belum ada data penggajian. Silakan generate terlebih dahulu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($payrolls->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #e8e8e8;">{{ $payrolls->links() }}</div>
    @endif
</div>
@endsection

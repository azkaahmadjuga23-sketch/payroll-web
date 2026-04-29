@extends('layouts.app')
@section('title', 'Data Karyawan')

@section('content')

{{-- Form Tambah --}}
<div class="card">
    <div class="card-head">
        <div class="card-title">Tambah Karyawan Baru</div>
    </div>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" placeholder="e.g. EMP-001" value="{{ old('nik') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama karyawan" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="position" class="form-control" placeholder="e.g. Staff IT" value="{{ old('position') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Departemen</label>
                    <select name="department" class="form-control" required>
                        <option value="">Pilih departemen</option>
                        @foreach(['IT','HRD','Keuangan','Marketing','Operasional'] as $dept)
                            <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="join_date" class="form-control" value="{{ old('join_date') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gaji Pokok (Rp)</label>
                    <input type="number" name="basic_salary" class="form-control" placeholder="e.g. 5000000" value="{{ old('basic_salary') }}" min="0" required>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="reset" class="btn">Reset</button>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 16 16"><path d="M13 3H3a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1V4a1 1 0 00-1-1z"/><path d="M10 3V1H6v2M8 7v4M6 9h4"/></svg>
                Simpan Karyawan
            </button>
        </div>
    </form>
</div>

{{-- Tabel Karyawan --}}
<div class="card">
    <div class="card-head">
        <div class="card-title">Daftar Karyawan</div>
        <span style="font-size:12.5px;color:#888;">{{ $employees->total() }} karyawan</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Gaji Pokok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr>
                <td style="color:#888;font-size:12px;">{{ $employee->nik }}</td>
                <td>
                    <span class="emp-avatar">{{ strtoupper(substr($employee->name, 0, 2)) }}</span>
                    {{ $employee->name }}
                </td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->department }}</td>
                <td>Rp {{ number_format($employee->salary->basic_salary ?? 0, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $employee->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                        {{ $employee->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('employees.edit', $employee) }}" class="btn" style="padding:5px 10px;font-size:12px;">Edit</a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px;">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Belum ada data karyawan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($employees->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #e8e8e8;">
        {{ $employees->links() }}
    </div>
    @endif
</div>
@endsection

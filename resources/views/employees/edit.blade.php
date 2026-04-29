@extends('layouts.app')
@section('title', 'Edit Karyawan')

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-head">
        <div class="card-title">Edit Karyawan — {{ $employee->name }}</div>
        <a href="{{ route('employees.index') }}" class="btn" style="font-size:12px;padding:6px 12px;">← Kembali</a>
    </div>
    <form action="{{ route('employees.update', $employee) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $employee->nik) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position', $employee->position) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Departemen</label>
                    <select name="department" class="form-control" required>
                        @foreach(['IT','HRD','Keuangan','Marketing','Operasional'] as $dept)
                            <option value="{{ $dept }}" {{ old('department', $employee->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="join_date" class="form-control" value="{{ old('join_date', $employee->join_date) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gaji Pokok (Rp)</label>
                    <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary', $employee->salary->basic_salary ?? 0) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('employees.index') }}" class="btn">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

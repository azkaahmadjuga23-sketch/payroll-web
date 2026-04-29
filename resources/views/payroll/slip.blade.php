<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji — {{ $detail->employee->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #1a1a1a; background: #fff; padding: 30px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 16px; border-bottom: 2px solid #185FA5; margin-bottom: 20px; }
        .company-name { font-size: 18px; font-weight: bold; color: #185FA5; }
        .company-sub { font-size: 11px; color: #666; margin-top: 3px; }
        .slip-title { text-align: right; }
        .slip-title h2 { font-size: 14px; font-weight: bold; color: #1a1a1a; }
        .slip-title p { font-size: 11px; color: #888; margin-top: 3px; }

        .employee-info { display: flex; gap: 40px; background: #f5f8fc; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; }
        .info-item { }
        .info-label { font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px; }
        .info-value { font-size: 13px; font-weight: bold; color: #1a1a1a; }

        .section-title { font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.07em; color: #888; font-weight: bold; margin: 16px 0 8px; }

        table { width: 100%; border-collapse: collapse; }
        td { padding: 7px 0; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
        td:last-child { text-align: right; }
        tr:last-child td { border-bottom: none; }

        .subtotal td { font-weight: bold; padding: 8px 0; border-top: 1px solid #ddd; border-bottom: none; }
        .deduction-amount { color: #A32D2D; }

        .net-salary { display: flex; justify-content: space-between; align-items: center; background: #185FA5; color: white; border-radius: 8px; padding: 14px 18px; margin-top: 20px; }
        .net-label { font-size: 12px; opacity: 0.85; }
        .net-value { font-size: 20px; font-weight: bold; }

        .footer { margin-top: 30px; display: flex; justify-content: space-between; font-size: 11px; color: #888; border-top: 1px solid #e8e8e8; padding-top: 14px; }
        .sign-box { text-align: center; }
        .sign-line { width: 140px; border-bottom: 1px solid #888; margin-top: 50px; margin-bottom: 6px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="company-name">PT Maju Bersama Indonesia</div>
            <div class="company-sub">Jl. Sudirman No. 123, Jakarta · payroll@mbi.co.id</div>
        </div>
        <div class="slip-title">
            <h2>SLIP GAJI</h2>
            <p>Periode: {{ \Carbon\Carbon::parse($detail->payroll->period . '-01')->format('F Y') }}</p>
        </div>
    </div>

    {{-- Info Karyawan --}}
    <div class="employee-info">
        <div class="info-item">
            <div class="info-label">Nama</div>
            <div class="info-value">{{ $detail->employee->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">NIK</div>
            <div class="info-value">{{ $detail->employee->nik }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Jabatan</div>
            <div class="info-value">{{ $detail->employee->position }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Departemen</div>
            <div class="info-value">{{ $detail->employee->department }}</div>
        </div>
    </div>

    {{-- Pendapatan --}}
    <div class="section-title">Pendapatan</div>
    <table>
        <tr>
            <td>Gaji Pokok</td>
            <td>Rp {{ number_format($detail->basic_salary, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Tunjangan Transport</td>
            <td>Rp {{ number_format($detail->transport_allowance, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Tunjangan Makan</td>
            <td>Rp {{ number_format($detail->meal_allowance, 0, ',', '.') }}</td>
        </tr>
        <tr class="subtotal">
            <td>Total Pendapatan</td>
            <td>Rp {{ number_format($detail->total_income, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Potongan --}}
    <div class="section-title">Potongan</div>
    <table>
        <tr>
            <td>BPJS Ketenagakerjaan (1%)</td>
            <td class="deduction-amount">- Rp {{ number_format($detail->bpjs_deduction, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>PPh 21 (5%)</td>
            <td class="deduction-amount">- Rp {{ number_format($detail->tax_deduction, 0, ',', '.') }}</td>
        </tr>
        <tr class="subtotal">
            <td>Total Potongan</td>
            <td class="deduction-amount">- Rp {{ number_format($detail->total_deduction, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Gaji Bersih --}}
    <div class="net-salary">
        <div>
            <div class="net-label">Gaji Bersih Diterima</div>
        </div>
        <div class="net-value">Rp {{ number_format($detail->net_salary, 0, ',', '.') }}</div>
    </div>

    {{-- Footer & TTD --}}
    <div class="footer">
        <div>
            <p>Dicetak pada: {{ now()->format('d F Y') }}</p>
            <p style="margin-top:4px;">Dokumen ini dibuat secara otomatis oleh sistem.</p>
        </div>
        <div class="sign-box">
            <div class="sign-line"></div>
            <div>HRD / Manager</div>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html>

<head>
    <title>Slip Gaji - {{ $gaji->user->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .label {
            font-weight: bold;
            width: 120px;
        }

        .salary-box {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }

        .salary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .total-row {
            font-weight: bold;
            font-size: 18px;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            width: 100%;
            margin-top: 50px;
        }

        .signature {
            width: 40%;
            float: right;
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
        }

        .clear {
            clear: both;
        }

        .watermark {
            position: absolute;
            top: 30%;
            left: 20%;
            font-size: 60px;
            opacity: 0.1;
            transform: rotate(-30deg);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- HEADER KOP SURAT -->
        <div class="header">
            <h1>CAFE TERAS BUMI</h1>
            <p>Jl. Perjuangan No. 12, Cirebon, Jawa Barat</p>
            <p>Telp: (0231) 123456 | Email: hrd@terasbumi.com</p>
        </div>

        <div class="watermark">SLIP GAJI</div>

        <!-- JUDUL -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0; text-decoration: underline;">SLIP GAJI KARYAWAN</h2>
            {{-- PERBAIKAN DI SINI: Menambahkan (int) sebelum $gaji->bulan --}}
            <p style="margin: 5px 0;">Periode: {{ \Carbon\Carbon::create()->month((int) $gaji->bulan)->translatedFormat('F') }} {{ $gaji->tahun }}</p>
        </div>

        <!-- INFO KARYAWAN -->
        <table class="info-table">
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $gaji->user->name }}</td>
                <td class="label">Total Hadir</td>
                <td>: {{ $gaji->total_hadir }} Hari</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td>: {{ $gaji->user->jabatan }}</td>
                <td class="label">Terlambat</td>
                <td>: {{ $gaji->total_terlambat }} Kali</td>
            </tr>
            <tr>
                <td class="label">ID Transaksi</td>
                <td>: #PAY-{{ $gaji->id }}{{ $gaji->bulan }}{{ $gaji->tahun }}</td>
                <td class="label">Total Izin</td>
                <td>: {{ $gaji->total_izin }} Hari</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ \Carbon\Carbon::parse($gaji->tanggal_dicetak)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <!-- RINCIAN GAJI -->
        <div class="salary-box">
            <table width="100%">
                <tr>
                    <td style="padding: 10px 0;"><strong>PENERIMAAN BERSIH (TAKE HOME PAY)</strong></td>
                    <td style="text-align: right; font-weight: bold; font-size: 18px;">
                        Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <div style="font-style: italic; font-size: 12px; margin-top: 10px; color: #555;">
                *Nominal di atas sudah termasuk gaji pokok, tunjangan, dan dikurangi potongan keterlambatan (jika ada).
            </div>
        </div>

        @if($gaji->catatan)
        <div style="margin-bottom: 20px; border: 1px dashed #ccc; padding: 10px;">
            <strong>Catatan:</strong><br>
            {{ $gaji->catatan }}
        </div>
        @endif

        <!-- TANDA TANGAN -->
        <div class="footer">
            <div class="signature">
                <p>Cirebon, {{ date('d F Y') }}</p>
                <p>Manajer Operasional,</p>
                <div class="signature-line"></div>
                <p><strong>( Tanda Tangan & Stempel )</strong></p>
            </div>
            <div class="clear"></div>
        </div>

    </div>

</body>

</html>
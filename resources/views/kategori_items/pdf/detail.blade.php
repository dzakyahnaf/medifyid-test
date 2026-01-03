<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Kategori - {{ $kategori->kode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #7f8c8d;
            font-weight: normal;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 8px 0;
        }
        .info-table td:first-child {
            width: 150px;
            font-weight: bold;
            color: #2c3e50;
        }
        .info-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #bdc3c7;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th {
            background-color: #34495e;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ecf0f1;
        }
        .items-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .items-table tr:hover {
            background-color: #e8f4f8;
        }
        .no-items {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            padding: 10px 0;
            border-top: 1px solid #bdc3c7;
        }
        .page-break {
            page-break-after: always;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Kategori Item</h1>
        <h2>Laporan Kategori dan Master Items</h2>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td>Kode Kategori</td>
                <td>:</td>
                <td>{{ $kategori->kode }}</td>
            </tr>
            <tr>
                <td>Nama Kategori</td>
                <td>:</td>
                <td>{{ $kategori->nama }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Master Items</div>

    @if($kategori->masterItems->count() > 0)
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode</th>
                    <th width="30%">Nama Item</th>
                    <th width="20%">Harga Beli</th>
                    <th width="10%">Laba (%)</th>
                    <th width="20%">Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori->masterItems as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->laba }}%</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px; font-size: 11px; color: #7f8c8d;">
            <strong>Total Items:</strong> {{ $kategori->masterItems->count() }} item(s)
        </div>
    @else
        <div class="no-items">
            Tidak ada master item dengan kategori ini.
        </div>
    @endif

    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>
</body>
</html>

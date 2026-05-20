<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kuitansi Pembayaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            background: #f4f4f4;
            padding: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Kuitansi Pembayaran Kontrakan</h2>
        <p style="color: gray;">Renthub</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="30%"><strong>No. Invoice</strong></td>
            <td>: {{ $payment->invoice_number }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Bayar</strong></td>
            <td>: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Penyewa</strong></td>
            <td>: {{ $payment->lease->tenant->name }}</td>
        </tr>
        <tr>
            <td><strong>Nomor Kontrakan</strong></td>
            <td>: {{ $payment->lease->room->room_number }}</td>
        </tr>
        <tr>
            <td><strong>Metode Pembayaran</strong></td>
            <td>: {{ $payment->payment_method }}</td>
        </tr>
        <tr>
            <td><strong>Keterangan</strong></td>
            <td>: {{ $payment->notes ?? 'Pembayaran sewa kontrakan' }}</td>
        </tr>
    </table>

    <div class="total">
        Total Pembayaran: Rp {{ number_format($payment->amount_paid, 0, ',', '.') }} (LUNAS)
    </div>

    <div style="margin-top:50px; text-align:right;">
        <p>{{ config('app.location') }}, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        <br><br>
        <p><strong>Pengelola RentHub</strong></p>
    </div>
</body>
</html>
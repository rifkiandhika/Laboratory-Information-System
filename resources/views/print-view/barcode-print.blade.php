<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-size: 8px;
        }
        .print-area {
            width: 55mm;
            height: 20mm;
        }
        .nama {
            text-align: center;
        }
        .barcode-area{
            text-align: center;
        }
        .deskripsi {
            display: flex;
            justify-content: space-between;
            padding: 0 0;
        }

        @page {
            margin: 0;
            padding: 0;
            text-align: center;
        }
    </style>
    <title>Barcode Print</title>
</head>
<body>

    <div class="print-area">
        <p class="nama">Tn. {{ $nama }}</p>
        <div class="barcode-area">
            <img style="width: 5cm" alt='Barcode Generator TEC-IT' src='https://barcode.tec-it.com/barcode.ashx?data={{ $no_lab }}{{ $nama_barcode }}&code=Code128&translate-esc=on&unit=Fit&imagetype=Png&showhrt=no&eclevel=L&dmsize=Default&modulewidth=400'/>
        </div>
        <div class="deskripsi">
            <p>K3 EDTA 01-02-2024</p>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en" xmlns:background-color="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Laporan Untung <?php echo $user->nama_umkm;?> </title>
    <!--<script>
        document.addEventListener('DOMContentLoaded', function(){
            // your code goes here
            window.print();
        }, false);
    </script>-->
    <style type="text/css" media="all">
        hr {
            -moz-border-bottom-colors: none;
            -moz-border-image: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #EEEEEE -moz-use-text-color #FFFFFF;
            border-style: solid none;
            border-width: 1px 0;
            margin: 18px 0;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        'margin: 0 auto;
        }
        .borderless{
            border:0px;
        }
        .spacer{
            display: block;
            padding-top: 10px;
            padding-bottom:10px
        }
        .border1{
            border:3px solid #000;
            padding: 3px;
        }
        .border1 td{
            border:1px solid #000;
            padding: 2px;
        }
        .border1 th{
            border:1px solid #000;
            padding: 3px;
        }
        .tebal2{
            font-weight: bold;
        }
        #tebal{
            border:1px solid #000;
            padding: 3px;
            font-weight: normal;
            text-align: center;
        }
        #garis{
            width: 40%;
            border: 1px solid #000000;
        }
        .text-left{
            text-align: left;
        }

        @media print {
            tr.kepala-tabel {
                background-color: #b0bec5 !important;
                -webkit-print-color-adjust: exact;
            }
            html, body {
                width: 210mm;
                height: 330mm;
            }
            header,footer {
                display: none;
            }
        }
        @page{
            /* margin: 0;
             padding-top: 5cm;*/
            margin-top: 2cm;
            margin-bottom: 2cm;
            margin-right: 2cm;
            margin-left: 2cm;
        }

    </style>
    <style type="text/css" media="all">
        .under { text-decoration: underline;
            color: #000000;
        }
        .over  { text-decoration: overline; }
        .line  { text-decoration: line-through; }
        .blink { text-decoration: blink; }
        .all   { text-decoration: underline overline line-through; }
        a      { text-decoration: none; }
        .my-center {
            text-align: center;
        }
        .no-margin-vertical{
            margin-bottom: 0;
            margin-top: 1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h1 style="margin-bottom: 0px;"><?php echo $user->nama_umkm;?></h1>
            <h3 style="margin-top: 1px;"><?php echo $user->phone;?></h3>
        </div>
        <div class="col-md-12">
            <div class="text-center">
                <h2 style="align-self: center;" class="my-center">Laporan Keuntungan </h2>
            </div>
        </div>
        <div class="col-md-9">
            <p class="no-margin-vertical">Laporan dibuat tanggal : <?php echo $now; ?> </p>
            <p class="no-margin-vertical">Jumlah Data : <?php echo count($untung); ?> </p>
            <br>
            <p class="no-margin-vertical">Data Tanggal <?php echo $dari; ?> s/d Tanggal <?php echo $sampai; ?> </p>
        </div>
        <div class="bb-1 mt-1 w-100"></div>
        <div class="bb-3 mt-2 w-100"></div>
        <hr>
    </div>
    <div class="row mt-6">
        <div class="col-md-12">
            <div class="text-center">
                <table class="table border1">
                    <thead class="thead-dark">
                    <tr>
                        <td>No.</td>
                        <td>Tanggal</td>
                        <td>Pelanggan</td>
                        <td>Pembayaran</td>
                        <td>Keuntungan</td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total_untung = 0;
                        foreach ($untung as $val) {
                            $date = strtotime($val->created_at);
                            $nama_pelanggan = $val->nama_pelanggan;
                            if ($nama_pelanggan == "" || $nama_pelanggan == null){
                                $nama_pelanggan = "Guest";
                            }
                            $total_untung+=$val->total_untung;
                            ?>
                            <tr>
                                <td> <?php echo $no++;?> </td>
                                <td> <?php echo date('d F Y', $date);?> </td>
                                <td> <?php echo $nama_pelanggan; ?> </td>
                                <td>Rp. <?php echo number_format($val->total_bayar,0,',','.') ?> </td>
                                <td>Rp. <?php echo number_format($val->total_untung,0,',','.') ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <h5 style="margin-top: 1px;">Total Keuntungan : Rp. <?php echo number_format($total_untung,0,',','.') ?> </h5>
        </div>
    </div>
</div>


</body>
</html>

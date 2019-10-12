<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <style>
        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 250px; /* or something else */
        }
        body {
            font-family: Helvetica;
            font-size: 12px;
        }
        h3{
            font-size: 16px;
        }
        .smalltxt {
            font-size: 10px;
        }
    </style>
</head> 
<body> 
<htmlpageheader name="page-header">
@include('medical.pdf.header')
</htmlpageheader>
<br><br>
<div>
    <table width="100%" cellpadding="2">
    <tr>
        <td style="font-weight: bold;border-bottom: 1px solid #333333;padding-bottom: 5px;" width="5%">Lp.</td>
        <td style="font-weight: bold;border-bottom: 1px solid #333333;padding-bottom: 5px;" width="15%">Zapis z dnia</td>
        <td style="font-weight: bold;border-bottom: 1px solid #333333;padding-bottom: 5px;" width="30%">Rozpoznanie</td>
        <td style="font-weight: bold;border-bottom: 1px solid #333333;padding-bottom: 5px;" width="30%">Wykonano</td>
        <td style="font-weight: bold;border-bottom: 1px solid #333333;padding-bottom: 5px;" width="10%">Wykonał</td>
    </tr>
    @foreach($historyData as $x=>$hd)
    <tr>
        <td style="border-top: 1px solid #333333;padding-top: 5px;padding-bottom: 5px;">{{$x+=1}}</td>
        <td style="border-top: 1px solid #333333;padding-top: 5px;padding-bottom: 5px;">{{$hd['created_at']}}</td>        
        <td style="border-top: 1px solid #333333;padding-top: 5px;padding-bottom: 5px;">{{json_decode($hd['json_data'])->diagnosis}}</td>
        <td style="border-top: 1px solid #333333;padding-top: 5px;padding-bottom: 5px;">{{json_decode($hd['json_data'])->procedures}}</td>
        <td style="border-top: 1px solid #333333;padding-top: 5px;padding-bottom: 5px;">{{$hd['name']}}</td>
    </tr>
    @endforeach
</table>
</div>
<br>
<pagebreak/>
<h3 style="text-align: center;">Załączniki</h3>
@foreach($photos as $i=>$photo)
<p style="font-weight: bold;">Opis:</strong></p>
<i>{{$photos[0]->description}}</i><br>
    <img width="70%" src="{{base_path().'/public/dir_home/public/storage/app/'.$photos[0]->file}}"><br>
@if($i > 1)<pagebreak/>@endif
@endforeach
<htmlpagefooter name="page-footer">
@include('medical.pdf.footer')
</htmlpagefooter>

</body>
</html>

<div style="text-align: center;"><h3>Dokumentacja Medyczna</h3></div>
<br>
Wydruk z dnia: {{date('Y-m-d H:i:s')}}
<br><br>
<div style="font-weight: bold;">Karta choroby pacjenta</div>
<br>
<div style="border-width:1px;border-color: #333333;border-style: solid;padding: 5px;">
<table width="100%" border="0">
    <tr>
        <td width="50%">
            @if(is_array($historyData))
            <table width="100%" border="0">
                <tr>
                    <td>Pacjent:</td>
                    <td style="font-weight: bold;">{{$historyData[0]['firstname']}} {{$historyData[0]['lastname']}}</td>
                </tr>
                <tr>
                    <td>PESEL:</td>
                    <td style="font-weight: bold;">{{$historyData[0]['nin']}}</td>
                </tr>
                <tr>
                    <td>Płeć:</td>
                    <td style="font-weight: bold;">{{$historyData[0]['gender']}}</td>
                </tr>
                <tr>
                    <td>Data ur.:</td>
                    <td style="font-weight: bold;">{{$historyData[0]['birthdate']}}</td>
                </tr>
            </table>       
            @endif
        </td>
        <td width="50%" valign="top">
            {{ $bus[0]['name'] }}<br>
            {{ $bus[0]['postal_address'] }}<br>
            <i>{{ $bus[0]['description'] }}</i><br>
        </td>
    </tr>
</table>
</div>
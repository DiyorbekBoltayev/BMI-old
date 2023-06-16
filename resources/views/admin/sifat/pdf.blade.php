<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 14px;
        }


        th {

            text-align: left;
            padding: 10px;
            border: 1px solid black;
        }


        td {
            padding: 10px;
            border: 1px solid black;
        }
        .kafedra{
            text-align: center;
            font-size: 20px;
        }

    </style>
    <title>Document</title>
</head>
<body>
<h2 style="text-align: center"> MUHAMMAD AL-XORAZMIY NOMIDAGI TOSHKENT AXBOROT TEXNOLIGIYALARI UNIVERSITETI URGANCH FILIALI {{$year?? ''}} o'quv yili {{$semester?? ''}} "Kurs ishi" va "Bitiruv malakaviy ishi" statistikalari   </h2>
<table>

@foreach($data as $item)
<tr><th class="kafedra full-width-centered"  colspan="6">{{$item['kafedra']}}</th>
</tr>
    <tr>
        <th style="width: 5px;">T/R</th>
        <th>Talaba</th>
        <th>Guruh</th>
        <th>Mavzu</th>
        <th style="">O'qituvchi</th>
        <th style="">Foiz</th>
    </tr>
    @foreach($item['themes'] as $theme)
        <tr>
            <td style="width: 2%;text-align: center">{{$loop->iteration}}</td>
            <td style="width: 30%">{{$theme->student_name ?? 'mavjud emas'}}</td>
            <td style="width: 5%">{{$theme->group_name ?? 'mavjud emas'}}</td>
            <td style="width: 40%">{{$theme->name}}</td>
            <td style="width:20% ">{{$theme->teacher_name}}</td>
            <td style="width: 3%; text-align: center">{{$theme->percentage}}</td>
        </tr>
        @endforeach
@endforeach
</table>
<br>
<br>
<br>
<br>
<br>
<p> <span style="margin-left:2px; margin-right: 45%;">Sana : {{date('d.m.Y')}}</span>
<span style="margin-right: 10px; ">____________</span>
<span style="">{{$sifat_user_name}}</span>
</p>
</body>
</html>

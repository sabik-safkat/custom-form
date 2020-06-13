@extends('layouts.email')
@section('content')



Crofun for administrators
</p>
<p>
There was new registration from the following person.
</p>
----------------------------------------------------------
<table>
    <tr>
        <td>お名前</td>
        <td>: {{$data['name']}}</td>
    </tr>
    <tr>
        <td>生年月日</td>
        <td>: </td>
    </tr>
    <tr>
        <td>性別</td>
        <td>: </td>
    </tr>
    <tr>
        <td>住所</td>
        <td>: </td>
    </tr>
    <tr>
        <td>電話番号</td>
        <td>: </td>
    </tr>
</table>


----------------------------------------------------------
<p>
以上
</p>
        

@endsection    
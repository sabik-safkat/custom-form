@extends('layouts.email')
@section('content')


{{$data['name']}}様
<p>
Crofun運営局の{{$data['contact_person']}}です。
</P>
<p>
この度は、数あるクラウドファンディングの中から弊社のサービス
<br>
Crofunにご登録いただき、ありがとうございます。
</p>
<p>
下記の情報でアカウントの登録が完了しました。
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
それでは、早速、Crofunをご利用ください。
<br>
URL：
</p>
        

@endsection    
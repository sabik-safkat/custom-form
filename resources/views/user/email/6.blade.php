@extends('layouts.email')
@section('content')

<p>Crofun　管理者用</p><br>

<p>下記アカウントの情報が変更されました。</p><br>

<p>----------------------------------------------------------</p><br>

<p>お名前　：{{$data['person_name']}}様</p>
<p>生年月日：{{$data['birth_date']}}</p>
<p>住所　　：〒{{$data['address']}}</p>
<p>電話番号：{{$data['phone_number']}}</p><br>

<p>---------------------------------------------------------</p>

@endsection    
@extends('layouts.email')
@section('content')

{{$data['name']}}様

<p>いつもお世話になっております。</p><br>

<p>Crofunへのお問合せありがとうございました。</p><br>

<p>以下の内容でお問合せを受け付けいたしました。</p><br><br>


<p>〇営業日以内に、担当者よりご連絡いたしますので<p>
<p>今しばらくお待ちくださいませ。</p><br><br>


<p>お問合せ内容</p>
<p>-------------------------------------------------</p>
<p>-------------------------------------------------</p>


@endsection    
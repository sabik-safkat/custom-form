@extends('layouts.email')
@section('content')

{{$data['name']}}様

<p>Crofun運営局の です。</p><br><br>


<p>掲載していたただいておりましたプロジェクト〇〇〇〇〇の</p>
<p>支援金額が決定しましたので、ご報告いたします。</p><br>

<p>--------------------------------------------------------------------------------------------------------------------</p>
<p>プロジェクト名　　　　：{{$data['project_name']}}</p><br>

<p>総資金　　　　　　　：　　{{$data['total_funds']}}　　　〇〇〇〇〇円</p><br>

<p>弊社手数料　10％　　：　　　　　{{$data['our_commission']}}　　　　　円</p><br>

<p>差し引きお振込み金額：　　　　　{{$data['debit_transfer_amount']}}　　　　　円</p><br><br>


<p>お振込み先</p>
<p>金融機関名　：</p>
<p>口座名義人　：</p>
<p>金額　　　　：　　　　　　　円</p>
<p>振込予定日　：　〇月〇日</p>
<p>-------------------------------------------------------------------------------------------------------------------</p>

<p>この度は数あるクラウドファンディングの中から、</p>
<p>Crofunをお選びいただき、誠にありがとうございました。</p><br>

<p>今後ともよろしくお願い申し上げます。</p>


@endsection    
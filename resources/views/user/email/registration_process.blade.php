@extends('layouts.email')
@section('content')


{{$data['name']}}様
<p>
Crofun運営局の{{$data['contact_person']}}です。
</p>
<p>
この度は、数あるクラウドファンディングの中から弊社のサービス
<br>
Crofunにご登録いただき、ありがとうございます。
</p>
<p>
下記の情報でアカウントの仮登録が完了しています。
</p>
<p>
メールアドレス：{{$data['email']}}
</p>
<p>
情報に誤りがなければ下記URLをクリックし、本登録をお願いいたします。
<br>
URL：<a href="{{$data['root']}}/register/{{$data['register_token']}}">{{$data['root']}}/register/{{$data['register_token']}}</a>
</p>
<P>
何かご不明な点やご質問がございましたら、
<br>
下記の電話番号もしくはメールアドレスへお気軽にお問合せください。
</P>
        

@endsection    
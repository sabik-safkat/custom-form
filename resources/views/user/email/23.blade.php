@extends('layouts.email')
@section('content')

<p>株式会社{{$data['name']}}<p>
<p>代表取締役社長{{$data['name']}}様<p><br>

<p>Crofun運営局の{{$data['name']}}です。</p><br>

<p>下記のプロジェクトが期間終了しましたので、ご連絡いたします。</p><br>

<p>-----------------------------------------------------------</p><br>

<p>プロジェクト名：{{$data['project_name']}}</p>
<p>URL                     ：{{$data['name']}}</p><br>

<p>----------------------------------------------------------</p><br><br>


<p>期間中の活動お疲れでした。</p>
<p>Crofunのサービスはいかがでしたでしょうか。</p>
<p>何かご不明点やご質問がございましたら、ご連絡お待ちしております。</p><br>

<p>今後ともCrofunをよろしくお願いします。</p>



@endsection    
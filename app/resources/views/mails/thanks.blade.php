@component('mail::message')

{{$user_name}}様<br>
{{$team_name}}へ以下の内容で送信完了しました。<br>

日程：{{$day}}

内容{{$text}}

お問い合わせありがとうございました。

{{-- @component('mail::button', ['url' => ''])
決済画面へ
@endcomponent --}}

<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')

{{$team_name}}様<br>
{{$user_name}}様から以下の内容でお問い合わせを受付ました。<br>

日程：{{$day}}

内容{{$text}}

{{$user_email}}へ
返信をお願いします。

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

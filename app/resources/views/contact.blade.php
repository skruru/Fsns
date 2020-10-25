@extends('team')

@section('show')

<div class="">
    <p>contact</p>
    <form action="" method="POST">
        @csrf
        日程<input type="text" name="contact_day"><br>
        @isset($err_day)
            <p>{{$err_day}}</p>
        @endisset
        <p>内容</p>
        <textarea id="" cols="30" rows="10" name="contact_text"></textarea><br>
        @isset($err_text)
            <p>{{$err_text}}</p>
        @endisset
        <input type="submit" value="送信">
    </form>
</div>

@endsection

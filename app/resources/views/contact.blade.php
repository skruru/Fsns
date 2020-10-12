@extends('team')

@section('show')
<div class="">
    <p>contact</p>
    <form action="" method="POST">
        @csrf
        申込者<input type="text"><br>
        <p></p>
        日程<input type="text"><br>
        <p></p>
        メールアドレス<input type="mail"><br>
        <p></p>
        <p>内容</p>
        <textarea name="" id="" cols="30" rows="10"></textarea><br>
        <p></p>
        <input type="submit" value="送信">
    </form>
</div>
@endsection

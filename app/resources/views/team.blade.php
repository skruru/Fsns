@extends('layouts.app')

@section('teammenu')
       <div class="header">
           <h1 class="team_ttl">チーム名</h1>
           <p><a href="/teamcreate">チーム編集</a></p>
           <div class="header_content">
               <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""></p>
               <p>
                    <p class="header_content_area">活動地域：大阪</p>
                    <p class="header_content_txt">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
               </p>
               <p class="team_link"><a href="twitter">t</a><a href="twitter">i</a><a href="twitter">f</a></p>
               <p class="team_follow"><a href="/follower">フォロワー</a></p>
           </div>
       </div>
@endsection

@section('items')
こんにちは
@endsection

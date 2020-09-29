@extends('layouts.app')

@section('teammenu')
       <div class="header">
           <h1 class="team_ttl">チーム名:{{$item->team_name}}</h1>
           <p><a href="/update">チーム編集</a></p>
           <div class="header_content">
               <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""></p>
               <p>
                    <p class="header_content_area">活動地域：{{$item->team_area}}</p>
                    <p class="header_content_txt">{{$item->team_contents}}</p>
               </p>
               <ul class="team_link d-flex">
                    <li><a href="twitter">t</a></li>
                    <li><a href="instagram">i</a></li>
                    <li><a href="facebook">f</a></li>
                </ul>
               <p class="team_follow"><a href="/follower">フォロワー</a></p>
               <p><a href="/teams">チーム一覧へ</a></p>
           </div>
       </div>
       <section class="items">
            <nav class="items_nav">
                <ul class="d-flex justify-content-end">
                    <li><a href="/days">Days</a></li>
                    <li><a href="/movies">Movies</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
            <div class="items_bord bg-primary">
                こんにちは
            </div>
        </section>
@endsection

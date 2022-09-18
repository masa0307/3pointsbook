<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>

</head>
<body>
    <div class="flex">
        <section class="w-1/4 h-screen bg-primary">
            <div>
                <button id="addBookOpen">＋ 本の追加</button>
                <div id="addBookMenu" class="hidden">
                    <a href="{{route('book.search')}}" class="block">本を検索する</a>
                    <a href="{{route('book.manual')}}" class="block">本を手動で登録する</a>
                    <button id="addBookClose">キャンセル</button>
                </div>
                <button id="settingScreenOpen">⚙</button>
                <div id="settingMenu" class="hidden">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="settingScreenClose">×</span>
                        </div>
                        <div class="modal-body">
                            <a href="{{route('user-name.edit', Auth::id())}}" class="block">ユーザー名称の変更</a>
                            <a href="{{route('email.edit', Auth::id())}}" class="block">メールアドレスの変更</a>
                            <a href="{{route('login-password.edit', Auth::id())}}" class="block">パスワードの変更</a>
                            <a href="{{route('book-sort.edit', Auth::id())}}" class="block">本の並び替え</a>
                            <a href="{{route('genre-name.edit', Auth::id())}}" class="block">ジャンル名の追加</a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <input type="submit" value="ログアウト">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <ul>
                    <li>
                        <p class="pl-6">読書中</p>
                        <ul class="pl-10">
                            @foreach ($books as $book)
                                @if ($book->state==='読書中')
                                    <li class="mt-2">
                                        <a href="{{route('book.show', $book->id)}}" class="dropdown marker block">{{$book->title}}</a>
                                        <ul class="pl-6 hidden dropdown__list">
                                            <li><a href="#" class="marker block">読書メモ</a></li>
                                            <li><a href="#" class="marker block">アクションリスト</a></li>
                                            <li><a href="#" class="marker block">振り返り</a></li>
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>

                <ul class="mt-10">
                    <li>
                        <p class="pl-6">気になる</p>
                        <ul class="pl-10">
                            @foreach ($books as $book)
                                @if ($book->state==='気になる')
                                    <li class="mt-2">
                                        <a href="{{route('book.show', $book->id)}}" class="marker block">{{$book->title}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </section>

        <section>
            <h2>本の登録</h2>
            <form action="{{route('book.store')}}" method="POST">
                @csrf
                <div>
                    <label for="title" class="block">タイトル（必須）</label>
                    <input name="title" type="text" value="{{$temporary_store_book->title}}" id="title" class="block">
                </div>
                <div>
                    <label for="titleKana" class="block">タイトル（カナ）（必須）</label>
                    <input name="title_kana" type="text" value="{{$temporary_store_book->title_kana}}" id="titleKana" class="block">
                </div>
                <div>
                    <label for="author" class="block">著者名（必須）</label>
                    <input name="author" type="text" value="{{$temporary_store_book->author}}" id="author" class="block">
                </div>
                <div>
                    <label for="genre" class="block">ジャンル（任意）（選択式）</label>
                    <select name="genre_id" id="genre" class="block">
                        @foreach($genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="state" class="block">状態（必須）（選択式：気になる or 読書中）</label>
                    <select name="state" id="state" class="block">
                        <option value="気になる">気になる</option>
                        <option value="読書中">読書中</option>
                    </select>
                </div>
                <input type="submit" value="保存する">
            </form>
        </section>
    </div>
</body>
</html>



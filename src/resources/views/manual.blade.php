<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/top.js') }}" defer></script>

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
            </div>

            <div>
                <ul>
                    <li>
                        <p class="pl-6">読書中</p>
                        <ul class="pl-10">
                            @foreach ($books as $book)
                                @if ($book->state==='読書中')
                                    <li class="mt-2">
                                        <a href="#" class="dropdown marker block">{{$book->title}}</a>
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
                                        <a href="#" class="marker block">{{$book->title}}</a>
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
                    <input name="title" type="text" id="title" class="block">

                </div>
                <div>
                    <label for="author" class="block">著者名（必須）</label>
                    <input name="author" type="text" id="author" class="block">
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



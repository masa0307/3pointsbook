<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>

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
            <h2>読書メモ</h2>
            @if($before_reading_content)
                <h3>読書前</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly>{{$before_reading_content}}</textarea>
            @elseif(!$before_reading_content)
                <h3>読書前</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly placeholder="※目次から学びたい内容を３点記載"></textarea>
            @endif

            @if($reading_content)
                <h3>読書中</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly>{{$reading_content}}</textarea>
            @elseif(!$reading_content)
                <h3>読書中</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly placeholder="※目次から学びたい内容を３点記載"></textarea>
            @endif

            @if($after_reading_content)
                <h3>読書後</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly>{{$after_reading_content}}</textarea>
            @elseif(!$after_reading_content)
                <h3>読書後</h3>
                <a href="{{route('book-memo.create', ['id'=>$id])}}">編集</a>
                <textarea  cols="80" rows="5" readonly placeholder="※読書前に記載した３点に関して得た情報を記載"></textarea>
            @endif
        </section>
    </div>
</body>
</html>



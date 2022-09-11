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
            @if(strpos(url()->full(),'book-memo')!== false)
                <h2>読書メモ</h2>
                @if($before_reading_content)
                    <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <label for="before_reading_content" class="block">読書前</label>
                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5">{{$before_reading_content}}</textarea>
                        </div>
                        <input type="submit" value="上書きする">
                    </form>
                @else
                    <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST">
                        @csrf
                        <div>
                            <label for="before_reading_content" class="block">読書前</label>
                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載"></textarea>
                        </div>
                        <input type="submit" value="保存する">
                    </form>
                @endif

                @if($reading_content)
                    <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <label for="reading_content" class="block">読書中</label>
                            <textarea name="reading_content" id="reading_content" cols="80" rows="5">{{$reading_content}}</textarea>
                        </div>
                        <input type="submit" value="上書きする">
                    </form>
                @else
                    <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST">
                        @csrf
                        <div>
                            <label for="reading_content" class="block">読書中</label>
                            <textarea name="reading_content" id="reading_content" cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載"></textarea>
                        </div>
                        <input type="submit" value="保存する">
                    </form>
                @endif

                @if($after_reading_content)
                    <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <label for="after_reading_content" class="block">読書後</label>
                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5">{{$after_reading_content}}</textarea>
                        </div>
                        <input type="submit" value="上書きする">
                    </form>
                @else
                    <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST">
                        @csrf
                        <div>
                            <label for="after_reading_content" class="block">読書後</label>
                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5" placeholder="※読書前に記載した３点に関して得た情報を記載"></textarea>
                        </div>
                        <input type="submit" value="保存する">
                    </form>
                @endif
            @elseif(strpos(url()->full(),'action-list')!== false)
                <h2>アクションリスト</h2>
                @if($actionlist1_content)
                    <form action="{{route('action-list.update', ['id'=>$id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <label for="actionlist1_content" class="block">アクションリスト１</label>
                            <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5">{{$actionlist1_content}}</textarea>
                        </div>
                        <div>
                            <label for="actionlist2_content" class="block">アクションリスト２</label>
                            <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5">{{$actionlist2_content}}</textarea>
                        </div>
                        <div>
                            <label for="actionlist3_content" class="block">アクションリスト３</label>
                            <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5">{{$actionlist3_content}}</textarea>
                        </div>
                        <input type="submit" value="上書きする">
                    </form>
                @else
                    <form action="{{route('action-list.store', ['book_id'=>$id])}}" method="POST">
                        @csrf
                        <div>
                            <label for="actionlist1_content" class="block">アクションリスト１</label>
                            <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5" placeholder="※行動に移すことを記載"></textarea>
                        </div>
                        <div>
                            <label for="actionlist2_content" class="block">アクションリスト２</label>
                            <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5" placeholder="※行動に移すことを記載"></textarea>
                        </div>
                        <div>
                            <label for="actionlist3_content" class="block">アクションリスト３</label>
                            <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5" placeholder="※行動に移すことを記載"></textarea>
                        </div>
                        <input type="submit" value="保存する">
                    </form>
                @endif
            @endif

        </section>
    </div>
</body>
</html>



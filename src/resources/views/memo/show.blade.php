<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-memolist.js') }}" defer></script>
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
                            <a href="#" class="block">本の並び替え</a>
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
                                        <a href="{{route('book.show', $book->id)}}" class="marker block">{{$book->title}}</a>
                                        <ul class="pl-6 hidden dropdown">
                                            <li><a href="{{ route('book-memo.show', $book->id) }}" class="marker block">読書メモ</a></li>
                                            <li><a href="{{ route('action-list.show', $book->id) }}" class="marker block">アクションリスト</a></li>
                                            <li><a href="{{ route('feedback-list.show', $book->id) }}" class="marker block">振り返り</a></li>
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
                <h2 id="book-memo">読書メモ</h2>
                @if (session('errors'))
                    <div>
                        {{ session('errors')->first('none_before_reading_content') }}
                    </div>
                @endif
                @if($is_store_memo)
                    <h3>読書前</h3>
                    <a href="{{route('book-memo-before.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->before_reading_content}}</textarea>
                @else
                    <h3>読書前</h3>
                    <a href="{{route('book-memo-before.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly placeholder="※目次から学びたい内容を３点記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>読書中</h3>
                    <a href="{{route('book-memo-during.edit', ['id'=>$id])}}">編集</a>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->reading_content}}</textarea>
                @else
                    <h3>読書中</h3>
                    <a href="{{route('book-memo-during.edit', ['id'=>$id])}}">編集</a>
                    <textarea  cols="80" rows="5" readonly placeholder="※目次から学びたい内容を３点記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>読書後</h3>
                    <a href="{{route('book-memo-after.edit', ['id'=>$id])}}">編集</a>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->after_reading_content}}</textarea>
                @else
                    <h3>読書後</h3>
                    <a href="{{route('book-memo-after.edit', ['id'=>$id])}}">編集</a>
                    <textarea  cols="80" rows="5" readonly placeholder="※読書前に記載した３点に関して得た情報を記載"></textarea>
                @endif
            @elseif(strpos(url()->full(),'action-list')!== false)
                <h2 id="book-memo">アクションリスト</h2>
                @if (session('errors'))
                    <div>
                        {{ session('errors')->first('none_book_memo') }}
                        {{ session('errors')->first('none_action_list1_content') }}
                    </div>
                @endif
                @if($is_store_memo)
                    <h3>アクションリスト１</h3>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->actionlist1_content}}</textarea>
                @else
                    <h3>アクションリスト１</h3>
                    <textarea  cols="80" rows="5" readonly placeholder="※行動に移すことを記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>アクションリスト２</h3>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->actionlist2_content}}</textarea>
                @else
                    <h3>アクションリスト２</h3>
                    <textarea  cols="80" rows="5" readonly placeholder="※行動に移すことを記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>アクションリスト３</h3>
                    <a href="{{route('action-list.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->actionlist3_content}}</textarea>
                @else
                    <h3>アクションリスト３</h3>
                    <a href="{{route('action-list.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly placeholder="※行動に移すことを記載"></textarea>
                @endif

            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <h2 id="book-memo">振り返り</h2>
                @if (session('errors'))
                    <div>
                        {{ session('errors')->first('none_book_memo') }}
                        {{ session('errors')->first('none_action_list') }}
                        {{ session('errors')->first('none_feedback_list1_content') }}
                    </div>
                @endif
                @if($is_store_memo)
                    <h3>Q.アクションリスト１を実施した結果は？</h3>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->feedback1_content}}</textarea>
                @else
                    <h3>Q.アクションリスト１を実施した結果は？</h3>
                    <textarea  cols="80" rows="5" readonly placeholder="※振り返りを記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>Q.アクションリスト２を実施した結果は？</h3>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->feedback2_content}}</textarea>
                @else
                    <h3>Q.アクションリスト２を実施した結果は？</h3>
                    <textarea  cols="80" rows="5" readonly placeholder="※振り返りを記載"></textarea>
                @endif

                @if($is_store_memo)
                    <h3>Q.アクションリスト３を実施した結果は？</h3>
                    <a href="{{route('feedback-list.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly>{{$store_memo->feedback3_content}}</textarea>
                @else
                    <h3>Q.アクションリスト３を実施した結果は？</h3>
                    <a href="{{route('feedback-list.edit', ['id'=>$id])}}" id="edit">編集</a>
                    <textarea  cols="80" rows="5" readonly placeholder="※振り返りを記載"></textarea>
                @endif
            @endif

        </section>
    </div>
</body>
</html>



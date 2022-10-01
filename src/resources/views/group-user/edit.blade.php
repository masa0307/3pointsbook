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
                <button>
                    <a href="{{ route('search-book.index') }}">🔎</a>
                </button>
                <button>
                    <a href="{{ route('group.create') }}">👨‍👨‍👧‍👦</a>
                </button>
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
                                        <a href="{{route('book.show', $book->id)}}" class="marker block">{{$book->title}}</a>
                                        <ul class="pl-6 hidden dropdown">
                                            <li><a href="{{route('book-memo.show', $book->id)}}" class="marker block">読書メモ</a></li>
                                            <li><a href="{{route('action-list.show', $book->id)}}" class="marker block">アクションリスト</a></li>
                                            <li><a href="{{route('feedback-list.show', $book->id)}}" class="marker block">振り返り</a></li>
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

                <ul class="mt-10">
                    <li>
                        <p class="pl-6">グループ</p>
                        <ul class="pl-10">
                            @if($memo_groups)
                                @foreach ($memo_groups as $memo_group)
                                    @if($memo_group->pivot->participation_status == '参加中')
                                        <li class="mt-2">
                                            <div class="flex">
                                                <a href="#" class="marker block">{{$memo_group->group_name}}</a>
                                                @if($memo_group->pivot->is_owner == true)
                                                    <div class="flex">
                                                        <a href="{{ route('group-user.add', $memo_group->id) }}" class="block">👬</a>
                                                        <a href="{{ route('group-user.edit', $memo_group->id) }}" class="block">📝</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif

                        </ul>
                    </li>
                </ul>

            </div>
        </section>

        <section>
            <h2>メンバー編集</h2>
            <h3>グループ名：{{ $group_name }}</h3>

            @if(isset($group_users))
                <h3>メンバー</h3>
                @foreach($group_users as $group_user)
                    @if($group_user->participation_status == '参加中')
                        <p>・{{ $group_user->user->name }}</p>
                        <form action="{{ route('group-user.destroy', ['group_id'=>$group_user->group_id, 'user_id'=>$group_user->user_id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit">削除</button>
                        </form>
                    @endif
                @endforeach
            @endif
        </section>
    </div>
</body>
</html>



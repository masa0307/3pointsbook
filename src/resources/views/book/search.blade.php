<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/search-book.js') }}" defer></script>
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

        <section id="searchSection">
            <div id="searchWindow">
                <input type="text" placeholder="タイトル名" id="title">
                <button id="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </section>
    </div>
</body>
</html>

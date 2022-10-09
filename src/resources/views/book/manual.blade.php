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
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="flex">
        <section class="w-1/4 h-screen bg-primary">
            <div class="flex my-10">
                <button id="addBookOpen" class="px-1.5 py-1 bg-slate-50 rounded ml-4 mr-4">＋ 本の追加</button>
                <div id="addBookMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-1/4 text-center text-2xl rounded-2xl">
                        <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800">本を検索する</a>
                        <a href="{{route('book.manual')}}" class="block py-4">本を手動で登録する</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-1/4 text-center text-2xl rounded-2xl">
                        <button id="addBookClose" class="block py-4 w-full">キャンセル</button>
                    </div>
                </div>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center mr-4">
                    <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                </button>
                <button>
                    <a href="{{ route('group.create') }}">👨‍👨‍👧‍👦</a>
                </button>
                <button id="settingScreenOpen" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
                <div id="settingMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-1/4 text-center text-2xl rounded-2xl">
                        <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">ユーザー名称の変更</a>
                        <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">メールアドレスの変更</a>
                        <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">パスワードの変更</a>
                        <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">本の並び替え</a>
                        <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4">ジャンル名の追加</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-1/4 text-center text-2xl rounded-2xl">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full">
                        </form>
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

                                        @foreach($memo_group->user as $group_user)
                                                @foreach($group_user->book as $book)
                                                    @foreach($book->memo as $memo)
                                                        @if($memo->group_id == $memo_group->id)
                                                            <a href="{{route('group-user-memo.index', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="block groupMarker pl-4">{{$book->title}}（公開ユーザー名：{{ $memo->user->name }}）</a>
                                                            <ul class="pl-8 hidden groupDropdown">
                                                                <li><a href="{{route('group-user-book-memo.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">読書メモ</a></li>
                                                                <li><a href="{{route('group-user-action-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">アクションリスト</a></li>
                                                                <li><a href="{{route('group-user-feedback-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">振り返り</a></li>
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </section>

        <section class="w-1/2">
            <h2 class="px-10 pt-10 font-medium text-xl">本の追加</h2>
            <div class="bg-primary p-3 ml-20 mt-8 rounded-xl w-full text-center text-lg">本の登録</div>
            <div class="p-2 ml-20 rounded w-full h-3/4 bg-modal-window flex align-center">
                <form action="{{route('book.store')}}" method="POST" class="w-full h-fit my-auto bg-slate-300">
                    @csrf
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="title"class="block pt-2 pl-2 text-white">タイトル（必須）</label>
                        <input name="title" type="text" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="titleKana" class="block pt-2 pl-2 text-white">タイトル（カナ）（必須）</label>
                        <input name="title_kana" type="text" id="title_kana" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="author" class="block pt-2 pl-2 text-white">著者名（必須）</label>
                        <input name="author" type="text" id="author" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="genre" class="block pt-2 pl-2 text-white">ジャンル（任意）（選択式）</label>
                        <select name="genre_id" id="genre" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="state" class="block pt-2 pl-2 text-white">状態（必須）（選択式：気になる or 読書中）</label>
                        <select name="state" id="state" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            <option value="読書中">読書中</option>
                            <option value="気になる">気になる</option>
                        </select>
                    </div>
                    <div class="pt-4 bg-modal-window flex flex-row-reverse">
                        <button type="submit" class="inline-block py-2 px-4 bg-slate-300 rounded">保存する</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>



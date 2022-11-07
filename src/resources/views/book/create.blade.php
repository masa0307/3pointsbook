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
    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen bg-primary">
            <div class="hidden md:flex justify-around my-10">
                <button id="addBookOpen" class="px-1.5 py-1 bg-slate-50 rounded">＋ 本の追加</button>
                <div id="addBookMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-1/4 text-center text-2xl rounded-2xl">
                        <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">本を検索する</a>
                        <a href="{{route('book.manual')}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">本を手動で登録する</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-1/4 text-center text-2xl rounded-2xl">
                        <button id="addBookClose" class="block py-4 w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
                    </div>
                </div>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                    <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                </button>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                    <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
                </button>
                <button id="settingScreenOpen" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
                <div id="settingMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-1/4 text-center text-2xl rounded-2xl">
                        <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">ユーザー名称の変更</a>
                        <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">メールアドレスの変更</a>
                        <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">パスワードの変更</a>
                        <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">本の並び替え</a>
                        <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">ジャンル名の追加</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-1/4 text-center text-2xl rounded-2xl">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex justify-between bg-primary py-4 px-2 items-center md:hidden">
                <button id="addBookOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="fluent:add-24-regular" width="24" height="24" flip="vertical"></iconify-icon></button>
                <div id="addBookMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 text-center text-xl rounded-2xl">
                        <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">本を検索する</a>
                        <a href="{{route('book.manual')}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">本を手動で登録する</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
                        <button id="addBookCloseBySp" class="block py-4 w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
                    </div>
                </div>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                    <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                </button>
                <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の登録</a></h2>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                    <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
                </button>
                <button id="settingScreenOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
                <div id="settingMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-32 w-3/4 text-center text-xl rounded-2xl">
                        <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">ユーザー名称の変更</a>
                        <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">メールアドレスの変更</a>
                        <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">パスワードの変更</a>
                        <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">本の並び替え</a>
                        <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">ジャンル名の追加</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl ">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-ful rounded-2xl hover:bg-sky-500 hover:text-slate-50">
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden md:block mr-4">
                <ul>
                    <li>
                        <p class="pl-6">読書中</p>
                        <ul class="pl-10">
                            @foreach ($books_reading as $book_reading)
                                <li class="mt-2">
                                    <a href="{{route('book.show', [$book_reading->id,  str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_reading->title}}</a>
                                    <ul class="pl-6 hidden dropdown">
                                        <li><a href="{{route('book-memo.show', $book_reading->id)}}" class="marker block">読書メモ</a></li>
                                        <li><a href="{{route('action-list.show', $book_reading->id)}}" class="marker block">アクションリスト</a></li>
                                        <li><a href="{{route('feedback-list.show', $book_reading->id)}}" class="marker block">振り返り</a></li>
                                    </ul>
                                </li>
                            @endforeach

                            {{ $books_reading->links('vendor.pagination.custom') }}
                        </ul>
                    </li>
                </ul>

                <ul class="mt-10">
                    <li>
                        <p class="pl-6">気になる</p>
                        <ul class="pl-10">
                            @foreach ($books_interesting as $book_interesting)
                                <li class="mt-2">
                                    <a href="{{route('book.show', [$book_interesting->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_interesting->title}}</a>
                                </li>
                            @endforeach

                            {{ $books_interesting->links('vendor.pagination.custom') }}
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
                                            <div class="flex justify-between">
                                                <p class="marker block"><iconify-icon inline icon="fa:group" width="16" height="16" class="mr-2"></iconify-icon>{{$memo_group->group_name}}</p>

                                                @if($memo_group->pivot->is_owner == true)
                                                    <div class="flex">
                                                        <a href="{{ route('group-user.add', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block"><iconify-icon inline icon="material-symbols:group-add" width="16" height="16" class="px-1.5 py-1 bg-slate-50 rounded mr-2"></iconify-icon>
                                                        <a href="{{ route('group-user.edit', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block"><iconify-icon inline icon="material-symbols:group-remove" width="16" height="16" class="px-1.5 py-1 bg-slate-50 rounded mr-10"></iconify-icon></a>
                                                    </div>
                                                @endif
                                            </div>

                                            @foreach($memo_group->user as $group_user)
                                                @foreach($group_user->book as $book)
                                                    @foreach($book->memo as $memo)
                                                        @if($memo->group_id == $memo_group->id)
                                                            <a href="{{route('group-user-memo.index', ['book_id'=>$book->id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="block groupMarker pl-6"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book->title}}（公開ユーザー名：{{ $memo->user->name }}）</a>
                                                            <ul class="pl-6 hidden groupDropdown">
                                                                <li><a href="{{route('group-user-book-memo.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">読書メモ</a></li>
                                                                <li><a href="{{route('group-user-action-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">アクションリスト</a></li>
                                                                <li><a href="{{route('group-user-feedback-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">振り返り</a></li>
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </li>
                                    @endif
                                @endforeach

                                {{ $memo_groups->links('vendor.pagination.custom') }}
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </section>

        <section class="md:w-1/2">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の追加</h2>
            <div class="hidden md:block bg-primary p-3 ml-20 mt-8 rounded-xl w-full text-center text-lg">
                本の登録
            </div>
            <div class="p-2 mt-10 md:mt-0 md:ml-20 rounded w-full h-3/4 bg-modal-window flex align-center">
                <form action="{{route('book.store')}}" method="POST" class="w-full h-fit my-auto bg-slate-300">
                    @csrf

                    <div class="border-b border-neutral-50 pb-2">
                        <label for="title" class="block pt-2 pl-2 text-white">タイトル（必須）</label>

                        @if($errors->has('title'))
                            @error('title')
                                <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                            @enderror
                            <input name="title" type="text" value="{{old('title')}}" id="title" class="block rounded  border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                        @else
                            <input name="title" type="text" value="{{$temporary_store_book->title}}" id="title" class="block rounded  border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                        @endif

                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="titleKana" class="block pt-2 pl-2 text-white">タイトル（カナ）（必須）</label>

                        @if($errors->has('title_kana'))
                            @error('title_kana')
                                <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                                <input name="title_kana" type="text" value="{{old('title_kana')}}" id="titleKana" class="block rounded border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            @enderror
                        @else
                            <input name="title_kana" type="text" value="{{$temporary_store_book->title_kana}}" id="titleKana" class="block rounded border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                        @endif

                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="author" class="block pt-2 pl-2 text-white">著者名（必須）</label>

                        @if($errors->has('author'))
                            @error('author')
                                <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                            @enderror
                            <input name="author" type="text" value="{{old('author')}}" id="author" class="block rounded  border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                        @else
                            <input name="author" type="text" value="{{$temporary_store_book->author}}" id="author" class="block rounded  border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                        @endif

                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="genre" class="block pt-2 pl-2 text-white">ジャンル（任意）（選択式）</label>
                        <select name="genre_id" id="genre" class="block rounded border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="state" class="block pt-2 pl-2 text-white">状態（必須）（選択式：気になる or 読書中）</label>
                        <select name="state" id="state" class="block rounded border-none w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            <option value="読書中">読書中</option>
                            <option value="気になる">気になる</option>
                        </select>
                    </div>
                    <div class="pt-4 bg-modal-window flex flex-row-reverse">
                        <button type="submit" class="inline-block py-2 px-4 bg-slate-300 rounded hover:bg-sky-500 hover:text-slate-50">保存する</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>



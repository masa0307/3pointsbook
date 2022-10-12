<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-booklist.js') }}" defer></script>
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
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center mr-4">
                    <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
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

                                            @foreach($memo_group->user as $group_user)
                                                @foreach($group_user->book as $book)
                                                    @foreach($book->memo as $memo)
                                                        @if($memo->group_id == $memo_group->id)
                                                            <a href="{{route('group-user-memo.index', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="block groupMarker pl-6">{{$book->title}}（公開ユーザー名：{{ $memo->user->name }}）</a>
                                                            <ul class="pl-6 hidden groupDropdown">
                                                                <li><a href="{{route('book-memo.show', $book->id)}}" class="marker block">読書メモ</a></li>
                                                                <li><a href="{{route('action-list.show', $book->id)}}" class="marker block">アクションリスト</a></li>
                                                                <li><a href="{{route('feedback-list.show', $book->id)}}" class="marker block">振り返り</a></li>
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                </ul>

            </div>
        </section>

        <section class="w-5/12">
            @if(isset($selectedBook))
                @if($selectedBook->state == '読書中')
                    <h2 class="px-10 pt-10 font-medium text-xl">読書中</h2>
                    <div class="bg-primary p-8 ml-20 mt-8 rounded-xl h-1/2">
                        <div class="flex justify-between">
                            <button class="bg-slate-200 p-1 rounded-xl px-4">
                                <a href="{{ route('group-user-memo.publish_status',['book_id'=> $selectedBook->id]) }}" class="text-xl">メモの公開・非公開</a>
                            </button>
                            <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-xl bg-slate-200 p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                            </form>
                        </div>
                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="m-auto px-4 text-xl w-1/2">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>

                                @if(!($selectedBook->memo->isEmpty()))
                                    <div class="text-xl bg-slate-50 py-2 px-4 rounded-xl mt-4">
                                        <p class="pt-2">公開中のグループ：</p>
                                        @foreach($selectedBook->memo as $memo)
                                            @if($memo_groups->find($memo->group_id))
                                                <p class="pt-2 pl-6">{{ $memo_groups->find($memo->group_id)->group_name}}</p>
                                            @else
                                                <p class="pt-2 pl-6">※グループなし</p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($selectedBook->state == '気になる')
                    <h2 class="px-10 pt-10 font-medium text-xl">気になる</h2>
                    <div class="bg-primary p-8 ml-20 mt-8 rounded-xl h-1/2">
                        <div class="flex justify-between">
                            <div class="hover:after:content-['「気になる」から「読書中」に移動する'] hover:after:relative hover:after:-top-10 hover:after:-left-10 hover:after:bg-gray-700 hover:after:text-stone-50 hover:after:rounded hover:after:p-2">
                                <button class="bg-slate-200 p-1 rounded-xl px-4">
                                    <a href="{{ route('book.update', $selectedBook->id) }}"><iconify-icon inline icon="cil:data-transfer-up" width="24" height="24"></iconify-icon></a>
                                </button>
                            </div>

                            <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-xl bg-slate-200 p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                            </form>
                        </div>
                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="m-auto px-4 text-xl w-1/2">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>

                                @if(!($selectedBook->memo->isEmpty()))
                                    <div class="text-xl bg-slate-50 py-2 px-4 rounded-xl mt-4">
                                        <p class="pt-2">公開中のグループ：</p>
                                        @foreach($selectedBook->memo as $memo)
                                            @if($memo_groups->find($memo->group_id))
                                                <p class="pt-2 pl-6">{{ $memo_groups->find($memo->group_id)->group_name}}</p>
                                            @else
                                                <p class="pt-2 pl-6">※グループなし</p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </section>
    </div>

    @if($is_invited_group_users)
        <div>
            @foreach ($invited_group_users as $count => $invited_group_user)
                @if($count === 0)
                    <div class="fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                        <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-1/4 h-2/5 text-center text-2xl rounded-2xl">
                            <div class="bg-primary p-3 rounded-xl w-full text-center text-2lg text-white">招待通知</div>
                            <p class="flex justify-start w-3/4 mx-auto pt-8 text-xl">招待ユーザー：{{ App\Models\User::find($memo_group->pivot->where('is_owner', true)->where('group_id', $invited_group_user->group_id)->first()->user_id)->name }}</p>
                            <p class="flex justify-start w-3/4 mx-auto pt-6 text-xl">招待グループ名：{{  $memo_groups->where('id', $invited_group_user->group_id)->first()->group_name }}</p>
                            <div class="mt-8">
                                <form action="{{ route('group-user.update') }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" name="participation_status" value="参加中" class="block w-full py-4 bg-slate-300 border-b-2 border-slate-200">参加</button>
                                </form>
                                <form action="{{ route('group-user.reject') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" name="participation_status" value="非参加" class="block w-full py-4 bg-slate-300">非参加</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</body>
</html>



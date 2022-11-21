<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-booklist.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="{{ asset('js/show-bookinformation.js') }}" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="md:flex">
        <section id="topMenu" class="md:w-1/4 h-screen md:bg-primary">
            <x-side-menu />

            <x-top-menu />

            <x-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

        </section>

        <section id="bookInformation" class="hidden md:block md:w-5/12">
            @if(isset($selectedBook))
                @if($selectedBook->state == '読書中')
                    <div class="flex justify-between bg-primary py-4 px-2 items-center md:hidden">
                        <button id="addBookOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="fluent:add-24-regular" width="24" height="24" flip="vertical"></iconify-icon></button>
                        <div id="addBookMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                            <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 text-center text-xl rounded-2xl">
                                <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800">本を検索する</a>
                                <a href="{{route('book.manual')}}" class="block py-4">本を手動で登録する</a>
                            </div>

                            <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
                                <button id="addBookCloseBySp" class="block py-4 w-full">キャンセル</button>
                            </div>
                        </div>
                        <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                            <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                        </button>
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$selectedBook->id,  str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書中</a></h2>
                        <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                            <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
                        </button>
                        <button id="settingScreenOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
                        <div id="settingMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                            <div class="modal-content-setting bg-modal-window mx-auto mt-32 w-3/4 text-center text-xl rounded-2xl">
                                <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">ユーザー名称の変更</a>
                                <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">メールアドレスの変更</a>
                                <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">パスワードの変更</a>
                                <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">本の並び替え</a>
                                <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4">ジャンル名の追加</a>
                            </div>

                            <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full">
                                </form>
                            </div>
                        </div>
                    </div>

                    <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">読書中</h2>
                    <div class="md:bg-primary p-4 md:p-8 md:ml-20 mt-8 rounded-xl md:h-1/2">
                        @if($memo_groups->isEmpty())
                            <div class="flex justify-end">
                                <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-xl bg-slate-200 p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                                </form>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <button class="bg-slate-200 hover:bg-sky-500 hover:text-slate-50 border p-1 rounded-xl px-4">
                                    <a href="{{ route('group-user-memo.publish_status',['book_id'=> $selectedBook->id]) }}" class="text-xl">メモの公開・非公開</a>
                                </button>
                                <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-xl bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                                </form>
                            </div>
                        @endif

                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="w-2/3 md:m-auto px-4 text-xl md:w-1/2">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>

                                @if(!($selectedBook->memo->isEmpty()))
                                    <div class="hidden md:block text-xl md:bg-slate-50 py-2 px-4 rounded-xl mt-4">
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

                        @if(!($selectedBook->memo->isEmpty()))
                            <div class="md:hidden text-xl bg-primary py-2 px-4 rounded-xl mt-4">
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
                @elseif($selectedBook->state == '気になる')
                    <div class="flex justify-between bg-primary py-4 px-2 items-center md:hidden">
                        <button id="addBookOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="fluent:add-24-regular" width="24" height="24" flip="vertical"></iconify-icon></button>
                        <div id="addBookMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                            <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 text-center text-2xl rounded-2xl">
                                <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800">本を検索する</a>
                                <a href="{{route('book.manual')}}" class="block py-4">本を手動で登録する</a>
                            </div>

                            <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-2xl rounded-2xl">
                                <button id="addBookCloseBySp" class="block py-4 w-full">キャンセル</button>
                            </div>
                        </div>
                        <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                            <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                        </button>
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>気になる</a></h2>
                        <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                            <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
                        </button>
                        <button id="settingScreenOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
                        <div id="settingMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                            <div class="modal-content-setting bg-modal-window mx-auto mt-32 w-3/4 text-center text-2xl rounded-2xl">
                                <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">ユーザー名称の変更</a>
                                <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">メールアドレスの変更</a>
                                <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">パスワードの変更</a>
                                <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800">本の並び替え</a>
                                <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4">ジャンル名の追加</a>
                            </div>

                            <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-2xl rounded-2xl">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full">
                                </form>
                            </div>
                        </div>
                    </div>
                    <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">気になる</h2>
                    <div class="md:bg-primary p-4 md:p-8 md:ml-20 mt-8 rounded-xl md:h-1/2">
                        <div class="flex justify-between">
                            <div class="hover:after:content-['「気になる」から「読書中」に移動する'] hover:after:relative hover:after:-top-10 hover:after:-left-10 hover:after:bg-gray-700 hover:after:text-stone-50 hover:after:rounded hover:after:p-2 hover:after:text-">
                                <a href="{{ route('book.update', $selectedBook->id) }}" class="inline-block bg-slate-200 hover:bg-sky-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="cil:data-transfer-up" width="24" height="24"></iconify-icon></a>
                            </div>

                            <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                            </form>
                        </div>
                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="w-2/3 md:m-auto px-4 text-xl md:w-1/2">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>
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



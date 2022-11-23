<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-groupbooklist.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="{{ asset('js/web-share.js') }}" defer></script>
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
                <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>グループ</a></h2>
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

            @if(isset($selectedBook))
                <h2 id="groupName" class="mt-8 px-4 md:px-10 md:mt-10 font-medium text-xl py-2">公開グループ名：{{ $group_name }}</h2>

                <div class="md:bg-primary md:p-8 md:ml-20 md:mt-8 rounded-xl md:h-1/2">
                    <div class="bg-primary text-xl w-5/6 mx-4 md:mx-0 md:bg-slate-50 py-2 px-10 my-2 md:px-4 rounded-xl md:mt-4 md:w-9/12">
                        公開ユーザー名：{{ $users->find($selectedBook->memo->first()->user_id)->name }}
                    </div>
                    <div class="flex w-full md:my-8 p-4 md:p-0">
                        <div class="w-1/3">
                            <img src="{{$selectedBook->image_path}}" class="w-full">
                        </div>
                        <div class="md:m-auto px-4 text-xl w-2/3 md:w-1/2 text-normal">
                            <p id="title">{{$selectedBook->title}}</p>
                            <p class="pt-6">{{$selectedBook->author}}</p>
                            <p class="pt-6">{{$genre_name}}</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
</body>
</html>



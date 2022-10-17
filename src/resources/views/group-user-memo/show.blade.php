<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-groupmemolist.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="{{ asset('js/web-share.js') }}" defer></script>
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
                                        <a href="{{route('book.show', $book->id)}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book->title}}</a>
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
                                        <a href="{{route('book.show', $book->id)}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book->title}}</a>
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
                                            <div class="flex justify-between">
                                                <a href="#" class="marker block"><iconify-icon inline icon="fa:group" width="16" height="16" class="mr-2"></iconify-icon>{{$memo_group->group_name}}</a>

                                                @if($memo_group->pivot->is_owner == true)
                                                    <div class="flex">
                                                        <a href="{{ route('group-user.add', $memo_group->id) }}" class="block"><iconify-icon inline icon="material-symbols:group-add" width="16" height="16" class="px-1.5 py-1 bg-slate-50 rounded mr-2"></iconify-icon>
                                                        <a href="{{ route('group-user.edit', $memo_group->id) }}" class="block"><iconify-icon inline icon="material-symbols:group-remove" width="16" height="16" class="px-1.5 py-1 bg-slate-50 rounded mr-10"></iconify-icon></a>
                                                    </div>
                                                @endif
                                            </div>

                                            @foreach($memo_group->user as $group_user)
                                                @foreach($group_user->book as $book)
                                                    @foreach($book->memo as $memo)
                                                        @if($memo->group_id == $memo_group->id)
                                                            <a href="{{route('group-user-memo.index', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="block groupMarker pl-4"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book->title}}（公開ユーザー名：{{ $memo->user->name }}）</a>
                                                            <ul class="pl-8 hidden groupDropdown">
                                                                <li><a href="{{route('group-user-book-memo.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">読書メモ</a></li>
                                                                <li><a href="{{route('group-user-action-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">アクションリスト</a></li>
                                                                <li><a href="{{route('group-user-feedback-list.show', ['book_id'=>$book->id, 'group_id'=>$memo->group_id])}}" class="groupMarker block">振り返り</a></li>
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

        <section>
            <h2 id="title" class="px-10 pt-10 font-medium text-xl">{{ $select_book->title }}</h2>
            <p id="groupName" class="px-10 pt-2">（公開グループ名：{{ $group_name }}）</p>

            @if(strpos(url()->full(),'book-memo')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-6 font-medium text-xl">読書メモ</h2>

                    <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4">読書前</h3>
                        <textarea cols="80" rows="5" readonly class="rounded">{{$store_memo->before_reading_content}}</textarea>
                    </section>

                    <section class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">読書中</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->reading_content}}</textarea>
                    </section>

                    <section class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">読書後</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->after_reading_content}}</textarea>
                    </section>
                </div>

            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-6 font-medium text-xl">アクションリスト</h2>

                    <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4">アクションリスト１</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->actionlist1_content}}</textarea>
                    </section>

                    <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">アクションリスト２</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->actionlist2_content}}</textarea>
                    </section>

                    <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">アクションリスト３</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->actionlist3_content}}</textarea>
                    </section>
                </div>
            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-6 font-medium text-xl">振り返り</h2>

                    <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4">Q.アクションリスト１を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->feedback1_content}}</textarea>
                    </section>

                    <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">Q.アクションリスト２を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->feedback2_content}}</textarea>
                    </section>

                    <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-4 rounded bg-primary">
                        <h3 class="py-4">Q.アクションリスト３を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded">{{$store_memo->feedback3_content}}</textarea>
                    </section>
                </div>
            @endif
        </section>
    </div>
</body>
</html>



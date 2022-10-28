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

            <div class="mr-4">
                <ul>
                    <li>
                        <p class="pl-6">読書中</p>
                        <ul class="pl-10">
                            @foreach ($books_reading as $book_reading)
                                <li class="mt-2">
                                    <a href="{{route('book.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_reading->title}}</a>
                                    <ul class="pl-6 hidden dropdown">
                                        <li><a href="{{route('book-memo.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">読書メモ</a></li>
                                        <li><a href="{{route('action-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">アクションリスト</a></li>
                                        <li><a href="{{route('feedback-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">振り返り</a></li>
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

        <section class="w-1/2">
            <h2 id="title" class="px-10 pt-10 font-medium text-xl">{{ $select_book->title }}</h2>

            @if(strpos(url()->full(),'book-memo')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-4 font-medium text-xl">読書メモ</h2>
                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_before_reading_content') }}
                        </div>
                    @endif

                    @if($is_store_memo)
                        @if(strpos(url()->previous(),'book-memo/before/edit'))
                            <p class="text-red-600 pt-2 pl-4">読書前メモの保存に成功しました！</p>
                        @elseif(strpos(url()->previous(),'book-memo/during/edit'))
                            <p class="text-red-600 pt-2 pl-4">読書中メモの保存に成功しました！</p>
                        @elseif(strpos(url()->previous(),'book-memo/after/edit'))
                            <p class="text-red-600 pt-2 pl-4">読書後メモの保存に成功しました！</p>
                        @endif

                        <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書前</h3>
                                <a href="{{route('book-memo-before.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->before_reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書前</h3>
                                <a href="{{route('book-memo-before.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->reading_content)
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書中</h3>
                                <div class="flex justify-between">
                                    @if($store_memo->reading_content)
                                        <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                                    @endif

                                    <a href="{{route('book-memo-during.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                                </div>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書中</h3>
                                <a href="{{route('book-memo-during.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※自由なメモを記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->after_reading_content)
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書後</h3>
                                <div class="flex justify-between">
                                    @if($store_memo->after_reading_content)
                                        <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                                    @endif

                                    <a href="{{route('book-memo-after.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                                </div>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->after_reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto">読書後</h3>
                                <a href="{{route('book-memo-after.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※読書前に記載した３点に関して得た情報を記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif
                </div>

            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-4 font-medium text-xl">アクションリスト</h2>

                    @if(strpos(url()->previous(),'action-list/edit'))
                        <p class="text-red-600 pt-2 pl-4">アクションリストメモの保存に成功しました！</p>
                    @endif

                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_book_memo') }}
                            {{ session('errors')->first('none_action_list1_content') }}
                        </div>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist1_content)
                        <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4">アクションリスト１</h3>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->actionlist1_content}}</textarea>
                        </section>
                    @else
                        <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4">アクションリスト１</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist2_content)
                        <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">アクションリスト２</h3>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->actionlist2_content}}</textarea>
                        </section>
                    @else
                        <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">アクションリスト２</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist1_content)
                        @if($store_memo->actionlist3_content)
                            <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4">アクションリスト３</h3>
                                <textarea  cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->actionlist3_content}}</textarea>
                            </section>
                        @else
                            <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4">アクションリスト３</h3>
                                <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full" disabled></textarea>
                            </section>
                        @endif

                        <div class="flex justify-end mt-2">
                            @if($store_memo->actionlist1_content)
                                <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                            @endif

                            <a href="{{route('action-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                        </div>
                    @else
                        <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">アクションリスト３</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full" disabled></textarea>
                        </section>
                        <div class="flex justify-end mt-2">
                            <a href="{{route('action-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                        </div>
                    @endif
                </div>

            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="pl-12">
                    <h2 id="book-memo" class="pt-4 font-medium text-xl">振り返り</h2>

                    @if(strpos(url()->previous(),'feedback-list/edit'))
                        <p class="text-red-600 pt-2 pl-4">振り返りメモの保存に成功しました！</p>
                    @endif

                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_book_memo') }}
                            {{ session('errors')->first('none_action_list') }}
                            {{ session('errors')->first('none_feedback_list1_content') }}
                        </div>
                    @endif

                    @if($is_store_memo && $store_memo->feedback1_content)
                        <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4">Q.アクションリスト１を実施した結果は？</h3>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->feedback1_content}}</textarea>
                        </section>
                    @else
                        <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4">Q.アクションリスト１を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->feedback2_content)
                        <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">Q.アクションリスト２を実施した結果は？</h3>
                            <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->feedback2_content}}</textarea>
                        </section>
                    @else
                        <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">Q.アクションリスト２を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full" disabled></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->feedback1_content)
                        @if($store_memo->feedback3_content)
                            <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4">Q.アクションリスト３を実施した結果は？</h3>
                                <textarea cols="80" rows="5" class="rounded w-full" disabled>{{$store_memo->feedback3_content}}</textarea>
                            </section>
                        @else
                            <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4">Q.アクションリスト３を実施した結果は？</h3>
                                <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full" disabled></textarea>
                            </section>
                        @endif

                        <div class="flex justify-end mt-2">
                            @if($store_memo->feedback1_content)
                                <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                            @endif

                            <a href="{{route('feedback-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                        </div>
                    @else
                        <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4">Q.アクションリスト３を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full" disabled></textarea>
                        </section>
                        <div class="flex justify-end mt-2">
                            <a href="{{route('feedback-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    </div>
</body>
</html>



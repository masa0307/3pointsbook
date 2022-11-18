<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-memolist.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />

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
                                                        <a href="{{ route('group-user.add', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block"><iconify-icon inline icon="material-symbols:group-add" width="20" height="20" class="px-1.5 py-1 bg-slate-50 rounded mr-8"></iconify-icon>
                                                        <a href="{{ route('group-user.edit', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block"><iconify-icon inline icon="material-symbols:group-remove" width="20" height="20" class="px-1.5 py-1 bg-slate-50 rounded"></iconify-icon></a>
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

        <section class="mb:w-1/2">
            <div class="flex justify-between bg-primary py-4 px-2 items-center md:hidden">
                <button id="addBookOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="fluent:add-24-regular" width="24" height="24" flip="vertical"></iconify-icon></button>
                <div id="addBookMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                    <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 text-center text-xl rounded-2xl">
                        <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800 rounded-t-2xl  hover:bg-sky-500 hover:text-slate-50">本を検索する</a>
                        <a href="{{route('book.manual')}}" class="block py-4 rounded-b-2xl  hover:bg-sky-500 hover:text-slate-50">本を手動で登録する</a>
                    </div>

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
                        <button id="addBookCloseBySp" class="block py-4 w-full rounded-2xl  hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
                    </div>
                </div>
                <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
                    <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
                </button>
                @if(strpos(url()->full(),'book-memo')!== false)
                    <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書メモ</a></h2>
                @elseif(strpos(url()->full(),'action-list')!== false)
                    <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>アクションリスト</a></h2>
                @elseif(strpos(url()->full(),'feedback-list')!== false)
                    <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>振り返り</a></h2>
                @endif


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

                    <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">
                        </form>
                    </div>
                </div>
            </div>

            <h2 class="px-5 md:px-10 pt-8 pb-2 font-medium text-xl">{{ $select_book->title }}</h2>
            @if(strpos(url()->full(),'before')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ</h2>
                    @if($is_store_memo)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="before_reading_content" class="block">読書前</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('before_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5" class="rounded w-full">{{old('before_reading_content', $store_memo->before_reading_content)}}</textarea>
                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="before_reading_content" class="block">読書前</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('before_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載" class="rounded w-full">{{old('before_reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'during')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ</h2>
                    @if($store_memo->reading_content)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="reading_content" class="block">読書中</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="reading_content" id="reading_content" cols="80" rows="5" class="rounded w-full">{{old('reading_content', $store_memo->reading_content)}}</textarea>

                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="reading_content" class="block">読書中</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="reading_content" id="reading_content" cols="80" rows="5" placeholder="※自由なメモを記載" class="rounded w-full">{{old('reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'after')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ</h2>
                    @if($store_memo->after_reading_content)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="after_reading_content" class="block">読書後</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('after_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5" class="rounded w-full">{{old('after_reading_content', $store_memo->after_reading_content)}}</textarea>
                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="after_reading_content" class="block">読書後</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('after_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5" placeholder="※読書前に記載した３点に関して得た情報を記載" class="rounded w-full">{{old('after_reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">アクションリスト</h2>
                    @if($store_memo->actionlist1_content)
                        <form action="{{route('action-list.update', ['id'=>$id])}}" method="POST" name="form">
                            @method('PATCH')
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="actionlist1_content" class="block py-4">アクションリスト１</label>

                                @error('actionlist1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5" class="rounded w-full">{{old('actionlist1_content', $store_memo->actionlist1_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist2_content" class="block py-4">アクションリスト２</label>

                                @error('actionlist2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{old('actionlist2_content', $store_memo->actionlist2_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist3_content" class="block py-4">アクションリスト３</label>

                                @error('actionlist3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{old('actionlist3_content', $store_memo->actionlist3_content)}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('action-list.store', ['book_id'=>$id])}}" method="POST" name="form">
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="actionlist1_content" class="block py-4">アクションリスト１</label>

                                @error('actionlist1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist1_content') }}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist2_content" class="block py-4">アクションリスト２</label>

                                @error('actionlist2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist2_content') }}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist3_content" class="block py-4">アクションリスト３</label>

                                @error('actionlist3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist3_content') }}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">振り返り</h2>
                    @if($store_memo->feedback1_content)
                        <form action="{{route('feedback-list.update', ['id'=>$id])}}" method="POST" name="form">
                            @method('PATCH')
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="feedback1_content" class="block py-4">Q.アクションリスト１を実施した結果は？</label>

                                @error('feedback1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback1_content" id="feedback1_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback1_content', $store_memo->feedback1_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback2_content" class="block py-4">Q.アクションリスト２を実施した結果は？</label>

                                @error('feedback2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback2_content" id="feedback2_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback2_content', $store_memo->feedback2_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback3_content" class="block py-4">Q.アクションリスト３を実施した結果は？</label>

                                @error('feedback3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback3_content" id="feedback3_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content', $store_memo->feedback3_content)}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('feedback-list.store', ['book_id'=>$id])}}" method="POST" name="form">
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="feedback1_content" class="block py-4">Q.アクションリスト１を実施した結果は？</label>

                                @error('feedback1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback1_content" id="feedback1_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback2_content" class="block py-4">Q.アクションリスト２を実施した結果は？</label>

                                @error('feedback2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback2_content" id="feedback2_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback3_content" class="block py-4">Q.アクションリスト３を実施した結果は？</label>

                                @error('feedback3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback3_content" id="feedback3_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif
        </section>
    </div>
</body>
</html>



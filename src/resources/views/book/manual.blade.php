<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen bg-primary">
            <x-side-menu />

            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の登録</a></h2>
            </x-top-menu>

            <div class="hidden md:block mr-4">
                <ul>
                    <li>
                        <p class="pl-6">読書中</p>
                        <ul class="pl-10">
                            @foreach ($books_reading as $book_reading)
                                <li class="mt-2">
                                    <a href="{{route('book.show', $book_reading->id)}}" class="marker block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_reading->title}}</a>
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
            <div class="hidden md:block bg-primary p-3 ml-20 mt-8 rounded-xl w-full text-center text-lg">本の登録</div>
            <div class="mt-10 md:mt-0 p-2 md:ml-20 rounded w-full h-3/4 bg-modal-window flex align-center">
                <form action="{{route('book.store')}}" method="POST" class="w-full h-fit my-auto bg-slate-300">
                    @csrf
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="title"class="block pt-2 pl-2 text-white">タイトル（必須）</label>

                        @error('title')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="title" type="text" value="{{old('title')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="titleKana" class="block pt-2 pl-2 text-white">タイトル（カナ）（必須）</label>

                        @error('title_kana')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="title_kana" type="text" value="{{old('title_kana')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="author" class="block pt-2 pl-2 text-white">著者名（必須）</label>

                        @error('author')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="author" type="text" value="{{old('author')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
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
                        <button type="submit" class="inline-block py-2 px-4 bg-slate-300 hover:bg-sky-500 hover:text-slate-50 rounded">保存する</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>



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
                <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の検索</a></h2>
            </x-top-menu>

            <div class="hidden md:block mt-8">
                <ul class="pr-4 pb-5 border-b">
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

                <ul class="pt-5 pb-5 border-b">
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

                <ul class="pr-4 pt-5">
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
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の検索</h2>
            <form method="GET" action="{{ route('search-book.index') }}" class="bg-primary p-2 md:ml-20 mt-8 rounded-xl md:w-full text-center flex mx-2">
                <input type="search" placeholder="本のタイトルを入力" name="search_title" value="@if (isset($search)) {{ $search }} @endif" class="rounded w-10/12 md:ml-4">
                <div class="flex align-center">
                    <button type="submit" class="ml-2 px-2 py-2 bg-slate-200 rounded hover:bg-sky-500 hover:text-slate-50">検索</button>
                </div>
            </form>
            <div class="flex flex-wrap p-2 md:ml-20 rounded w-full h-3/4 md:bg-modal-window">
                @if($is_search_result == false)
                    <p class="text-red-600">※該当する本がありません</p>
                @endif

                @if(session("search_book"))
                    @foreach(session("search_book") as $value)
                        <div class="md:basis-1/5 pt-6 pr-4">
                            <a href="{{ route("book.show", $value->id) }}" class="flex md:block">
                                <img src="{{$value->image_path}}" class="mr-4">
                                <div>
                                    <p id="title">{{$value->title}}</p>
                                    <p>{{$value->author}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    </div>
</body>
</html>



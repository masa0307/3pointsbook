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
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />

            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-sm"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>ユーザー名称の変更</a></h2>
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

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">ユーザー名称の変更</h2>

            @if(strpos(url()->full(),'update'))
                <p class="text-red-600 pt-8 md:ml-20 mx-4">ユーザー名称の変更に成功しました！</p>
                <div class="bg-primary p-8 md:ml-20 mt-2 mx-4 rounded-xl">
                    <div>
                        <p>現在</p>
                        <input type="text" value="{{ $user_name }}" class="pl-3 pt-2 mt-2 border-none rounded w-full" disabled>
                    </div>
                </div>
            @else
                <div class="bg-primary p-8 md:ml-20 mt-8 mx-4 rounded-xl">
                    <form action="{{ route('user-name.update', Auth::id()) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <p>現在</p>
                            <p class="pl-3 pt-2">{{ $user_name }}</p>
                        </div>
                        <div class="pt-8">
                            <p>変更後</p>

                            @error('name')
                                <p class="text-red-600 pt-1">※{{ $message }}</p>
                            @enderror

                            <div class="pt-2">
                                <input type="text" name="name" placeholder="ユーザー名称" value="{{ old('name') }}" class="border-none rounded w-full">
                            </div>
                        </div>
                        <div class="pt-8">
                            <button type="submit" class="block text-center w-full bg-slate-200 p-1 rounded hover:bg-sky-500 hover:text-slate-50">変更</button>
                        </div>
                    </form>
                </div>
            @endif

        </section>
    </div>
</body>
</html>



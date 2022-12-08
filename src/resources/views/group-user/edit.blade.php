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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>メンバーの削除</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />

        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">メンバーの削除</h2>
            <div class="bg-primary p-8 mx-4 md:ml-20 mt-8 rounded-xl text-normal">
                <p class="font-semibold text-lg">グループ名：{{ session('group_name') }}</p>
                <div class="pt-10">
                    @if(isset($group_users))
                        <p class="border-b border-slate-400">メンバー</p>
                        @foreach($group_users as $group_user)
                            @if($group_user->participation_status == '参加中')
                                <div class="flex justify-between mt-2">
                                    <p class="py-2">・{{ $group_user->user->name }}</p>
                                    <form action="{{ route('group-user.destroy', ['group_id'=>$group_user->group_id, 'user_id'=>$group_user->user_id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="px-2 py-2 bg-slate-200 rounded text-black hover:bg-red-500 hover:text-slate-50 ">削除</button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </div>
</body>
</html>



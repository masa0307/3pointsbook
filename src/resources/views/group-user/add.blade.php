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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>メンバーの追加</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">メンバーの追加</h2>
            <div class="bg-primary p-8 mx-4 md:ml-20 mt-8 rounded-xl text-normal">
                <p class="font-semibold text-lg">グループ名：{{ session('group_name') }}</p>
                <div class="pt-10">
                    <p class="border-b border-slate-400">追加するメンバー</p>

                    <form action="{{ route('group-user.searchResult') }}" method="post" class="pt-4">
                        @csrf
                        <input type="search" placeholder="メンバー名を入力" name="name" class="border-none rounded w-9/12">
                        <button type="submit" class="ml-2 px-2 py-2 bg-slate-200 rounded text-black">検索</button>
                    </form>

                    @error('user_id')
                        <p class="text-red-600">※{{ $message }}</p>
                    @enderror

                    @error('name')
                        <p class="text-red-600">※{{ $message }}</p>
                    @enderror

                </div>

                <p class="pt-6 border-b border-slate-400">現在のメンバー</p>
                @foreach($group_users as $group_user)
                    @if($group_user->is_owner == true)
                        <p class="pt-4">・{{ $group_user->user->name }}（グループオーナー）</p>
                    @else
                        <p class="pt-1">・{{ $group_user->user->name }}（{{ $group_user->participation_status }}）</p>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
</body>
</html>



<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />
            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>メンバーの追加</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">メンバーの追加</h2>
            <div class="bg-primary p-8 mx-4 md:ml-20 mt-8 rounded-xl text-normal">
                <p class="font-semibold text-lg">グループ名：{{ session('group_name') }}</p>
                <div class="pt-10">
                    <p class="border-b border-slate-400">追加するメンバー</p>

                    <form action="{{ route('group-user.searchResult') }}" method="post" class="pt-4 pb-2">
                        @csrf
                        <input type="search" placeholder="メンバー名を入力" name="name" class="border-none rounded w-9/12 text-black">
                        <button type="submit" class="ml-2 px-2 py-2 bg-slate-200 rounded text-black hover:bg-sky-500 hover:text-slate-50">検索</button>
                    </form>

                    <p class="text-red-600">{{ session('search_number_limit') }}</p>
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
                        <p class="pt-2">・{{ $group_user->user->name }}（グループオーナー）</p>
                    @else
                        <p class="pt-2">・{{ $group_user->user->name }}（{{ $group_user->participation_status }}）</p>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
</x-common>


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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>パスワードの変更</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">パスワードの変更</h2>

            @if(strpos(url()->full(),'update'))
                <p class="text-red-600 pt-8 md:ml-20 mx-4">パスワードの変更に成功しました！</p>
                <div class="bg-primary p-8 md:ml-20 mt-2 mx-4 rounded-xl text-normal">
                    <form action="{{ route('login-password.update', Auth::id()) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <p>現在</p>

                            @if (session('errors'))
                                <div class="text-red-600 pt-1">
                                    {{ session('errors')->first('not_match_password') }}
                                </div>
                            @endif

                            <div class="pt-2">
                                <input type="password" name="current_password" placeholder="現在のパスワード" class="border-none rounded w-full text-black">
                            </div>
                        </div>
                        <div class="pt-8">
                            <p>変更後</p>
                            <div class="pt-2">
                                <input type="password" name="update_password" placeholder="変更後のパスワード" class="border-none rounded w-full text-black">
                            </div>
                        </div>
                        <div class="pt-8">
                            <button type="submit" class="block text-center w-full bg-slate-200 p-1 rounded">変更</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-primary p-8 md:ml-20 mt-8 mx-4 rounded-xl text-normal">
                    <form action="{{ route('login-password.update', Auth::id()) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <p>現在</p>

                            @if (session('errors'))
                                <div class="text-red-600 pt-1">
                                    {{ session('errors')->first('not_match_password') }}
                                </div>
                            @endif

                            <div class="pt-2">
                                <input type="password" name="current_password" placeholder="現在のパスワード" class="border-none rounded w-full text-black">
                            </div>
                        </div>
                        <div class="pt-8">
                            <p>変更後</p>
                            <div class="pt-2">

                                @error('update_password')
                                    <p class="text-red-600">※{{ $message }}</p>
                                @enderror

                                <input type="password" name="update_password" placeholder="変更後のパスワード" class="border-none rounded w-full mt-1 text-black">
                            </div>
                        </div>
                        <div class="pt-8">
                            <button type="submit" class="block text-center w-full bg-slate-200 p-1 rounded hover:bg-sky-500 hover:text-slate-50 text-black">変更</button>
                        </div>
                    </form>
                </div>
            @endif
        </section>
    </div>
</x-common>

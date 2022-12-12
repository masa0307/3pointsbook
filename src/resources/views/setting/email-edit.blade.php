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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>メールアドレスの変更</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">メールアドレスの変更</h2>

            @if(strpos(url()->full(),'update'))
                <p class="text-red-600 pt-8 md:ml-20 mx-4">メールアドレスの変更に成功しました！</p>
                <div class="bg-primary p-8 md:ml-20 mt-2 mx-4 rounded-xl">
                    <div class="text-normal">
                        <p>現在</p>
                        <input type="text" value="{{ $email }}" class="pl-3 pt-2 mt-2 border-none rounded w-full text-black" disabled>
                    </div>
                </div>
            @else
                <div class="bg-primary p-8 md:ml-20 mt-8 mx-4 rounded-xl text-normal">
                    <form action="{{ route('email.update', Auth::id()) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <p>現在</p>
                            <p class="pl-3 pt-2">{{ $email }}</p>
                        </div>
                        <div class="pt-8">
                            <p>変更後</p>

                            @error('email')
                                <p class="text-red-600 pt-1">※{{ $message }}</p>
                            @enderror

                            <p class="pt-2">
                                <input type="text" name="email" placeholder="メールアドレス" value="{{ old('email') }}" class="border-none rounded w-full text-black">
                            </p>
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



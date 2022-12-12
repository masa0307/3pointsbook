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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>ジャンル名の追加</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">ジャンル名の追加</h2>

            @if(strpos(url()->full(),'store'))
                <p class="text-red-600 pt-8 md:ml-20 mx-4">ジャンル名の追加に成功しました！</p>
                <div class="bg-primary p-8 md:ml-20 mt-2 mx-4 rounded-xl text-normal">
                    <div>
                        <p>現在</p>
                        <div class="bg-slate-50 mt-2 rounded p-2 text-black">
                            @foreach($genres as $genre)
                                <p class="pl-3 pt-2 w-full">・{{ $genre->genre_name }}</p>
                            @endforeach
                        </div>

                    </div>
                </div>
            @else
                <div class="bg-primary p-8 md:ml-20 mt-8 mx-4 rounded-xl text-normal">
                    <form action="{{ route('genre-name.store', Auth::id()) }}" method="POST">
                        @csrf
                        <div>
                            <p>現在のジャンル名</p>
                            @foreach($genres as $genre)
                                <p class="pl-3 pt-2">・{{ $genre->genre_name }}</p>
                            @endforeach
                        </div>
                        <div class="pt-8">
                            <p>追加するジャンル名</p>
                            <div class="pt-2">
                                @error('genre_name')
                                    <p class="text-red-600">※{{ $message }}</p>
                                @enderror
                                <input type="text" name="genre_name" placeholder="ジャンル名" class="border-none rounded w-full mt-1 text-black">
                            </div>
                        </div>
                        <div class="pt-8">
                            <button type="submit" class="block text-center w-full bg-slate-200 p-1 rounded hover:bg-sky-500 hover:text-slate-50 text-black">追加</button>
                        </div>
                    </form>
                </div>
            @endif

        </section>
    </div>
</x-common>



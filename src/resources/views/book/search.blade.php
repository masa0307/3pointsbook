<x-common>
    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/search-book.js') }}" defer></script>
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen bg-primary">
            <x-side-menu />

            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-xl text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の追加</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />

        </section>

        <section id="searchSection" class="md:w-1/2">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の追加</h2>
            <div id="searchWindow" class="bg-primary p-3 mx-2 md:ml-20 mt-8 rounded-xl md:w-full text-center">
                <input type="text" placeholder="タイトル名" id="title" class="rounded w-4/5 md:w-5/6">
                <button id="searchButton" class="w-2/12 md:w-1/12 px-2 py-2 bg-slate-200 rounded  hover:bg-sky-500 hover:text-slate-50">
                    検索
                </button>
            </div>
            <div id="resultWindow" class="md:flex md:flex-wrap p-2 md:ml-20 rounded md:w-full min-h-[75%] md:bg-modal-window">
                <p class="text-red-600 hidden" id="resultMessage">※該当する本がありません</p>
            </div>
        </section>
    </div>
</x-common>

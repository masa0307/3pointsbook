<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/search-book.js') }}" defer></script>
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen bg-primary">
            <x-side-menu />

            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の追加</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

        </section>

        <section id="searchSection" class="md:w-1/2">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の追加</h2>
            <div id="searchWindow" class="bg-primary p-3 mx-2 md:ml-20 mt-8 rounded-xl md:w-full text-center">
                <input type="text" placeholder="タイトル名" id="title" class="rounded w-4/5 md:w-5/6">
                <button id="searchButton" class="w-2/12 md:w-1/12 px-2 py-2 bg-slate-200 rounded  hover:bg-sky-500 hover:text-slate-50">
                    検索
                </button>
            </div>
            <div id="resultWindow" class="md:flex md:flex-wrap p-2 md:ml-20 rounded md:w-full h-3/4 md:bg-modal-window">
                <p class="text-red-600 hidden" id="resultMessage">※該当する本がありません</p>
            </div>
        </section>
    </div>
</body>
</html>

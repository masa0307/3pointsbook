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

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

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



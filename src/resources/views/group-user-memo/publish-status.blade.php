<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3pointsbook</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/add-book.js') }}" defer></script>
    <script src="{{ asset('js/marker-booklist.js') }}" defer></script>
    <script src="{{ asset('js/set-application.js') }}" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />

            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>メモの公開・非公開</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />

        </section>

        <section class="md:w-5/12 text-black">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">メモの公開</h2>

            <div class="md:bg-primary md:p-8 px-4 md:ml-20 mt-8 rounded-xl h-1/2">
                @if($memo_groups)
                    @if(!($not_published_groups->isEmpty()))
                        <form action="{{ route('group-user-memo.publish', $published_book->id) }}" method="POST">
                            @csrf
                            @if(($published_book->memo)->isEmpty())
                                <p class="pt-2 text-red-500 ml-2">※保存済みのメモがないため、公開できません</p>
                            @else
                                <label for="group_name" class="font-semibold md:text-subtitle">メモの公開&emsp;：</label>
                                <select name="group_id" id="group_name" class="rounded w-1/3 md:w-1/4">
                                    @foreach($not_published_groups as $not_published_group)
                                        <option value="{{ $not_published_group->id }}">{{ $not_published_group->group_name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-slate-200 hover:bg-sky-500 hover:text-slate-50 py-1 rounded-xl px-4 ml-4 w-1/4 md:w-1/6">公開</button>
                            @endif

                        </form>
                    @else
                        <p class="pt-2 text-red-500 ml-2">※全てのグループに公開済みです</p>
                    @endif

                    @if(!($published_groups->isEmpty()))
                        <form action="{{ route('group-user-memo.publish', $published_book->id) }}" method="POST" class="mt-2">
                            @csrf
                            <label for="group_name" class="font-semibold md:text-subtitle">メモの非公開：</label>
                            <select name="non_group_id" id="group_name" class="rounded w-1/3 md:w-1/4">
                                @foreach($published_groups as $published_group)
                                    <option value="{{ $published_group->id }}">{{ $published_group->group_name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-slate-200 hover:bg-sky-500 hover:text-slate-50 py-1 rounded-xl px-4 ml-4 w-1/4 md:w-1/6">非公開</button>
                        </form>
                    @else
                        <p class="pt-2 text-red-500 ml-2">※非公開にするグループはありません</p>
                    @endif

                @endif

                <div class="flex w-full my-8">
                    <div class="w-1/3">
                        <img src="{{$published_book->image_path}}" class="w-full">
                    </div>
                    <div class="m-auto px-4 text-xl w-1/2 md:text-normal">
                        <p id="title">{{$published_book->title}}</p>
                        <p class="pt-6">{{$published_book->author}}</p>
                        <p class="pt-6">{{$genre_name}}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>



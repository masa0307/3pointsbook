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
                <h2 class="md:px-10 md:pt-10 font-medium text-xl text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の登録</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

        </section>

        <section class="md:w-1/2">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の追加</h2>
            <div class="hidden md:block bg-primary p-3 ml-20 mt-8 rounded-xl w-full text-center text-lg text-normal">本の登録</div>
            <div class="mt-10 md:mt-0 p-2 md:ml-20 rounded w-full h-3/4 bg-modal-window flex align-center">
                <form action="{{route('book.store')}}" method="POST" class="w-full h-fit my-auto bg-slate-300">
                    @csrf
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="title"class="block pt-2 pl-2 text-white">タイトル（必須）</label>

                        @error('title')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="title" type="text" value="{{old('title')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="titleKana" class="block pt-2 pl-2 text-white">タイトル（カナ）（必須）</label>

                        @error('title_kana')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="title_kana" type="text" value="{{old('title_kana')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="author" class="block pt-2 pl-2 text-white">著者名（必須）</label>

                        @error('author')
                            <p class="text-red-600 pl-4 pt-1">※{{ $message }}</p>
                        @enderror

                        <input name="author" type="text" value="{{old('author')}}" id="title" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="genre" class="block pt-2 pl-2 text-white">ジャンル（任意）（選択式）</label>
                        <select name="genre_id" id="genre" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="border-b border-neutral-50 pb-2">
                        <label for="state" class="block pt-2 pl-2 text-white">状態（必須）（選択式：気になる or 読書中）</label>
                        <select name="state" id="state" class="block rounded w-11/12 mt-1 bg-slate-300 border-slate-200 mx-2">
                            <option value="読書中">読書中</option>
                            <option value="気になる">気になる</option>
                        </select>
                    </div>
                    <div class="pt-4 bg-modal-window flex flex-row-reverse">
                        <button type="submit" class="inline-block py-2 px-4 bg-slate-300 hover:bg-sky-500 hover:text-slate-50 rounded">保存する</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>



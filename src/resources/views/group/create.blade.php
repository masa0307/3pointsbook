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
                <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>グループの作成</a></h2>
            </x-top-menu>

            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups" />

        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">グループの作成</h2>
            <div class="bg-primary p-8 mx-4 md:ml-20 mt-8 rounded-xl">
                <form action="{{ route('group.store') }}" method="post">
                    @csrf
                    <div>
                        <label for="group_name">グループ名</label>
                    </div>
                    <div class="pt-8">
                        @error('group_name')
                            <p class="text-red-600">※{{ $message }}</p>
                        @enderror
                        <input type="text" placeholder="作成するグループ名" name="group_name" class="border-none rounded w-full mt-2">
                    </div>
                    <div class="pt-8">
                        <button type="submit" class="block text-center w-full bg-slate-200 p-1 rounded hover:bg-sky-500 hover:text-slate-50">保存する</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>



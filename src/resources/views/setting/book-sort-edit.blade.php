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
                <h2 class="md:px-10 md:pt-10 font-medium text-sm text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の並び替え</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">本の並び替え</h2>

            @if(strpos(url()->full(),'update'))
                <p class="text-red-600 pt-8 md:ml-20 mx-4">本の並び替えに成功しました！</p>
                <div class="bg-primary p-8 md:ml-20 mt-2 mx-4 rounded-xl">
                    <div class="text-normal">
                        <p>現在</p>
                        <input type="text" value="{{ $sort_name }}" class="pl-3 pt-2 mt-2 border-none rounded w-full text-black" disabled>
                    </div>
                </div>
            @else
                <div class="bg-primary p-8 md:ml-20 mt-8 mx-4 rounded-xl text-normal">
                    <form action="{{ route('book-sort.update', Auth::id()) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div>
                            <p>現在</p>
                            <p class="pl-3 pt-2">{{ $sort_name }}</p>
                        </div>
                        <div class="pt-8">
                            <p>変更後</p>
                            <div class="pt-2">
                                <select name="sort_name" id="state" class="block border-none rounded w-full text-black" required>
                                    <option value="" selected hidden>選択してください</option>
                                    <option value="追加順（昇順）">追加順（昇順）</option>
                                    <option value="追加順（降順）">追加順（降順）</option>
                                    <option value="タイトル順（昇順）">タイトル順（昇順）</option>
                                    <option value="タイトル順（降順）">タイトル順（降順）</option>
                                </select>
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

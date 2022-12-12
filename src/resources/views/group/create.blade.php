<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen bg-primary">
            <x-side-menu />
            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{ route('book.index') }}" class="flex items-center justify-center text-normal"><iconify-icon icon="ci:external-link"></iconify-icon>グループの作成</a></h2>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/3">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">グループの作成</h2>
            <div class="bg-primary p-8 mx-4 md:ml-20 mt-8 rounded-xl">
                <form action="{{ route('group.store') }}" method="post">
                    @csrf
                    <div>
                        <label for="group_name" class="text-normal">グループ名</label>
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
</x-common>



<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-groupbooklist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="{{ asset('js/web-share.js') }}" defer></script>
        <script src="{{ asset('js/show-bookinformation.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-top-menu>
                <h2 class="md:px-10 md:pt-10 font-medium text-xl text-normal"><a href="{{ route('book.index') }}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>本の詳細</a></h2>
            </x-top-menu>
            <div id="sideMenu">
                <x-side-menu />
                <x-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
            </div>
        </section>

        <section id="bookInformation" class="hidden md:block md:w-5/12">
            @if(isset($selectedBook))
                <h2 id="groupName" class="mt-8 px-4 md:px-10 md:mt-10 font-medium text-xl py-2">公開グループ名：{{ $group_name }}</h2>

                <div class="md:bg-primary md:p-8 md:ml-20 md:mt-8 rounded-xl md:h-1/2">
                    <div class="bg-primary text-xl w-5/6 mx-4 md:mx-0 md:bg-slate-50 py-2 px-10 my-2 md:px-4 rounded-xl md:mt-4 md:w-9/12 text-normal md:text-black">
                        公開ユーザー名：{{ $users->find($selectedBook->memo->first()->user_id)->name }}
                    </div>
                    <div class="flex w-full md:my-8 p-4 md:p-0">
                        <div class="w-1/3">
                            <img src="{{$selectedBook->image_path}}" class="w-full">
                        </div>
                        <div class="md:m-auto px-4 text-xl w-2/3 md:w-1/2 md:text-normal">
                            <p id="title">{{$selectedBook->title}}</p>
                            <p class="pt-6">{{$selectedBook->author}}</p>
                            <p class="pt-6">{{$genre_name}}</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
</x-common>

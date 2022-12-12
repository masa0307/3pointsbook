<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-groupmemolist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="{{ asset('js/web-share.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />
            <x-top-menu>
                <div class="text-normal">
                    @if(strpos(url()->full(),'book-memo')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('group-user-memo.index', [$book_id, $group_id_parameter])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書メモ</a></h2>
                    @elseif(strpos(url()->full(),'action-list')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{route('group-user-memo.index', [$select_book->id, $group_id_parameter])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>アクションリスト</a></h2>
                    @elseif(strpos(url()->full(),'feedback-list')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('group-user-memo.index', [$select_book->id, $group_id_parameter])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>振り返り</a></h2>
                    @endif
                </div>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="md:w-1/2">
            <h2 id="title" class="px-10 pt-8 font-medium text-xl">{{ $select_book->title }}</h2>
            <p id="groupName" class="px-10 pt-2">（公開グループ名：{{ $group_name }}）</p>

            @if(strpos(url()->full(),'book-memo')!== false)
                <div class="px-4 md:px-0 pb-4 md:pl-12">
                    <h2 id="book-memo" class="hidden md:block pt-6 font-medium text-xl">読書メモ</h2>

                    <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4 text-normal">読書前</h3>
                        <textarea cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->before_reading_content}}</textarea>
                    </section>

                    <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">読書中</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->reading_content}}</textarea>
                    </section>

                    <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">読書後</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->after_reading_content}}</textarea>
                    </section>
                </div>

            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="px-4 md:px-0 pb-4 md:pl-12">
                    <h2 id="book-memo" class="hidden md:block pt-6 font-medium text-xl">アクションリスト</h2>

                    <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4 text-normal">アクションリスト１</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->actionlist1_content}}</textarea>
                    </section>

                    <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">アクションリスト２</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->actionlist2_content}}</textarea>
                    </section>

                    <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">アクションリスト３</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->actionlist3_content}}</textarea>
                    </section>
                </div>
            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="px-4 md:px-0 pb-4 md:pl-12">
                    <h2 id="book-memo" class="hidden md:block pt-6 font-medium text-xl">振り返り</h2>

                    <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                        <h3 class="py-4 text-normal">Q.アクションリスト１を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->feedback1_content}}</textarea>
                    </section>

                    <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">Q.アクションリスト２を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->feedback2_content}}</textarea>
                    </section>

                    <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                        <h3 class="py-4 text-normal">Q.アクションリスト３を実施した結果は？</h3>
                        <textarea  cols="80" rows="5" readonly class="rounded w-full">{{$store_memo->feedback3_content}}</textarea>
                    </section>
                </div>
            @endif
        </section>
    </div>
</x-common>


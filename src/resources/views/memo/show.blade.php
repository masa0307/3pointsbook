<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-memolist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="{{ asset('js/web-share.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:h-screen md:bg-primary">
            <x-side-menu />
            <x-top-menu>
                <div class="text-normal">
                    @if(strpos(url()->full(),'search_title')!== false)
                        @if(strpos(url()->full(),'book-memo')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('search-book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書メモ</a></h2>
                        @elseif(strpos(url()->full(),'action-list')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{route('search-book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>アクションリスト</a></h2>
                        @elseif(strpos(url()->full(),'feedback-list')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('search-book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>振り返り</a></h2>
                        @endif
                    @else
                        @if(strpos(url()->full(),'book-memo')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書メモ</a></h2>
                        @elseif(strpos(url()->full(),'action-list')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>アクションリスト</a></h2>
                        @elseif(strpos(url()->full(),'feedback-list')!== false)
                            <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>振り返り</a></h2>
                        @endif
                    @endif
                </div>
            </x-top-menu>

            @if(strpos(url()->full(),'search_title') !== false)
                <x-sp-hidden-search-memo-list />
            @else
                <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
            @endif
        </section>

        <section>
            <h2 id="title" class="px-5 md:px-10 pt-8 pb-2 font-medium text-xl">{{ $select_book->title }}</h2>

            @if(strpos(url()->full(),'book-memo')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ</h2>
                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_before_reading_content') }}
                        </div>
                    @endif

                    @if($is_store_memo)
                        @if(strpos(url()->previous(),'book-memo/before/edit') && session()->get('is_edit'))
                            <p class="text-red-600 pt-2 pl-4">読書前メモの保存に成功しました！</p>
                        @elseif(strpos(url()->previous(),'book-memo/during/edit') && session()->get('is_edit'))
                            <p class="text-red-600 pt-2 pl-4">読書中メモの保存に成功しました！</p>
                        @elseif(strpos(url()->previous(),'book-memo/after/edit') && session()->get('is_edit'))
                            <p class="text-red-600 pt-2 pl-4">読書後メモの保存に成功しました！</p>
                        @endif

                        <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書前</h3>
                                <a href="{{route('book-memo-before.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->before_reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書前</h3>
                                <a href="{{route('book-memo-before.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->reading_content)
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書中</h3>
                                <div class="flex justify-between">
                                    @if($store_memo->reading_content)
                                        <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                                    @endif

                                    <a href="{{route('book-memo-during.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                                </div>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書中</h3>
                                <a href="{{route('book-memo-during.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※自由なメモを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->after_reading_content)
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書後</h3>
                                <div class="flex justify-between">
                                    @if($store_memo->after_reading_content)
                                        <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                                    @endif

                                    <a href="{{route('book-memo-after.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                                </div>
                            </div>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->after_reading_content}}</textarea>
                        </section>
                    @else
                        <section class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <div class="flex justify-between py-2">
                                <h3 class="my-auto text-normal">読書後</h3>
                                <a href="{{route('book-memo-after.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                            </div>
                            <textarea cols="80" rows="5" placeholder="※読書前に記載した３点に関して得た情報を記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif
                </div>

            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">アクションリスト</h2>

                    @if(strpos(url()->previous(),'action-list/edit') && session()->get('is_edit'))
                        <p class="text-red-600 pt-2 pl-4">アクションリストメモの保存に成功しました！</p>
                    @endif

                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_book_memo') }}
                            {{ session('errors')->first('none_action_list1_content') }}
                        </div>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist1_content)
                        <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">アクションリスト１</h3>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->actionlist1_content}}</textarea>
                        </section>
                    @else
                        <section id="actionMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">アクションリスト１</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist2_content)
                        <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">アクションリスト２</h3>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->actionlist2_content}}</textarea>
                        </section>
                    @else
                        <section id="actionMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">アクションリスト２</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->actionlist1_content)
                        @if($store_memo->actionlist3_content)
                            <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4 text-normal">アクションリスト３</h3>
                                <textarea  cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->actionlist3_content}}</textarea>
                            </section>
                        @else
                            <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4 text-normal">アクションリスト３</h3>
                                <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                            </section>
                        @endif

                        <div class="flex justify-end mt-2">
                            @if($store_memo->actionlist1_content)
                                <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                            @endif

                            <a href="{{route('action-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                        </div>
                    @else
                        <section id="actionMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">アクションリスト３</h3>
                            <textarea cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                        <div class="flex justify-end mt-2">
                            <a href="{{route('action-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                        </div>
                    @endif
                </div>

            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">振り返り</h2>

                    @if(strpos(url()->previous(),'feedback-list/edit') && session()->get('is_edit'))
                        <p class="text-red-600 pt-2 pl-4">振り返りメモの保存に成功しました！</p>
                    @endif

                    @if (session('errors'))
                        <div class="text-red-600 pt-2">
                            {{ session('errors')->first('none_book_memo') }}
                            {{ session('errors')->first('none_action_list') }}
                            {{ session('errors')->first('none_feedback_list1_content') }}
                        </div>
                    @endif

                    @if($is_store_memo && $store_memo->feedback1_content)
                        <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">Q.アクションリスト１を実施した結果は？</h3>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->feedback1_content}}</textarea>
                        </section>
                    @else
                        <section id="feedbackMemo1" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">Q.アクションリスト１を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->feedback2_content)
                        <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">Q.アクションリスト２を実施した結果は？</h3>
                            <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->feedback2_content}}</textarea>
                        </section>
                    @else
                        <section id="feedbackMemo2" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">Q.アクションリスト２を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                    @endif

                    @if($is_store_memo && $store_memo->feedback1_content)
                        @if($store_memo->feedback3_content)
                            <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4 text-normal">Q.アクションリスト３を実施した結果は？</h3>
                                <textarea cols="80" rows="5" class="rounded w-full focus:outline-none" readonly>{{$store_memo->feedback3_content}}</textarea>
                            </section>
                        @else
                            <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <h3 class="my-auto py-4 text-normal">Q.アクションリスト３を実施した結果は？</h3>
                                <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                            </section>
                        @endif

                        <div class="flex justify-end mt-2">
                            @if($store_memo->feedback1_content)
                                <button class="shareButton px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 mr-2">共有する</button>
                            @endif

                            <a href="{{route('feedback-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">編集する</a>
                        </div>
                    @else
                        <section id="feedbackMemo3" class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                            <h3 class="my-auto py-4 text-normal">Q.アクションリスト３を実施した結果は？</h3>
                            <textarea cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full focus:outline-none" readonly></textarea>
                        </section>
                        <div class="flex justify-end mt-2">
                            <a href="{{route('feedback-list.edit', [$id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" id="edit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200 block">メモする</a>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    </div>
</x-common>



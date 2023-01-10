<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-memolist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section class="md:w-1/4 md:min-h-screen md:bg-primary">
            <x-side-menu />
            <x-top-menu>
                <div class="text-normal">
                    @if(strpos(url()->full(),'book-memo')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>読書メモ</a></h2>
                    @elseif(strpos(url()->full(),'action-list')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-lg"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>アクションリスト</a></h2>
                    @elseif(strpos(url()->full(),'feedback-list')!== false)
                        <h2 class="md:px-10 md:pt-10 font-medium text-xl"><a href="{{route('book.show', [$select_book->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="flex items-center justify-center"><iconify-icon icon="ci:external-link"></iconify-icon>振り返り</a></h2>
                    @endif
                </div>
            </x-top-menu>
            <x-sp-hidden-memo-list :books-reading="$books_reading" :books-interesting="$books_interesting" :memo-groups="$memo_groups_paginate" />
        </section>

        <section class="mb:w-1/2">
            <h2 class="px-5 md:px-10 pt-8 pb-2 font-medium text-xl">{{ $select_book->title }}</h2>
            @if(strpos(url()->full(),'before')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ<span class="text-red-500">（※編集画面）</span></h2>
                    @if($is_store_memo)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="before_reading_content" class="block text-normal">読書前</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('before_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5" class="rounded w-full">{{old('before_reading_content', $store_memo->before_reading_content)}}</textarea>
                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="before_reading_content" class="block text-normal">読書前</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('before_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="before_reading_content" id="before_reading_content" cols="80" rows="5" placeholder="※目次から学びたい内容を３点記載" class="rounded w-full">{{old('before_reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'during')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ<span class="text-red-500">（※編集画面）</span></h2>
                    @if($store_memo->reading_content)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="reading_content" class="block text-normal">読書中</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="reading_content" id="reading_content" cols="80" rows="5" class="rounded w-full">{{old('reading_content', $store_memo->reading_content)}}</textarea>

                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="reading_content" class="block text-normal">読書中</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="reading_content" id="reading_content" cols="80" rows="5" placeholder="※自由なメモを記載" class="rounded w-full">{{old('reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'after')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">読書メモ<span class="text-red-500">（※編集画面）</span></h2>
                    @if($store_memo->after_reading_content)
                        <form action="{{route('book-memo.update', ['id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @method('PATCH')
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="after_reading_content" class="block text-normal">読書後</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('after_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5" class="rounded w-full">{{old('after_reading_content', $store_memo->after_reading_content)}}</textarea>
                        </form>
                    @else
                        <form action="{{route('book-memo.store', ['book_id'=>$id])}}" method="POST" name="form" class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                            @csrf
                            <div class="flex justify-between py-2 items-center">
                                <label for="after_reading_content" class="block text-normal">読書後</label>
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>

                            @error('after_reading_content')
                                <p class="text-red-600 pl-2">※{{ $message }}</p>
                            @enderror

                            <textarea name="after_reading_content" id="after_reading_content" cols="80" rows="5" placeholder="※読書前に記載した３点に関して得た情報を記載" class="rounded w-full">{{old('after_reading_content')}}</textarea>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'action-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">アクションリスト<span class="text-red-500">（※編集画面）</span></h2>
                    @if($store_memo->actionlist1_content)
                        <form action="{{route('action-list.update', ['id'=>$id])}}" method="POST" name="form">
                            @method('PATCH')
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="actionlist1_content" class="block py-4 text-normal">アクションリスト１</label>

                                @error('actionlist1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5" class="rounded w-full">{{old('actionlist1_content', $store_memo->actionlist1_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist2_content" class="block py-4 text-normal">アクションリスト２</label>

                                @error('actionlist2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{old('actionlist2_content', $store_memo->actionlist2_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist3_content" class="block py-4 text-normal">アクションリスト３</label>

                                @error('actionlist3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{old('actionlist3_content', $store_memo->actionlist3_content)}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('action-list.store', ['book_id'=>$id])}}" method="POST" name="form">
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="actionlist1_content" class="block py-4 text-normal">アクションリスト１</label>

                                @error('actionlist1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist1_content" id="actionlist1_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist1_content') }}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist2_content" class="block py-4 text-normal">アクションリスト２</label>

                                @error('actionlist2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist2_content" id="actionlist2_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist2_content') }}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="actionlist3_content" class="block py-4 text-normal">アクションリスト３</label>

                                @error('actionlist3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="actionlist3_content" id="actionlist3_content" cols="80" rows="5" placeholder="※行動に移すことを記載" class="rounded w-full">{{ old('actionlist3_content') }}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @endif
                </div>
            @elseif(strpos(url()->full(),'feedback-list')!== false)
                <div class="px-4 md:px-0 md:pl-12 pb-4">
                    <h2 id="book-memo" class="hidden md:block pt-4 font-medium text-xl">振り返り<span class="text-red-500">（※編集画面）</span></h2>
                    @if($store_memo->feedback1_content)
                        <form action="{{route('feedback-list.update', ['id'=>$id])}}" method="POST" name="form">
                            @method('PATCH')
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="feedback1_content" class="block py-4 text-normal">Q.アクションリスト１を実施した結果は？</label>

                                @error('feedback1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback1_content" id="feedback1_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback1_content', $store_memo->feedback1_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback2_content" class="block py-4 text-normal">Q.アクションリスト２を実施した結果は？</label>

                                @error('feedback2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback2_content" id="feedback2_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback2_content', $store_memo->feedback2_content)}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback3_content" class="block py-4 text-normal">Q.アクションリスト３を実施した結果は？</label>

                                @error('feedback3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback3_content" id="feedback3_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content', $store_memo->feedback3_content)}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('feedback-list.store', ['book_id'=>$id])}}" method="POST" name="form">
                            @csrf
                            <div class="px-6 pt-2 pb-4 mt-2 rounded bg-primary">
                                <label for="feedback1_content" class="block py-4 text-normal">Q.アクションリスト１を実施した結果は？</label>

                                @error('feedback1_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback1_content" id="feedback1_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback2_content" class="block py-4 text-normal">Q.アクションリスト２を実施した結果は？</label>

                                @error('feedback2_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback2_content" id="feedback2_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="px-6 pt-2 pb-4 mt-6 rounded bg-primary">
                                <label for="feedback3_content" class="block py-4 text-normal">Q.アクションリスト３を実施した結果は？</label>

                                @error('feedback3_content')
                                    <p class="text-red-600 pl-2">※{{ $message }}</p>
                                @enderror

                                <textarea name="feedback3_content" id="feedback3_content" cols="80" rows="5" placeholder="※振り返りを記載" class="rounded w-full">{{old('feedback3_content')}}</textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-6 py-2 bg-slate-50 rounded hover:bg-sky-500 hover:text-slate-50 border border-slate-200">保存する</button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif
        </section>
    </div>
</x-common>

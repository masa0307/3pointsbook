<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/delete-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-booklist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
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
                @if($selectedBook->state === App\Models\Book::STATE_READING)
                    <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">{{ App\Models\Book::STATE_READING }}</h2>
                    <div class="md:bg-primary p-4 md:p-8 md:ml-20 mt-8 rounded-xl">
                        @if(!($memo_groups->isEmpty()) && $selectedBook->memo()->first())
                            <div class="flex justify-between">
                                <button class="bg-slate-200 hover:bg-sky-500 hover:text-slate-50 border p-1 rounded-xl px-4">
                                    <a href="{{ route('group-user-memo.publish_status',[$selectedBook->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="text-xl">メモの公開・非公開</a>
                                </button>
                                <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" id="deleteBookOpen" class="text-xl bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                                    <div id="deleteBookMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                                        <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 md:w-1/4 text-center text-xl rounded-2xl">
                                            <button type="submit" class="block py-4 border-b border-gray-800 w-full rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">本を削除する</button>
                                            <button type="button" id="deleteBookClose" class="block py-4 w-full rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="flex justify-end">
                                <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" id="deleteBookOpen" class="text-xl bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                                    <div id="deleteBookMenu" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
                                        <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 md:w-1/4 text-center text-xl rounded-2xl">
                                            <button type="submit" class="block py-4 border-b border-gray-800 w-full rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">本を削除する</button>
                                            <button type="button" id="deleteBookClose" class="block py-4 w-full rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="w-2/3 md:m-auto px-4 text-xl md:w-1/2 md:text-normal">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>

                                @if($is_publish_memo)
                                    <div class="hidden md:block text-xl md:bg-slate-50 py-2 px-4 rounded-xl mt-4 text-black">
                                        <p class="pt-2">公開中のグループ</p>

                                        @foreach($selectedBook->memo as $published_memo)
                                            @if($published_memo->memogroup)
                                                <p class="pt-2 pl-2">・{{ $published_memo->memogroup->group_name }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($is_publish_memo)
                            <div class="md:hidden text-xl bg-primary py-2 px-4 rounded-xl mt-4 text-normal">
                                <p class="pt-2">公開中のグループ</p>

                                @foreach($selectedBook->memo as $published_memo)
                                    @if($published_memo->memogroup)
                                        <p class="pt-2 pl-2">・{{ $published_memo->memogroup->group_name }}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>
                @elseif($selectedBook->state === App\Models\Book::STATE_INTERESTING)
                    <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">{{ App\Models\Book::STATE_INTERESTING }}</h2>
                    <div class="md:bg-primary p-4 md:p-8 md:ml-20 mt-8 rounded-xl">
                        <div class="flex justify-between">
                            <div class="group">
                                <a href="{{ route('book.update', $selectedBook->id) }}" class="inline-block bg-slate-200 hover:bg-sky-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="cil:data-transfer-up" width="24" height="24"></iconify-icon></a>
                                <p class="group-hover:block hidden text-stone-50 pt-2 pl-2">「{{ App\Models\Book::STATE_INTERESTING }}」から「{{ App\Models\Book::STATE_READING }}」に移動する</p>
                            </div>

                            <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                            </form>
                        </div>
                        <div class="flex w-full my-8">
                            <div class="w-1/3">
                                <img src="{{$selectedBook->image_path}}" class="w-full">
                            </div>
                            <div class="w-2/3 md:m-auto px-4 text-xl md:w-1/2 md:text-normal">
                                <p id="title">{{$selectedBook->title}}</p>
                                <p class="pt-6">{{$selectedBook->author}}</p>
                                <p class="pt-6">{{$genre_name}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </section>
    </div>

    @if($is_invited_group_users)
        <x-invitation :is-invited-group-users="$is_invited_group_users" :invited-group-users="$invited_group_users" :invitee-user-name="$invitee_user_name" :invtee-group-name="$invtee_group_name" />
    @endif
</x-common>

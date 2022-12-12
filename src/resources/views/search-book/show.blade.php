<x-common>
    <x-slot name="head">
        <script src="{{ asset('js/add-book.js') }}" defer></script>
        <script src="{{ asset('js/marker-booklist.js') }}" defer></script>
        <script src="{{ asset('js/set-application.js') }}" defer></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    </x-slot>

    <div class="md:flex">
        <section id="topMenu" class="md:w-1/4 h-screen md:bg-primary">
            <x-side-menu />
            <x-top-menu />
            <x-search-memo-list />
            <x-sp-hidden-search-memo-list />
        </section>

        <section id="bookInformation" class="hidden md:block md:w-5/12">
            <h2 class="hidden md:block px-10 pt-10 font-medium text-xl">{{ App\Models\Book::STATE_READING }}</h2>
            <div class="md:bg-primary p-4 md:p-8 md:ml-20 mt-8 rounded-xl md:h-1/2">
                @if($memo_groups->isEmpty())
                    <div class="flex justify-end">
                        <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-xl bg-slate-200 p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                        </form>
                    </div>
                @else
                    <div class="flex justify-between">
                        <button class="bg-slate-200 hover:bg-sky-500 hover:text-slate-50 border p-1 rounded-xl px-4">
                            <a href="{{ route('group-user-memo.publish_status',['book_id'=> $selectedBook->id]) }}" class="text-xl">メモの公開・非公開</a>
                        </button>
                        <form action="{{route('book.destroy', $selectedBook)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-xl bg-slate-200 hover:bg-red-500 hover:text-slate-50 border p-1 rounded-xl px-4"><iconify-icon inline icon="akar-icons:trash-can" width="24" height="24"></iconify-icon></button>
                        </form>
                    </div>
                @endif

                <div class="flex w-full my-8">
                    <div class="w-1/3">
                        <img src="{{$selectedBook->image_path}}" class="w-full">
                    </div>
                    <div class="w-2/3 md:m-auto px-4 text-xl md:w-1/2 text-normal">
                        <p id="title">{{$selectedBook->title}}</p>
                        <p class="pt-6">{{$selectedBook->author}}</p>
                        <p class="pt-6">{{$genre_name}}</p>

                        @if($is_publish_memo)
                            <div class="hidden md:block text-xl md:bg-slate-50 py-2 px-4 rounded-xl mt-4 text-black">
                                <p class="pt-2">公開中のグループ</p>
                                @if($memo_groups->find($selectedBook->memo->group_id))
                                    <p class="pt-2 pl-2">・{{ $memo_groups->find($selectedBook->memo->group_id)->group_name}}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($is_publish_memo)
                    <div class="md:hidden text-xl bg-primary py-2 px-4 rounded-xl mt-4 text-normal">
                        <p class="pt-2">公開中のグループ</p>
                        @if($memo_groups->find($selectedBook->memo->group_id))
                            <p class="pt-2 pl-2">・{{ $memo_groups->find($selectedBook->memo->group_id)->group_name}}</p>
                        @endif
                    </div>
                @endif

            </div>
        </section>
    </div>
</x-common>

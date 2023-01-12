<div class="mt-8">
    <ul class="pr-4 pb-5 border-b md:border-b-0">
        <li>
            <p class="pl-6 md:text-subtitle">{{ App\Models\Book::STATE_READING }}</p>
            <ul class="pl-10 md:text-normal">
                @foreach ($books_reading as $book_reading)
                    <li class="mt-2">
                        <a href="{{route('book.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker showInformation block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_reading->title}}</a>
                        <ul class="pl-6 hidden dropdown">
                            <li><a href="{{route('book-memo.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">読書メモ</a></li>
                            <li><a href="{{route('action-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">アクションリスト</a></li>
                            <li><a href="{{route('feedback-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">振り返り</a></li>
                        </ul>
                    </li>
                @endforeach

                {{ $books_reading->links('vendor.pagination.custom') }}
            </ul>
        </li>
    </ul>

    <ul class="pt-5 pb-5 pr-4 border-b md:border-b-0">
        <li>
            <p class="pl-6 md:text-subtitle">{{ App\Models\Book::STATE_INTERESTING }}</p>
            <ul class="pl-10 md:text-normal">
                @foreach ($books_interesting as $book_interesting)
                    <li class="mt-2">
                        <a href="{{route('book.show', [$book_interesting->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker showInformation block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_interesting->title}}</a>
                    </li>
                @endforeach

                {{ $books_interesting->links('vendor.pagination.custom') }}
            </ul>
        </li>
    </ul>

    <ul class="pr-4 pt-5">
        <li>
            <p class="pl-6 md:text-subtitle">グループ</p>
            <ul class="pl-10 md:text-normal">
                @if($memo_groups)
                    @foreach ($memo_groups as $memo_group)
                        @if($memo_group->pivot->participation_status == '参加中')
                            <li class="mt-2">
                                <div class="flex justify-between">
                                    <p class="marker block"><iconify-icon inline icon="fa:group" width="16" height="16" class="mr-2"></iconify-icon>{{$memo_group->group_name}}</p>

                                    @if($memo_group->pivot->is_owner == true)
                                        <div class="flex">
                                            <a href="{{ route('group-user.add', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block text-black"><iconify-icon inline icon="material-symbols:group-add" width="20" height="20" class="px-1.5 py-1 bg-slate-200 md:bg-slate-50 rounded mr-8"></iconify-icon>
                                            <a href="{{ route('group-user.remove', [$memo_group->id, str_replace('?', '', mb_strstr(url()->full(), '?'))]) }}" class="block text-black"><iconify-icon inline icon="material-symbols:group-remove" width="20" height="20" class="px-1.5 py-1 bg-slate-200 md:bg-slate-50 rounded"></iconify-icon></a>
                                        </div>
                                    @endif
                                </div>

                                @foreach($memo_group->memo as $memo)
                                    @if($memo->group_id == $memo_group->id)
                                        <a href="{{route('group-user-memo.index', ['book_id'=>$memo->book_id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="block groupMarker showInformation pl-6"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{ $memo->book->title }}（公開ユーザー名：{{ $memo->user->name }}）</a>
                                        <ul class="pl-12 hidden groupDropdown">
                                            <li><a href="{{route('group-user-book-memo.show', ['book_id'=>$memo->book_id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">読書メモ</a></li>
                                            <li><a href="{{route('group-user-action-list.show', ['book_id'=>$memo->book_id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">アクションリスト</a></li>
                                            <li><a href="{{route('group-user-feedback-list.show', ['book_id'=>$memo->book_id, 'group_id'=>$memo->group_id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="groupMarker block">振り返り</a></li>
                                        </ul>
                                    @endif
                                @endforeach
                            </li>
                        @endif
                    @endforeach

                    {{ $memo_groups->links('vendor.pagination.custom') }}
                @endif
            </ul>
        </li>
    </ul>
</div>

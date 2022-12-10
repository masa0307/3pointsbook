<div class="md:hidden mt-8">
    <ul class="pr-4 pb-5 border-b md:border-b-0">
        <li>
            <div class="flex justify-between">
                <h3 class="pl-4 md:text-subtitle">検索結果</h3>
                <button class=" text-cyan-600"><a href="{{ route('book.index') }}">検索解除</a></button>
            </div>
            <p class="pl-6 pt-2">{{ App\Models\Book::STATE_READING }}</p>
            <ul class="pl-10">
                @foreach (session("search_books") as $book_reading)
                    <li class="mt-2">
                        <a href="{{route('search-book.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker showInformation block"><iconify-icon inline icon="clarity:book-line" width="16" height="16" class="mr-2"></iconify-icon>{{$book_reading->title}}</a>
                        <ul class="pl-6 hidden dropdown">
                            <li><a href="{{route('book-memo.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">読書メモ</a></li>
                            <li><a href="{{route('action-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">アクションリスト</a></li>
                            <li><a href="{{route('feedback-list.show', [$book_reading->id, str_replace('?', '', mb_strstr(url()->full(), '?'))])}}" class="marker block">振り返り</a></li>
                        </ul>
                    </li>
                @endforeach

                {{ session("search_books")->links('vendor.pagination.custom') }}
            </ul>
        </li>
    </ul>
</div>

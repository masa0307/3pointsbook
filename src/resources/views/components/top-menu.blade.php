<div class="flex justify-between bg-primary py-4 px-2 items-center md:hidden">
    <button id="addBookOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="fluent:add-24-regular" width="24" height="24" flip="vertical"></iconify-icon></button>
    <div id="addBookMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
        <div class="modal-content-setting bg-modal-window mx-auto mt-40 w-3/4 text-center text-xl rounded-2xl">
            <a href="{{route('book.search')}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">本を検索する</a>
            <a href="{{route('book.manual')}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">本を手動で登録する</a>
        </div>

        <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
            <button id="addBookCloseBySp" class="block py-4 w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">キャンセル</button>
        </div>
    </div>
    <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
        <a href="{{ route('search-book.index') }}"><iconify-icon inline icon="fe:search" width="24" height="24"></iconify-icon></a>
    </button>
    {{ $slot }}
    <button class="px-1.5 py-1 bg-slate-50 rounded flex align-center">
        <a href="{{ route('group.create') }}"><iconify-icon inline icon="fa:group" width="24" height="24"></iconify-icon></a>
    </button>
    <button id="settingScreenOpenBySp" class="px-1.5 py-1 bg-slate-50 rounded"><iconify-icon inline icon="ep:setting" width="24" height="24"></iconify-icon></button>
    <div id="settingMenuBySp" class="hidden fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
        <div class="modal-content-setting bg-modal-window mx-auto mt-32 w-3/4 text-center text-xl rounded-2xl">
            <a href="{{route('user-name.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 rounded-t-2xl hover:bg-sky-500 hover:text-slate-50">ユーザー名称の変更</a>
            <a href="{{route('email.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">メールアドレスの変更</a>
            <a href="{{route('login-password.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">パスワードの変更</a>
            <a href="{{route('book-sort.edit', Auth::id())}}" class="block py-4 border-b border-gray-800 hover:bg-sky-500 hover:text-slate-50">本の並び替え</a>
            <a href="{{route('genre-name.edit', Auth::id())}}" class="block py-4 rounded-b-2xl hover:bg-sky-500 hover:text-slate-50">ジャンル名の追加</a>
        </div>

        <div class="modal-content-logout bg-modal-window mx-auto my-10 w-3/4 text-center text-xl rounded-2xl">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <input type="submit" value="ログアウト" class="py-4 cursor-pointer w-full rounded-2xl hover:bg-sky-500 hover:text-slate-50">
            </form>
        </div>
    </div>
</div>

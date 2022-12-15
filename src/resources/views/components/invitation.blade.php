<div class="fixed left-0 top-0 z-10 overflow-auto h-full w-full bg-modal-rgba">
    <div class="modal-content-setting bg-modal-window mt-40 pb-4 w-11/12 md:w-1/4 mx-auto text-center text-xl md:text-2xl rounded-xl">
        <div class="bg-primary p-3 rounded-xl w-full text-center text-normal">招待通知</div>
        <p class="flex justify-start w-3/4 mx-auto pt-8 text-xl">招待ユーザー名：{{ $invitee_user_name }}</p>
        <p class="flex justify-start w-3/4 mx-auto pt-6 text-xl">招待グループ名：{{ $invtee_group_name }}</p>
        <div class="mt-8">
            <form action="{{ route('group-user.accept') }}" method="post">
                @csrf
                @method('patch')
                <button type="submit" name="participation_status" value="参加中" class="block w-full py-4 bg-slate-300 border-b-2 border-slate-200 hover:bg-sky-500 hover:text-slate-50">参加</button>
            </form>

            <form action="{{ route('group-user.reject') }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" name="participation_status" value="非参加" class="block w-full py-4 bg-slate-300 mb-4 hover:bg-sky-500 hover:text-slate-50">非参加</button>
            </form>
        </div>
    </div>
</div>

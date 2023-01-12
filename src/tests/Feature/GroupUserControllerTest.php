<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use App\Models\GroupUser;
use App\Models\Memo;
use App\Models\MemoGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupUserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp():void{
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_search(){
        $response = $this->actingAs($this->user)->post(route('group.store'), [
            'group_name' => '読書の会'
        ]);
        $response->assertRedirect(route('group-user.search'));

        $response = $this->actingAs($this->user)->get(route('group-user.search'));
        $response->assertViewHas('group_users');

    }

    public function test_searchResult(){
        User::factory()->create(['name'=>'Tanaka']);

        $this->actingAs($this->user)->post(route('group.store'), [
            'group_name' => '読書の会'
        ]);

        $response = $this->actingAs($this->user)->post(route('group-user.searchResult'), [
            'name'=>'Tanaka'
        ]);
        $response->assertSee('Tanaka');
    }

    public function test_store(){
        User::factory()->create(['name'=>'Sato']);

        $this->actingAs($this->user)->post(route('group.store'), [
            'group_name' => 'PHPの会'
        ]);
        $this->actingAs($this->user)->post(route('group-user.searchResult'), [
            'name'=>'Sato'
        ]);

        $response = $this->actingAs($this->user)->post(route('group-user.store'), [
            'user_id'=>session('search_user')->id
        ]);
        $response->assertRedirect(route('group-user.search'));
    }

    public function test_accept(){
        $memo_group         = MemoGroup::factory()->create();
        $invitee_user       = User::factory()->create();
        $invitee_group_user = GroupUser::factory()->for($invitee_user)->for($memo_group)->create(['is_owner' => 1]);

        $invited_user = User::factory()->create(['name'=>'Jun']);
        $invited_group_user = GroupUser::factory()->for($invited_user)->for($memo_group)->create([
            "participation_status"=>"招待中"
        ]);

        $response = $this->actingAs($invited_user)->patch(route('group-user.accept'), [
            "participation_status"=>"参加中"
        ]);
        $response->assertRedirect(route('book.index'));
    }

    public function test_reject(){
        $memo_group         = MemoGroup::factory()->create();
        $invitee_user       = User::factory()->create();
        $invitee_group_user = GroupUser::factory()->for($invitee_user)->for($memo_group)->create(['is_owner' => 1]);

        $invited_user = User::factory()->create(['name'=>'Goto']);
        $invited_group_user = GroupUser::factory()->for($invited_user)->for($memo_group)->create([
            "participation_status"=>"招待中"
        ]);

        $response = $this->actingAs($invited_user)->delete(route('group-user.reject'));
        $response->assertRedirect(route('book.index'));
    }

    public function test_edit(){
        $memo_group       = MemoGroup::factory()->create();
        $other_user       = User::factory()->create();
        $auth_group_user  = GroupUser::factory()->for($this->user)->for($memo_group)->create(['is_owner' => 1]);
        $other_group_user = GroupUser::factory()->for($other_user)->for($memo_group)->create();


        $response = $this->actingAs($this->user)->get(route('group-user.add', $memo_group->id));
        $response->assertOk();
        $response->assertSee($other_user->name);

        $response = $this->actingAs($this->user)->get(route('group-user.remove', $memo_group->id));
        $response->assertOk();
        $response->assertSee($other_user->name);
    }

    public function test_destroy(){
        $memo_group       = MemoGroup::factory()->create();
        $other_user       = User::factory()->create(['name'=>'竹林']);
        $auth_group_user  = GroupUser::factory()->for($this->user)->for($memo_group)->create(['is_owner' => 1]);
        $other_group_user = GroupUser::factory()->for($other_user)->for($memo_group)->create();

        $response = $this->actingAs($this->user)->delete(route('group-user.destroy', [$memo_group->id, $other_group_user->user_id]));
        $response->assertRedirect(route('group-user.remove', $memo_group->id));
    }

    public function test_index(){
        $genre        = Genre::factory()->for($this->user)->create();
        $selectedBook = Book::factory()->for($this->user)->for($genre)->create();
        $memo_group   = MemoGroup::factory()->create();
        $memo         = Memo::factory()->for($this->user)->for($selectedBook)->for($memo_group)->create();

        $response = $this->actingAs($this->user)->get(route('group-user-memo.index', [$selectedBook->id, $memo_group->id]));
        $response->assertOk();
    }

    public function test_show(){
        $genre        = Genre::factory()->for($this->user)->create();
        $selectedBook = Book::factory()->for($this->user)->for($genre)->create();
        $memo_group   = MemoGroup::factory()->create();
        $memo         = Memo::factory()->for($this->user)->for($selectedBook)->for($memo_group)->create();

        $response = $this->actingAs($this->user)->get(route('group-user-book-memo.show', [$selectedBook->id, $memo_group->id]));
        $response->assertOk();
    }

    public function test_showPublishStatus(){
        $genre            = Genre::factory()->for($this->user)->create();
        $selectedBook     = Book::factory()->for($this->user)->for($genre)->create();
        $belong_to_groups = MemoGroup::factory()->count(3)->create();
        $published_group  = MemoGroup::factory()->create();
        $memo             = Memo::factory()->for($this->user)->for($selectedBook)->for($published_group)->create();
        $group_user       = GroupUser::factory()->for($this->user)->for($published_group)->create(['is_owner' => 1]);

        $response = $this->actingAs($this->user)->get(route('group-user-memo.publish_status', $selectedBook->id));
        $response->assertOk();
    }

    public function test_publish(){
        $genre            = Genre::factory()->for($this->user)->create();
        $selectedBook     = Book::factory()->for($this->user)->for($genre)->create();
        $belong_to_groups = MemoGroup::factory()->count(3)->create();
        $published_group  = MemoGroup::factory()->create();
        $memo             = Memo::factory()->for($this->user)->for($selectedBook)->for($published_group)->create();
        $group_user       = GroupUser::factory()->for($this->user)->for($published_group)->create(['is_owner' => 1]);

        $response = $this->actingAs($this->user)->post(route('group-user-memo.publish', $selectedBook->id));
        $response->assertRedirect(route('book.show', $selectedBook));
    }
}

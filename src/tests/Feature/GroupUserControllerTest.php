<?php

namespace Tests\Feature;

use App\Models\GroupUser;
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
}

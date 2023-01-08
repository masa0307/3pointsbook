<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp():void{
        parent::setUp();

        $this->user       = User::factory()->create();
        // $this->memo_group = MemoGroup::factory()->create();
        $this->genre      = Genre::factory()->for($this->user)->create();
        // $this->book       = Book::factory()->for($this->user)->for($this->genre)->ReadingState()->create();
        // $this->memo       = Memo::factory()->for($this->user)->for($this->book)->for($this->memo_group)->create();
        // $this->group_user = GroupUser::factory()->for($this->user)->for($this->memo_group)->create();
    }

    public function test_edit(){
        $response = $this->actingAs($this->user)->get(route('user-name.edit', $this->user->id));
        $response->assertOk();

        $response = $this->actingAs($this->user)->get(route('email.edit', $this->user->id));
        $response->assertOk();

        $response = $this->actingAs($this->user)->get(route('login-password.edit', $this->user->id));
        $response->assertOk();

        $response = $this->actingAs($this->user)->get(route('book-sort.edit', $this->user->id));
        $response->assertOk();

        $response = $this->actingAs($this->user)->get(route('genre-name.edit', $this->user->id));
        $response->assertOk();
    }

    public function test_update(){
        $response = $this->actingAs($this->user)->patch(route('user-name.update', $this->user->id), [
            'name'=>'田中'
        ]);

        $response->assertOk();
        $response->assertSee('田中');
    }

    public function test_store(){
        $response = $this->actingAs($this->user)->post(route('genre-name.store', $this->user->id), [
            'genre_name'=>'小説'
        ]);
        $genres   = Genre::where('user_id', $this->user->id)->get();

        $response->assertOk();
        $response->assertViewHas('genres', $genres);
        $response->assertSee('小説');
    }
}

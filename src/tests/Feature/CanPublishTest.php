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

class CanPublishTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_canPublish(){
        $user       = User::factory()->create();
        $memo_group = MemoGroup::factory()->create();
        $genre      = Genre::factory()->for($user)->create();
        $book       = Book::factory()->for($user)->for($genre)->ReadingState()->create();
        // $memo       = Memo::factory()->for($user)->for($book)->for($memo_group)->create();
        $group_user = GroupUser::factory()->for($user)->for($memo_group)->create();

        $response = $this->actingAs($user)->get(route('book.index'));

        if($book->memo->isEmpty()){
            $response->assertDontSee('メモの公開');
        }else{
            $response->assertSee('メモの公開');
        }

        $response->assertStatus(200);
    }
}

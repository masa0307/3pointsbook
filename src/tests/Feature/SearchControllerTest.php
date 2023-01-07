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

class SearchControllerTest extends TestCase
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
        $this->memo_group = MemoGroup::factory()->create();
        $this->genre      = Genre::factory()->for($this->user)->create();
        $this->book       = Book::factory()->for($this->user)->for($this->genre)->ReadingState()->create([
            'title'=>'PHPフレームワークLaravel入門'
        ]);
        $this->memo       = Memo::factory()->for($this->user)->for($this->book)->for($this->memo_group)->create();
        $this->group_user = GroupUser::factory()->for($this->user)->for($this->memo_group)->create();
    }

    public function test_index(){
        $response = $this->actingAs($this->user)->get(route('search-book.index', [
            'search_title'=>'Laravel'
        ]));

        $response->assertOk();
        $response->assertSee('Laravel入門');
        $response->assertViewHas('is_search_result', true);
    }

    public function test_show(){
        $this->actingAs($this->user)->get(route('search-book.index', [
            'search_title'=>'Laravel'
        ]));

        $response = $this->actingAs($this->user)->get(route('search-book.show', $this->book->id));

        $response->assertOk();
        $response->assertDontSee('本の検索');
    }
}

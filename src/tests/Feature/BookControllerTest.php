<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use App\Models\GroupUser;
use App\Models\MemoGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp():void{
        parent::setUp();

        $this->user = User::factory()->create();
        $this->memo_group = MemoGroup::factory()->create();
        $this->genre = Genre::factory()->for($this->user)->create();
        $this->book = Book::factory()->for($this->user)->for($this->genre)->ReadingState()->create();
        GroupUser::factory()->for($this->user)->for($this->memo_group)->create();
    }


    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index(){
        $response = $this->actingAs($this->user)->get(route('book.index'));

        $response->assertSee($this->book->title);
        $response->assertOk();
    }

    public function test_search(){
        $response = $this->actingAs($this->user)->get(route('book.search'));

        $response->assertOk();
    }

    public function test_manual(){
        $response = $this->actingAs($this->user)->get(route('book.manual'));

        $response->assertOk();
    }

    public function test_create(){
        $response = $this->actingAs($this->user)->get(route('book.create'));

        $response->assertOk();
    }

    public function test_show(){
        $response = $this->actingAs($this->user)->get(route('book.show', $this->book->id));

        $response->assertSee($this->book->title);
        $response->assertOk();
    }

    public function test_temporaryStore(){
        $response = $this->actingAs($this->user)->post(route('book.temporaryStore', [
            'title'      => '嫌われる勇気',
            'title_kana' => 'キラワレルユウキ',
            'author'     => '古賀史健',
            'user_id'    => $this->user
        ]));

        $response->assertRedirect(route('book.create'));
    }

    public function test_store(){
        $response = $this->actingAs($this->user)->post(route('book.store', [
            'title'      => '嫌われる勇気',
            'title_kana' => 'キラワレルユウキ',
            'author'     => '古賀史健',
            'image_path' => 'ff',
            'state'      => '読書中',
            'user_id'    => $this->user
        ]));

        $response->assertRedirect(route('book.index'));
    }

    public function test_destroy(){
        $response = $this->actingAs($this->user)->delete(route('book.destroy', $this->book));

        $response->assertRedirect(route('book.index'));
    }

    public function test_update(){
        $response = $this->actingAs($this->user)->patch(route('book.update', $this->book));

        $response->assertRedirect(route('book.index'));
    }

}

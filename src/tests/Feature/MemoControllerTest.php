<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Memo;
use App\Models\MemoGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemoControllerTest extends TestCase
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
        $this->book       = Book::factory()->for($this->user)->for($this->genre)->ReadingState()->create();
        $this->memo       = Memo::factory()->for($this->user)->for($this->book)->for($this->memo_group)->create();
        // $this->group_user = GroupUser::factory()->for($this->user)->for($this->memo_group)->create();
    }

    public function test_bookMemoShow(){
        $response = $this->actingAs($this->user)->get(route('book-memo.show', $this->book->id));

        $response->assertSee('編集する');
        $response->assertOk();
    }

    public function test_actionListEdit(){
        $response = $this->actingAs($this->user)->get(route('action-list.edit', $this->book->id));

        $response->assertOk();
    }

    public function test_feedbackListStore(){
        $response = $this->actingAs($this->user)->post(route('feedback-list.store',['book_id' => $this->memo->book_id]),[
            'feedback1_content' => 'サンプルメモ'
        ]);

        $response->assertRedirect(route('feedback-list.show', $this->memo->book_id));
    }

    public function test_feedbackListUpdate(){
        $response = $this->actingAs($this->user)->get(route('feedback-list.edit', $this->memo->book_id));
        $response->assertOk();

        $response = $this->actingAs($this->user)->patch(route('feedback-list.update', $this->memo->book_id), [
            'feedback1_content' => 'サンプル2メモ'
        ]);

        $response->assertRedirect(route('feedback-list.show', $this->memo->book_id));
    }




}

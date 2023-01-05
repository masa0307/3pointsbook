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

class MemoGroupControllerTest extends TestCase
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

     public function test_create(){
        $response = $this->actingAs($this->user)->get(route('group.create'));

        $response->assertViewIs('group.create');
     }

     public function test_store(){
        $response = $this->actingAs($this->user)->post(route('group.store'), [
            'group_name' => '読書の会'
        ]);
        $response->assertRedirect(route('group-user.search'));

        $response = $this->actingAs($this->user)->get(route('group-user.search'));
        $response->assertSeeText('読書の会');
     }
}

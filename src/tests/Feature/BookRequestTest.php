<?php

namespace Tests\Feature;

use App\Http\Requests\BookRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BookRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider dataProvider
     * @return void
    */

    public function test_BookRequest($data, $expect){
        $request   = new BookRequest();
        $rules     = $request->rules();
        $validator = Validator::make($data, $rules);
        $result    = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataProvider(){
        return [
            '正常' => [
                [
                    'title' => '嫌われる勇気',
                    'title_kana'=>'キラワレルユウキ',
                    'author'=>'古賀',
                ],
                true
            ],
            'タイトルなし' => [
                [
                    'title' => '',
                    'title_kana'=>'キラワレルユウキ',
                    'author'=>'古賀',
                ],
                false
            ],
            'タイトル50文字以上' => [
                [
                    'title' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
                    'title_kana'=>'キラワレルユウキ',
                    'author'=>'古賀',
                ],
                false
            ],
        ];
    }
}

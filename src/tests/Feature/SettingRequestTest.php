<?php

namespace Tests\Feature;

use App\Http\Requests\SettingRequest;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Tests\TestCase;

class SettingRequestTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @dataProvider dataProvider
     * @return void
     */

    public function test_SettingRequest($data, $expect){
        $user = User::factory()->create(['name' => '後藤']);
        Genre::factory()->for($user)->create(['genre_name' => '古典']);
        $request   = new SettingRequest();
        $rules     = $request->rules();
        $validator = FacadesValidator::make($data, $rules);
        $result    = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataProvider(){
        return [
            '正常' => [
                [
                    'name'           =>'田中',
                    'email'          =>'tanaka@gmail.com',
                    'genre_name'     =>'ビジネス',
                    'update_password'=>'tanaka111'
                ],
                true
            ],
            'emailの記載ミス' => [
                [
                    'email'=>'fewaaaef',
                ],
                false
            ],
            'nameの重複' => [
                [
                    'name'=>'後藤',
                ],
                false
            ],
            'genre_nameの重複' => [
                [
                    'genre_name'=>'古典',
                ],
                false
            ],
        ];
    }
}

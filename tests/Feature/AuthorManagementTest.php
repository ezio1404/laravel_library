<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_can_be_created(){
        $this->post('/authors',$this->data());
        $author = Author::all();
        $this->assertCount(1,$author);
        $this->assertInstanceOf(Carbon::class,$author->first()->dob);
        $this->assertEquals('1945/12/05', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function author_dob_carbon_parsed(){
        $this->post('/authors',$this->data());
        $author = Author::all();
        $this->assertInstanceOf(Carbon::class,$author->first()->dob);
        $this->assertEquals('1945/12/05', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/authors',array_merge($this->data(),["name"=>""]));
        $response->assertSessionHasErrors('name');
    }

    public function a_dob_is_required()
    {
        $response = $this->post('/authors',array_merge($this->data(),["dob"=>""]));
        $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name'=> 'Ryan Gosling',
            'dob'=> '05/12/1945'
        ];
    }

}

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
        $this->withExceptionHandling();
        $this->post('/author',[
            'name'=> 'Ryan Gosling',
            'dob'=> '05/12/1945'
        ]);
        $author = Author::all();
        $this->assertCount(1,$author);
        $this->assertInstanceOf(Carbon::class,$author->first()->dob);
        $this->assertEquals('1945/12/05', $author->first()->dob->format('Y/d/m'));
    }
}

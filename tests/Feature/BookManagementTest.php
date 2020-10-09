<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redirectToIndex(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    /** @test */
    public function a_book_can_be_added_to_library(){
        $this->withoutExceptionHandling();

        $response=$this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>'Ryan Gosling'
        ]);

        $response->assertOk();
        $this->assertCount(1,Book::all());
    }


    /** @test */
    public function a_title_is_required(){


        $response=$this->post('/books',[
            'title'=>'',
            'author'=>'Ryan Gosling'
        ]);

       $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required(){
        $response=$this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>'Ryan Gosling'
        ]);

        $book = Book::first();
        $response = $this->patch("/books/$book->id",[
            'title'=>'Java Second Edition',
            'author'=> 'Ryan Gosling'
        ]);

        $this->assertEquals('Java Second Edition',Book::first()->title);
        $this->assertEquals('Ryan Gosling',Book::first()->author);
    }
}

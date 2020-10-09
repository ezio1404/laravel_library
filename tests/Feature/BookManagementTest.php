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


        $response=$this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>'Ryan Gosling'
        ]);
            $book = Book::first();

        $this->assertCount(1,Book::all());
        $response->assertRedirect($book->path());

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

        $this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>'Ryan Gosling'
        ]);

        $book = Book::first();
        $response = $this->patch($book->path(),[
            'title'=>'Java Second Edition',
            'author'=> 'Ryan Gosling'
        ]);

        $this->assertEquals('Java Second Edition',Book::first()->title);
        $this->assertEquals('Ryan Gosling',Book::first()->author);
        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {

        $this->post('/books',[
            'title'=>'Java First Edition',
            'author'=>'Ryan Gosling'
        ]);
        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }
}

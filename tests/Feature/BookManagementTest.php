<?php

namespace Tests\Feature;

use App\Author;
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


        $response=$this->post('/books',$this->data());
            $book = Book::first();

        $this->assertCount(1,Book::all());
        $response->assertRedirect($book->path());

    }


    /** @test */
    public function a_title_is_required(){


        $response=$this->post('/books',array_merge($this->data(),['title'=>'']));

       $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required(){
        $response=$this->post('/books',array_merge($this->data(),['author_id'=>'']));
        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated(){

        $this->post('/books',$this->data());

        $book = Book::first();
        $response = $this->patch($book->path(),
                    array_merge($this->data(),
                    ['title' => 'Java Second Edition','author_id'=>'New Ryan Gosling']));
        $this->assertEquals('Java Second Edition',Book::first()->title);
        $this->assertEquals(2,Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {

        $this->post('/books',$this->data());
        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added(){
        $this->withExceptionHandling();

        $this->post('/books',$this->data());


        $author = Author::first();
        $book = Book::first();


        // $this->assertCount(1,Book::all());
        $this->assertEquals($author->id,$book->author_id);
        $this->assertCount(1,Author::all());
    }
    private function data() :array
    {
        return [
            'title'=>'Java First Edition',
            'author_id'=>'Ryan Gosling'
        ];
    }
}

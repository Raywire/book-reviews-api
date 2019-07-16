<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Book;

class BookTest extends TestCase
{
    public function testBooksAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'user_id' => 1,
            'title' => 'Lorem',
            'description' => 'Ipsum',
        ];

        $this->json('POST', '/api/books', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([ 'data' => ['id' => 1, 'title' => 'Lorem', 'description' => 'Ipsum']]);
    }

    public function testBooksUnauthorizedUpdate()
    {
        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $book = factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'First Book',
            'description' => 'First description',
        ]);

        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/books/' . $book->id, $payload, $headers)
            ->assertStatus(403)
            ->assertJson([
                'error' => 'You can only edit your own books.'
            ]);
    }

    public function testBooksUnauthorizedDelete()
    {
        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $book = factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'First Book',
            'description' => 'First description',
        ]);

        $this->json('DELETE', '/api/books/' . $book->id, [], $headers)
            ->assertStatus(403)
            ->assertJson([
                'error' => 'You can only delete your own books.'
            ]);
    }

    public function testBooksAreUpdated()
    {
        $this->markTestSkipped('must be revisited.');
        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $book = factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'First Book',
            'description' => 'First description',
        ]);

        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/books/' . $book->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => 'Lorem',
                    'description' => 'Ipsum'
                ]
            ]);
    }

    public function testBooksAreDeleted()
    {
        $this->markTestSkipped('must be revisited.');
        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];
        $book = factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'First Book',
            'description' => 'First description',
        ]);

        $this->json('DELETE', '/api/books/' . $book->id, [], $headers)
            ->assertStatus(204);
    }

    public function testBooksAreListedCorrectly()
    {
        factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'First Book',
            'description' => 'First description'
        ]);

        factory(Book::class)->create([
            'user_id' => 1,
            'title' => 'Second Book',
            'description' => 'Second description'
        ]);

        $user = factory(User::class)->create();
        $token = auth()->login($user);
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/books', [], $headers)
            ->assertStatus(200);
    }
}

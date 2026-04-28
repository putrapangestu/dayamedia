<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookHistoryAuthorReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_chapter_author_can_read_and_book_history_created(): void
    {
        $user = User::create([
            'full_name' => 'Author One',
            'email' => 'author@example.com',
            'password' => 'password',
        ]);

        $category = Category::create([
            'name' => 'Testing',
            'status' => 'active',
        ]);

        $book = Book::create([
            'title' => 'Sample Book',
            'slug' => 'sample-book',
            'status' => Book::STATUS_PUBLISHED,
            'category_id' => $category->id,
        ]);

        Module::create([
            'title' => 'Bab 1',
            'slug' => 'bab-1',
            'chapter' => 1,
            'days' => 7,
            'is_active' => true,
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('book.read', $book->slug));

        $response->assertStatus(200);

        $this->assertDatabaseHas('book_histories', [
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);
    }
}

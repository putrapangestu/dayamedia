<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationBooksFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_individual_publishing_books_are_hidden_from_collaboration_books(): void
    {
        $category = Category::create([
            'name' => 'Collaboration Filter',
            'status' => 'active',
        ]);

        Book::create([
            'title' => 'Visible Collaboration Book',
            'slug' => 'visible-collaboration-book',
            'status' => Book::STATUS_OPEN,
            'category_id' => $category->id,
            'is_individual' => false,
        ]);

        Book::create([
            'title' => 'Hidden Individual Publishing Book',
            'slug' => 'hidden-individual-publishing-book',
            'status' => Book::STATUS_EDITING,
            'category_id' => $category->id,
            'is_individual' => true,
        ]);

        $response = $this->get(route('collaboration'));

        $response->assertOk();
        $response->assertSee('Visible Collaboration Book');
        $response->assertDontSee('Hidden Individual Publishing Book');
    }

    public function test_individual_publishing_book_cannot_be_opened_as_collaboration_detail(): void
    {
        $category = Category::create([
            'name' => 'Collaboration Detail Filter',
            'status' => 'active',
        ]);

        Book::create([
            'title' => 'Individual Detail Blocked',
            'slug' => 'individual-detail-blocked',
            'status' => Book::STATUS_EDITING,
            'category_id' => $category->id,
            'is_individual' => true,
        ]);

        $this->get(route('collaborationDetail', 'individual-detail-blocked'))
            ->assertNotFound();
    }
}

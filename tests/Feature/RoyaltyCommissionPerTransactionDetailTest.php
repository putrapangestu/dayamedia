<?php

namespace Tests\Feature;

use App\Helpers\Transaction\TransactionHelper;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\CommissionHistory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoyaltyCommissionPerTransactionDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_royalty_is_created_for_each_book_transaction_detail_in_mixed_order(): void
    {
        $buyer = User::factory()->create();
        $authors = User::factory()->count(2)->create();
        $category = Category::create([
            'name' => 'Royalty',
            'status' => 'active',
        ]);
        $book = Book::create([
            'title' => 'Mixed Royalty Book',
            'slug' => 'mixed-royalty-book',
            'status' => Book::STATUS_PUBLISHED,
            'category_id' => $category->id,
        ]);

        foreach ($authors as $author) {
            BookAuthor::create([
                'book_id' => $book->id,
                'user_id' => $author->id,
            ]);
        }

        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'total_price' => 425000,
            'status' => 'paid',
            'payment_method' => 'transfer',
            'transaction_code' => 'TRX-MIXED-ROYALTY',
        ]);

        $ebookDetail = TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'type' => 'digital',
            'price_book' => 65000,
        ]);
        $physicalDetail = TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'book_id' => $book->id,
            'quantity' => 3,
            'type' => 'physical',
            'price_book' => 120000,
        ]);

        $book->load('authors', 'modules');

        TransactionHelper::calculateCommissionRoyalti(13000, $book, $transaction, $ebookDetail);
        TransactionHelper::calculateCommissionRoyalti(72000, $book, $transaction, $physicalDetail);
        TransactionHelper::calculateCommissionRoyalti(72000, $book, $transaction, $physicalDetail);

        $this->assertSame(4, CommissionHistory::where('transaction_id', $transaction->id)->where('type', 'royalti')->count());
        $this->assertSame(2, CommissionHistory::where('transaction_detail_id', $ebookDetail->id)->where('type', 'royalti')->count());
        $this->assertSame(2, CommissionHistory::where('transaction_detail_id', $physicalDetail->id)->where('type', 'royalti')->count());

        foreach ($authors as $author) {
            $this->assertSame(42500.0, (float) $author->fresh()->balance);
        }
    }
}

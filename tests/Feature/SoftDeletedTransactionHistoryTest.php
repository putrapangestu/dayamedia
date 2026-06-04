<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Module;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SoftDeletedTransactionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_book_order_history_still_shows_soft_deleted_member_and_book(): void
    {
        $admin = $this->createAdmin();
        $member = User::factory()->create([
            'full_name' => 'Deleted Buyer',
            'email' => 'deleted-buyer@example.com',
        ]);
        $book = $this->createBook('Archived Transaction Book', 'archived-transaction-book');
        $transaction = $this->createTransaction($member, 'TRX-DELETED-BOOK', 150000);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'type' => 'digital',
            'price_book' => 150000,
        ]);

        $member->delete();
        $book->delete();

        $response = $this->actingAs($admin)->get(route('admin.book-order.show', $transaction->id));

        $response->assertOk();
        $response->assertSee('Deleted Buyer');
        $response->assertSee('Archived Transaction Book');
        $response->assertSee('TRX-DELETED-BOOK');
    }

    public function test_admin_bab_order_history_still_shows_soft_deleted_member_book_and_module(): void
    {
        $admin = $this->createAdmin();
        $member = User::factory()->create([
            'full_name' => 'Deleted Chapter Buyer',
            'email' => 'deleted-chapter-buyer@example.com',
        ]);
        $book = $this->createBook('Deleted Collaboration Book', 'deleted-collaboration-book');
        $module = Module::create([
            'title' => 'Deleted Chapter Title',
            'slug' => 'deleted-chapter-title',
            'chapter' => 3,
            'days' => 7,
            'price' => 75000,
            'is_active' => true,
            'book_id' => $book->id,
        ]);
        $transaction = $this->createTransaction($member, 'TRX-DELETED-BAB', 75000);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'book_id' => $book->id,
            'module_id' => $module->id,
            'quantity' => 1,
            'type' => 'module',
            'price_book' => 75000,
        ]);

        $member->delete();
        $module->delete();
        $book->delete();

        $response = $this->actingAs($admin)->get(route('admin.bab-order.show', $transaction->id));

        $response->assertOk();
        $response->assertSee('Deleted Chapter Buyer');
        $response->assertSee('Deleted Collaboration Book');
        $response->assertSee('Deleted Chapter Title');
        $response->assertSee('TRX-DELETED-BAB');
    }

    private function createAdmin(): User
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $admin = User::factory()->create([
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        return $admin;
    }

    private function createBook(string $title, string $slug): Book
    {
        $category = Category::create([
            'name' => 'History',
            'status' => 'active',
        ]);

        return Book::create([
            'title' => $title,
            'slug' => $slug,
            'status' => Book::STATUS_PUBLISHED,
            'category_id' => $category->id,
            'price_digital' => 150000,
            'price_physical' => 0,
        ]);
    }

    private function createTransaction(User $member, string $code, int $totalPrice): Transaction
    {
        return Transaction::create([
            'user_id' => $member->id,
            'total_price' => $totalPrice,
            'status' => 'paid',
            'payment_method' => 'transfer',
            'transaction_code' => $code,
        ]);
    }
}

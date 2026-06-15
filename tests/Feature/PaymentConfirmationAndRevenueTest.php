<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PaymentConfirmationAndRevenueTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_individual_book_confirmation_clears_payment_expiry(): void
    {
        $admin = $this->createAdmin();
        $member = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => $member->id,
            'total_price' => 102000,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'transaction_code' => 'IND-EXPIRY',
            'admin_fee' => 2000,
            'expired_at' => now()->addHours(2),
            'individual_book_status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.individual-books.confirm', $transaction))
            ->assertRedirect(route('admin.individual-books.index'));

        $transaction->refresh();

        $this->assertSame('paid', $transaction->status);
        $this->assertNull($transaction->expired_at);
    }

    public function test_paid_checkout_page_does_not_render_countdown_even_if_old_expiry_exists(): void
    {
        $member = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => $member->id,
            'total_price' => 102000,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
            'transaction_code' => 'PAID-OLD-EXPIRY',
            'admin_fee' => 2000,
            'expired_at' => now()->addHours(2),
        ]);

        $this->actingAs($member)
            ->get(route('checkout.success', $transaction->transaction_code))
            ->assertOk()
            ->assertDontSee('Waktu Tersisa')
            ->assertDontSee('countdown-timer');
    }

    public function test_admin_dashboard_revenue_uses_filtered_net_sales_without_admin_fee(): void
    {
        $admin = $this->createAdmin();

        $individual = $this->createPaidTransaction('IND-REVENUE', 102000, 2000, now()->setDate(2026, 6, 5), [
            'individual_book_confirmed_at' => now()->setDate(2026, 6, 5),
        ]);
        TransactionDetail::create([
            'transaction_id' => $individual->id,
            'quantity' => 1,
            'type' => 'physical',
            'price_book' => 102000,
            'price_discount' => 0,
        ]);

        $ebook = $this->createPaidTransaction('EBOOK-REVENUE', 52000, 2000, now()->setDate(2026, 6, 6));
        TransactionDetail::create([
            'transaction_id' => $ebook->id,
            'quantity' => 1,
            'type' => 'digital',
            'price_book' => 50000,
            'price_discount' => 0,
        ]);

        $outsideFilter = $this->createPaidTransaction('OLD-REVENUE', 202000, 2000, now()->setDate(2026, 5, 6));
        TransactionDetail::create([
            'transaction_id' => $outsideFilter->id,
            'quantity' => 1,
            'type' => 'digital',
            'price_book' => 200000,
            'price_discount' => 0,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.home', [
                'filter_type' => 'monthly',
                'year' => 2026,
                'month' => 6,
            ]))
            ->assertOk()
            ->assertSee('Rp. 150.000')
            ->assertSee('Rp. 100.000')
            ->assertSee('Rp. 50.000')
            ->assertDontSee('Rp. 154.000')
            ->assertDontSee('Rp. 350.000');
    }

    private function createAdmin(): User
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $admin = User::factory()->create([
            'full_name' => 'Admin User',
            'email' => 'admin-payment-revenue@example.com',
        ]);
        $admin->assignRole('admin');

        return $admin;
    }

    private function createPaidTransaction(string $code, int $totalPrice, int $adminFee, \DateTimeInterface $createdAt, array $attributes = []): Transaction
    {
        return Transaction::create(array_merge([
            'user_id' => User::factory()->create()->id,
            'total_price' => $totalPrice,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
            'transaction_code' => $code,
            'admin_fee' => $adminFee,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ], $attributes));
    }
}

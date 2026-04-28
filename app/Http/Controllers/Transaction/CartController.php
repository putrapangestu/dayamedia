<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\AddToCartRequest;
use App\Http\Requests\Transaction\CheckoutProcessRequest;
use App\Http\Requests\Transaction\UpdateCartRequest;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(AddToCartRequest $request)
    {
        $type = $request->type ?? 'digital';
        $quantity = $request->quantity ?? 1;

        $cart = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'type' => $type,
        ]);

        $cart->quantity = ($cart->quantity ?? 0) + $quantity;
        $cart->save();

        return response()->json(['message' => 'Buku berhasil ditambahkan ke keranjang!']);
    }

    public function update(UpdateCartRequest $request, string $id)
    {
        $cart = Cart::with('book')->find($id);

        if (! $cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($request->has('quantity')) {
            $cart->quantity = $request->quantity;
        }

        if ($request->has('type')) {
            $cart->type = $request->type;
        }

        $cart->save();

        $price = $cart->type === 'digital' ? $cart->book->price_digital : $cart->book->price_physical;
        $subtotal = $price * $cart->quantity;

        return response()->json([
            'message' => 'Keranjang berhasil diperbarui.',
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp.'.number_format($subtotal, 0, ',', '.'),
        ]);
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Item berhasil dihapus dari keranjang.']);
    }

    public function processCheckout(CheckoutProcessRequest $request)
    {
        $items = collect($request->items)->map(function ($item) {
            if (isset($item['book_id'])) {
                $book = Book::find($item['book_id']);
            }
            $module = isset($item['module_id']) ? Module::find($item['module_id']) : null;

            return [
                'book_id' => $item['book_id'] ?? null,
                'module_id' => $item['module_id'] ?? null,
                'title' => $book?->title ?? $module?->title,
                'quantity' => $item['quantity'],
                'type' => $item['type'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'cover' => $book->cover ?? null,
                'category_name' => $book?->category?->name ?? null,
            ];
        });

        $total = $items->sum('subtotal');

        session([
            'checkout_items' => $items->toArray(),
            'checkout_total' => $total,
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('checkout'),
        ]);
    }

    public function count()
    {
        $count = 0;
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->whereHas('book')->count();
        }

        return response()->json(['count' => $count]);
    }
}

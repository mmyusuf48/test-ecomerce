<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $carts = Cart::where('id_user', $user_id)->with('product')->orderBy('created_at', 'desc')->get();

        $grandTotal = 0;
        $discountCode = "";
        $diskon = "";
        $discountApplied = false;

        foreach ($carts as $cart) {
            if ($cart->product) {
                $cart->subtotal = $cart->qty * $cart->product->price;
            }

            $grandTotal += $cart->subtotal;
        }

        if ($request != null) {
            $discountCode = $request->input('kode', '');
            $voucher = Voucher::where('kode', $discountCode)->first();

            if ($voucher) {
                if ($discountCode == 'FA111') {
                    $grandTotal *= 0.9;
                    $diskon = '10%';
                } elseif ($discountCode == 'FA222') {
                    foreach ($carts as $cart) {
                        if ($cart->product && $cart->product->kode == 'FA4532') {
                            $grandTotal -= 50000;
                            $diskon = 'Rp, 50.000';
                            $discountApplied = true;
                            break;
                        }
                    }
                } elseif ($discountCode == 'FA333') {
                    foreach ($carts as $cart) {
                        if ($cart->subtotal > 400000) {
                            $grandTotal -= $cart->subtotal * 0.06;
                            $diskon = '6%';
                            $discountApplied = true;
                        }
                    }
                } elseif ($discountCode == 'FA444') {
                    $now = Carbon::now();
                    if ($now->isTuesday() && $now->between($now->copy()->setTime(13, 0), $now->copy()->setTime(15, 0))) {
                        $grandTotal *= 0.95;
                        $diskon = '5%';
                        $discountApplied = true;
                    }
                }
            } else {
                return view('cart.index', compact('carts', 'grandTotal', 'discountCode'))
                    ->with('status', 'Error')
                    ->with('message', 'Code not found!');
            }
        }

        if (!$discountApplied && !empty($discountCode)) {
            return view('cart.index', compact('carts', 'grandTotal', 'discountCode', 'diskon'))
                ->with('status', 'Error')
                ->with('message', 'Discount not applicable for your cart items!');
        }


        return view('cart.index', compact('carts', 'grandTotal', 'discountCode', 'diskon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {

        $user_id = Auth::user()->id;

        $cartItem = Cart::where('id_user', $user_id)
        ->where('id_product', $id)
        ->first();

        if ($cartItem) {
            $cartItem->qty += $request->qty;
            $cartItem->save();
        } else {
             Cart::create([
                'id_user' => $user_id,
                'id_product' => $id,
                'qty' => $request->qty,
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'success')->with('message', 'Product added to cart successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function incrementDecrement(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        if($request->type == 'minus'){
            if($cart->qty > 1){
                $cart->qty = $cart->qty - 1;
            }else{
                $this->destroy($cart->id);
                return redirect()->route('cart');
            }
        }else{
            $cart->qty = $cart->qty + 1;
        }

        $cart->save();
        return redirect()->route('cart');
    }

    public function destroy( $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart')->with('status', 'success')->with('message', 'The product has been successfully removed from the cart!');
    }
}

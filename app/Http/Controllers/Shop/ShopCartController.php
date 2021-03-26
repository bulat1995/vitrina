<?php
/*
Контроллер работы с корзиной
 */

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ShopCartRepository;
use App\Http\Requests\ShopCartCreateRequest;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);

    }
    /**
     * Отображение корзины
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repository = new ShopCartRepository();
        $cartItems  = $repository->getCartProducts(auth()->user()->id);
        //dd($cartItems);
        return view('shop.cart.index', compact('cartItems'));
    }

    /**
     * Добавление товара в корзину
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopCartCreateRequest $request)
    {
        $cart          = new ShopCart($request->input());
        $cart->user_id = auth()->user()->id;
        if ($cart->save()) {
            return redirect()->route('shop.cart.index')->with(['success' => 'Товар успешно добавлен в корзину']);
        }
        return redirect()->back()->withErrors();
    }

    /**
     * Удаление товара из корзины
     *
     * @param  $id идентификатор товара
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopCart = ShopCart::findOrFail($id);
        if ($shopCart->user_id != auth()->user()->id) {
            abort(403);
        }
        if ($shopCart->delete()) {
            return redirect()->route('shop.cart.index')->with([
                'success' => 'Товар успешно удален',
            ]);
        } else {
            return back();
        }
    }
}

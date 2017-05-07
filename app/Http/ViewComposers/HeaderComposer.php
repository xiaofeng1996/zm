<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Entities\Search;
use Entities\Cart;

class HeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $keywords = $this->getHotSearches();
        $cart_count = $this->getCartCount();
        $view->with('keywords', $keywords)
            ->with('cart_count', $cart_count);
    }

    private function getHotSearches()
    {
        $keywords = Search::orderBy('sort')->limit(5)->get();
        return $keywords;
    }

    private function getCartCount() {
        $user_id = session('user_id');
        $cart_count = Cart::where('user_id', $user_id)->count();
        return $cart_count;
    }
}
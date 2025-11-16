<?php

namespace App\Controllers;

use App\Models\QuoteItem;
use App\Models\Quote;
use App\Models\Product;

class QuoteItemController extends Controller
{
    protected $quoteItem;
    protected $quote;
    protected $product;

    public function __construct()
    {
        parent::__construct();
        $this->quoteItem = new QuoteItem();
        $this->quote = new Quote();
        $this->product = new Product();
    }

    public function index($quoteId)
    {
        $quote = $this->quote->find($quoteId);
        $items = $this->quoteItem->where('quote_id', $quoteId);
        
        // 获取产品信息
        $products = [];
        foreach ($items as $item) {
            if (!isset($products[$item['product_id']])) {
                $product = $this->product->find($item['product_id']);
                $products[$item['product_id']] = $product;
            }
        }
        
        return $this->render('quotes/items/index', [
            'quote' => $quote,
            'items' => $items,
            'products' => $products
        ]);
    }

    public function create($quoteId)
    {
        $quote = $this->quote->find($quoteId);
        $products = $this->product->all();
        
        return $this->render('quotes/items/create', [
            'quote' => $quote,
            'products' => $products
        ]);
    }

    public function store($quoteId)
    {
        $data = [
            'quote_id' => $quoteId,
            'product_id' => $this->post('product_id'),
            'quantity' => $this->post('quantity'),
            'unit_price' => $this->post('unit_price'),
            'discount_rate' => $this->post('discount_rate', 0)
        ];

        $this->quoteItem->create($data);
        $this->redirect("/quotes/{$quoteId}/items");
    }

    public function edit($quoteId, $itemId)
    {
        $quote = $this->quote->find($quoteId);
        $item = $this->quoteItem->find($itemId);
        $products = $this->product->all();
        
        return $this->render('quotes/items/edit', [
            'quote' => $quote,
            'item' => $item,
            'products' => $products
        ]);
    }

    public function update($quoteId, $itemId)
    {
        $data = [
            'product_id' => $this->post('product_id'),
            'quantity' => $this->post('quantity'),
            'unit_price' => $this->post('unit_price'),
            'discount_rate' => $this->post('discount_rate', 0)
        ];

        $this->quoteItem->update($itemId, $data);
        $this->redirect("/quotes/{$quoteId}/items");
    }

    public function destroy($quoteId, $itemId)
    {
        $this->quoteItem->delete($itemId);
        $this->redirect("/quotes/{$quoteId}/items");
    }
}
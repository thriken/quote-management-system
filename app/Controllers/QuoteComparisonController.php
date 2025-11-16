<?php

namespace App\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Customer;
use App\Models\Product;

class QuoteComparisonController extends Controller
{
    protected $quote;
    protected $quoteItem;
    protected $customer;
    protected $product;

    public function __construct()
    {
        parent::__construct();
        $this->quote = new Quote();
        $this->quoteItem = new QuoteItem();
        $this->customer = new Customer();
        $this->product = new Product();
    }

    public function index()
    {
        // 获取所有报价单用于选择对比
        $quotes = $this->quote->query()
            ->orderBy('created_at', 'DESC')
            ->get();
            
        // 获取客户信息
        $customers = [];
        foreach ($quotes as $quote) {
            if (!isset($customers[$quote['customer_id']])) {
                $customer = $this->customer->find($quote['customer_id']);
                $customers[$quote['customer_id']] = $customer;
            }
        }
        
        return $this->render('quotes/comparison/index', [
            'quotes' => $quotes,
            'customers' => $customers
        ]);
    }

    public function compare()
    {
        $quoteIds = $this->post('quote_ids', []);
        
        if (count($quoteIds) < 2) {
            return $this->render('quotes/comparison/index', [
                'quotes' => $this->quote->all(),
                'customers' => $this->getCustomersForQuotes($this->quote->all()),
                'error' => '请至少选择两个报价单进行对比'
            ]);
        }
        
        // 获取报价单详情
        $quotes = [];
        $items = [];
        $products = [];
        
        foreach ($quoteIds as $quoteId) {
            $quote = $this->quote->find($quoteId);
            if ($quote) {
                $quotes[$quoteId] = $quote;
                
                // 获取报价单项目
                $quoteItems = $this->quoteItem->where('quote_id', $quoteId);
                $items[$quoteId] = $quoteItems;
                
                // 获取产品信息
                foreach ($quoteItems as $item) {
                    if (!isset($products[$item['product_id']])) {
                        $product = $this->product->find($item['product_id']);
                        $products[$item['product_id']] = $product;
                    }
                }
            }
        }
        
        // 获取客户信息
        $customers = [];
        foreach ($quotes as $quote) {
            if (!isset($customers[$quote['customer_id']])) {
                $customer = $this->customer->find($quote['customer_id']);
                $customers[$quote['customer_id']] = $customer;
            }
        }
        
        return $this->render('quotes/comparison/result', [
            'quotes' => $quotes,
            'items' => $items,
            'products' => $products,
            'customers' => $customers
        ]);
    }
    
    protected function getCustomersForQuotes($quotes)
    {
        $customers = [];
        foreach ($quotes as $quote) {
            if (!isset($customers[$quote['customer_id']])) {
                $customer = $this->customer->find($quote['customer_id']);
                $customers[$quote['customer_id']] = $customer;
            }
        }
        return $customers;
    }
}
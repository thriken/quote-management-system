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
        // 通过GET参数获取对比列表中的报价单ID
        $compareIds = $this->get('compare_ids', '');
        
        if (!empty($compareIds)) {
            // 解析ID列表并获取对应的报价单
            $ids = explode(',', $compareIds);
            $quotes = [];
            
            foreach ($ids as $id) {
                $quote = $this->quote->find($id);
                if ($quote) {
                    $quotes[] = $quote;
                }
            }
        } else {
            // 如果没有指定ID，则显示所有报价单（向后兼容）
            $quotes = $this->quote->query()
                ->orderBy('created_at', 'DESC')
                ->get();
        }
            
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
    
    /**
     * 根据URI参数进行报价单对比
     * URI格式: /quotes/comparison/id1_id2_id3_...
     */
    public function compareByUri($uriParam)
    {
        // 解析URI参数获取报价单ID
        $quoteIds = explode('_', $uriParam);
        
        // 过滤无效ID并限制最多8个
        $quoteIds = array_slice(array_filter($quoteIds, function($id) {
            return is_numeric($id) && $id > 0;
        }), 0, 8);
        
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
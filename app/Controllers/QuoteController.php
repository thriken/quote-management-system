<?php

namespace App\Controllers;

use App\Models\Quote;
use App\Models\Customer;

class QuoteController extends Controller
{
    protected $quote;
    protected $customer;

    public function __construct()
    {
        parent::__construct();
        $this->quote = new Quote();
        $this->customer = new Customer();
    }

    public function index()
    {
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
        
        return $this->render('quotes/index', [
            'quotes' => $quotes,
            'customers' => $customers
        ]);
    }

    public function create()
    {
        $customers = $this->customer->all();
        return $this->render('quotes/create', [
            'customers' => $customers,
            'categories' => ['我司', '他司', '预期', '客定']
        ]);
    }

    public function store()
    {
        $data = [
            'customer_id' => $this->post('customer_id'),
            'category' => $this->post('category'),
            'version' => $this->post('version'),
            'is_active' => $this->post('is_active', 0),
            'discount_rate' => $this->post('discount_rate', 0),
            'rebate_rate' => $this->post('rebate_rate', 0),
            'effective_date' => $this->post('effective_date'),
            'expiry_date' => $this->post('expiry_date')
        ];

        // 检查是否需要取消该客户其他生效的报价单
        if ($data['is_active']) {
            $this->deactivateOtherQuotes($data['customer_id']);
        }

        $this->quote->create($data);
        $this->redirect('/quotes');
    }

    public function edit($id)
    {
        $quote = $this->quote->find($id);
        $customers = $this->customer->all();
        
        return $this->render('quotes/edit', [
            'quote' => $quote,
            'customers' => $customers,
            'categories' => ['我司', '他司', '预期', '客定']
        ]);
    }

    public function update($id)
    {
        $data = [
            'customer_id' => $this->post('customer_id'),
            'category' => $this->post('category'),
            'version' => $this->post('version'),
            'is_active' => $this->post('is_active', 0),
            'discount_rate' => $this->post('discount_rate', 0),
            'rebate_rate' => $this->post('rebate_rate', 0),
            'effective_date' => $this->post('effective_date'),
            'expiry_date' => $this->post('expiry_date')
        ];

        // 检查是否需要取消该客户其他生效的报价单
        if ($data['is_active']) {
            $this->deactivateOtherQuotes($data['customer_id'], $id);
        }

        $this->quote->update($id, $data);
        $this->redirect('/quotes');
    }

    public function destroy($id)
    {
        $this->quote->delete($id);
        $this->redirect('/quotes');
    }

    /**
     * 取消客户其他生效的报价单
     * @param int $customerId 客户ID
     * @param int $excludeQuoteId 要排除的报价单ID（可选）
     */
    private function deactivateOtherQuotes($customerId, $excludeQuoteId = null)
    {
        $query = $this->quote->query()
            ->where('customer_id', $customerId)
            ->where('is_active', 1);
            
        if ($excludeQuoteId) {
            $query->where('id', '!=', $excludeQuoteId);
        }
        
        $otherActiveQuotes = $query->get();
        
        foreach ($otherActiveQuotes as $quote) {
            $this->quote->update($quote['id'], ['is_active' => 0]);
        }
    }
}
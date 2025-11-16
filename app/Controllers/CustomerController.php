<?php

namespace App\Controllers;

use App\Models\Customer;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function index()
    {
        $customers = $this->customer->all();
        return $this->render('customers/index', ['customers' => $customers]);
    }

    public function create()
    {
        return $this->render('customers/create');
    }

    public function store()
    {
        $data = [
            'code' => $this->post('code'),
            'short_name' => $this->post('short_name'),
            'full_name' => $this->post('full_name'),
            'address' => $this->post('address'),
            'phone' => $this->post('phone'),
            'company_name' => $this->post('company_name'),
            'credit_code' => $this->post('credit_code'),
            'bank' => $this->post('bank'),
            'account_number' => $this->post('account_number'),
            'level' => $this->post('level')
        ];

        $this->customer->create($data);
        $this->redirect('/customers');
    }

    public function edit($id)
    {
        $customer = $this->customer->find($id);
        return $this->render('customers/edit', ['customer' => $customer]);
    }

    public function update($id)
    {
        $data = [
            'code' => $this->post('code'),
            'short_name' => $this->post('short_name'),
            'full_name' => $this->post('full_name'),
            'address' => $this->post('address'),
            'phone' => $this->post('phone'),
            'company_name' => $this->post('company_name'),
            'credit_code' => $this->post('credit_code'),
            'bank' => $this->post('bank'),
            'account_number' => $this->post('account_number'),
            'level' => $this->post('level')
        ];

        $this->customer->update($id, $data);
        $this->redirect('/customers');
    }

    public function destroy($id)
    {
        $this->customer->delete($id);
        $this->redirect('/customers');
    }
}
<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    protected $product;

    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
    }

    public function index()
    {
        $products = $this->product->query()
            ->orderBy('created_at', 'DESC')
            ->get();
            
        // 包含常量文件
        require_once __DIR__ . '/../../config/const.php';
        return $this->render('products/index', ['products' => $products]);
    }

    public function create()
    {
        // 包含常量文件
        require_once __DIR__ . '/../../config/const.php';
        return $this->render('products/create');
    }

    public function store()
    {
        $data = [
            'name' => $this->post('name'),
            'manufacturer' => $this->post('manufacturer'),
            'price' => $this->post('price'),
            'unit' => $this->post('unit'),
            'type' => $this->post('type')
        ];

        $this->product->create($data);
        $this->redirect('/products');
    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        // 包含常量文件
        require_once __DIR__ . '/../../config/const.php';
        return $this->render('products/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $data = [
            'name' => $this->post('name'),
            'manufacturer' => $this->post('manufacturer'),
            'price' => $this->post('price'),
            'unit' => $this->post('unit'),
            'type' => $this->post('type')
        ];

        $this->product->update($id, $data);
        $this->redirect('/products');
    }

    public function destroy($id)
    {
        $this->product->delete($id);
        $this->redirect('/products');
    }
}
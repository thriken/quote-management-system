<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }

    public function index()
    {
        $users = $this->user->query()
            ->orderBy('created_at', 'DESC')
            ->get();
            
        return $this->render('users/index', ['users' => $users]);
    }

    public function create()
    {
        return $this->render('users/create', [
            'roles' => ['销售主管', '客服']
        ]);
    }

    public function store()
    {
        $data = [
            'username' => $this->post('username'),
            'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
            'role' => $this->post('role'),
            'name' => $this->post('name'),
            'email' => $this->post('email')
        ];

        $this->user->create($data);
        $this->redirect('/users');
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        return $this->render('users/edit', [
            'user' => $user,
            'roles' => ['销售主管', '客服']
        ]);
    }

    public function update($id)
    {
        $data = [
            'username' => $this->post('username'),
            'role' => $this->post('role'),
            'name' => $this->post('name'),
            'email' => $this->post('email')
        ];

        // 如果提供了新密码，则更新密码
        if ($this->post('password')) {
            $data['password'] = password_hash($this->post('password'), PASSWORD_DEFAULT);
        }

        $this->user->update($id, $data);
        $this->redirect('/users');
    }

    public function destroy($id)
    {
        $this->user->delete($id);
        $this->redirect('/users');
    }
}
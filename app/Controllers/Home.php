<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('landing/index');
    }

    public function maintenance(): string
    {
        $msg = $this->request->getGet('msg');
        return view('maintenance', ['msg' => $msg]);
    }
}

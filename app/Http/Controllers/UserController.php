<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function users(){
        $data = ['count' => User::count(), 'users' => User::all()];
        return response($data);
    }
}

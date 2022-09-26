<?php
namespace App\Http\Controllers\Api\Users;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UsersController extends Controller{

    public function index(){
        User::all();
    }
}
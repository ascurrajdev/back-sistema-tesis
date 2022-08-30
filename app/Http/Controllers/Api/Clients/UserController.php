<?php
namespace App\Http\Controllers\Api\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserController extends Controller{
    public function getUser(Request $request){
        $user = $request->user();
        return $user;
    }
}
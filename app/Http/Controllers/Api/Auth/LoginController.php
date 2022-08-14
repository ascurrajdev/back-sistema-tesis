<?php
namespace App\Http\Controllers\Api\Auth;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;

class LoginController extends Controller{
    use ResponseTrait;
    public function loginClient(Request $request){
        $request->validate([
            "email" => ["required","email","exists:clients"],
            "password" => ["required"]
        ]);
        $client = Client::firstWhere("email",$request->email);
        if(!$client || !Hash::check($request->password,$client->password)){
            throw ValidationException::withMessages([
                "email" => trans("auth.failed"),
            ]);
        }
        $token = $client->createToken($request->ip());
        return $this->success([
            'token' => [
                'plainTextToken' => $token->plainTextToken,
                'abilities' => $token->accessToken->abilities,
            ],
            "client" => new ClientResource($client),
        ]);
    }

    public function loginUser(Request $request){
        $request->validate([
            "email" => ["required","email","exists:users"],
            "password" => ["required"]
        ]);
        $user = User::firstWhere("email",$request->email);
        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                "email" => trans("auth.failed"),
            ]);
        }
        $token = $user->createToken($request->ip());
        return $this->success([
            'token' => [
                'plainTextToken' => $token->plainTextToken,
                'abilities' => $token->accessToken->abilities,
            ],
            "user" => new UserResource($user),
        ]);
    }
}
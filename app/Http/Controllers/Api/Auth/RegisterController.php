<?php 
namespace App\Http\Controllers\Api\Auth;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;

class RegisterController extends Controller{
    use ResponseTrait;
    public function registerClient(Request $request){
        $request->validate([
            'name' => ['required','string','min:3'],
            'email' => ['required','unique:clients','email'],
            'phone_number' => ['required','unique:clients'],
            'password' => ['required','min:8','confirmed']
        ]);
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password)
        ]);
        $token = $client->createToken($request->ip());
        return $this->success([
            'client' => new ClientResource($client),
            'token' => [
                'plainTextToken' => $token->plainTextToken,
                'abilities' => $token->accessToken->abilities,
            ]
        ]);
    }
    public function registerUser(Request $request){
        $request->validate([
            'name' => ['required','string','min:3'],
            'email' => ['required','unique:users','email'],
            'password' => ['required','min:8','confirmed']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken($request->ip());
        return $this->success([
            'user' => new UserResource($user),
            'token' => [
                'plainTextToken' => $token->plainTextToken,
                'abilities' => $token->accessToken->abilities,
            ],
        ]);
    }
}
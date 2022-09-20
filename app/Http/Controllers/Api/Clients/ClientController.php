<?php
namespace App\Http\Controllers\Api\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
class ClientController extends Controller{
    public function getUser(Request $request){
        $user = $request->user();
        return new ClientResource($user);
    }

    public function update(Request $request){
        $request->validate([
            'name' => ['string'],
            'email' => ['email']
        ]);
        $client = $request->user();
        $client->update($request->only(['name','email']));
        return new ClientResource($client);
    }
}
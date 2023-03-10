<?php
namespace App\Http\Controllers\Api\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Traits\ResponseTrait;
use DB;
class ClientController extends Controller{
    use ResponseTrait;
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

    public function statistics(){
        $result = DB::table('reservations')->selectRaw("count(1) as quantity, case when active = true THEN 'RESERVACIONES' ELSE 'PRESUPUESTOS' END AS type")
        ->groupBy('active')->get();
        return $this->success($result);
    }
}
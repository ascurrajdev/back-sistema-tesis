<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencySaveRequest;
use Illuminate\Http\Request;
use App\Http\Resources\AgencyResource;
use App\Models\Agency;

class AgenciesController extends Controller
{
    public function index(){
        $this->authorize('viewAny',Agency::class);
        return AgencyResource::collection(Agency::all());
    }

    public function view(Agency $agency){
        $this->authorize('view',$agency);
        return new AgencyResource($agency);
    }

    public function store(AgencySaveRequest $request){
        $params = $request->validated();
        $params['user_id'] = $request->user()->id;
        $agency = Agency::create($params);
        return new AgencyResource($agency);
    }
    
    public function delete(Agency $agency){
        $this->authorize('delete',$agency);
        $agency->delete();
        return new AgencyResource($agency);
    }
}

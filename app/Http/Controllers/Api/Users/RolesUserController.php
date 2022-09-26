<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleUserSaveRequest;
use App\Http\Requests\RoleUserUpdateRequest;
use App\Traits\ResponseTrait;
use App\Models\RoleUser;
use App\Http\Resources\RoleUserResource;

class RolesUserController extends Controller
{
    use ResponseTrait;

    public function abilities(){
        return $this->success(config('perms'));
    }

    public function index(){
        $this->authorize('viewAny',RoleUser::class);
        return RoleUserResource::collection(RoleUser::all());
    }

    public function view(RoleUser $role){
        $this->authorize('view',$role);
        return new RoleUserResource($role);
    }

    public function store(RoleUserSaveRequest $request){
        $params = $request->validated();
        $role = RoleUser::create($params);
        return new RoleUserResource($role);
    }

    public function update(RoleUser $role,RoleUserUpdateRequest $request){
        $role->fill($request->validated());
        $role->save();
        return new RoleUserResource($role);
    }

    public function delete(RoleUser $role){
        $this->authorize('view',$role);
        $role->delete();
        return new RoleUserResource($role);
    }
}

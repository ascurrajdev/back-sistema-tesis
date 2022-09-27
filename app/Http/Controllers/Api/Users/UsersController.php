<?php
namespace App\Http\Controllers\Api\Users;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller{

    public function index(){
        $this->authorize('viewAny',User::class);
        return UserResource::collection(User::all());
    }

    public function view(User $user){
        $this->authorize('view',$user);
        return new UserResource($user);
    }

    public function store(Request $request){
        $this->authorize('create',User::class);
        $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','min:8'],
            'role_id' => ['required','exists:roles,id']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'email_verified_at' => now(),
        ]);
        return new UserResource($user);
    }

    public function update(User $user, Request $request){
        $this->authorize('update',$user);
        $request->validate([
            'name' => ['string'],
            'email' => ['email','unique:users'],
            'password' => ['min:8'],
            'role_id' => ['exists:roles,id']
        ]);
        $user->fill($request->all());
        $user->save();
        return new UserResource($user);
    }

    public function delete(User $user){
        $this->authorize('delete',$user);
        $user->delete();
        return new UserResource($user);
    }
}
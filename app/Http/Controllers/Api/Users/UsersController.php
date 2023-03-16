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
        return UserResource::collection(User::with('role')->get());
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
            'role_id' => ['required','exists:role_users,id']
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
            'email' => ['email'],
            'password' => ['min:8'],
            'role_id' => ['exists:role_users,id']
        ]);
        $params = $request->all();
        if(array_key_exists('password',$params)){
            $params['password'] = Hash::make($request->password);
        }
        $user->fill($params);
        $user->save();
        return new UserResource($user);
    }

    public function delete(User $user){
        $this->authorize('delete',$user);
        $user->delete();
        return new UserResource($user);
    }
}
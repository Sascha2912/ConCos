<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        // $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = User::paginate(50);

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {

        return view('users.create', ['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $this->validate($request, User::validationRules(true));
        $user = $this->userRepository->updateOrCreate($data);

        if($request->expectsJson()){

            return response([
                'user'    => $user,
                'success' => true,
            ]);
        }

        Auth::login($user);

        return redirect(route('users.show', ['user' => $user]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user) {
        if($request->expectsJson()){

            return response([
                'user' => $user,
            ]);
        }

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {
        if($request->email === $user->email){
            unset($request['email']);
        }
        
        $data = $this->validate($request, User::validationRules());
        $user = $this->userRepository->updateOrCreate($data, $user);

        return redirect(route('users.show', ['user' => $user]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) {
        $user->delete();

        return redirect(route('users.index'));
    }
}
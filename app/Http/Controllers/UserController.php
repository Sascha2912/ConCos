<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * Show the forms for creating a new resource.
     */
    public function create(Request $request) {

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

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user) {
        $roles = ['viewer', 'editor', 'admin'];

        if($request->expectsJson()){

            return response([
                'user'  => $user,
                'roles' => $roles,
            ]);
        }

        return view('users.edit', [
            'user'  => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the forms for editing the specified resource.
     */
    public function edit(User $user) {
        $roles = ['viewer', 'editor', 'admin'];

        return view('users.edit', [
            'user'  => $user,
            'roles' => $roles,
        ]);
    }

    public function editProfile(Request $request) {
        $user = Auth::user();

        return view('users.edit', ['user' => $user, 'roles' => [$user->role]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {

        if($request->email === $user->email){
            unset($request['email']);
        }

        if($request->routeIs('users.update.language') && $request->has('preferred_language')){
            $data = $this->validate($request, [
                'preferred_language' => 'required|in:en,de',
            ]);
            $this->userRepository->updateOrCreate($data, $user);

            // Stelle sicher, dass die Seite neu geladen wird, ohne Umleitung
            return back();
        }else{
            $data = $this->validate($request, User::validationRules());

            // Neues Passwort festlegen, falls angegeben
            if( !empty($data['new_password'])){
                // Überprüfen, ob das aktuelle Passwort korrekt ist
                if( !Hash::check($request->current_password, $user->password)){
                    return back()->withErrors(['current_password' => 'Das aktuelle Passwort ist nicht korrekt.']);
                }else{
                    $data['password'] = bcrypt($data['new_password']); // Passwort verschlüsseln
                }

            }else{
                unset($data['password']); // Passwort nicht aktualisieren, wenn es nicht gesetzt ist
            }
        }

        $user = $this->userRepository->updateOrCreate($data, $user);

        return redirect(route('users.edit', ['user' => $user]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) {
        $user->delete();

        return redirect(route('users.index'));
    }
}
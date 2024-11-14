<?php

namespace Test\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase {

    use RefreshDatabase;

    public function test_user_has_correct_validation_rules_for_creation() {
        // Regeln für die Erstellung eines neuen Benutzers (mit $creating=true)
        $rules = User::validationRules(true);

        $this->assertEquals([
            'firstname'          => 'required|bail|string|max:255',
            'lastname'           => 'required|bail|string|max:255',
            'role'               => 'nullable|string|in:viewer,editor,admin',
            'preferred_language' => 'nullable|string|max:255',
            'email'              => 'required|bail|email|unique:users,email|string|max:255',
            'password'           => 'required|bail|string|min:8',
            'current_password'   => 'nullable|string|min:8',
            'new_password'       => 'nullable|string|min:8|confirmed',
        ], $rules);
    }

    public function test_user_has_correct_validation_rules_for_updating() {
        // Regeln für die Aktualisierung eines bestehenden Benutzers (mit $creating=false)
        $rules = User::validationRules(false);

        $this->assertEquals([
            'firstname'          => 'required|bail|string|max:255',
            'lastname'           => 'required|bail|string|max:255',
            'role'               => 'nullable|string|in:viewer,editor,admin',
            'preferred_language' => 'nullable|string|max:255',
            'email'              => 'email|unique:users,email|string|max:255',
            'password'           => 'nullable|string|min:8',
            'current_password'   => 'nullable|string|min:8',
            'new_password'       => 'nullable|string|min:8|confirmed',
        ], $rules);
    }

    public function test_user_identifies_admin_roles_correctly() {
        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isViewer());
        $this->assertFalse($user->isEditor());
    }

    public function test_user_identifies_editor_roles_correctly() {
        $user = User::factory()->create(['role' => User::ROLe_EDITOR]);
        $this->assertTrue($user->isEditor());
        $this->assertFalse($user->isViewer());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_identifies_viewer_roles_correctly() {
        $user = User::factory()->create(['role' => User::ROLE_VIEWER]);
        $this->assertTrue($user->isViewer());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isEditor());
    }
}

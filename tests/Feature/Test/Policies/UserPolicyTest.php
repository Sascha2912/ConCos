<?php

namespace Test\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->policy = new UserPolicy();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'viewer']);
    }

    // ########## Tests for viewAny and error message ##########
    public function test_admin_can_view_any() {
        $this->assertTrue($this->policy->viewAny($this->admin)->allowed());
    }

    public function test_non_admin_cannot_view_any() {
        $this->assertFalse($this->policy->viewAny($this->user)->allowed());

    }

    // ########## Tests for view  ##########
    public function test_admin_can_view_any_user() {
        $otherUser = User::factory()->create();
        $this->assertTrue($this->policy->view($this->admin, $otherUser)->allowed());
    }

    public function test_user_can_view_own_profile() {
        $this->assertTrue($this->policy->view($this->user, $this->user)->allowed());
    }

    public function test_user_cannot_view_other_profile() {
        $otherUser = User::factory()->create();
        $this->assertFalse($this->policy->view($this->user, $otherUser)->allowed());
    }

    // ########## Tests for create ##########
    public function test_admin_can_create_user() {
        $this->assertTrue($this->policy->create($this->admin)->allowed());
    }

    public function test_non_admin_cannot_create_user() {
        $this->assertFalse($this->policy->create($this->user)->allowed());
    }

    // ########## Tests for update ##########
    public function test_admin_can_update_user() {
        $otherUser = User::factory()->create();
        $this->assertTrue($this->policy->update($this->admin, $otherUser)->allowed());
    }

    public function test_admin_can_update_user_role() {
        $otherUser = User::factory()->create();
        request()->merge(['role' => 'new_role']);
        $this->assertTrue($this->policy->update($this->admin, $otherUser)->allowed());
    }

    public function test_non_admin_cannot_update_other_user_profile() {
        $otherUser = User::factory()->create();
        $this->assertFalse($this->policy->update($this->user, $otherUser)->allowed());
    }

    public function test_user_can_update_own_profile_without_role_change() {
        $this->assertTrue($this->policy->update($this->user, $this->user)->allowed());
    }

    public function test_user_cannot_update_own_role_with_error_message() {
        request()->merge(['role' => 'new_role']);
        $response = $this->policy->update($this->user, $this->user);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__('app.you_do_not_have_permission_for_this_action'), $response->message());
    }

    // ########## Tests for delete ##########
    public function test_admin_can_delete_user() {
        $otherUser = User::factory()->create();
        $this->assertTrue($this->policy->delete($this->admin, $otherUser)->allowed());
    }

    public function test_non_admin_cannot_delete_user() {
        $otherUser = User::factory()->create();
        $this->assertFalse($this->policy->delete($this->user, $otherUser)->allowed());
    }

    // ########## Tests for restore ##########
    public function test_admin_can_restore_user() {
        $otherUser = User::factory()->create();
        $this->assertTrue($this->policy->restore($this->admin, $otherUser)->allowed());
    }

    public function test_non_admin_cannot_restore_user() {
        $otherUser = User::factory()->create();
        $this->assertFalse($this->policy->restore($this->user, $otherUser)->allowed());
    }

    // ########## Tests for forceDelete ##########
    public function test_admin_can_force_delete_user() {
        $otherUser = User::factory()->create();
        $this->assertTrue($this->policy->forceDelete($this->admin, $otherUser)->allowed());
    }

    public function test_non_admin_cannot_force_delete_user() {
        $otherUser = User::factory()->create();
        $this->assertFalse($this->policy->forceDelete($this->user, $otherUser)->allowed());
    }
}

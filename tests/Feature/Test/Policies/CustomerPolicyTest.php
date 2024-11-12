<?php

namespace Test\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerPolicyTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    protected $policy;
    protected $user;
    protected $customer;

    protected function setUp(): void {
        parent::setUp();
        $this->policy = new CustomerPolicy();
        $this->user = User::factory()->create();
        $this->customer = Customer::factory()->create();
    }

    // ########## Tests for viewAny and error message ##########
    public function test_user_can_view_any() {
        $this->assertTrue($this->policy->viewAny($this->user)->allowed());
    }

    // ########## Tests for view  ##########
    public function test_user_can_view_customer() {
        $this->assertTrue($this->policy->view($this->user, $this->customer)->allowed());
    }

    // ########## Tests for create ##########
    public function test_viewer_user_cannot_create_customer() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->create($this->user)->allowed());
    }

    public function test_editor_user_can_create_customer() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    public function test_admin_user_can_create_customer() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    // ########## Tests for update ##########
    public function test_viewer_user_cannot_update_customer() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->update($this->user, $this->customer)->allowed());
    }

    public function test_editor_user_can_update_customer() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->update($this->user, $this->customer)->allowed());
    }

    public function test_admin_user_can_update_customer() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->update($this->user, $this->customer)->allowed());
    }

    // ########## Tests for delete ##########
    public function test_viewer_user_cannot_delete_customer() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->delete($this->user, $this->customer)->allowed());
    }

    public function test_editor_user_cannot_delete_customer() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->delete($this->user, $this->customer)->allowed());
    }

    public function test_admin_user_can_delete_customer() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->delete($this->user, $this->customer)->allowed());
    }

    // ########## Tests for restore ##########
    public function test_viewer_user_cannot_restore_customer() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->restore($this->user, $this->customer)->allowed());
    }

    public function test_editor_user_cannot_restore_customer() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->restore($this->user, $this->customer)->allowed());
    }

    public function test_admin_user_can_restore_customer() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->restore($this->user, $this->customer)->allowed());
    }

// ########## Tests for forceDelete ##########
    public function test_viewer_user_cannot_force_delete_customer() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->customer)->allowed());
    }

    public function test_editor_user_cannot_force_delete_customer() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->customer)->allowed());
    }

    public function test_admin_user_can_force_delete_customer() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->forceDelete($this->user, $this->customer)->allowed());
    }
}

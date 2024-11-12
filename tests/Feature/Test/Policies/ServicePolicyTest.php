<?php

namespace Test\Policies;

use App\Models\Service;
use App\Models\User;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePolicyTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    protected $policy;
    protected $user;
    protected $service;

    protected function setUp(): void {
        parent::setUp();
        $this->policy = new ServicePolicy();
        $this->user = User::factory()->create();
        $this->service = Service::factory()->create();
    }

    // ########## Tests for viewAny and error message ##########
    public function test_user_can_view_any() {
        $this->assertTrue($this->policy->viewAny($this->user)->allowed());
    }

    // ########## Tests for view  ##########
    public function test_user_can_view_service() {
        $this->assertTrue($this->policy->view($this->user, $this->service)->allowed());
    }

    // ########## Tests for create ##########
    public function test_viewer_user_cannot_create_service() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->create($this->user)->allowed());
    }

    public function test_editor_user_can_create_service() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    public function test_admin_user_can_create_service() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    // ########## Tests for update ##########
    public function test_viewer_user_cannot_update_service() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->update($this->user, $this->service)->allowed());
    }

    public function test_editor_user_can_update_service() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->update($this->user, $this->service)->allowed());
    }

    public function test_admin_user_can_update_service() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->update($this->user, $this->service)->allowed());
    }

    // ########## Tests for delete ##########
    public function test_viewer_user_cannot_delete_service() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->delete($this->user, $this->service)->allowed());
    }

    public function test_editor_user_cannot_delete_service() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->delete($this->user, $this->service)->allowed());
    }

    public function test_admin_user_can_delete_service() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->delete($this->user, $this->service)->allowed());
    }

    // ########## Tests for restore ##########
    public function test_viewer_user_cannot_restore_service() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->restore($this->user, $this->service)->allowed());
    }

    public function test_editor_user_cannot_restore_service() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->restore($this->user, $this->service)->allowed());
    }

    public function test_admin_user_can_restore_service() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->restore($this->user, $this->service)->allowed());
    }

// ########## Tests for forceDelete ##########
    public function test_viewer_user_cannot_force_delete_service() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->service)->allowed());
    }

    public function test_editor_user_cannot_force_delete_service() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->service)->allowed());
    }

    public function test_admin_user_can_force_delete_service() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->forceDelete($this->user, $this->service)->allowed());
    }
}

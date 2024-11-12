<?php

namespace Test\Policies;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Timelog;
use App\Models\User;
use App\Policies\TimelogPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimelogPolicyTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    protected $policy;
    protected $user;
    protected $timelog;

    protected function setUp(): void {
        parent::setUp();
        // Erstelle die Policy und einen Benutzer
        $this->policy = new TimelogPolicy();
        $this->user = User::factory()->create();

        // Erstelle einmal die abhängigen Modelle, die für den Test verwendet werden
        $customer = Customer::factory()->create();
        $contract = Contract::factory()->create();
        $service = Service::factory()->create();

        // Erstelle ein Timelog mit den oben erstellten Abhängigkeiten
        $this->timelog = Timelog::factory()->create([
            'customer_id' => $customer->id,
            'contract_id' => $contract->id,
            'service_id'  => $service->id,
        ]);
    }

    // ########## Tests for viewAny and error message ##########
    public function test_user_can_view_any() {
        $this->assertTrue($this->policy->viewAny($this->user)->allowed());
    }

    // ########## Tests for view  ##########
    public function test_user_can_view_timelog() {
        $this->assertTrue($this->policy->view($this->user, $this->timelog)->allowed());
    }

    // ########## Tests for create ##########
    public function test_viewer_user_cannot_create_timelog() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->create($this->user)->allowed());
    }

    public function test_editor_user_can_create_timelog() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    public function test_admin_user_can_create_timelog() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->create($this->user)->allowed());
    }

    // ########## Tests for update ##########
    public function test_viewer_user_cannot_update_timelog() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->update($this->user, $this->timelog)->allowed());
    }

    public function test_editor_user_can_update_timelog() {
        $this->user->role = 'editor';
        $this->assertTrue($this->policy->update($this->user, $this->timelog)->allowed());
    }

    public function test_admin_user_can_update_timelog() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->update($this->user, $this->timelog)->allowed());
    }

    // ########## Tests for delete ##########
    public function test_viewer_user_cannot_delete_timelog() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->delete($this->user, $this->timelog)->allowed());
    }

    public function test_editor_user_cannot_delete_timelog() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->delete($this->user, $this->timelog)->allowed());
    }

    public function test_admin_user_can_delete_timelog() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->delete($this->user, $this->timelog)->allowed());
    }

    // ########## Tests for restore ##########
    public function test_viewer_user_cannot_restore_timelog() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->restore($this->user, $this->timelog)->allowed());
    }

    public function test_editor_user_cannot_restore_timelog() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->restore($this->user, $this->timelog)->allowed());
    }

    public function test_admin_user_can_restore_timelog() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->restore($this->user, $this->timelog)->allowed());
    }

// ########## Tests for forceDelete ##########
    public function test_viewer_user_cannot_force_delete_timelog() {
        $this->user->role = 'viewer';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->timelog)->allowed());
    }

    public function test_editor_user_cannot_force_delete_timelog() {
        $this->user->role = 'editor';
        $this->assertFalse($this->policy->forceDelete($this->user, $this->timelog)->allowed());
    }

    public function test_admin_user_can_force_delete_timelog() {
        $this->user->role = 'admin';
        $this->assertTrue($this->policy->forceDelete($this->user, $this->timelog)->allowed());
    }
}

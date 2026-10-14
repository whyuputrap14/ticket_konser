<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_order_summary_without_event_crud_controls(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Daftar Pesanan Masuk');
        $response->assertSee('Belum ada pesanan masuk.');
        $response->assertDontSee('Tambah Event');
        $response->assertDontSee('Update');
        $response->assertDontSee('Hapus');
    }
}

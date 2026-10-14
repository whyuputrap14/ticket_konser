<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_list_events(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Event',
            'email' => 'admin@gmail.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('events.store'), [
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 50000,
            'description' => 'Acara musik malam hari',
        ]);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 50000,
        ]);

        $this->get(route('events.index'))
            ->assertOk()
            ->assertSee('Festival Musik');
    }

    public function test_customer_can_view_an_event_from_the_catalog(): void
    {
        $event = Event::create([
            'title' => 'Festival Musik',
            'category' => 'Musik',
            'ticket_price' => 50000,
            'description' => 'Acara musik malam hari',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Rp 50.000')
            ->assertSee(route('customer.events.show', $event));

        $this->get(route('customer.events.show', $event))
            ->assertOk()
            ->assertSee('Festival Musik')
            ->assertSee('Acara musik malam hari')
            ->assertSee('Rp 50.000');
    }
}

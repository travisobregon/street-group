<?php

namespace Tests\Feature;

use App\Models\Homeowner;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListHomeownersTest extends TestCase
{
    #[Test]
    public function unauthenticated_users_cannot_view_homeowners(): void
    {
        $response = $this->get(route('homeowners.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function authenticated_users_can_view_homeowners(): void
    {
        $user = User::factory()->create();
        Homeowner::factory()->create(['title' => 'Mr', 'first_name' => 'Tom', 'initial' => null, 'last_name' => 'Staff']);
        Homeowner::factory()->create(['title' => 'Mrs', 'first_name' => 'Heather', 'initial' => null, 'last_name' => 'Staff']);
        
        $this->actingAs($user)
            ->get(route('homeowners.index')) 
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Homeowners/Index')
                ->has('homeowners.data', 2)
                ->has('homeowners.data.0', fn (Assert $assert) => $assert
                    ->has('id')
                    ->has('created_at')
                    ->has('updated_at')
                    ->where('title', 'Mrs')
                    ->where('first_name', 'Heather')
                    ->where('initial', null)
                    ->where('last_name', 'Staff')
                )
                ->has('homeowners.data.1', fn (Assert $assert) => $assert
                    ->has('id')
                    ->has('created_at')
                    ->has('updated_at')
                    ->where('title', 'Mr')
                    ->where('first_name', 'Tom')
                    ->where('initial', null)
                    ->where('last_name', 'Staff')
                )
        );
    }
}

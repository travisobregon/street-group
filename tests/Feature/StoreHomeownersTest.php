<?php

namespace Tests\Feature;

use App\Models\Homeowner;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreHomeownersTest extends TestCase
{
    #[Test]
    public function unauthenticated_users_cannot_import_homeowners(): void
    {
        $response = $this->post(route('homeowners.store'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function authenticated_users_can_import_homeowners(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('homeowners.store'), [
                'file' => new UploadedFile(__DIR__.'/../stubs/homeowners.csv', 'homeowners.csv', 'text/csv', test: true),
            ]);

        $this->assertSame(10, Homeowner::query()->count());
    }

    #[Test]
    #[DataProvider('inputProvider')]
    public function it_validates_input($value, $message): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('homeowners.store'), [
                'file' => $value,
            ]);

        $response->assertInvalid(['file' => $message]);
    }

    public static function inputProvider(): array
    {
        return [
            'file is required' => [null, 'The file field is required.'],
            'file must be a file' => ['not a file', 'The file field must be a file.'],
            'file must be a csv or txt file' => [UploadedFile::fake()->image('not-a-csv.png'), 'The file field must be a file of type: csv, txt.'],
        ];
    }
}

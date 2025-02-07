<?php

namespace Tests\Unit\Actions;

use App\Actions\SplitName;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SplitNameTest extends TestCase
{
    #[Test]
    #[DataProvider('titleProvider')]
    public function it_can_handle_different_titles(string $title): void
    {
        $result = with(new SplitName)->handle("{$title} Smith");

        $this->assertSame([[
            'title' => $title,
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Smith',
        ]], $result);
    }

    #[Test]
    public function it_can_handle_an_initial_with_a_period(): void
    {
        $result = with(new SplitName)->handle('Mr F. Fredrickson');

        $this->assertSame([[
            'title' => 'Mr',
            'first_name' => null,
            'initial' => 'F',
            'last_name' => 'Fredrickson',
        ]], $result);
    }

    #[Test]
    public function it_can_handle_an_initial_without_a_period(): void
    {
        $result = with(new SplitName)->handle('Mr M Mackie');

        $this->assertSame([[
            'title' => 'Mr',
            'first_name' => null,
            'initial' => 'M',
            'last_name' => 'Mackie',
        ]], $result);
    }

    #[Test]
    public function it_can_handle_multiple_names_with_and(): void
    {
        $result = with(new SplitName)->handle('Mr Tom Staff and Mr John Doe');

        $this->assertSame([
            [
                'title' => 'Mr',
                'first_name' => 'Tom',
                'initial' => null,
                'last_name' => 'Staff',
            ],
            [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Doe',
            ],
        ], $result);
    }

    #[Test]
    public function it_can_handle_multiple_names_with_ampersand(): void
    {
        $result = with(new SplitName)->handle('Dr & Mrs Jane Bloggs');

        $this->assertSame([
            [
                'title' => 'Dr',
                'first_name' => null,
                'initial' => null,
                'last_name' => 'Bloggs',
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Jane',
                'initial' => null,
                'last_name' => 'Bloggs',
            ],
        ], $result);
    }

    #[Test]
    public function it_handles_leading_and_trailing_spaces(): void
    {
        $result = with(new SplitName)->handle('  Mr Smith  ');

        $this->assertSame([[
            'title' => 'Mr',
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Smith',
        ]], $result);
    }

    #[Test]
    #[DataProvider('validationProvider')]
    public function it_validates_input(string $input, string $exceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        with(new SplitName)->handle($input);
    }

    public static function titleProvider(): array
    {
        return [
            'Mr title' => ['Mr'],
            'mrs title lowercase' => ['mrs'],
            'Dr title' => ['Dr'],
            'PROF title uppercase' => ['PROF'],
            'Ms title' => ['Ms'],
            'MiStEr title mixed' => ['MiStEr'],
        ];
    }

    public static function validationProvider(): array
    {
        return [
            'missing title' => [
                'Smith',
                'Invalid or missing title',
            ],
            'invalid title' => [
                'Sir Smith',
                'Invalid or missing title',
            ],
            'missing last name' => [
                'Mr',
                'Last name is required',
            ],
        ];
    }
}

<?php

namespace App\Actions;

use InvalidArgumentException;

class SplitName
{
    private const array TITLES = ['Mr', 'Mister', 'Mrs', 'Ms', 'Dr', 'Prof'];
    private const array CONJUNCTIONS = ['and', '&'];

    public function handle(string $name): array
    {
        $names = collect(preg_split('/\s*(' . implode('|', array_map('preg_quote', self::CONJUNCTIONS)) . ')\s*/i', $name))
            ->filter()
            ->reverse();

        $lastName = null;

        return $names->map(function ($name) use (&$lastName) {
            $parts = explode(' ', trim($name));

            $titlePattern = '/^(' . implode('|', array_map('preg_quote', self::TITLES)) . ')\.?$/i';
            preg_match($titlePattern, $parts[0], $titleMatches);

            $title = $titleMatches[1] ?? throw new InvalidArgumentException('Invalid or missing title.');
            array_shift($parts);

            $lastName = array_pop($parts) ?? $lastName;

            if (!$lastName) {
                throw new InvalidArgumentException('Last name is required.');
            }

            [$firstName, $initial] = $this->extractFirstNameAndInitial($parts);
            
            return [
                'title' => $title,
                'first_name' => $firstName,
                'initial' => $initial,
                'last_name' => $lastName,
            ];
        })->reverse()->toArray();
    }

    private function extractFirstNameAndInitial(array $parts): array
    {
        if (empty($parts)) {
            return [null, null];
        }
        
        preg_match('/^([A-Z])\.?$/', $parts[0], $initialMatches);

        if (isset($initialMatches[1])) {
            return [null, $initialMatches[1]];
        }

        return [array_shift($parts), null];
    }
}
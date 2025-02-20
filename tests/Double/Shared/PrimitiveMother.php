<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use DateTime;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;
use Ramsey\Uuid\Uuid as RamseyUuid;
use TaskFlow\Shared\Domain\Uuid;

final class PrimitiveMother
{
    public const DEFAULT_LOCALE = 'es_ES';

    private static ?Generator $faker = null;

    public static function word(): string
    {
        /** @var string */
        return self::create()->word();
    }

    public static function name(): string
    {
        /** @var string */
        return self::create()->name();
    }

    public static function password(int $minLength, int $maxLength): string
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

         $password = self::create()->password($minLength, $maxLength);

        $passwordArray = str_split($password);
        $passwordArray[0] = $lowercase[rand(0, strlen($lowercase) - 1)];
        $passwordArray[1] = $uppercase[rand(0, strlen($uppercase) - 1)];
        $passwordArray[2] = $numbers[rand(0, strlen($numbers) - 1)];


        shuffle($passwordArray);


        return implode('', $passwordArray);
    }

    public static function email(): string
    {
        /** @var string */
        return self::create()->email();
    }

    public static function boolean(): bool
    {
        /** @var bool */
        return self::create()->boolean();
    }

    public static function uuid(): Uuid
    {
        return Uuid::create(RamseyUuid::uuid4()->toString());
    }

    public static function between(int $min, int $max): int
    {
        return self::create()->numberBetween($min, $max);
    }

    private static function create(): Generator
    {
        return self::$faker = self::$faker ?? Factory::create(self::DEFAULT_LOCALE);
    }

    public static function dateTimeBetween(string $startDate, string $endDate): DateTimeImmutable
    {
        /** @var DateTime $mutableDateTime */
        $mutableDateTime = self::create()->dateTimeBetween($startDate, $endDate);

        /** @var DateTimeImmutable */
        return DateTimeImmutable::createFromMutable($mutableDateTime);
    }
}

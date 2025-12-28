<?php declare(strict_types=1);

namespace App\Enums;

use Exception;
use BenSampo\Enum\Enum;

/**
 * @method static static Country()
 * @method static static Region()
 * @method static static County()
 * @method static static Town()
 */
final class LocalityTypeEnum extends Enum
{
    const Country = 1;
    const Region = 2;
    const County = 3;
    const Town = 4;

    public function nextLevelDown(): self
    {
        return match ($this->value) {
            LocalityTypeEnum::Country => LocalityTypeEnum::Region(),
            LocalityTypeEnum::Region => LocalityTypeEnum::County(),
            LocalityTypeEnum::County => LocalityTypeEnum::Town(),
            default => throw new Exception('There are no further levels down'),
        };
    }
}

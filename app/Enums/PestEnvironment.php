<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Inside()
 * @method static static Outside()
 * @method static static Both()
 */
final class PestEnvironment extends Enum
{
    const Inside = 1;
    const Outside = 2;
    const Both = 2;
}

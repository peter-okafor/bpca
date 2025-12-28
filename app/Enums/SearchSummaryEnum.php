<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SearchCount()
 * @method static static ServiceCount()
 */
final class SearchSummaryEnum extends Enum
{
    const SearchCount = 1;
    const ServiceCount = 2;
}

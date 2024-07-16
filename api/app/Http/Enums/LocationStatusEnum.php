<?php

namespace App\Http\Enums;

use BenSampo\Enum\Enum;

/**
 * The locations status enums class
 */
final class LocationStatusEnum extends Enum
{   
    /**
     * @var const Closed
     */
    const Closed = 'closed';

    /**
     * @var const Active
     */
    const Active = 'active';

    /**
     * @var const Planned
     */
    const Planned = 'planned';
}
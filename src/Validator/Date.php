<?php

declare(strict_types=1);

namespace App\Validator;

class Date
{
    public const REGEX_VALID_FORMAT_DATE_WITH_HOUR = '/^(20[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])$/';
    public const MESSAGE_FORMAT_DATE_WITH_HOUR = 'The value %s does not match the expected pattern. Correct format is Y-M-d H:i:s.';
}

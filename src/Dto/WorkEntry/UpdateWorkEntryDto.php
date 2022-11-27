<?php

declare(strict_types=1);

namespace App\Dto\WorkEntry;

use App\Exception\EndDateLessThanStartDateException;
use App\Validator\Date;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class UpdateWorkEntryDto
{
    public function __construct(
        #[OAT\Property(property: 'userId', type: 'integer', example: '1')]
        public readonly int $userId,
        #[OAT\Property(property: 'startDate', type: 'datetime', example: '2022-01-01 00:00:00')]
        public readonly \DateTime $startDate,
        #[OAT\Property(property: 'endDate', type: 'datetime', example: '2022-01-01 00:00:00')]
        public readonly ?\DateTime $endDate = null,
    ) {
    }

    public static function createFromRequest(Request $request): self
    {
        $payload = (array) json_decode($request->getContent(), true);

        Assert::keyExists($payload, 'userId');
        Assert::keyExists($payload, 'startDate');

        Assert::notNull($payload['userId']);
        Assert::positiveInteger($payload['userId']);
        Assert::notNull($payload['startDate']);
        $patternDateTime = Date::REGEX_VALID_FORMAT_DATE_WITH_HOUR;
        $errorMessagePatternDateTime = Date::MESSAGE_FORMAT_DATE_WITH_HOUR;
        Assert::regex($payload['startDate'], $patternDateTime, $errorMessagePatternDateTime);

        $startDate = new \DateTime($payload['startDate']);

        if (key_exists('endDate', $payload)) {
            Assert::regex($payload['endDate'], $patternDateTime, $errorMessagePatternDateTime);
            $endDate = new \DateTime($payload['endDate']);
            if ($endDate <= $startDate) {
                throw new EndDateLessThanStartDateException();
            }

            return new self(
                $payload['userId'],
                $startDate,
                $endDate
            );
        }

        return new self(
            $payload['userId'],
            $startDate
        );
    }
}

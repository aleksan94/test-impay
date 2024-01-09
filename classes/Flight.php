<?php

namespace Aleks\TestImpay;

use DateTime;

class Flight
{
    public function __construct(
        public string $from,
        public string $to,
        public DateTime $depart,
        public DateTime $arrival,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            from: $data['from'],
            to: $data['to'],
            depart: DateTime::createFromFormat('d.m.Y H:i', $data['depart']),
            arrival: DateTime::createFromFormat('d.m.Y H:i', $data['arrival']),
        );
    }
}
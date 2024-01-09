<?php

namespace Aleks\TestImpay;

class Route
{
    /** @var array<Flight> */
    private array $flights = [];

    public function __construct(array $flights) {
        $this->flights = $flights;
    }

    public function duration(): int
    {
        return end($this->flights)->arrival->getTimestamp() - reset($this->flights)->depart->getTimestamp();
    }

    public function timeFrom(): string
    {
        return reset($this->flights)->depart->format('d.m.Y H:i');
    }

    public function timeTo(): string
    {
        return end($this->flights)->arrival->format('d.m.Y H:i');
    }

    public function durationFormat(): string
    {
        $duration = $this->duration();

        $days = floor($duration / 86400);
        $hours = floor(($duration % 86400) / 3600);
        $minutes = floor(($duration % 3600) / 60);
        $seconds = $duration % 60;

        return  ($days > 0 ? $days." д. " : "")
            .   ($days || $hours > 0 ? $hours." ч. " : "")
            .   ($days || $hours > 0 || $minutes > 0 ? $minutes." мин. " : "")
            .   ($days || $hours > 0 || $minutes > 0 || $seconds > 0 ? $seconds." сек." : "");
    }
}
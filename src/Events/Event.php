<?php

namespace Devqaly\DevqalyClient\Events;

interface Event
{
    public function create(string $sessionId, string $sessionSecret, array $data): void;
}

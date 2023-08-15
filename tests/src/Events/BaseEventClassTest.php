<?php

use Devqaly\DevqalyClient\Events\BaseEvent;

it('should return the correct endpoint when calling `getCreateEventEndpoint` method', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $sessionId = 'b79cb3ba-745e-5d9a-8903-4a02327a7e09';

    $createEndpoint = $client->getCreateEventEndpoint($sessionId);

    expect($createEndpoint)->toBe(sprintf('%s/sessions/%s/events', $backendUrl, $sessionId));
});

it('should return correct payload when calling `generatePayload` method', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $clickEventPayload = ['positionX' => 500, 'positionY' => 500];
    $eventType = 'click-event';

    $payload = $client->generatePayload($clickEventPayload, $eventType);

    expect($payload)
        ->toBeArray()
        ->and($payload)
        ->toMatchArray([
            ...$clickEventPayload,
            'type' => $eventType,
            'source' => $sourceIdentifier,
        ])
        ->and(DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $payload['clientUtcEventCreatedAt']) !== false)
        ->toBeTrue();
});

it('should allow to validate the session id when calling `validateSessionId` method', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';

    $client->validateSessionId($sessionId);

    // I have added this here just to assert something.
    // As far as I researched, pest doesn't have something like PHP Unit's @doesNotPerformAssertions
    expect(1)->toBe(1);
});

it('should throw error exception when calling `validateSessionId` method with invalid session id', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $sessionId = '';

    $client->validateSessionId($sessionId);
})->throws(\Error::class, '$sessionId must be set and not empty');

it('should allow to validate session secret when calling `validateSessionSecret` method', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';

    $client->validateSessionSecret($sessionSecret);

    // I have added this here just to assert something.
    // As far as I researched, pest doesn't have something like PHP Unit's @doesNotPerformAssertions
    expect(1)->toBe(1);
});

it('should throw error exception when calling `validateSessionSecret` method with invalid session secret', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';

    $client = new BaseEvent($backendUrl, $sourceIdentifier);

    $sessionSecret = '';

    $client->validateSessionSecret($sessionSecret);
})->throws(\Error::class, '$sessionSecret must be set and not empty');

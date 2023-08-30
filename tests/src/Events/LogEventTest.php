<?php

use Devqaly\DevqalyClient\Events\LogEvent;

it('should throw an error when passing empty `level`', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';
    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $securityToken = 'nJOFUgmcKDhzpMMbL6VqEzWbK7XOby8ZMqOWqYooTE1Xtd4Y3RQBidpeq42i';

    $client = new LogEvent($backendUrl, $sourceIdentifier, $securityToken);

    $client->create($sessionId, $sessionSecret, ['log' => 'some log']);
})->throws(\Error::class, '`level` must be set to create a log event in $data');

it('should throw an error when passing empty `log`', function () {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';
    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $securityToken = 'nJOFUgmcKDhzpMMbL6VqEzWbK7XOby8ZMqOWqYooTE1Xtd4Y3RQBidpeq42i';

    $client = new LogEvent($backendUrl, $sourceIdentifier, $securityToken);

    $client->create($sessionId, $sessionSecret, ['level' => LogEvent::LOG_LEVEL_ALERT]);
})->throws(\Error::class, '`log` must be set to create a log event in $data');

it('should execute curl request when calling `create` method and close', function() {
    $backendUrl = 'https://devqaly.test/api';
    $sourceIdentifier = 'microservice-x';
    $sessionId = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $sessionSecret = 'c7622e14-21f8-40c2-b151-3a311816b423';
    $securityToken = 'nJOFUgmcKDhzpMMbL6VqEzWbK7XOby8ZMqOWqYooTE1Xtd4Y3RQBidpeq42i';

    $client = Mockery::mock(LogEvent::class, [$backendUrl, $sourceIdentifier, $securityToken])->makePartial();

    $endpoint = 'https://something.com';

    $baseData = ['level' => LogEvent::LOG_LEVEL_ALERT, 'log' => 'something'];

    $client->shouldReceive('validateSessionId')->with($sessionId)->once();
    $client->shouldReceive('validateSessionSecret')->with($sessionSecret)->once();
    $client->shouldReceive('getCreateEventEndpoint')->with($sessionId)->once()->andReturn($endpoint);

    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_URL, $endpoint);
    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_RETURNTRANSFER, true);
    $client->shouldReceive('setOption')->times(1);
    $client->shouldReceive('setOption')->times(1)->with(CURLOPT_HTTPHEADER, ['x-devqaly-session-secret-token: '.$sessionSecret]);

    $client->shouldReceive('execute')->withNoArgs()->once();
    $client->shouldReceive('close')->withNoArgs()->once();

    $client->create($sessionId, $sessionSecret, $baseData);
});

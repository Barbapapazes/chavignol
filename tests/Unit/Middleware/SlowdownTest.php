<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Sleep;

test('it sleeps for a write request', function (string $method) {
    Sleep::fake();
    Config::set('app.sleep_time', 2);

    Route::any('api/test', fn () => response(status: 200));

    $this->call($method, 'api/test');

    Sleep::assertSequence([
        Sleep::for(2)->second(),
    ]);
})
    ->with([
        'post', 'put', 'patch', 'delete',
    ]);

test('it only sleeps for API requests', function (string $method) {
    Sleep::fake();
    Config::set('app.sleep_time', 2);

    Route::any('test', fn () => response(status: 200));

    $this->call($method, 'test');

    Sleep::assertNeverSlept();
})
    ->with([
        'post',
        'put',
        'patch',
        'delete',
    ]);

test('it does not sleep for a read request', function (string $method) {
    Sleep::fake();
    Config::set('app.sleep_time', 2);

    Route::any('api/test', fn () => response(status: 200));

    $this->call($method, 'api/test');

    Sleep::assertNeverSlept();
})
    ->with([
        'get', 'head', 'options',
    ]);

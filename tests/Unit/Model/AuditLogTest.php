<?php

declare(strict_types=1);

use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can be created with factory', function (): void {
    $auditLog = AuditLog::factory()->create();

    expect($auditLog)->toBeInstanceOf(AuditLog::class);
});

it('has fillable attributes', function (): void {
    $user = User::factory()->create();

    $auditLog = AuditLog::factory()->create([
        'user_id' => $user->id,
        'model_type' => Customer::class,
        'model_id' => 1,
        'action' => 'created',
        'old_values' => [],
        'new_values' => ['name' => 'New Customer'],
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
    ]);

    expect($auditLog->user_id)->toBe($user->id)
        ->and($auditLog->model_type)->toBe(Customer::class)
        ->and($auditLog->model_id)->toBe(1)
        ->and($auditLog->action)->toBe('created')
        ->and($auditLog->old_values)->toBe([])
        ->and($auditLog->new_values)->toBe(['name' => 'New Customer'])
        ->and($auditLog->ip_address)->toBe('127.0.0.1')
        ->and($auditLog->user_agent)->toBe('Mozilla/5.0');
});

it('casts old_values to array', function (): void {
    $auditLog = AuditLog::factory()->create(['old_values' => ['name' => 'Old Name']]);

    expect($auditLog->old_values)->toBeArray()
        ->and($auditLog->old_values)->toBe(['name' => 'Old Name']);
});

it('casts new_values to array', function (): void {
    $auditLog = AuditLog::factory()->create(['new_values' => ['name' => 'New Name']]);

    expect($auditLog->new_values)->toBeArray()
        ->and($auditLog->new_values)->toBe(['name' => 'New Name']);
});

it('has user relationship', function (): void {
    $user = User::factory()->create();
    $auditLog = AuditLog::factory()->create(['user_id' => $user->id]);

    expect($auditLog->user)->toBeInstanceOf(User::class)
        ->and($auditLog->user->id)->toBe($user->id);
});

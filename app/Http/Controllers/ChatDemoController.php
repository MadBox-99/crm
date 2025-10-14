<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CustomerType;
use App\Models\Customer;
use Illuminate\Contracts\View\View;

final class ChatDemoController extends Controller
{
    public function index(): View
    {
        // Demo customer létrehozása vagy meglévő használata
        $customer = Customer::query()->firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'unique_identifier' => 'DEMO-'.uniqid(),
                'name' => 'Demo Customer',
                'email' => 'demo@example.com',
                'phone' => '+36 20 123 4567',
                'type' => CustomerType::B2C,
                'is_active' => true,
            ]
        );

        return view('chat-demo', compact('customer'));
    }
}

<?php

declare(strict_types=1);

use App\Enums\OpportunityStage;
use App\Filament\Resources\LeadOpportunities\Pages\ManageLeadOpportunities;
use App\Filament\Resources\LostOpportunities\Pages\ManageLostOpportunities;
use App\Filament\Resources\NegotiationOpportunities\Pages\ManageNegotiationOpportunities;
use App\Filament\Resources\ProposalOpportunities\Pages\ManageProposalOpportunities;
use App\Filament\Resources\QualifiedOpportunities\Pages\ManageQualifiedOpportunities;
use App\Filament\Resources\WonOpportunities\Pages\ManageWonOpportunities;
use App\Models\Customer;
use App\Models\Opportunity;
use App\Models\User;
use Spatie\Permission\Models\Permission;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create();

    Permission::query()->firstOrCreate(['name' => 'view_any_opportunity']);
    $this->user->givePermissionTo('view_any_opportunity');

    $this->actingAs($this->user);
});

it('can render lead opportunities page', function (): void {
    livewire(ManageLeadOpportunities::class)
        ->assertSuccessful();
});

it('displays lead opportunities in the lead opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $leadOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Won,
        'title' => 'Won Test Opportunity',
    ]);

    livewire(ManageLeadOpportunities::class)
        ->assertCanSeeTableRecords([$leadOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays qualified opportunities in the qualified opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $qualifiedOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Qualified,
        'title' => 'Qualified Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageQualifiedOpportunities::class)
        ->assertCanSeeTableRecords([$qualifiedOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays proposal opportunities in the proposal opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $proposalOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Proposal,
        'title' => 'Proposal Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageProposalOpportunities::class)
        ->assertCanSeeTableRecords([$proposalOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays negotiation opportunities in the negotiation opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $negotiationOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Negotiation,
        'title' => 'Negotiation Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageNegotiationOpportunities::class)
        ->assertCanSeeTableRecords([$negotiationOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays won opportunities in the won opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $wonOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Won,
        'title' => 'Won Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageWonOpportunities::class)
        ->assertCanSeeTableRecords([$wonOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays lost opportunities in the lost opportunities resource', function (): void {
    $customer = Customer::factory()->create();
    $lostOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lost,
        'title' => 'Lost Test Opportunity',
    ]);

    $otherOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageLostOpportunities::class)
        ->assertCanSeeTableRecords([$lostOpportunity])
        ->assertCanNotSeeTableRecords([$otherOpportunity]);
});

it('displays customer data in lead opportunities table', function (): void {
    $customer = Customer::factory()->create([
        'name' => 'Test Customer Name',
        'email' => 'testcustomer@example.com',
    ]);

    $opportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Lead Test Opportunity',
    ]);

    livewire(ManageLeadOpportunities::class)
        ->assertCanSeeTableRecords([$opportunity])
        ->assertSee('Test Customer Name')
        ->assertSee('testcustomer@example.com');
});

it('can search lead opportunities by customer name', function (): void {
    $customer1 = Customer::factory()->create(['name' => 'John Doe']);
    $customer2 = Customer::factory()->create(['name' => 'Jane Smith']);

    $opportunity1 = Opportunity::factory()->create([
        'customer_id' => $customer1->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'First Opportunity',
    ]);

    $opportunity2 = Opportunity::factory()->create([
        'customer_id' => $customer2->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Second Opportunity',
    ]);

    livewire(ManageLeadOpportunities::class)
        ->searchTable('John Doe')
        ->assertCanSeeTableRecords([$opportunity1])
        ->assertCanNotSeeTableRecords([$opportunity2]);
});

it('can search lead opportunities by opportunity title', function (): void {
    $customer = Customer::factory()->create();

    $opportunity1 = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Unique Opportunity Title',
    ]);

    $opportunity2 = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Different Opportunity',
    ]);

    livewire(ManageLeadOpportunities::class)
        ->searchTable('Unique Opportunity')
        ->assertCanSeeTableRecords([$opportunity1])
        ->assertCanNotSeeTableRecords([$opportunity2]);
});

it('can sort lead opportunities by customer name', function (): void {
    $customer1 = Customer::factory()->create(['name' => 'Alpha Customer']);
    $customer2 = Customer::factory()->create(['name' => 'Zulu Customer']);

    $opportunity1 = Opportunity::factory()->create([
        'customer_id' => $customer1->id,
        'stage' => OpportunityStage::Lead,
    ]);

    $opportunity2 = Opportunity::factory()->create([
        'customer_id' => $customer2->id,
        'stage' => OpportunityStage::Lead,
    ]);

    livewire(ManageLeadOpportunities::class)
        ->sortTable('customer.name')
        ->assertCanSeeTableRecords([$opportunity1, $opportunity2], inOrder: true)
        ->sortTable('customer.name', 'desc')
        ->assertCanSeeTableRecords([$opportunity2, $opportunity1], inOrder: true);
});

it('can sort lead opportunities by value', function (): void {
    $customer = Customer::factory()->create();

    $opportunity1 = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'value' => 1000,
    ]);

    $opportunity2 = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'value' => 5000,
    ]);

    livewire(ManageLeadOpportunities::class)
        ->sortTable('value')
        ->assertCanSeeTableRecords([$opportunity1, $opportunity2], inOrder: true)
        ->sortTable('value', 'desc')
        ->assertCanSeeTableRecords([$opportunity2, $opportunity1], inOrder: true);
});

it('displays correct table columns for lead opportunities', function (): void {
    $customer = Customer::factory()->create([
        'name' => 'Test Customer',
        'email' => 'test@example.com',
        'phone' => '+36-1-234-5678',
    ]);

    $user = User::factory()->create(['name' => 'Assigned User']);

    $opportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => OpportunityStage::Lead,
        'title' => 'Test Opportunity',
        'value' => 10000,
        'probability' => 75,
        'assigned_to' => $user->id,
    ]);

    livewire(ManageLeadOpportunities::class)
        ->assertCanSeeTableRecords([$opportunity])
        ->assertSee('Test Customer')
        ->assertSee('test@example.com')
        ->assertSee('+36-1-234-5678')
        ->assertSee('Test Opportunity')
        ->assertSee('75%')
        ->assertSee('Assigned User');
});

it('can render all opportunity stage pages', function (string $pageClass, OpportunityStage $stage): void {
    $customer = Customer::factory()->create();
    Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => $stage,
    ]);

    livewire($pageClass)
        ->assertSuccessful();
})->with([
    'Leads' => [ManageLeadOpportunities::class, OpportunityStage::Lead],
    'Qualified' => [ManageQualifiedOpportunities::class, OpportunityStage::Qualified],
    'Proposals' => [ManageProposalOpportunities::class, OpportunityStage::Proposal],
    'Negotiations' => [ManageNegotiationOpportunities::class, OpportunityStage::Negotiation],
    'Won' => [ManageWonOpportunities::class, OpportunityStage::Won],
    'Lost' => [ManageLostOpportunities::class, OpportunityStage::Lost],
]);

it('only shows opportunities for the correct stage', function (string $pageClass, OpportunityStage $correctStage, OpportunityStage $wrongStage): void {
    $customer = Customer::factory()->create();

    $correctOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => $correctStage,
    ]);

    $wrongOpportunity = Opportunity::factory()->create([
        'customer_id' => $customer->id,
        'stage' => $wrongStage,
    ]);

    livewire($pageClass)
        ->assertCanSeeTableRecords([$correctOpportunity])
        ->assertCanNotSeeTableRecords([$wrongOpportunity]);
})->with([
    'Leads' => [ManageLeadOpportunities::class, OpportunityStage::Lead, OpportunityStage::Won],
    'Qualified' => [ManageQualifiedOpportunities::class, OpportunityStage::Qualified, OpportunityStage::Lead],
    'Proposals' => [ManageProposalOpportunities::class, OpportunityStage::Proposal, OpportunityStage::Lead],
    'Negotiations' => [ManageNegotiationOpportunities::class, OpportunityStage::Negotiation, OpportunityStage::Lead],
    'Won' => [ManageWonOpportunities::class, OpportunityStage::Won, OpportunityStage::Lead],
    'Lost' => [ManageLostOpportunities::class, OpportunityStage::Lost, OpportunityStage::Lead],
]);

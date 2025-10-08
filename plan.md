# CRM Rendszer Fejlesztési Terv

## Projekt áttekintés

Laravel 12 alapú CRM rendszer fejlesztése, amely megfelel a GINOP PLUSZ-1.2.4-24 felhívás követelményeinek.

### Használt technológiák
- Laravel 12
- Filament v4 (Admin panel és UI komponensek)
- Livewire v3
- Pest v4 (tesztelés)
- Tailwind CSS v4
- PHP 8.4

## Adatbázis struktúra

### Főbb modellek és kapcsolatok

#### 1. Ügyfélkezelés (Customers)
```
- Customer (Ügyfél)
  - id
  - unique_identifier (egyedi azonosító)
  - name
  - type (B2B/B2C)
  - tax_number
  - timestamps

- CustomerContact (Kapcsolattartó)
  - id
  - customer_id
  - name
  - email
  - phone
  - position
  - is_primary
  - timestamps

- CustomerAddress (Cím)
  - id
  - customer_id
  - type (billing/shipping)
  - country
  - postal_code
  - city
  - street
  - is_default
  - timestamps

- CustomerAttribute (Egyedi jellemzők)
  - id
  - customer_id
  - attribute_key
  - attribute_value
  - timestamps
```

#### 2. Értékesítés (Sales)
```
- Campaign (Kampány)
  - id
  - name
  - description
  - start_date
  - end_date
  - status
  - target_audience_criteria (JSON)
  - timestamps

- CampaignResponse (Kampány válasz)
  - id
  - campaign_id
  - customer_id
  - response_type
  - notes
  - responded_at
  - timestamps

- Opportunity (Értékesítési lehetőség)
  - id
  - customer_id
  - title
  - description
  - value
  - probability
  - stage
  - expected_close_date
  - assigned_to
  - timestamps

- Quote (Ajánlat)
  - id
  - customer_id
  - opportunity_id
  - quote_number
  - issue_date
  - valid_until
  - status
  - subtotal
  - discount_amount
  - tax_amount
  - total
  - notes
  - timestamps

- QuoteItem (Ajánlat tétel)
  - id
  - quote_id
  - product_id
  - description
  - quantity
  - unit_price
  - discount_percent
  - discount_amount
  - tax_rate
  - total
  - timestamps
```

#### 3. Rendelés és számlázás
```
- Order (Rendelés)
  - id
  - customer_id
  - quote_id
  - order_number
  - order_date
  - status
  - subtotal
  - discount_amount
  - tax_amount
  - total
  - timestamps

- OrderItem (Rendelés tétel)
  - id
  - order_id
  - product_id
  - description
  - quantity
  - unit_price
  - discount_amount
  - tax_rate
  - total
  - timestamps

- Invoice (Számla)
  - id
  - customer_id
  - order_id
  - invoice_number
  - issue_date
  - due_date
  - status
  - subtotal
  - discount_amount
  - tax_amount
  - total
  - timestamps
```

#### 4. Kedvezmények
```
- Discount (Kedvezmény)
  - id
  - name
  - type (quantity/value_threshold/time_based/custom)
  - value_type (percentage/fixed)
  - value
  - min_quantity
  - min_value
  - valid_from
  - valid_until
  - customer_id (NULL = általános)
  - product_id (NULL = általános)
  - is_active
  - timestamps
```

#### 5. Ügyfélkapcsolat kezelés
```
- Interaction (Kapcsolatfelvétel)
  - id
  - customer_id
  - user_id
  - type (call/email/meeting/note)
  - subject
  - description
  - interaction_date
  - duration
  - next_action
  - next_action_date
  - timestamps

- Task (Feladat)
  - id
  - customer_id
  - assigned_to
  - assigned_by
  - title
  - description
  - priority
  - status
  - due_date
  - completed_at
  - timestamps

- Complaint (Reklamáció)
  - id
  - customer_id
  - order_id
  - reported_by
  - assigned_to
  - title
  - description
  - severity
  - status
  - resolution
  - reported_at
  - resolved_at
  - timestamps

- ComplaintEscalation (Eszkaláció)
  - id
  - complaint_id
  - escalated_to
  - escalated_by
  - reason
  - escalated_at
  - timestamps
```

#### 6. Kommunikáció
```
- Communication (Kommunikáció)
  - id
  - customer_id
  - channel (email/sms/chat/social)
  - direction (inbound/outbound)
  - subject
  - content
  - status
  - sent_at
  - delivered_at
  - read_at
  - timestamps

- ChatSession (Chat munkamenet)
  - id
  - customer_id
  - user_id
  - started_at
  - ended_at
  - status
  - timestamps

- ChatMessage (Chat üzenet)
  - id
  - chat_session_id
  - sender_type (customer/user/bot)
  - sender_id
  - message
  - timestamps
```

#### 7. Termékek
```
- Product (Termék)
  - id
  - name
  - sku
  - description
  - category_id
  - unit_price
  - tax_rate
  - is_active
  - timestamps

- ProductCategory (Termékkategória)
  - id
  - name
  - parent_id
  - timestamps
```

#### 8. Rendszer funkciók
```
- AuditLog (Napló)
  - id
  - user_id
  - model_type
  - model_id
  - action
  - old_values (JSON)
  - new_values (JSON)
  - ip_address
  - user_agent
  - timestamps

- BugReport (Hibabejelentés)
  - id
  - user_id
  - title
  - description
  - severity
  - status
  - assigned_to
  - resolved_at
  - timestamps

- Notification (Értesítés)
  - id
  - user_id
  - type
  - title
  - message
  - data (JSON)
  - read_at
  - timestamps
```

## Widgets és Dashboard

```
app/Filament/Widgets/
├── SalesStatsWidget (Értékesítési statisztikák)
├── CustomerActivityWidget (Ügyfél aktivitás)
├── CampaignPerformanceWidget (Kampány teljesítmény)
├── RevenueChartWidget (Bevétel grafikon)
├── TopCustomersWidget (Top ügyfelek)
├── UpcomingTasksWidget (Közelgő feladatok)
└── ComplaintStatusWidget (Reklamációk státusza)
```

## API Endpoints (app/Http/Controllers/Api/)

```
/api/v1/customers
├── GET    /              (lista)
├── POST   /              (létrehozás)
├── GET    /{id}          (részletek)
├── PUT    /{id}          (módosítás)
└── DELETE /{id}          (törlés)

/api/v1/campaigns
/api/v1/opportunities
/api/v1/quotes
/api/v1/orders
/api/v1/invoices
/api/v1/complaints
/api/v1/products
/api/v1/communications
```

## Feladatok ütemezése (Laravel Scheduler)

```
app/Console/Commands/
├── SendCampaignEmailsCommand
├── CheckOverdueInvoicesCommand
├── GenerateSalesReportsCommand
├── CleanupOldLogsCommand
└── BackupDatabaseCommand
```

## Tesztelési stratégia

### Feature tesztek (tests/Feature/)
```
- CustomerManagementTest
- CampaignManagementTest
- OpportunityManagementTest
- QuoteGenerationTest
- OrderProcessingTest
- ComplaintHandlingTest
- DiscountApplicationTest
- ReportGenerationTest
- ApiAuthenticationTest
```

### Unit tesztek (tests/Unit/)
```
- DiscountCalculationTest
- QuotePricingTest
- CustomerValidationTest
- CampaignAudienceFilterTest
```

## Biztonsági funkciók

### Autentikáció és Authorizáció
- Laravel Sanctum API tokenek
- Filament jogosultság-kezelés
- Role-based access control (RBAC)
- Kétfaktoros authentikáció (2FA)

### Policies (app/Policies/)
```
- CustomerPolicy
- CampaignPolicy
- OpportunityPolicy
- QuotePolicy
- OrderPolicy
- ComplaintPolicy
```

## Integrációk

### Email integráció
- Laravel Mail + Mailables
- Email templates (resources/views/emails/)
- Queue-ba helyezett email küldés

### Exportálás
- Excel export (Laravel Excel)
- PDF generálás (DomPDF/Snappy)
- CSV export

### Külső API integrációk
- Social Media API-k (Facebook, Twitter)
- SMS gateway integráció
- Accounting software integration (API-kon keresztül)

## Telepítési és üzemeltetési követelmények

### Környezet
- PHP 8.4+
- MySQL 8.0+ / PostgreSQL 14+
- Redis (cache és queue)
- Node.js 18+ (frontend build)

### Biztonsági mentés
- Napi automatikus adatbázis backup
- File storage backup
- Disaster Recovery Plan dokumentáció

### Monitoring és logging
- Laravel Log
- Application Performance Monitoring
- Error tracking (pl. Sentry)

### Dokumentáció
- Felhasználói kézikönyv (magyar)
- Adminisztrátori kézikönyv (magyar)
- API dokumentáció (OpenAPI/Swagger)
- Deployment útmutató
- Verziókezelési stratégia

## Fejlesztési fázisok

### 1. Fázis - Alapok (1-2 hét)
- Projekt inicializálás
- Adatbázis migráció és seeders
- User management és autentikáció
- Alapvető Filament panel beállítás

### 2. Fázis - Ügyfélkezelés (2-3 hét)
- Customer CRUD
- Contact és Address kezelés
- Customer attributes
- Audit logging

### 3. Fázis - Értékesítés (3-4 hét)
- Campaign management
- Opportunity tracking
- Quote generation
- Order processing
- Invoice generation
- Discount system

### 4. Fázis - Kommunikáció (2-3 hét)
- Interaction logging
- Task management
- Email integration
- SMS integration
- Chat system

### 5. Fázis - Ügyfélszolgálat (2 hét)
- Complaint management
- Escalation workflow
- Customer feedback

### 6. Fázis - Jelentések és analitika (2 hét)
- Dashboard widgets
- Custom reports
- Data visualization
- Export funkcionalitás

### 7. Fázis - API és Integrációk (2 hét)
- REST API
- External integrations
- Webhook support

### 8. Fázis - Tesztelés és dokumentáció (2-3 hét)
- Feature és unit tesztek
- Felhasználói dokumentáció
- Adminisztrátori dokumentáció
- API dokumentáció

### 9. Fázis - Élesítés (1 hét)
- Production deployment
- Adatmigráció
- Felhasználói képzés
- Rendszer átadás

## Következő lépések

1. Adatbázis migrációk elkészítése
2. Model osztályok létrehozása factory-kkal és seeder-ekkel
3. Filament Resources kialakítása
4. Policy-k és permission rendszer implementálása
5. Alapvető tesztek írása
6. API endpoints kialakítása
7. Dokumentáció készítése

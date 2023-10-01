<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Tests\Sprinkle\Pastries;

use Illuminate\Database\Schema\Builder;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Sprinkle\Pastries\Database\Migrations\V100\PastriesPermissions;
use UserFrosting\Sprinkle\Pastries\Database\Migrations\V100\PastriesTable;
use UserFrosting\Sprinkle\Pastries\Database\Models\Pastries;
use UserFrosting\Sprinkle\Pastries\MyApp;
use UserFrosting\Testing\TestCase;

/**
 * Tests for PastriesController Class.
 */
class PastriesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithTestUser;

    // Use our Sprinkle to test
    protected string $mainSprinkle = MyApp::class;

    /**
     * Setup test database
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    /**
     * Make sure  database migrations are working, and be brought down.
     * Migrate up has already been done by the RefreshDatabase trait method.
     */
    public function testMigrations(): void
    {
        /** @var Builder */
        $builder = $this->ci->get(Builder::class);

        // Make sure Pastries exists
        $this->assertTrue($builder->hasTable('pastries'));
        $this->assertSame(3, Pastries::count());

        // Make sure permissions exists
        $this->assertNotNull(Permission::where('slug', 'see_pastries')->first());
        $this->assertNotNull(Permission::where('slug', 'see_pastry_origin')->first());

        // Migration down data migration
        $this->ci->get(PastriesPermissions::class)->down();

        // Make sure permissions were removed
        $this->assertNull(Permission::where('slug', 'see_pastries')->first());
        $this->assertNull(Permission::where('slug', 'see_pastry_origin')->first());

        // Migration down table migration, and make sure table doesn't exist anymore.
        $this->ci->get(PastriesTable::class)->down();
        $this->assertFalse($builder->hasTable('pastries'));

        // Run back on, to avoid conflict with further tests
        $this->ci->get(PastriesTable::class)->up();
        $this->ci->get(PastriesPermissions::class)->up();
    }

    /**
     * Test `/pastries` page. AuthGuard should redirect to login page.
     */
    public function testPageNoAuth(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/pastries');
        $response = $this->handleRequest($request);

        // Asserts
        $this->assertResponseStatus(302, $response);
        $this->assertJsonResponse('Login Required', $response, 'title');
    }

    /**
     * Test `/pastries` page. User doesn't have `see_pastries` permission,
     * ForbiddenException will be thrown.
     */
    public function testPageNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/pastries');
        $response = $this->handleRequest($request);

        // Asserts
        $this->assertResponseStatus(403, $response);
        $this->assertJsonResponse('Access Denied', $response, 'title');
    }

    /**
     * Test `/pastries` page.
     */
    public function testPage(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['see_pastries']);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/pastries');
        $response = $this->handleRequest($request);

        // Asserts
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
        $this->assertStringContainsString('Apple strudel', (string) $response->getBody());
    }
}

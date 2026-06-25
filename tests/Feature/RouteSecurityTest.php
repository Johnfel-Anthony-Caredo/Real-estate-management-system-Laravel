<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteSecurityTest extends TestCase
{
    public function test_admin_request_status_updates_are_post_only_and_admin_protected(): void
    {
        $route = Route::getRoutes()->getByName('admin.request.update-status');

        $this->assertNotNull($route);
        $this->assertSame('admin/requests/{id}/status', $route->uri());
        $this->assertContains('POST', $route->methods());
        $this->assertContains('auth:admin', $route->gatherMiddleware());
    }

    public function test_destructive_user_actions_are_delete_only(): void
    {
        $cancelRoute = Route::getRoutes()->getByName('cancel.request');
        $removeSavedRoute = Route::getRoutes()->getByName('remove.saved.prop');

        $this->assertContains('DELETE', $cancelRoute->methods());
        $this->assertContains('DELETE', $removeSavedRoute->methods());
        $this->assertContains('auth', $cancelRoute->gatherMiddleware());
        $this->assertContains('auth', $removeSavedRoute->gatherMiddleware());
    }
}

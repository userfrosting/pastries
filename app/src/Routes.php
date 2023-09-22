<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Pastries\Controller\PastriesController;

class Routes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/pastries', function (RouteCollectorProxy $group) {
            $group->get('', PastriesController::class)->setName('pastries');
        })->add(AuthGuard::class);
        $app->redirect('/', '/dashboard', 301)->setName('index');
    }
}
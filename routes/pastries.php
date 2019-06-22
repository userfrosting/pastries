<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

use UserFrosting\Sprinkle\Core\Util\NoCache;

$app->group('/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:pageList')
         ->setName('pastries');
})->add('authGuard');

// These routes will be for any methods that retrieve/modify data from the database.
$app->group('/api/pastries', function () {
    $this->delete('/p/{name}', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:delete');

    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getList');

    $this->post('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:create');

    $this->put('/p/{name}', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:updateInfo');
})->add('authGuard')->add(new NoCache());

// These routes will be used to access any modals
$app->group('/modals/pastries', function () {
    $this->get('/create', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalCreate');

    $this->get('/confirm-delete', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalDelete');

    $this->get('/edit', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalEdit');
})->add('authGuard');

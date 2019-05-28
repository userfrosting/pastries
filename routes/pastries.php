<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

$app->group('/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:displayPage')
         ->setName('pastries');
})->add('authGuard');

$app->group('/api/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getList');
    $this->post('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:create');
})->add('authGuard');

$app->group('/modals/pastries', function () {
    $this->get('/create', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalCreate');
    $this->get('/delete', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalDelete');
    $this->get('/edit', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalEdit');
})->add('authGuard');

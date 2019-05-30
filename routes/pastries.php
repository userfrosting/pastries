<?php

$app->group('/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:pagePastries')
         ->setName('pastries');
})->add('authGuard');

$app->group('/api/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getList');

    $this->post('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:create');

    $this->post('/p/{name}', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:updateInfo');

    $this->delete('/p/{name}', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:delete');
})->add('authGuard');

$app->group('/modals/pastries', function () {
    $this->get('/create', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalCreate');

    $this->get('/confirm-delete', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalDelete');

    $this->get('/edit', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:getModalEdit');
})->add('authGuard');

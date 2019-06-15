<?php

/**
 * Routes for pastries related pages.
 */
$app->group('/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:displayPage')
         ->setName('pastries');
})->add('authGuard');

<?php

/*
 * UserFrosting Pastries Sprinkle
 *
 * @link      https://github.com/userfrosting/pastries
 * @copyright Copyright (c) 2023 Louis Charette
 * @license   https://github.com/userfrosting/pastries/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Pastries\Database\Models\Pastries;

class PastriesPageAction
{
    public function __invoke(
        Response $response,
        Authenticator $authenticator,
        Twig $view,
    ): Response {
        // Access-controlled page
        if (!$authenticator->checkAccess('see_pastries')) {
            throw new ForbiddenException();
        }

        $pastries = Pastries::all();

        return $view->render($response, 'pages/pastries.html.twig', [
            'pastries' => $pastries,
        ]);
    }
}

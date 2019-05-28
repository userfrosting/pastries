<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Pastries\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Pastries\Database\Models\Pastries;
use UserFrosting\Sprinkle\Pastries\Sprunje\PastrySprunje;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;

class PastriesController extends SimpleController
{
    public function create(Request $request, Response $response, $args)
    {
        // Get POST parameters: name, origin, description
        $params = $request->getParsedBody();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'see_pastries')) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        // Load the request schema
        $schema = new RequestSchema('schema://requests/pastry/create.yaml');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        $error = false;

        // Validate request data
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            $ms->addValidationErrors($validator);
            $error = true;
        }
        Debug::debug('var data');
        Debug::debug(print_r($data, true));

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // All checks passed!  log events/activities and create pastry
        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($data, $ms, $currentUser) {
            // Create the pastry
            $pastry = new Pastries();

            $pastry->name = $data['name'];
            $pastry->description = $data['description'];
            $pastry->origin = $data['origin'];

            // Store new group to database
            $pastry->save();

            // Create activity record
            $this->ci->userActivityLogger->info("User {$currentUser->user_name} created pastry {$pastry->name}.", [
              'type'    => 'group_create',
              'user_id' => $currentUser->id
          ]);

            $ms->addMessageTranslated('success', 'New pastry created!', $data);
        });

        return $response->withJson([], 200);
    }

    public function displayPage(Request $request, Response $response, $args)
    {
        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'see_pastries')) {
            throw new ForbiddenException();
        }

        $pastries = Pastries::all();

        //Debug::debug($pastries);

        return $this->ci->view->render($response, 'pages/pastries.html.twig', [
            'pastries' => $pastries
        ]);
    }

    public function getList(Request $request, Response $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'see_pastries')) {
            throw new ForbiddenException();
        }
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = new PastrySprunje($classMapper, $params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    public function getModalCreate(Request $request, Response $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        /** @var \UserFrosting\I18n\MessageTranslator $translator */
        $translator = $this->ci->translator;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'see_pastries')) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        // Create a dummy pastry to prepopulate fields
        $pastry = new Pastries();

        $pastry->icon = 'fa fa-cutlery';

        $fields = [
            'hidden'   => [],
            'disabled' => []
        ];

        return $this->ci->view->render($response, 'modals/pastries.html.twig', [
            'pastry' => $pastry,
            'form'   => [
                'action'      => 'api/pastries',
                'method'      => 'POST',
                'fields'      => $fields,
                'submit_text' => 'Create'
            ]
        ]);
    }
}

<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI\Endpoints;

use PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI\Controllers\AbstractRESTController;

use function add_action;

abstract class AbstractRESTAPIEndpointManager
{
    public function __construct()
    {
        $this->initialize();
    }

    public function initialize(): void
    {
        if (!class_exists('WP_REST_Server')) {
            return;
        }

        add_action('rest_api_init', \Closure::fromCallable([$this, 'registerRoutes']));
    }

    public function registerRoutes(): void
    {
        foreach ($this->getControllers() as $controller) {
            $controller->register_routes();
        }
    }

    /**
     * @return AbstractRESTController[]
     */
    abstract protected function getControllers(): array;
}

<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI\Controllers;

use GraphQLAPI\GraphQLAPI\Facades\Registries\ModuleRegistryFacade;
use WP_Error;

trait WithModuleParamRESTControllerTrait
{
    /**
     * @return array<string,mixed>
     */
    protected function getModuleIDParamArgs(): array
    {
        return [
            'description' => __('Module ID', 'graphql-api-testing'),
            'type' => 'string',
            'required' => true,
            'validate_callback' => \Closure::fromCallable([$this, 'validateModule']),
        ];
    }

    /**
     * Validate there is a module with this ID
     * @return bool|\WP_Error
     * @param string $moduleID
     */
    protected function validateModule($moduleID)
    {
        $module = $this->getModuleByID($moduleID);
        if ($module === null) {
            return new WP_Error(
                '1',
                sprintf(
                    __('There is no module with ID \'%s\'', 'graphql-api'),
                    $moduleID
                ),
                [
                    'moduleID' => $moduleID,
                ]
            );
        }
        return true;
    }

    /**
     * @param string $moduleID
     */
    public function getModuleByID($moduleID): ?string
    {
        $moduleRegistry = ModuleRegistryFacade::getInstance();
        $modules = $moduleRegistry->getAllModules();
        foreach ($modules as $module) {
            $moduleResolver = $moduleRegistry->getModuleResolver($module);
            if ($moduleID === $moduleResolver->getID($module)) {
                return $module;
            }
        }
        return null;
    }
}

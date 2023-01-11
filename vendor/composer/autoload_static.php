<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c6afcd2779d25b1656753e7c1018edd
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\' => 39,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\Constants\\CustomHeaders' => __DIR__ . '/../..' . '/src/Constants/CustomHeaders.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\Environment' => __DIR__ . '/../..' . '/src/Environment.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\Plugin' => __DIR__ . '/../..' . '/src/Plugin.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Constants\\ParamValues' => __DIR__ . '/../..' . '/src/RESTAPI/Constants/ParamValues.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Constants\\Params' => __DIR__ . '/../..' . '/src/RESTAPI/Constants/Params.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Constants\\ResponseStatus' => __DIR__ . '/../..' . '/src/RESTAPI/Constants/ResponseStatus.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Constants\\Roles' => __DIR__ . '/../..' . '/src/RESTAPI/Constants/Roles.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\AbstractAdminRESTController' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/AbstractAdminRESTController.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\AbstractRESTController' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/AbstractRESTController.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\CPTBlockAttributesAdminRESTController' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/CPTBlockAttributesAdminRESTController.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\ModuleSettingsAdminRESTController' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/ModuleSettingsAdminRESTController.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\ModulesAdminRESTController' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/ModulesAdminRESTController.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\WithFlushRewriteRulesRESTControllerTrait' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/WithFlushRewriteRulesRESTControllerTrait.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Controllers\\WithModuleParamRESTControllerTrait' => __DIR__ . '/../..' . '/src/RESTAPI/Controllers/WithModuleParamRESTControllerTrait.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Endpoints\\AbstractRESTAPIEndpointManager' => __DIR__ . '/../..' . '/src/RESTAPI/Endpoints/AbstractRESTAPIEndpointManager.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Endpoints\\AdminRESTAPIEndpointManager' => __DIR__ . '/../..' . '/src/RESTAPI/Endpoints/AdminRESTAPIEndpointManager.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\RESTResponse' => __DIR__ . '/../..' . '/src/RESTAPI/RESTResponse.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\RESTAPI\\Response\\ResponseKeys' => __DIR__ . '/../..' . '/src/RESTAPI/Response/ResponseKeys.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\Settings\\Options' => __DIR__ . '/../..' . '/src/Settings/Options.php',
        'PHPUnitForGraphQLAPI\\GraphQLAPITesting\\Utilities\\CustomHeaderAppender' => __DIR__ . '/../..' . '/src/Utilities/CustomHeaderAppender.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c6afcd2779d25b1656753e7c1018edd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c6afcd2779d25b1656753e7c1018edd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4c6afcd2779d25b1656753e7c1018edd::$classMap;

        }, null, ClassLoader::class);
    }
}
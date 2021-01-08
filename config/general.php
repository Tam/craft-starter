<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\helpers\App;

return [
    // Global settings
    '*' => [
        'defaultWeekStartDay' => 1,
        'omitScriptNameInUrls' => true,
        'cpTrigger' => 'super',
        'securityKey' => getenv('SECURITY_KEY'),
        'useProjectConfigFile' => true,
        'enableGraphQlCaching' => true,
        'enableGql' => false,
    ],

    // Dev environment settings
    'dev' => [
        'devMode' => true,
        'testToEmailAddress' => getenv('TEST_EMAIL'),
        'enableGraphQlCaching' => false,
        'disallowRobots' => true,
    ],

    // Staging environment settings
    'staging' => [
        'allowAdminChanges' => false,
        'disallowRobots' => true,
    ],

    // Production environment settings
    'production' => [
        'allowAdminChanges' => false,
    ],
];

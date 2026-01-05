<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Event Reservation System API Documentation',
                'description' => 'A complete event reservation system built with Laravel 11, Sanctum authentication, and Filament admin panel.<br><br>This documentation explains all API endpoints in English and allows direct testing.',
                'version' => '1.0.0',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app'),
                    base_path('app/OpenApi'),
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],
        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => env('L5_SWAGGER_BASE_PATH', null),
            'excludes' => [],
        ],
        'scanOptions' => [
            'default_processors_configuration' => [],
            'analyser' => null,
            'analysis' => null,
            'processors' => [],
            'pattern' => null,
            'exclude' => [],
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', \L5Swagger\Generator::OPEN_API_DEFAULT_SPEC_VERSION),
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'sanctum' => [
                    'type' => 'apiKey',
                    'description' => 'Enter your Sanctum token in Bearer <token> format',
                    'name' => 'Authorization',
                    'in' => 'header',
                ],
            ],
            'security' => [
                ['sanctum' => []],
            ],
        ],
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', true),
        'generate_yaml_copy' => false,
        'proxy' => false,
        'additional_config_url' => null,
        'operations_sort' => 'alpha',
        'validator_url' => null,
        'ui' => [
            'display' => [
                'dark_mode' => env('L5_SWAGGER_UI_DARK_MODE', false),
                'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
                'filter' => true,
            ],
            'authorization' => [
                'persist_authorization' => true,
                'oauth2' => [
                    'use_pkce_with_authorization_code_grant' => false,
                ],
            ],
        ],
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost'),
        ],
        'swagger_ui_config' => [
            'layout' => "StandaloneLayout",
            'direction' => "ltr",
            'lang' => "en",
            'persistAuthorization' => true,
            'displayOperationId' => false,
            'defaultModelsExpandDepth' => 1,
            'defaultModelExpandDepth' => 1,
            'defaultModelRendering' => 'example',
            'displayRequestDuration' => true,
            'docExpansion' => 'none',
            'filter' => true,
            'maxDisplayedTags' => -1,
            'showExtensions' => true,
            'showCommonExtensions' => true,
            'deepLinking' => true,
            'customCss' => "
                html, body {
                    direction: ltr !important;
                    text-align: left !important;
                    font-family: 'Inter', system-ui, sans-serif !important;
                }
                .swagger-ui {
                    direction: ltr !important;
                    text-align: left !important;
                }
                .swagger-ui .info {
                    margin: 50px 0;
                    text-align: left;
                }
                .swagger-ui .info hgroup {
                    text-align: left;
                }
                .swagger-ui .opblock {
                    direction: ltr;
                }
                .swagger-ui .opblock-summary-description {
                    text-align: left;
                }
                .swagger-ui .parameter__name {
                    text-align: left;
                }
                .swagger-ui .table {
                    direction: ltr;
                }
                .swagger-ui select {
                    direction: ltr;
                    text-align: left;
                    text-align-last: left;
                }
                .swagger-ui .model {
                    direction: ltr;
                }
                .swagger-ui .responses-table {
                    direction: ltr;
                }
                .swagger-ui .topbar {
                    direction: ltr;
                }
                .swagger-ui .auth-wrapper {
                    direction: ltr;
                }
            ",
        ],
    ],
];

<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | This option controls the default language that will be used by the
    | translation service provider. You are free to set this value to any
    | of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'zh_CN'),

    /*
    |--------------------------------------------------------------------------
    | Fallback Language
    |--------------------------------------------------------------------------
    |
    | This option may be used to specify a fallback locale when the current one
    | is not available. You may specify as many fallback locales as you wish,
    | and they will be used in the order they are listed in this array.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Translation File Path
    |--------------------------------------------------------------------------
    |
    | This option defines where the translation files are stored.
    |
    */

    'path' => BASE_PATH . '/storage/languages',
];
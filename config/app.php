<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Australia/Sydney',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',


    //GDPR encryption keys
    'gdpr_secret_key' => env('GDPR_SECRET_KEY'),

    'gdpr_secret_iv' => env('GDPR_SECRET_IV'),

    'tokenex_secret_key' => env('TOKENEX_SECRET_KEY'),

    'tokenex_secret_iv' => env('TOKENEX_SECRET_IV'),


    'upload_plan_rates_path' => env('UPLOAD_PLAN_RATE_PATH'),

    'upload_plan_path' => env('UPLOAD_PLAN_PATH'),

    'gas_upload_plan_rates_path' => env('GAS_UPLOAD_PLAN_RATE_PATH'),
    'lpg_upload_plan_rates_path' => env('LPG_UPLOAD_PLAN_RATE_PATH'),


    'gas_upload_plan_path' => env('GAS_UPLOAD_PLAN_PATH'),
    'lpg_upload_plan_path' => env('LPG_UPLOAD_PLAN_PATH'),
    'mobile_upload_plan_path' => env('MOBILE_UPLOAD_PLAN_PATH'),

    'tariff_upload_sheet_path' => env('TARIFF_UPLOAD_SHEET_PATH'),


    'ea_okta_token' => env('EA_TOKEN'),

    'ea_okta_client_id' => env('EA_CLIENT_ID'),

    'ea_okta_client_secret' => env('EA_CLIENT_SECRET'),

    'ea_okta_authorization_url' => env('EA_OKTA_AUTHORIZATION_URL'),

    'ea_sale_submission_url' => env('EA_SALE_SUBMISSION_URL'),

    'x_ea_env' => env('X_EA_Env'),

    'flux_token' => env('FLUX_TOKEN'),

    'flux_url' => env('FLUX_URL'),

    'ovo_api_key' => env('OVO_API_KEY'),

    'ovo_broker_url' => env('OVO_BROKER_URL'),

    'red_lumo_api_url' => env('RED_LUMO_API_URL'),

    'red_lumo_api_token' => env('RED_LUMO_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        // App\Providers\CimetPasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Carbon' => 'Carbon\Carbon',


    ],

    'master_tab_manage_section' => [1 => 'personal_details', 2 => 'connection_details', 3 => 'identification_details', 4 => 'employment_details', 5 => 'connection_address', 6 => 'billing_and_delivery_address'],

    // 'personal_details' => [1 => 'Name', 2 => 'Email', 3 => 'Phone Number', 4 => 'Alternative Phone Number', 5 => 'Date of Birth'],
    // The 1st 3 keys are removed as per instruction given by QA ParamDeep Singh.
    'personal_details' => [4 => 'Alternative Phone Number', 5 => 'Date of Birth'],

    'connection_details' => [1 => 'Already have an account with the provider', 2 => 'Keep existing phone number'],

    $primaryIdentification = ['Primary Identification' => array(1 => 'Drivers License', 2 => 'Australian Passport', 3 => 'Medicare Card', 4 => 'Foreign Passport', 5 => 'Concession Card')],
    $secondaryIdentification = ['Secondary Identification' => array(1 => 'Drivers License', 2 => 'Australian Passport', 3 => 'Medicare Card', 4 => 'Foreign Passport', 5 => 'Concession Card')],

    // 'identification_details'=>[1=>$primaryIdentification,2=>$secondaryIdentification],

    'identification_details'=>[1 =>'Drivers License',2 =>'Australian Passport',3=>'Medicare Card',4=>'Foreign Passport',5=>'Concession Card'],

    'employment_details' => [1 => 'Industry', 2 => 'Occupation type', 3 => 'Employment Status', 4 => 'Minimum time of employment', 5 => 'Do you have Credit card'],

    'connection_address' => [1 => 'Minimum residential status', 2 => 'Connection delivery date'],

    $billingAddress = ['Billing Address' => array(1 => 'Email', 2 => 'Current Address', 3 => 'Other Address')],
    $deliveryAddress = ['Delivery Address' => array(1 => 'Current Address', 2 => 'Other address')],

    //'billing_and_delivery_address'=>[1=>$billingAddress,2=>$deliveryAddress],

    'billing_address'=>[1=>'Email',2=>'Current Address',3=>'Other Address',4 => 'PO Box address'],
    'delivery_address'=>[1=>'Current Address',2=>'Other Address' , 3 => 'PO Box address'],

    'terms_and_conditions_types'=>[
        1 =>'Common Plan',
        2 =>'Promo Plan',
        3 =>'CIS',
        4 =>'Credit Check',
        5 =>'Direct Debit',
        6 =>'Porting and Transfer',
        7 =>'Privacy Policy',
        8 =>'Fairgo Policy',
        9 =>'Why Us?'
    ],
    'operating_system' =>['iOS' => 'iOS','Android' => 'Android','Symbian'=>'Symbian','Windows'=>'Windows','Blackberry'=>'Blackberry','Others'=>'Others'],

];

<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-05-09 18:08:24 --- EMERGENCY: Kohana_Exception [ 0 ]: Cannot load payment provider "company"! Module is not registered! ~ MODPATH/akosoft/site_payment/classes/payment.php [ 162 ] in /home/emwoo/websites/proffer/private/modules/akosoft/site_payment/classes/controller/ajax/payment.php:22
2016-05-09 18:08:24 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/site_payment/classes/controller/ajax/payment.php(22): payment::load_provider('company')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Ajax_Payment->action_get_payment_info()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Ajax_Payment))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/site_payment/classes/controller/ajax/payment.php:22
2016-05-09 19:57:49 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Arr::is_assoc() must be of the type array, integer given, called in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php on line 439 and defined ~ SYSPATH/classes/Kohana/Arr.php [ 30 ] in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php:30
2016-05-09 19:57:49 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php(30): Kohana_Core::error_handler(4096, 'Argument 1 pass...', '/home/emwoo/web...', 30, Array)
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php(439): Kohana_Arr::is_assoc(1)
#2 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/reader/kohana.php(89): Kohana_Arr::merge(Array, 1)
#3 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/reader/kohana.php(42): I18n_Reader_Kohana->load('pl')
#4 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(129): I18n_Reader_Kohana->get('bauth/frontend/...', 'pl')
#5 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(80): I18n_Core->get('bauth/frontend/...', 'pl')
#6 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(114): I18n_Core->form('bauth/frontend/...', 'other', 'pl')
#7 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(56): I18n_Core->plural('bauth/frontend/...', 0, 'pl')
#8 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/init.php(38): I18n_Core->translate('bauth/frontend/...', 0, NULL, 'pl')
#9 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Route.php(136): ___('bauth/frontend/...')
#10 /home/emwoo/websites/proffer/private/modules/akosoft/users/init.php(15): Route::set('bauth/frontend/...', true)
#11 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Kohana.php(244): require_once('/home/emwoo/web...')
#12 /home/emwoo/websites/proffer/private/modules/akosoft/modules/classes/modules.php(158): Kohana::init_modules(Array)
#13 /home/emwoo/websites/proffer/private/modules/akosoft/core/bootstrap.php(37): Modules::load()
#14 /home/emwoo/websites/proffer/private/application/bootstrap.php(136): require_once('/home/emwoo/web...')
#15 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#16 {main} in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php:30
2016-05-09 20:08:02 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected 't' (T_STRING), expecting ')' ~ MODPATH/akosoft/site_frontend/i18n/pl.php [ 237 ] in file:line
2016-05-09 20:08:02 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2016-05-09 20:08:04 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected 't' (T_STRING), expecting ')' ~ MODPATH/akosoft/site_frontend/i18n/pl.php [ 237 ] in file:line
2016-05-09 20:08:04 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2016-05-09 20:08:06 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected 't' (T_STRING), expecting ')' ~ MODPATH/akosoft/site_frontend/i18n/pl.php [ 237 ] in file:line
2016-05-09 20:08:06 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2016-05-09 20:08:09 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected 't' (T_STRING), expecting ')' ~ MODPATH/akosoft/site_frontend/i18n/pl.php [ 237 ] in file:line
2016-05-09 20:08:09 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2016-05-09 20:47:09 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Arr::is_assoc() must be of the type array, integer given, called in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php on line 439 and defined ~ SYSPATH/classes/Kohana/Arr.php [ 30 ] in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php:30
2016-05-09 20:47:09 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php(30): Kohana_Core::error_handler(4096, 'Argument 1 pass...', '/home/emwoo/web...', 30, Array)
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php(439): Kohana_Arr::is_assoc(1)
#2 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/reader/kohana.php(89): Kohana_Arr::merge(Array, 1)
#3 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/reader/kohana.php(42): I18n_Reader_Kohana->load('pl')
#4 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(129): I18n_Reader_Kohana->get('bauth/frontend/...', 'pl')
#5 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(80): I18n_Core->get('bauth/frontend/...', 'pl')
#6 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(114): I18n_Core->form('bauth/frontend/...', 'other', 'pl')
#7 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/classes/i18n/core.php(56): I18n_Core->plural('bauth/frontend/...', 0, 'pl')
#8 /home/emwoo/websites/proffer/private/modules/kohana/I18n_Plural/init.php(38): I18n_Core->translate('bauth/frontend/...', 0, NULL, 'pl')
#9 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Route.php(136): ___('bauth/frontend/...')
#10 /home/emwoo/websites/proffer/private/modules/akosoft/users/init.php(15): Route::set('bauth/frontend/...', true)
#11 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Kohana.php(244): require_once('/home/emwoo/web...')
#12 /home/emwoo/websites/proffer/private/modules/akosoft/modules/classes/modules.php(158): Kohana::init_modules(Array)
#13 /home/emwoo/websites/proffer/private/modules/akosoft/core/bootstrap.php(37): Modules::load()
#14 /home/emwoo/websites/proffer/private/application/bootstrap.php(136): require_once('/home/emwoo/web...')
#15 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#16 {main} in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php:30
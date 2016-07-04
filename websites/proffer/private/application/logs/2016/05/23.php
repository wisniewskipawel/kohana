<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-05-23 13:05:17 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:05:17 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:04 --- EMERGENCY: Swift_TransportException [ 0 ]: Failed to authenticate on SMTP server with username "emwoo.atthouse.pl" using 2 possible authenticators ~ MODPATH/akosoft/core/vendor/swift/classes/Swift/Transport/Esmtp/AuthHandler.php [ 184 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php:312
2016-05-23 13:06:04 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php(312): Swift_Transport_Esmtp_AuthHandler->afterEhlo(Object(Swift_SmtpTransport))
#1 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/AbstractSmtpTransport.php(120): Swift_Transport_EsmtpTransport->_doHeloCommand()
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Mailer.php(80): Swift_Transport_AbstractSmtpTransport->start()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Email.php(89): Swift_Mailer->send(Object(Swift_Message))
#4 /home/emwoo/websites/proffer/private/modules/akosoft/emails/classes/model/email.php(29): Email::send('the80gemi@wp.pl', 'Kupon promocyjn...', '<p>Witaj,</p>\n\n...', Array)
#5 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(1150): Model_Email->send('the80gemi@wp.pl', Array)
#6 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/controller/frontend/offers.php(725): Model_Offer->send_coupons(Array)
#7 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Frontend_Offers->action_send_coupon()
#8 [internal function]: Kohana_Controller->execute()
#9 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Frontend_Offers))
#10 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#11 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#12 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#13 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php:312
2016-05-23 13:06:23 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:23 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:24 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:24 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:26 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:26 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:06:48 --- EMERGENCY: Swift_TransportException [ 0 ]: Failed to authenticate on SMTP server with username "emwoo.atthouse.pl" using 2 possible authenticators ~ MODPATH/akosoft/core/vendor/swift/classes/Swift/Transport/Esmtp/AuthHandler.php [ 184 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php:312
2016-05-23 13:06:48 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php(312): Swift_Transport_Esmtp_AuthHandler->afterEhlo(Object(Swift_SmtpTransport))
#1 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/AbstractSmtpTransport.php(120): Swift_Transport_EsmtpTransport->_doHeloCommand()
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Mailer.php(80): Swift_Transport_AbstractSmtpTransport->start()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Email.php(89): Swift_Mailer->send(Object(Swift_Message))
#4 /home/emwoo/websites/proffer/private/modules/akosoft/emails/classes/model/email.php(29): Email::send('emwoo@live.ie', 'Kupon promocyjn...', '<p>Witaj,</p>\n\n...', Array)
#5 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(1150): Model_Email->send('emwoo@live.ie', Array)
#6 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/controller/frontend/offers.php(725): Model_Offer->send_coupons(Array)
#7 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Frontend_Offers->action_send_coupon()
#8 [internal function]: Kohana_Controller->execute()
#9 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Frontend_Offers))
#10 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#11 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#12 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#13 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/vendor/swift/classes/Swift/Transport/EsmtpTransport.php:312
2016-05-23 13:28:18 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:28:18 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:28:21 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:28:21 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:23 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:23 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:36 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:36 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:38 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-23 13:31:38 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
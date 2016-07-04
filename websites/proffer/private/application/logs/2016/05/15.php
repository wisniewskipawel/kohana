<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-05-15 17:08:10 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:08:10 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:08:54 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:08:54 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:11:41 --- EMERGENCY: ErrorException [ 2 ]: move_uploaded_file(/home/emwoo/websites/proffer/_upload/573891ad58e18ZGFkNTUwYTBhYjI0ZGM2ZjUxODUzMGY1ZDc4MjAyMTNV9CWyhXAvmLil8R6tJMpLaHR0cDovL21lZGlhLmFkc2ltZy5jb20vYTNkYWI2NDQyYTI3M2EyOWQ3YmM3ZDBkNmQ2MWMxYTRiNzI0ZGEyN2UxODRhYjM3MmYwY2ExNmViMmZiODNmMC5qcGd8fHx8fHw3MDB4NTI1fGh0dHA6Ly93d3cuYWR2ZXJ0cy5pZS9zdGF0.jpg): failed to open stream: Za długa nazwa pliku ~ SYSPATH/classes/Kohana/Upload.php [ 87 ] in file:line
2016-05-15 17:11:41 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(2, 'move_uploaded_f...', '/home/emwoo/web...', 87, Array)
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Upload.php(87): move_uploaded_file('/tmp/phpTGDPsD', '/home/emwoo/web...')
#2 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(405): Kohana_Upload::save(Array)
#3 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(368): Model_Offer->add_image(Array)
#4 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/controller/frontend/offers.php(520): Model_Offer->add_offer(Array, Array)
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Frontend_Offers->action_add()
#6 [internal function]: Kohana_Controller->execute()
#7 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Frontend_Offers))
#8 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#10 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#11 {main} in file:line
2016-05-15 17:11:49 --- EMERGENCY: ErrorException [ 2 ]: move_uploaded_file(/home/emwoo/websites/proffer/_upload/573891b575850ZGFkNTUwYTBhYjI0ZGM2ZjUxODUzMGY1ZDc4MjAyMTNV9CWyhXAvmLil8R6tJMpLaHR0cDovL21lZGlhLmFkc2ltZy5jb20vYTNkYWI2NDQyYTI3M2EyOWQ3YmM3ZDBkNmQ2MWMxYTRiNzI0ZGEyN2UxODRhYjM3MmYwY2ExNmViMmZiODNmMC5qcGd8fHx8fHw3MDB4NTI1fGh0dHA6Ly93d3cuYWR2ZXJ0cy5pZS9zdGF0.jpg): failed to open stream: Za długa nazwa pliku ~ SYSPATH/classes/Kohana/Upload.php [ 87 ] in file:line
2016-05-15 17:11:49 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(2, 'move_uploaded_f...', '/home/emwoo/web...', 87, Array)
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Upload.php(87): move_uploaded_file('/tmp/phpzwdoZc', '/home/emwoo/web...')
#2 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(405): Kohana_Upload::save(Array)
#3 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(368): Model_Offer->add_image(Array)
#4 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/controller/frontend/offers.php(520): Model_Offer->add_offer(Array, Array)
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Frontend_Offers->action_add()
#6 [internal function]: Kohana_Controller->execute()
#7 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Frontend_Offers))
#8 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#10 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#11 {main} in file:line
2016-05-15 17:12:32 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:12:32 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:14:06 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:14:06 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:26:48 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:26:48 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:30:56 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:30:56 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:31:35 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:31:35 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:44:20 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 17:44:20 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:04:47 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:04:47 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:06:11 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:06:11 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:06:41 --- EMERGENCY: ErrorException [ 2 ]: move_uploaded_file(/home/emwoo/websites/proffer/_upload/57389e9122ee6ZGFkNTUwYTBhYjI0ZGM2ZjUxODUzMGY1ZDc4MjAyMTNV9CWyhXAvmLil8R6tJMpLaHR0cDovL21lZGlhLmFkc2ltZy5jb20vYTNkYWI2NDQyYTI3M2EyOWQ3YmM3ZDBkNmQ2MWMxYTRiNzI0ZGEyN2UxODRhYjM3MmYwY2ExNmViMmZiODNmMC5qcGd8fHx8fHw3MDB4NTI1fGh0dHA6Ly93d3cuYWR2ZXJ0cy5pZS9zdGF0.jpg): failed to open stream: Za długa nazwa pliku ~ SYSPATH/classes/Kohana/Upload.php [ 87 ] in file:line
2016-05-15 18:06:41 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(2, 'move_uploaded_f...', '/home/emwoo/web...', 87, Array)
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Upload.php(87): move_uploaded_file('/tmp/phplWUPbB', '/home/emwoo/web...')
#2 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/model/offer.php(405): Kohana_Upload::save(Array)
#3 /home/emwoo/websites/proffer/private/modules/akosoft/site_offers/classes/controller/profile/offers.php(191): Model_Offer->add_image(Array)
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Profile_Offers->action_edit()
#5 [internal function]: Kohana_Controller->execute()
#6 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Profile_Offers))
#7 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#8 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#9 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#10 {main} in file:line
2016-05-15 18:07:10 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:07:10 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:07:54 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:07:54 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:08:15 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:08:15 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:19:01 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:19:01 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:25:21 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:25:21 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:26:35 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:26:35 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:27:02 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:27:02 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:27:23 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:27:23 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:38:56 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:38:56 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:39:27 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:39:27 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:39:46 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:39:46 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:40:01 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:40:01 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:57:45 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:57:45 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 18:59:59 --- EMERGENCY: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Arr::is_assoc() must be of the type array, integer given, called in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php on line 439 and defined ~ SYSPATH/classes/Kohana/Arr.php [ 30 ] in /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php:30
2016-05-15 18:59:59 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Arr.php(30): Kohana_Core::error_handler(4096, 'Argument 1 pass...', '/home/emwoo/web...', 30, Array)
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
2016-05-15 19:00:03 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:03 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:15 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:15 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:21 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:21 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:29 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:29 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:33 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:00:33 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:02:09 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 19:02:09 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:06 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:06 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:15 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:15 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:21 --- ERROR: Kohana_Exception [ 0 ]: Cannot find asset: img/expiration_date-icon.png ~ MODPATH/akosoft/core/classes/Asset.php [ 25 ] in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
2016-05-15 22:15:21 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php(34): Asset->__construct('img/expiration_...')
#1 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Controller.php(84): Controller_Media->action_file()
#2 [internal function]: Kohana_Controller->execute()
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Request/Client/Internal.php(116): ReflectionMethod->invoke(Object(Controller_Media))
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request/Client.php(114): Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#6 /home/emwoo/websites/proffer/index.php(123): Kohana_Request->execute()
#7 {main} in /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Controller/Media.php:34
<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-07-01 03:29:25 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 03:29:25 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 04:46:50 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 04:46:50 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 05:37:50 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 05:37:50 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 05:37:51 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 05:37:51 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 07:49:37 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 07:49:37 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 07:49:38 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 07:49:38 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:38:31 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:38:31 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:38:41 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:38:41 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:53:16 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:53:16 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:53:16 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 08:53:16 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:00:33 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:00:33 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:00:34 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:00:34 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:55:14 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:55:14 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:55:14 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 09:55:14 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 14:55:29 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 14:55:29 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 16:14:00 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 16:14:00 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 20:20:54 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 20:20:54 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 20:20:55 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-01 20:20:55 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
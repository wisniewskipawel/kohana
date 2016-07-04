<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-07-03 01:33:28 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 01:33:28 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 01:33:29 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 01:33:29 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 03:32:20 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 03:32:20 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:34:25 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:34:25 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:34:25 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:34:25 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:50:53 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:50:53 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:50:54 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:50:54 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:33 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:33 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:34 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:34 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:44 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:44 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:55 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:56:55 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:57:05 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:57:05 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:57:15 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 08:57:15 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:05:50 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:05:50 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:05:50 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:05:50 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:06:01 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:06:01 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:06:11 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:06:11 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:08:41 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:08:41 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:08:42 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:08:42 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:17:59 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:17:59 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:18:02 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:18:02 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:24 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:24 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:25 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:25 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:37 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:24:37 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:33:41 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:33:41 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:33:43 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 09:33:43 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 10:01:33 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 10:01:33 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 10:01:34 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-03 10:01:34 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
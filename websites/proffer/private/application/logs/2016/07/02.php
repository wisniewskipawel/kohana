<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-07-02 00:52:38 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 00:52:38 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 00:52:39 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 00:52:39 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 12:40:14 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 12:40:14 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 12:40:31 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 12:40:31 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 15:15:59 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 15:15:59 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 15:16:03 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 15:16:03 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 23:39:31 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 23:39:31 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 23:39:36 --- EMERGENCY: Database_Exception [ 2 ]: mysql_connect(): Access denied for user '1245_Proffer'@'localhost' (using password: YES) ~ MODPATH/kohana/database/classes/Kohana/Database/MySQL.php [ 67 ] in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
2016-07-02 23:39:36 --- DEBUG: #0 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php(171): Kohana_Database_MySQL->connect()
#1 /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/Query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `config_...', false, Array)
#2 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(66): Kohana_Database_Query->execute('default')
#3 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Akosoft/Config/Reader.php(43): Akosoft_Config_Reader->_init()
#4 /home/emwoo/websites/proffer/private/modules/kohana/system/classes/Kohana/Config.php(130): Akosoft_Config_Reader->load('site')
#5 /home/emwoo/websites/proffer/private/modules/akosoft/core/classes/Site.php(16): Kohana_Config->load('site')
#6 /home/emwoo/websites/proffer/private/application/bootstrap.php(129): Site::config('language.defaul...', 'pl')
#7 /home/emwoo/websites/proffer/index.php(107): require('/home/emwoo/web...')
#8 {main} in /home/emwoo/websites/proffer/private/modules/kohana/database/classes/Kohana/Database/MySQL.php:171
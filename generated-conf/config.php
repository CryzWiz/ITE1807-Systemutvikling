<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('local', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost:3306;dbname=stud_v17_gruppe1',
  'user' => 'root',
  'password' => '',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
    'ATTR_TIMEOUT' => 30,
  ),
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$manager->setName('local');
$serviceContainer->setConnectionManager('local', $manager);
$serviceContainer->setAdapterClass('stud_v17_gruppe1', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=kark.uit.no;dbname=stud_v17_gruppe1',
  'user' => 'stud_v17_gruppe1',
  'password' => 'gruppe1',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
    'ATTR_TIMEOUT' => 30,
  ),
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$manager->setName('stud_v17_gruppe1');
$serviceContainer->setConnectionManager('stud_v17_gruppe1', $manager);
$serviceContainer->setDefaultDatasource('local');
$serviceContainer->setLoggerConfiguration('defaultLogger', array (
  'type' => 'stream',
  'path' => '../propel.log',
  'level' => 300,
));
$serviceContainer->setLoggerConfiguration('defaultDebug', array (
  'type' => 'stream',
  'path' => '../propel_debug.log',
));
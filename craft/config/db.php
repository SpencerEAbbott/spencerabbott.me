<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

$customDbConfig = array(

  '*' => array(
    // Use the same prefix in all environments
    'tablePrefix'   => 'craft',

    // Live database info
    'server'    => '104.236.136.50',
    'user'      => 'root',
    'password'  => 'ihvE6LJF9j',
    'database'  => 'spencer_craft'
  ),

  // Dev database info
  'staging.' => array(
    'server'    => 'localhost',
    'user'      => 'root',
    'password'  => 'root',
    'database'  => 'spencer_craft_dev'
  )

);

// If a local db file exists, merge the local db settings
if (is_array($customLocalDbConfig = @include(CRAFT_CONFIG_PATH . 'local/db.php')))
{
  $customGlobalDbConfig = array_merge($customDbConfig['*'], $customLocalDbConfig);
  $customDbConfig['*'] = $customGlobalDbConfig;
}

return $customDbConfig;

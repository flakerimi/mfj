<?php
 
namespace Core;

class Config {
    public static function get($key, $default = null) {
        $keys = explode('.', $key);
        $configFile = $keys[0];

        // Check if the configuration file exists
        $configPath = __DIR__ . '/../app/config/' . $configFile . '.php';
        if (file_exists($configPath)) {
            $config = require $configPath;

            // Remove the first key (the config file name)
            array_shift($keys);

            // Traverse the config array
            foreach ($keys as $subkey) {
                if (isset($config[$subkey])) {
                    $config = $config[$subkey];
                } else {
                    return $default;
                }
            }

            return $config;
        }

        return $default;
    }
}

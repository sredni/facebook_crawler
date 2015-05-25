<?php

namespace Sredni\Registry;

/**
 * Settings Registry
 *
 * @author lsrednicki
 */
class Registry {

    /**
     * @var Array
     */
    protected static $config = Array();

    /**
     * Set value to path
     *
     * @access public
     * @param string $path
     * @param mixed $value
     * @return void
     */
    public static function set($path, $value)
    {
        $nodes = explode('/', $path);

        self::$config = self::processSet(self::$config, $nodes, $value);
    }

    /**
     * Process set request
     *
     * @access protected
     * @param Array $config
     * @param Array $nodes
     * @param mixed $value
     * @return Array
     */
    protected static function processSet(&$config, $nodes, $value)
    {
        $node = array_shift($nodes);

        if (!isset($config[$node]) || !is_array($config[$node])) {
            $config[$node] = array();
        }

        if (!count($nodes)) {
            $config[$node] = $value;
        } else {
            self::processSet($config[$node], $nodes, $value);
        }

        return $config;
    }

    /**
     * Get value from specified path
     *
     * @access public
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    public static function get($path = '', $default = null)
    {
        $nodes = explode('/', $path);

        $result = self::processGet(self::$config, $nodes);

        return $result ? : $default;
    }

    /**
     * Process get request
     *
     * @access protected
     * @param Array $config
     * @param Array $nodes
     * @return mixed
     * @throws
     */
    protected static function processGet(&$config, $nodes)
    {
        $node = array_shift($nodes);
        $result = null;

        if (isset($config[$node])) {
            if (!count($nodes)) {
                $result = $config[$node];
            } else {
                $result = self::processGet($config[$node], $nodes);
            }
        }

        return $result;
    }

    /**
     * Clear whole registry
     *
     * @access public
     * @return void
     */
    public static function clear() {
        self::$config = Array();
    }
}
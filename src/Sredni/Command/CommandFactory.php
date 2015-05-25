<?php

namespace Sredni\Command;

class CommandFactory {

    /**
     * Create command for arguments
     *
     * @param array $arguments Argumnets to create and setup command
     * @return Executable Created command
     * @throws \Exception
     */
    public static function factory($arguments) {
        $className = self::parseClassName($arguments[1]);

        if (!class_exists($className) || !in_array('Sredni\Command\Executable', class_implements($className))) {
            throw new \Exception(sprintf('Invalid command: %s', $className));
        }

        $command = new $className();

        $command->setUp(array_splice($arguments, 2));

        return $command;
    }

    /**
     * @param string $argument Prepare command class name
     * @return string
     */
    private static function parseClassName($argument) {
        return 'Sredni\Command\\' . str_replace(' ', '', ucwords(str_replace('-', ' ', $argument))) . 'Command';
    }
}
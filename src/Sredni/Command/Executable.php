<?php

namespace Sredni\Command;

interface Executable {
    /**
     * Setup command
     *
     * @param array $arguments Command arguments
     * @return void
     */
    public function setUp($arguments);

    /**
     * Execute command
     *
     * @return void
     */
    public function execute();

    /**
     * End command
     *
     * @return void
     */
    public function tearDown();
}
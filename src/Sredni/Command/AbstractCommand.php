<?php

namespace Sredni\Command;

abstract class AbstractCommand implements Executable {
    /**
     * Tear down command
     */
    public function __destruct() {
        $this->tearDown();
    }
}
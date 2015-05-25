#!/usr/bin/env php
<?php

require 'vendor/autoload.php';
require 'config/config.php';

$command = Sredni\Command\CommandFactory::factory($argv);

$command->execute();
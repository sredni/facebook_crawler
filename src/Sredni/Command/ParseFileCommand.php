<?php

namespace Sredni\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Sredni\Queue\QueueConnection;
use Sredni\Registry\Registry;

class ParseFileCommand extends AbstractCommand {
    private $queueName;
    private $fileName;
    private $queue;

    /**
     * @inheritdoc
     */
    public function setUp($arguments) {
        if (empty($arguments[0])) {
            throw new \Exception('No queue to consume');
        }

        if (!in_array($arguments[0], Registry::get('/consumer/queues'))) {
            throw new \Exception(sprintf('Unknown queue: %s', $arguments[0]));
        }

        if (empty($arguments[1])) {
            throw new \Exception('No file to parse');
        }

        if (!is_readable($arguments[1])) {
            throw new \Exception(sprintf('Invalid filename or file is not readable: %s', $arguments[0]));
        }

        $this->queueName = $arguments[0];
        $this->fileName = $arguments[1];
        $this->queue = new QueueConnection();
    }

    /**
     * @inheritdoc
     */
    public function execute() {
        $i = 0;
        $handle = fopen($this->fileName, "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $i++;
                $line = trim($line);
                $message = new AMQPMessage($line);

                $this->queue->enqueue($message, $this->queueName);
                echo sprintf("Added user: %s\n", $line);

                if ($i % 1000 == 0){
                    usleep(200000);
                }
            }

            fclose($handle);
        } else {
            throw new \Exception(sprintf('Unable to open file: %s', $this->fileName));
        }
    }

    /**
     * @inheritdoc
     */
    public function tearDown() {
        $this->queue->closeConnection();
    }
}
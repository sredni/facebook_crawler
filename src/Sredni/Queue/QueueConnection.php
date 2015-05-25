<?php

namespace Sredni\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use Sredni\Registry\Registry;
use PhpAmqpLib\Connection\AMQPConnection;

class QueueConnection {
    private $connection;

    /**
     * Create AMQP queue connection
     *
     * @param string $connectionName
     * @throws \Exception
     */
    public function __construct($connectionName = 'default')
    {
        $configuration = Registry::get('/connection/amqp/' . $connectionName, null);

        if (!$configuration) {
            throw new \Exception(sprintf('Invalid connection name: %s', $connectionName));
        }

        $this->connection = new AMQPConnection(
            $configuration['host'],
            $configuration['port'],
            $configuration['user'],
            $configuration['password']
        );

        $channel = $this->connection->channel();

        $channel->queue_declare($configuration['queue']);
    }

    /**
     * Enqueue message
     *
     * @param AMQPMessage $message
     * @param string $queueName
     */
    public function enqueue(AMQPMessage $message, $queueName) {
        $channel = $this->connection->channel();

        $channel->basic_publish($message, '', $queueName);
    }

    /**
     * Consume queue
     *
     * @param string $queueName
     * @param mixed $callback
     */
    public function consume($queueName, $callback) {
        $channel = $this->connection->channel();
        $i = 0;

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $i++;

            $channel->wait();

            echo "Consumed\n";

            if ($i % 10 == 0){
                usleep(500000);
            }
        }
    }

    /**
     * Cleanup connection
     */
    public function closeConnection() {
        $this->connection->channel()->close();
        $this->connection->close();
    }
}
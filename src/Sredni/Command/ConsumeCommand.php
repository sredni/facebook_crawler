<?php

namespace Sredni\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Sredni\Model\FacebookUser;
use Sredni\Model\Post;
use Sredni\Queue\QueueConnection;
use Sredni\Registry\Registry;
use Sredni\SocialConnector\FacebookConnector;

class ConsumeCommand extends AbstractCommand {

    private $queueName;
    private $facebookConnector;
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

        $this->queueName = $arguments[0];
        $this->queue = new QueueConnection();
        $this->facebookConnector = new FacebookConnector();
    }

    /**
     * @inheritdoc
     */
    public function execute() {
        $this->queue->consume($this->queueName, [$this, 'consume']);
    }

    /**
     * Process queue message
     *
     * @param AMQPMessage $message Message to process
     */
    public function consume($message) {
        $userId = $message->body;
        $user = new FacebookUser();

        $user->setExternalId($userId);
        //save FacebookUser

        foreach ($this->facebookConnector->getUserPosts($userId)->getProperty('data')->asArray() as $facebookPost) {
            $post = new Post();

            $post->setUserId($user->getId());
            $post->setExternalId($facebookPost->id);
            $post->setMessage($facebookPost->name);
            //save Post
        }
    }

    /**
     * @inheritdoc
     */
    public function tearDown() {
        $this->queue->closeConnection();
    }
}
<?php
namespace Sredni\Model;

class Post {
    private $id;
    private $userId;
    private $externalId;
    private $message;

    /**
     * Get post id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set post userId
     *
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * Get post userId
     *
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Set post externalId
     *
     * @param int $externalId
     */
    public function setExternalId($externalId) {
        $this->externalId = $externalId;
    }

    /**
     * Get post externalId
     *
     * @return int
     */
    public function getExternalId() {
        return $this->externalId;
    }

    /**
     * Set post message
     *
     * @param string $message
     */
    public function setMessage($message) {
        $this->externalId = $message;
    }

    /**
     * Get post message
     *
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }
}
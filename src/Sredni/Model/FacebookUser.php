<?php
namespace Sredni\Model;

class FacebookUser {
    private $id;
    private $externalId;

    /**
     * Get user id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user externalId
     *
     * @param int $externalId
     */
    public function setExternalId($externalId) {
        $this->externalId = $externalId;
    }

    /**
     * Get user externalId
     *
     * @return int
     */
    public function getExternalId() {
        return $this->externalId;
    }
}
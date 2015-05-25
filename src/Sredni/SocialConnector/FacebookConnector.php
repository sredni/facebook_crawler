<?php

namespace Sredni\SocialConnector;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Sredni\Registry\Registry;

class FacebookConnector {

    private $session;
    private $accessToken;

    /**
     * Create Facebook connector
     */
    public function __construct() {
        $configuration = Registry::get('/facebook/app');

        FacebookSession::setDefaultApplication($configuration['key'], $configuration['secret']);
        FacebookSession::enableAppSecretProof(false);

        $this->session = new FacebookSession($configuration['access_token']);
        $this->accessToken = $configuration['access_token'];
    }

    /**
     * Get feed posts for user
     *
     * @param int $userId
     * @return mixed
     * @throws \Facebook\FacebookRequestException
     */
    public function getUserPosts($userId) {
        $request = new FacebookRequest(
            $this->session, 'GET', '/' . $userId . '/feed', [
                'access_token' => $this->accessToken
            ]
        );

        $response = $request->execute();

        return $response->getGraphObject();
    }
}
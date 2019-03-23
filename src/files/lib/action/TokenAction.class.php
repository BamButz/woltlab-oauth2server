<?php

namespace wcf\action;

use wcf\data\oauth2server\AuthToken;
use wcf\system\exception\IllegalLinkException;
use wcf\system\oauth2server\TokenService;
use \wcf\data\oauth2server\AuthTokenEditor;
use \wcf\data\oauth2server\AuthClient;

class TokenAction extends AbstractAction {

	private $client = null;
	private $secret = null;
	private $grantType = null;
	private $code = null;
	private $refreshToken = null;
	private $username = null;
	private $password = null;
	private $clientId = null;
	private $clientSecret = null;

	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_POST["grant_type"]))
			$this->grantType = $_POST["grant_type"];

		if (isset($_POST["code"]))
			$this->code = $_POST["code"];

		if (isset($_POST["refresh_token"]))
			$this->refreshToken = $_POST["refresh_token"];

		if (isset($_POST["username"]))
			$this->username = $_POST["username"];

		if (isset($_POST["password"]))
			$this->password = $_POST["password"];

		if (isset($_POST["client_id"]))
			$this->clientId = $_POST["client_id"];

		if (isset($_POST["client_secret"]))
			$this->clientSecret = $_POST["client_secret"];
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		parent::execute();

		if (!$this->isValidGrantType($this->grantType))
			throw new IllegalLinkException();

		$token = $this->getTokenByGrant($this->grantType);
		if ($token == null)
			throw new IllegalLinkException();

		$client = new AuthClient($this->clientId);
		if($client->getObjectID() === 0)
			throw new IllegalLinkException();

		if($client->clientSecret != $this->clientSecret)
			throw new IllegalLinkException();

		$authCode = new AuthToken($token);
		if ($authCode->getObjectID() === 0)
			throw new IllegalLinkException();

		if (($authCode->creationDate + $authCode->expiresIn) < time())
			throw new IllegalLinkException();

		$authCodeEditor = new AuthTokenEditor($authCode);
		$authCodeEditor->delete();

		$refreshToken = TokenService::createRefreshToken($authCode->clientID, $authCode->userID);
		$accessToken = TokenService::createAccessToken($authCode->clientID, $authCode->userID);

		$json = new \stdClass();
		$json->access_token = $accessToken->token;
		$json->refresh_token = $refreshToken->token;
		$json->expires_in = $accessToken->expiresIn;
		$json->token_type = "Bearer";

		@header("Content-type: application/json");
		echo json_encode($json, JSON_PRETTY_PRINT);

		$this->executed();
		exit;
	}

	private function isValidGrantType($grantType) {
		switch ($grantType) {
			case "authorization_code":
			case "refresh_token":
			// case "password":
				return true;
			
			default:
				return false;
		}
	}

	private function getTokenByGrant($grantType) {
		switch ($grantType) {
			case "authorization_code":
				return $this->code;
			case "refresh_token":
				return $this->refreshToken;

			default:
				return null;
		}
	}
}

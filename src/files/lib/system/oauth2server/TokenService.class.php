<?php

namespace wcf\system\oauth2server;

use wcf\data\oauth2server\AuthToken;
use wcf\data\oauth2server\AuthTokenEditor;

class TokenService {
	public static function createAccessToken($clientID, $userID) : AuthToken {
		return self::createNewToken($clientID, $userID, "access_token");
	}

	public static function createRefreshToken($clientID, $userID) : AuthToken {
		return self::createNewToken($clientID, $userID, "refresh_token");
	}

	public static function createAuthorizationCode($clientID, $userID) : AuthToken {
		return self::createNewToken($clientID, $userID, "auth_code");
	}

	private static function createNewToken($clientID, $userID, $tokenType) {
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		$expiresIn = self::getExpiryByTokenType($tokenType);

		AuthTokenEditor::create([
			"token" => $token,
			"userID" => $userID,
			"clientID" => $clientID,
			"tokenType" => $tokenType,
			"expiresIn" => $expiresIn,
			"creationDate" => time()
		]);

		return new AuthToken($token);
	}

	private static function getExpiryByTokenType($tokenType) {
		switch($tokenType)
		{
			case "access_token":
				return 60 * 30;

			case "refresh_token":
				return 60 * 60 * 24 * 30;

			case "auth_code":
				return 60 * 5;

			default:
				return -1;
		}
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: b.just
 * Date: 27.10.2018
 * Time: 10:07
 */

namespace wcf\system\oauth2server;


use wcf\data\oauth2server\AuthTokenEditor;

class TokenService {
	public static function createAccessToken($clientID, $userID) {
		self::createNewToken($clientID, $userID, "access_token");
	}

	public static function createRefreshToken($clientID, $userID) {
		return self::createNewToken($clientID, $userID, "refresh_token");
	}

	public static function createAuthorizationCode($clientID, $userID) {
		return self::createNewToken($clientID, $userID, "auth_code");
	}

	private static function createNewToken($clientID, $userID, $tokenType) {

		$token = bin2hex(openssl_random_pseudo_bytes(16));
		$expires_in = self::getExpiryByTokenType($tokenType);

		$newToken = AuthTokenEditor::create([
			"token" => $token,
			"userID" => $userID,
			"clientID" => $clientID,
			"tokenType" => $tokenType,
			"expires" => $expires_in
		]);

		return $newToken;
	}

	private static function getExpiryByTokenType($tokenType) {
		switch($tokenType)
		{
			case "access_token":
				return time() + 60 * 30;

			case "refresh_token":
				return time() + 60 * 60 * 24 * 30;

			case "auth_code":
				return time() + 60 * 5;

			default:
				return -1;
		}
	}
}
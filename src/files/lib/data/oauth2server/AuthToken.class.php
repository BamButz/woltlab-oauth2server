<?php

namespace wcf\data\oauth2server;

use wcf\data\DatabaseObject;

/**
 * Class AuthToken
 * @package wcf\data\oauth2server
 *
 * @property-read	string		$token
 * @property-read	string		$tokenType
 * @property-read	integer		$userID
 * @property-read	string		$clientID
 * @property-read	integer		$expiresIn
 * @property-read	integer		$creationDate
 */
class AuthToken extends DatabaseObject {
	/**
	 * database table for this object
	 * @var    string
	 */
	protected static $databaseTableName = "auth_tokens";

	/**
	 * name of the primary index column
	 * @var    string
	 */
	protected static $databaseTableIndexName = "token";
}

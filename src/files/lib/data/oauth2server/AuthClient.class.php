<?php

namespace wcf\data\oauth2server;

use wcf\data\DatabaseObject;

/**
 * Class AuthClient
 * @package wcf\data\oauth2server
 *
 * @property-read	string		$clientID
 * @property-read	integer		$clientSecret
 * @property-read	string		$description
 * @property-read	string		$callbackUrl
 */
class AuthClient extends DatabaseObject {
	/**
	 * database table for this object
	 * @var    string
	 */
	protected static $databaseTableName = 'auth_clients';

	/**
	 * name of the primary index column
	 * @var    string
	 */
	protected static $databaseTableIndexName = 'clientID';
}

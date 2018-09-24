<?php

namespace wcf\data\oauth2server;

use wcf\data\DatabaseObject;

class AuthToken extends DatabaseObject {
	/**
	 * database table for this object
	 * @var    string
	 */
	protected static $databaseTableName = 'auth_tokens';

	/**
	 * name of the primary index column
	 * @var    string
	 */
	protected static $databaseTableIndexName = 'tokenID';
}
<?php
namespace wcf\data\oauth2server;

use wcf\data\DatabaseObject;

class AuthClient extends DatabaseObject {
    /**
     * database table for this object
     * @var	string
     */
    protected static $databaseTableName = 'auth_clients';

    /**
     * name of the primary index column
     * @var	string
     */
    protected static $databaseTableIndexName = 'clientID';
}
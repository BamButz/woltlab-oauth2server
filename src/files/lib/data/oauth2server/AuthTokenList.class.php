<?php

namespace wcf\data\oauth2server;

use wcf\data\DatabaseObjectList;

class AuthTokenList extends DatabaseObjectList {
    protected static $baseClass = AuthToken::class;
}
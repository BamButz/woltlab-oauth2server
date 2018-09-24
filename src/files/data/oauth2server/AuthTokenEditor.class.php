<?php

namespace wcf\data\oauth2server;

use wcf\data\DatabaseObjectEditor;

class AuthTokenEditor extends DatabaseObjectEditor {
	protected static $baseClass = AuthToken::class;
}
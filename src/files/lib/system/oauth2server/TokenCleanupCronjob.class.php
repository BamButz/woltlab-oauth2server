<?php

namespace wcf\system\oauth2server;

use \wcf\system\cronjob\AbstractCronjob;
use \wcf\data\cronjob\Cronjob;
use \wcf\data\oauth2server\AuthTokenList;

class TokenCleanupCronjob extends AbstractCronjob {

	/**
     * @inheritDoc
     */
    public function execute(Cronjob $cronjob) {
		parent::execute($cronjob);

		$authTokens = new AuthTokenList();
		$authTokens->getConditionBuilder()->add('(creationDate + expiresIn) < ?', [time()]);
	}
}
<?php

namespace wcf\acp\form;

use \wcf\form\AbstractForm;
use \wcf\system\exception\UserInputException;
use \wcf\data\oauth2server\AuthClientEditor;
use \wcf\util\HeaderUtil;
use \wcf\system\request\LinkHandler;

class AuthClientAddForm extends AbstractForm {
	/**
	 * @inheritDoc
	 */
	public $activeMenuItem = "wcf.acp.menu.oauth2server.authclient.list";

	public $description = "";
	public $callbackUrl = "";

	/**
     * @inheritDoc
     */
    public function readFormParameters() {
		parent::readFormParameters();
		
		$this->description = isset($_POST["description"]) ? $_POST["description"] : "";
        $this->callbackUrl = isset($_POST["callbackUrl"]) ? $_POST["callbackUrl"] : "";
	}
	
	/**
     * @inheritDoc
     */
    public function validate() {
		parent::validate();

		if ($this->description == "")
			throw new UserInputException("description");

		if ($this->callbackUrl == "")
			throw new UserInputException("callbackUrl");
	}

	public function save() {
		parent::save();

		$clientID = bin2hex(openssl_random_pseudo_bytes(16));
		$clientSecret = bin2hex(openssl_random_pseudo_bytes(16));

		AuthClientEditor::create([
			"clientID" => $clientID,
			"clientSecret" => $clientSecret,
			"description" => $this->description,
			"callbackUrl" => $this->callbackUrl
		]);

		HeaderUtil::redirect(LinkHandler::getInstance()->getLink("AuthClientList"));
		$this->saved();
		exit;
	}
}

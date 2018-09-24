<?php

namespace wcf\action;

use wcf\data\oauth2server\OAuth2Client;
use wcf\data\oauth2server\OAuth2Token;
use wcf\data\oauth2server\OAuth2TokenEditor;
use wcf\data\object\type\ObjectTypeCache;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\SystemException;
use wcf\system\payment\type\IPaymentType;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\HTTPRequest;
use wcf\util\StringUtil;

/**
 * Handles OAuth2 authorization requests
 *
 * @author    Cryptonica
 * @copyright 2018 Cryptonica
 * @package    Cryptonica\OAuth2Server\Action
 */
class AuthorizeAction extends AbstractAction {

	private $clientID = null;
	private $responseType = null;
	private $redirectUri = null;
	private $state = null;

	/**
	 * @inheritdoc
	 */
	public function readParameters() {
		parent::readParameters();

		$this->clientID = $_GET["client_id"];
		$this->responseType = $_GET["redirect_uri"];
		$this->redirectUri = $_GET["redirect_uri"];
		$this->state = $_GET["state"];
	}

	/**
	 * @inheritdoc
	 */
	public function execute() {
		parent::execute();

		// Ohne ClientID ist der anfordernde Dienst nicht zu erkennen
		if ($this->clientID == null)
			throw new IllegalLinkException();

		// Wir unterstützen für den Anfang nur den Authorization Code Flow
		if ($this->responseType != "code")
			throw new IllegalLinkException();

		// Existiert ein Client mit dieser ID?
		$client = new AuthClient($this->clientID);
		if ($client == null)
			throw new IllegalLinkException();

		// Wenn Benutzer nicht eingeloggt, muss dieser sich erst einmal einloggen
		if (!WCF::getUser()->userID) {
			$requestUri = WCF::getRequestURI();
			$url = LinkHandler::getInstance()->getLink("Login", ["url" => $requestUri]);

			HeaderUtil::redirect($url);
			$this->executed();
			exit;
		}

		// TODO: Consent

		// Token generieren
		$token = bin2hex(openssl_random_pseudo_bytes(16));

		AuthTokenEditor::create([
			'token' => $token,
			"userID" => WCF::getUser()->userID,
			"clientID" => $this->clientID,
			"tokenType" => "auth_code",
			"expires" => time() + (60 * 5) // Code ist ab aktueller Zeit 5 Minuten gültig
		]);

		// TODO: URL mit hinterlegter Adresse prüfen sowie sicherer Uri Erstellung
		$redirectUri = $this->redirectUri;
		$redirectUri .= (parse_url($redirectUri, PHP_URL_QUERY) ? '&' : '?') . 'state=' . $this->state . '&code=' . $token;

		HeaderUtil::redirect($redirectUri);
		$this->executed();
		exit;
	}
}
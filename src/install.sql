CREATE TABLE wcf1_auth_clients (
	clientID VARCHAR(255) NOT NULL PRIMARY KEY,
	clientSecret VARCHAR(255) NOT NULL,
	description VARCHAR(255) NOT NULL,
	callbackUrl VARCHAR(255) NOT NULL
);

CREATE TABLE wcf1_auth_tokens (
	token VARCHAR(255) NOT NULL PRIMARY KEY,
	tokenType ENUM('access_token', 'refresh_token', 'auth_code') NOT NULL,
	userID INT(10) NOT NULL,
	clientID VARCHAR(255) NOT NULL,
	expires_in INT(10) NOT NULL
);
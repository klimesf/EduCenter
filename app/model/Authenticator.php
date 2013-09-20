<?php

namespace EduCenter;

use Nette,
    Nette\Security,
    Nette\Utils\Strings;

/*
CREATE TABLE users (
	id int(11) NOT NULL AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	password char(60) NOT NULL,
	role varchar(20) NOT NULL,
	PRIMARY KEY (id)
);
*/

/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{
	/** @var Nette\Database\Connection */
	private $database;
	private $users;


	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}


    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
	list($username, $password) = $credentials;
	$row = $this->users->findByName($username);

	if (!$row) {
	    throw new Security\AuthenticationException('Nesprávné přihlašovací jméno.', self::IDENTITY_NOT_FOUND);
	}

	if ($row->password !== $this->calculateHash($password, $row->password)) {
	    throw new Security\AuthenticationException('Nesprávné heslo.', self::INVALID_CREDENTIAL);
	}

	$arr = $row->toArray();
	unset($arr['password']);
	return new Nette\Security\Identity($row->id, $row->role, $arr);
    }


	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		if ($password === Strings::upper($password)) {
			$password = Strings::lower($password);
		}
		return crypt($password, $salt ?: '$2a$07$' . Strings::random(22));
	}

	public function setPassword($id, $password)
	{
		$this->users->findBy(array('id' => $id))->update(array(
			'password' => $this->calculateHash($password),
		));
	}
}

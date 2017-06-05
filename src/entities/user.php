<?php

namespace Entities;

use Core\Database\BaseSql;

class User extends BaseSql
{

	protected $id = -1;
	protected $pseudo = null;
    protected $firstname = null;
    protected $lastname = null;
    protected $email = null;
	protected $password = null;
	protected $birthday = null;
	protected $created_at = null;
	protected $updated_at = null;

	public function __construct() {
		parent::__construct();

        $date = new \DateTime();
        $this->setCreatedAt($date->format("Y-m-d H:m:s"));
	}

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

	public function setId($id)
    {
		$this->id = $id;
	}

	// verifier les espace avant et apres la chaine 
	public function setEmail($email)
    {
		$this->email = trim($email);
	}

	public function setLastname($lastname)
    {
		$this->lastname = trim($lastname);
	}

	public function setFirstname($firstname)
    {
		$this->firstname = trim($firstname);
	}

	public function setPassword($password)
    {
		$this->password = password_hash($password, PASSWORD_DEFAULT );
	}

    public static function formRegister()
    {
        return [
            "struct" => [
                "method" => "POST",
                "action" => "admin/register",
                "class" => "form-group",
                "submit" => "Inscription"
            ],
            "data" => [
                "pseudo" => [
                    "type" => "text",
                    "placeholder" => "Pseudo",
                    "label" => "Votre pseudo",
                    "required" => true,
                    "rules" => [
                        "type" => "text",
                        "min" => "2",
                        "max" => "80",
                        "unique" => true
                    ]
                ],
                "email" => [
                    "type" => "email",
                    "placeholder" => "example@domain-name.com",
                    "label" => "Votre email",
                    "required" => true,
                    "rules" => [
                        "type" => "email",
                        "min" => "5",
                        "max" => "80",
                        "unique" => true
                    ]
                ],
                "firstname" => [
                    "type" => "text",
                    "placeholder" => "Votre prénom...",
                    "label" => "Votre prénom",
                    "required" => true,
                    "rules" => [
                        "type" => "text",
                        "min" => "1",
                    ]
                ],
                "lastname" => [
                    "type" => "text",
                    "placeholder" => "Votre nom...",
                    "label" => "Votre nom",
                    "required" => true
                ],
                "password" => [
                    "type" => "password",
                    "placeholder" => "Votre mot de passe...",
                    "required" => true,
                    "rules" => [
                        "type" => "repeated",
                        "second_placeholder" => "Confirmer votre mot de passe..."
                    ]
                ],
                "birthday" => [
                    "type" => "date",
                    "label" => "Votre date de naissance",
                    "required" => true,
                    "rules" => [
                        "type" => "date"
                    ]
                ],
                "terms" => [
                    "type" => "checkbox",
                    "value" => "agree",
                    "label" => "J'accepte les conditions d'utilisation",
                    "required" => true
                ]
            ]
        ];
    }

    public static function formLogin()
    {
        return [
            "struct" => [
                "method" => "POST",
                "action" => "admin/login",
                "class" => "form-group",
                "submit" => "Se connecter"
            ],
            "data" => [
                "email" => [
                    "type" => "email",
                    "placeholder" => "example@domain-name.com",
                    "label" => "Votre email",
                    "required" => true,
                    "rules" => [
                        "type" => "email"
                    ]
                ],
                "password" => [
                    "type" => "password",
                    "placeholder" => "Votre mot de passe...",
                    "label" => "Votre mot de passe",
                    "required" => true
                ]
            ]
        ];
    }

    public function formResetPasswordEmail()
    {
        return [
            "struct" => [
                "method" => "POST",
                "action" => "admin/reset_password",
                "class" => "form-group",
                "submit" => "Réinitialiser le mot de passe"
            ],
            "data" => [
                "email" => [
                    "type" => "email",
                    "placeholder" => "example@domain-name.com",
                    "label" => "Votre email",
                    "required" => true,
                    "rules" => [
                        "type" => "email"
                    ]
                ]
            ]
        ];
    }
}

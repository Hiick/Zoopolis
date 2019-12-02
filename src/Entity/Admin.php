<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Email already exist"
 * )
 */
class Admin implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="idadmin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=155, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="fisrtname", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     */
    private $lastname;


    public function getIdadmin(): ?int
    {
        return $this->idadmin;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function eraseCredentials() {}
    public function getSalt() {}
    public function getRoles() {
        return ["ROLE_ADMIN"];
    }
    public function getUsername() {
        return $this->getEmail();
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public static function getAllAdmins(array $admins) {
        $retour = [];
        foreach ($admins as $admin)
            array_push($retour, [
                "email" => $admin->getEmail(),
                "role" => $admin->getRole(),
                "firstname" => $admin->getFirstname(),
                "lastname" => $admin->getLastname()
            ]);
        return $retour;
    }

    public static function login(array $admins) {
        $retour = [];
        foreach ($admins as $admin)
            array_push($retour, [
                "email" => $admin->getEmail(),
                "password" => $admin->getPassword()
            ]);
        return $retour;
    }


}

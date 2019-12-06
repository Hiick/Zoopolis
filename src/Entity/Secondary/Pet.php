<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pet
 *
 * @ORM\Table(name="pet", indexes={@ORM\Index(name="fk_pet_user1_idx", columns={"user_iduser"})})
 * @ORM\Entity(repositoryClass="App\Repository\PetsRepository")
 */
class Pet
{
    /**
     * @var int
     *
     * @ORM\Column(name="idpet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpet;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false, options={"default"="Rex"})
     */
    private $name = 'Rex';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=60, nullable=false, options={"default"="Chien"})
     */
    private $type = 'Chien';

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=50, nullable=false)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="birthday", type="string", nullable=false)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=0, nullable=false, options={"default"="Homme"})
     */
    private $sexe = 'Homme';

    /**
     * @var string
     *
     * @ORM\Column(name="dateAcquisition", type="string", nullable=false)
     */
    private $dateacquisition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedat = 'CURRENT_TIMESTAMP';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="iduser")
     * })
     */
    private $userIduser;

    public function getIdpet(): ?int
    {
        return $this->idpet;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateacquisition(): ?string
    {
        return $this->dateacquisition;
    }

    public function setDateacquisition(string $dateacquisition): self
    {
        $this->dateacquisition = $dateacquisition;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getUserIduser(): ?User
    {
        return $this->userIduser;
    }

    public function setUserIduser(?User $userIduser): self
    {
        $this->userIduser = $userIduser;

        return $this;
    }


}

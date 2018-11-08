<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Adresse;
use App\Entity\Groupe;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"Default"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default"})
     */
    private $phone;


    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="users")
     * @ORM\JoinColumn(name="groupe_id", referencedColumnName="id", nullable=true)
     * @Groups({"Default"})
     */
    private $groupe;

    /**
    @ORM\ManyToMany(targetEntity="App\Entity\Adresse", inversedBy="user", cascade={"persist","remove"}))
    * @ORM\JoinTable(name="user_adresse",
    * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
    *   inverseJoinColumns={@ORM\JoinColumn(name="adresse_id", referencedColumnName="id")}
    * ))
    */
   private $adresses;

   public function __construct()
   {
       $this->adresses = new ArrayCollection();
   }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGroupe()
    {
        return $this->groupe;
    }

    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;
        return $this;
    }

    /**
     * @return Collection|Adresse[]
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    public function addAdresse(Adresse $adresse)
    {
        if ($this->adresses->contains($adresse)) {
            return;
        }


        $this->adresses[] = $adresse;
    }

    public function setAdresses(ArrayCollection $adresses)
    {
        $this->adresses = $adresses;
        return $this;
    }

    public function removeAdresse(Adresse $adresse)
    {
        $this->adresses->removeElement($adresse);
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }
}

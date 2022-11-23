<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 *
*/
class User  implements UserInterface , PasswordAuthenticatedUserInterface
{
    const ROLE_DEFAULT = 'ROLE_CLIENT';

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
   /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ApiProperty(identifier=true)
     * @Groups("user:read")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;

  
       /**
     * @var string
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */

    private $nom;


    /**
     * @var string
     *@Groups({"user:read", "user:write"})
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */

    private $prenom;


    /**
     * @ApiProperty(identifier=false)
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */

    private $email;


    /**
     * @var string
     *@Groups({"user:read", "user:write"})
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */

    private $telephone;


    /**
     * @Groups("user:read")
     * @ORM\Column(type="array")
     */

    private $roles = [];


    /**
     *
     * @ORM\Column(type="string", length=255)
     */

    private $password;


    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */

    protected $enabled;


    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */

    protected $lastLogin;


    /**
     * Random string sent to the user email address in order to verify it.
     *
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */

    protected $confirmationToken;


    /**
     * \DateTime|null $dateInscription
     *
     * @ORM\Column(name="dateInscription", type="datetime",nullable=true)

     */

    protected $dateInscription;


    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */

    protected $passwordRequestedAt;

    /**
     * @Groups("user:write")
     * @SerializedName("password")
     */
    protected $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Commandes::class, mappedBy="user")
     */
    private $Commande;

    /**
     * @ORM\OneToMany(targetEntity=Ads::class, mappedBy="users") AdresseLivraison
     */
    private $ads;

    /**
     * @ORM\OneToMany(targetEntity=AdresseLivraison::class, mappedBy="user")
     * @ApiSubresource
     */
    private $AdresseLivraison;

    public function __construct()
    {
        $this->enabled = true;
        $this->roles = array();
        $this->dateInscription = new \DateTime();
        $this->Commande = new ArrayCollection();
        $this->ads = new ArrayCollection();
        $this->AdresseLivraison= new ArrayCollection();
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


    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Porteur
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     *
     * @see PasswordAuthenticatedUserInterface
     */

    public function getPassword(): string    {
        // not needed for apps that do not check user passwords
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }
    /**
     * Gets the last login time.
     *
     * @return \DateTime|null
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string|null $confirmationToken
     */
    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        $this->plainPassword = null;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     *
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     *
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $boolean)
    {
        $this->enabled = (bool) $boolean;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPasswordRequestedAt(): ?\DateTime
    {
        return $this->passwordRequestedAt;
    }
    /**
     * {@inheritdoc}
     */
    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
            $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * @param \DateTime|null $passwordRequestedAt
     */
    public function setPasswordRequestedAt(?\DateTime $date = null): void
    {
        $this->passwordRequestedAt = $date;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * @param \DateTime $dateInscription
     */
    public function setDateInscription(\DateTime $dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->Commande->contains($commande)) {
            $this->Commande[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->Commande->contains($commande)) {
            $this->Commande->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Ads[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAds(Ads $ads): self
    {
        if (!$this->ads->contains($ads)) {
            $this->ads[] = $ads;
            $ads->setUsers($this);
        }

        return $this;
    }

    public function removeAds(Ads $ads): self
    {
        if ($this->ads->contains($ads)) {
            $this->ads->removeElement($ads);
            // set the owning side to null (unless already changed)
            if ($ads->getUsers() === $this) {
                $ads->setUsers(null);
            }
        }

        return $this;
    }

    public function getId()
    {
 return $this->id;
    }


    /**
     * @return Collection|AdresseLivraison[]
     */
    public function getAdresseLivraison(): Collection
    {
        return $this->AdresseLivraison;
    }

    public function addAdresseLivraison(AdresseLivraison $adresseLivraison): self
    {
        if (!$this->AdresseLivraison->contains($adresseLivraison)) {
            $this->AdresseLivraison[] = $adresseLivraison;
            $adresseLivraison->setUser($this);
        }

        return $this;
    }

    public function removeAdresseLivraison(AdresseLivraison $adresseLivraison): self
    {
        if ($this->AdresseLivraison->contains($adresseLivraison)) {
            $this->AdresseLivraison->removeElement($adresseLivraison);
            // set the owning side to null (unless already changed)
            if ($adresseLivraison->getUser() === $this) {
                $adresseLivraison->setUser(null);
            }
        }

        return $this;
    }

}
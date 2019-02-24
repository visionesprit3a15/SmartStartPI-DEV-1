<?php

namespace ChallengeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Challenge
 *
 * @ORM\Table(name="challenge", indexes={@ORM\Index(name="idFreelancer", columns={"idFreelancer"}), @ORM\Index(name="idEntreprise", columns={"idEntreprise"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Challenge
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;
    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", length=255, nullable=false)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255, nullable=false)
     */
    private $specialite;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="MyBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEntreprise", referencedColumnName="id")
     * })
     */
    private $identreprise;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="MyBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFreelancer", referencedColumnName="id")
     * })
     */
    private $idfreelancer;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="challenge", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;



    public function __construct()
    {
      $this->updateAt  = new \DateTime();

    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Challenge
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
     * Set description
     *
     * @param string $description
     *
     * @return Challenge
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Challenge
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Challenge
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Challenge
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     *
     * @return Challenge
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set identreprise
     *
     * @param \MyBundle\Entity\User $identreprise
     *
     * @return Challenge
     */
    public function setIdentreprise(\MyBundle\Entity\User $identreprise = null)
    {
        $this->identreprise = $identreprise;

        return $this;
    }

    /**
     * Get identreprise
     *
     * @return \MyBundle\Entity\User
     */
    public function getIdentreprise()
    {
        return $this->identreprise;
    }

    /**
     * Set idfreelancer
     *
     * @param \MyBundle\Entity\User $idfreelancer
     *
     * @return Challenge
     */
    public function setIdfreelancer(\MyBundle\Entity\User $idfreelancer = null)
    {
        $this->idfreelancer = $idfreelancer;

        return $this;
    }

    /**
     * Get idfreelancer
     *
     * @return \MyBundle\Entity\User
     */
    public function getIdfreelancer()
    {
        return $this->idfreelancer;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
    }


}

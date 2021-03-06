<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="date")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity="ArticleBundle\Entity\Paragraph", mappedBy="article", cascade={"all"})
     */
    private $paragraphs;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime",nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Article
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;
    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    static $choiceCategorie =
        array(
            1 => 'Captain Choice',
            2 => 'TOP 4 Players To Watch',
            3 => 'TOP 3 Differentials',
            4 => 'Gamewwek Top Facts & Stats',
            5 => 'Price Changes',
            6 => 'Injury Update',
            7 => 'FPL Clean Sheets',
            8 => 'EPL Teams Current Lineups',
            9 => 'Others',
            10 => 'Fixture Analysis'
        );

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->dateCreation = new \DateTime();

    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
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
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Article
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public function setUpdatedAt($updatedAt=null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set utilisateur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $utilisateur
     *
     * @return Article
     */
    public function setUtilisateur(\Application\Sonata\UserBundle\Entity\User $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paragraphs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add paragraph
     *
     * @param \ArticleBundle\Entity\Paragraph $paragraph
     *
     * @return Article
     */
    public function addParagraph(\ArticleBundle\Entity\Paragraph $paragraph)
    {
        $this->paragraphs[] = $paragraph;
        $paragraph->setArticle($this);
        return $this;
    }

    /**
     * Remove paragraph
     *
     * @param \ArticleBundle\Entity\Paragraph $paragraph
     */
    public function removeParagraph(\ArticleBundle\Entity\Paragraph $paragraph)
    {
        $this->paragraphs->removeElement($paragraph);
    }

    /**
     * Get paragraphs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParagraphs()
    {
        return $this->paragraphs;
    }
}

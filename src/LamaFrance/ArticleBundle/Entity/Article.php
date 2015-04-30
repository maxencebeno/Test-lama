<?php

namespace LamaFrance\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="LamaFrance\ArticleBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=255)
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="oem", type="string", length=255)
     */
    private $oem;

    /**
     * @var string
     *
     * @ORM\Column(name="codelama", type="string", length=255)
     */
    private $codelama;

    /**
     * @var string
     *
     * @ORM\Column(name="capacite", type="string", length=255)
     */
    private $capacite;

    /**
     * @var string
     *
     * @ORM\Column(name="equivalencelama", type="string", length=255)
     */
    private $equivalencelama;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set marque
     *
     * @param string $marque
     * @return Article
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string 
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set modele
     *
     * @param string $modele
     * @return Article
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string 
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set oem
     *
     * @param string $oem
     * @return Article
     */
    public function setOem($oem)
    {
        $this->oem = $oem;

        return $this;
    }

    /**
     * Get oem
     *
     * @return string 
     */
    public function getOem()
    {
        return $this->oem;
    }

    /**
     * Set codelama
     *
     * @param string $codelama
     * @return Article
     */
    public function setCodelama($codelama)
    {
        $this->codelama = $codelama;

        return $this;
    }

    /**
     * Get codelama
     *
     * @return string 
     */
    public function getCodelama()
    {
        return $this->codelama;
    }

    /**
     * Set capacite
     *
     * @param string $capacite
     * @return Article
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * Get capacite
     *
     * @return string 
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Set equivalencelama
     *
     * @param string $equivalencelama
     * @return Article
     */
    public function setEquivalencelama($equivalencelama)
    {
        $this->equivalencelama = $equivalencelama;

        return $this;
    }

    /**
     * Get equivalencelama
     *
     * @return string 
     */
    public function getEquivalencelama()
    {
        return $this->equivalencelama;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     * @return Article
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string 
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set description
     *
     * @param string $description
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
     * Set type
     *
     * @param string $type
     * @return Article
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}

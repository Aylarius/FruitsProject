<?php

namespace FruitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fruits
 */
class Fruits
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomFruit;

    /**
     * @var int
     */
    private $quantite;


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
     * Set nomFruit
     *
     * @param string $nomFruit
     * @return Fruits
     */
    public function setNomFruit($nomFruit)
    {
        $this->nomFruit = $nomFruit;

        return $this;
    }

    /**
     * Get nomFruit
     *
     * @return string 
     */
    public function getNomFruit()
    {
        return $this->nomFruit;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Fruits
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}

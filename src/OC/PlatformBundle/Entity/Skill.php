<?php
// src/OC/PlatformBundle/Entity/Skill.php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oc_skill")
 */
class Skill
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;


  /**
 * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\advert", inversedBy="skill", cascade={"persist"})
 */
  private $advert;

  public function getId()
  {
    return $this->id;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->advert = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add advert.
     *
     * @param \OC\PlatformBundle\Entity\advert $advert
     *
     * @return Skill
     */
    public function addAdvert(\OC\PlatformBundle\Entity\advert $advert)
    {
        $this->advert[] = $advert;

        return $this;
    }

    /**
     * Remove advert.
     *
     * @param \OC\PlatformBundle\Entity\advert $advert
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAdvert(\OC\PlatformBundle\Entity\advert $advert)
    {
        return $this->advert->removeElement($advert);
    }

    /**
     * Get advert.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}

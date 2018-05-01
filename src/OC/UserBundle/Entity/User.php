<?php

namespace OC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

<<<<<<< HEAD
    /**
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Advert", mappedBy="user")
     */
    private $adverts;

    public function __construct()
  {
    $this->adverts = new ArrayCollection();
    // ...
  }

  public function addAdvert(Advert $advert)
  {
    $this->adverts[] = $advert;
    $advert->setUser($this);
    return $this
  }

  public function removeAdvert(Advert $advert)
  {
    $this->adverts->removeElement($advert);
  }

  public function getAdverts()
  {
    return $this->adverts;
  }
=======
    
>>>>>>> dev-environment
}

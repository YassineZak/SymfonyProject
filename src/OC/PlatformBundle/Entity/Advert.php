<?php

namespace OC\PlatformBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table(name="oc_advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct(){
      $this->date = new \DateTime;
      $this->categories = new ArrayCollection();
    }

    /**
     * @var string
     * @Assert\Length(min=10)
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @Assert\NotBlank(message ="le champ contenu est vide")
     * @ORM\Column(name="content", type="text")
     */
    private $content;


    /**
     *
     * @ORM\Column(name="salary", type="integer")
     */
    private $number;

    /**
     * @Assert\Email(
     *     message = "le mail '{{ value }}' n'est pas au bon format.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=255)
     */
     private $email;



    /**
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * Get id
     *
     * @return int
     */

    /**
      * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
      * @Assert\Valid()
      */
    private $image;

    /**
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updatedAt;

    /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
    private $nbApplications = 0;

    /**
   * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Skill", mappedBy="advert", cascade={"persist"})
   */
    private $skill;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
   * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert", cascade={"remove"})
   */
    private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

    /**
   * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User", inversedBy="advert")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

    /**
     * Set user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setAdvert(\OC\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function increaseApplication()
    {
      $this->nbApplications++;
    }

    public function decreaseApplication()
    {
      $this->nbApplications--;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
      * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
      */
    private $categories;

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
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
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     *
     * @return Advert
     */
    public function setPublished( $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \booleen
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \OC\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \OC\PlatformBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\OC\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \OC\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\OC\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
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
    * @ORM\PreUpdate
    */
    public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Advert
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add skill.
     *
     * @param \OC\PlatformBundle\Entity\Skill $skill
     *
     * @return Advert
     */
    public function addSkill(\OC\PlatformBundle\Entity\Skill $skill)
    {
        $this->skill[] = $skill;
        $skill->addAdvert($this);
        return $this;
    }

    /**
     * Remove skill.
     *
     * @param \OC\PlatformBundle\Entity\Skill $skill
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSkill(\OC\PlatformBundle\Entity\Skill $skill)
    {
        return $this->skill->removeElement($skill);
    }

    /**
     * Get skill.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set skill
     *
     * @param \OC\PlatformBundle\Entity\Skill $skill
     *
     * @return Advert
     */
    public function setSkill(\OC\PlatformBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Add application.
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     *
     * @return Advert
     */
    public function addApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application.
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        return $this->applications->removeElement($application);
    }

    /**
     * Get applications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }


    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Advert
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * toString
     * @return string
     */
    public function __toString()
    {
            return (string) $this->getTitle();
    }
}

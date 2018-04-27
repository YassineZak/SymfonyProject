<?php
namespace OC\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class AdminGroup extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
}

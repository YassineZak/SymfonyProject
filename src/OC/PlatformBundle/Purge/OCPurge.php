<?php
// src/OC/PlatformBundle/Purge/OCPurge.php
namespace OC\PlatformBundle\Purge;


class OCPurge
{
  private $em;

  function __construct(\Doctrine\ORM\EntityManager $em){
    $this->em = $em;
  }
    public function purge($days){
      $em = $this->em;
      $advertsToPurge = $em->getRepository('OCPlatformBundle:Advert')->getAdvertsToPurge($days);
      foreach ($advertsToPurge as $advert){
         $em->remove($advert);
      }
      $em->flush();
      }


}










 ?>

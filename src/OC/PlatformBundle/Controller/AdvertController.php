<?php
// src/OC/PlatformBundle/Controller/AdvertController.php
namespace OC\PlatformBundle\Controller;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Category;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Skill;
use OC\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use OC\PlatformBundle\Form\ApplicationType;
class AdvertController extends Controller
{
  public function indexAction($page)
  {
    if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }
    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;
    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->getAdverts($page, $nbPerPage)
    ;
    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);
    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }
    // On donne toutes les informations nécessaires à la vue
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
    ));
  }
  public function viewAction(Advert $advert)
  {
    $listApplications = $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('OCPlatformBundle:Application')
    ->findBy(array('advert' => $advert));
    // On récupère maintenant la liste des AdvertSkill
    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert, 'listApplications' => $listApplications
    ));
  }
    /**
     * @Security("has_role('ROLE_USER')")
     */
   public function addAction(Request $request)
   {
     $advert = new Advert();
     $user = $this->container->get('security.token_storage')->getToken()->getUser();
     $form   = $this->get('form.factory')->create(AdvertType::class, $advert);
     if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
       $advert->setUser($user);
       $em = $this->getDoctrine()->getManager();
       $em->persist($advert);
       $em->flush();
       $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
       return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
     }
     return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
       'form' => $form->createView(),
     ));
  }
  public function editAction(advert $advert, Request $request)
  {
    $form   = $this->get('form.factory')->create(AdvertEditType::class, $advert);
    $em = $this->getDoctrine()->getManager();
    $em->persist($advert);
    $author =$advert->getUser()->getUsername();
    $user =$this->container->get('security.token_storage')->getToken()->getUsername();
    if ($author !== $user ) {
      return $this->redirectToRoute('oc_platform_home');
    }
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
  }
  return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
    'form' => $form->createView(),
  ));
}
  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
      return $this->redirectToRoute('oc_platform_home');
    }
    return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView(),
    ));
  }
  public function menuAction()
  {
    // On récupère le repository
      $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert');
      $listAdverts = $repository->findAll();
    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
  public function purgeAction($days, Request $request){
    $purge = $this->container->get('oc_platform.purger.advert')->purge($days);
    $request->getSession()->getFlashBag()->add('purge', 'Vos annonces ont bien été purgées');
    return $this->redirectToRoute('oc_platform_home');
  }
  public function commentAction($id, Request $request){
  $repository = $this->getDoctrine()
  ->getManager()
  ->getRepository('OCPlatformBundle:Advert');
  $advert = $repository->find($id);
  if (null === $advert) {
    throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
  }
  $user =$this->container->get('security.token_storage')->getToken()->getUsername();
  if ($user === $advert->getUser()->getUsername()) {
    return $this->redirectToRoute('oc_platform_home');
  }
  elseif ($user == 'anon.') {
    return $this->redirectToRoute('fos_user_security_login');
  }
  $comment = new Application();
  $comment->setAdvert($advert);
  $comment->setAuthor($user);
  $form   = $this->get('form.factory')->create(ApplicationType::class, $comment);
  if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
  $em = $this->getDoctrine()->getManager();
  $em->persist($comment);
  $em->flush();
  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
}
return $this->render('OCPlatformBundle:Advert:comment.html.twig', array(
  'form' => $form->createView(),
));
}
  }

<?php
namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\CoreBundle\Entity\Contact;
use OC\CoreBundle\Form\ContactType;



class CoreBundleController extends Controller
{
  public function indexAction() {

    return $this->render('OCCoreBundle:Home:index.html.twig', array( 'title' =>'Nos dernieres annonces'));
  }

  public function contactAction(Request $request){
    $form   = $this->get('form.factory')->create(ContactType::class);
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      if($this->sendEmail($form->getData())){
      $request->getSession()->getFlashBag()->add('notice', 'Message bien envoyé.');
      return $this->redirectToRoute('oc_corebundle_contact');
      }
    else{
      $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'envoi du message');
      return $this->redirectToRoute('oc_corebundle_contact');
      }
    }
      return $this->render('OCCoreBundle:Core:contactForm.html.twig', array(
        'form' => $form->createView(),));
    }
    private function sendEmail($data){
        $myappContactMail = 'yassine.zakari@hotmail.fr';
        $myappContactPassword = 'yourmailpassword';

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.live.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Code World Contact Form ". $data->getSubject())
        ->setFrom(array($myappContactMail => "Message by ".$data->getName()))
        ->setTo(array(
            $myappContactMail => $myappContactMail
        ))
        ->setBody($data->getMessage()."<br>ContactMail :".$data->getEmail());

        return $mailer->send($message);
    }
  }

 ?>

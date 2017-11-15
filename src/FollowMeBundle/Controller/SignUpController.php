<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use FollowMeBundle\Form\SignUp;

class SignUpController extends Controller
{
	

    /**
     * @Route("/signUp", name="signup")
     */
    public function indexAction(Request $request)
    {

        try {
        	
        	$this->get("session")->start();
        	if ( $this->get("session")->get("id") ) { // Si deja connecté -> renvoie vers home
        		throw new \RuntimeException;
        	}
        
	    	$form = $this->createForm(SignUp::class);
	    	
	    	$form->handleRequest($request); // handleRequest -> Traite les données de formulaire
    	
	    	if($form->isSubmitted() && $form->isValid()) {
	    		
	    		
	    		if ($form->getData() ["user_pswd"] 
	    			!== $form->getData()["confirm"]) {
	    			$form->get("confirm")
	    			->addError (new FormError ("confirmation invalid"));
	    			throw new \InvalidArgumentException;
	    		}
	    	
	
	    		$user = $this->get("foo");// Remplace = new \FollowMeBundle\Entity\User;
	            	$user->setUserMail(
	            			
	            			$form->getData()["user_mail"]
	            			);
	            	$user->setUserPswd(
	            			password_hash(
		            			$form->getData()["user_pswd"],
		            			PASSWORD_DEFAULT
	            			)
	            		);
					$this->getDoctrine() -> getManager() -> persist($user);
					$this->getDoctrine() -> getManager() -> flush();
					
					$this->get("session")->set("id",$user->getUserId());
					
					throw new \RuntimeException;
	    	}
	    	
       		 }catch (\InvalidArgumentException $e) {
       		 	dump($form->get("confirm"));
            } catch (\RuntimeException $e) {
            	return $this->redirectToRoute("main"); // Tout est ok, redirection vers main : nom de la route
            } catch (\Throwable $e) {
               dump($e);
            	$form->addError(new FormError("L'utilisateur existe déjà !"));
            }
  
        return $this->render('FollowMeBundle:SignUp:index.html.twig',
        		[
        			"form" => $form->createView()
        		]
        );
    }

}

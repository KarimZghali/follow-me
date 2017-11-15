<?php

namespace FollowMeBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use FollowMeBundle\Entity\Dating;
use FollowMeBundle\Entity\User;
use FollowMeBundle\Form\Add;

class AddController extends Controller
{
    /**
     * @Route("/add", name="add")
     */
    public function indexAction(Request $request)
    {
    	
    	try {
            // Affiche le niveau d'ADMIN :
            dump(
              $this->get("security.authorization_checker")
              ->isGranted("ROLE_SUPER_ADMIN")
            );
    		
    		$this->get("session")->start();
            
           $idSession = $this->get("session")->get("id");
         
    		if ( !$this->get("session")->get("id") ) {
    			return $this->redirectToRoute("main");
    			
    		}


    		$form = $this->createForm(Add::class);
  
    		$form->handleRequest($request);


            if( $form->isValid() ) {
    			
    			$dating = new \FollowMeBundle\Entity\Dating;
                $user = new \FollowMeBundle\Entity\User;
    		
    			$dating->setDatingTitle(
    					$form->getData()["dating_title"]
    					);
    			
    			$dating->setDatingDescription(
    					$form->getData()["dating_description"]
    					);

//                 Si une date anterieur est rentrée
                if (time() > $form->getData()["dating_start"]->getTimestamp()) {

                    $form->get("dating_start")->addError(
                        new FormError(
                            $this->get("translator")->trans("sign.error.date")
                        )
                    );


                }

                $dating->setDatingStart( $form->getData()["dating_start"]->getTimestamp() );

              //  $start = $form->getData()["dating_start"]->getTimestamp();
             //   $end = $form->getData()["dating_end"]->getTimestamp();

              if ($form->getData()["dating_end"]->getTimestamp()<0) {

                  $form->get("dating_end")->addError(
                      new FormError(
                          $this->get("translator")->trans("sign.error.duration")
                      )
                  );

                throw new \Exception();

              }


                $dating->setDatingEnd(
                    ($form->getData()["dating_start"]->getTimestamp())
                    +
                    ($form->getData()["dating_end"]->getTimestamp())
                );

                $dating->setDatingLat(
    					$form->getData()["dating_lat"]
    					);
         
                $dating->setDatingLng(
    					$form->getData()["dating_lng"]
    					);
           
                $dating->setDatingLinkHref(
    					$form->getData()["dating_link_title"]
    					);
                
                $dating->setDatingLinkTitle(
    					$form->getData()["dating_link_href"]
    					);

                $dating->setUser(

                     $this->getDoctrine()
	    					->getManager()
	    					->getRepository(User::class)
	    					->find($idSession)
                );


                
    			$this->getDoctrine() -> getManager() -> persist($dating);

    			$this->getDoctrine() -> getManager() -> flush();

    			throw new \RuntimeException();
    		}
            
            
    		


    	}catch(\RuntimeException $e) {
    	//	dump($e); exit;
    		return $this->redirectToRoute("main"); // Tout est ok, redirection vers main : nom de la route
    		
    	}catch (\Throwable $e) {
            dump($e);
            //     	$form->addError(new FormError("AIE AIE AIE"));
        }
    	
        return $this->render('FollowMeBundle:Add:index.html.twig',
        		[
        			"form" => $form->createView()
        		]
        );
    }

}

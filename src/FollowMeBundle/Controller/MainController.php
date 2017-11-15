<?php

namespace FollowMeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{

    /**
     * @Route("/", name="main")
     */
    public function indexAction()
    {
//     	$url = $this->generateUrl (
//     			"foo",
//     			[
//     				"identifiant" => "a"
//     			]
//     		);
//     	return $this->redirect($url);
    	
       return $this->render('FollowMeBundle:Main:index.html.twig', array(
            // ...
        ));
    }



    /**
     * @Route("/banner", name="banner")
     */
    public function bannerAction()
    {
//     	$url = $this->generateUrl (
//     			"foo",
//     			[
//     				"identifiant" => "a"
//     			]
//     		);
//     	return $this->redirect($url);

        return $this->render('FollowMeBundle:Main:banner.html.twig', array(
            // ...
        ));
    }
    
    
    
//     /**
//      * @Route(
//      * "/foo/{identifiant}",
//      * name="foo",
//      * defaults={"identifiant": "truc"},
//      * requirements={
//      * "identifiant": "a|b"
//      * }
//      * )
//      */
//     public function foo($identifiant)
//     {
    	
//     	die($identifiant);
//     }
    
    
    

}

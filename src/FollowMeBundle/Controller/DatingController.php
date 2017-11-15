<?php

namespace FollowMeBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use FollowMeBundle\Entity\Dating;
use FollowMeBundle\Entity\User;
use Doctrine\Common\Collections\Criteria;

class DatingController extends Controller
{
    /**
     * @Route("/dating", name="dating")
     */
	public function indexAction(Request $request)
    {

        $this->get("session")->set(
            "page",
            (int) $request->get("page") > 1
            ? $request->get("page")
                :null

        );

        $page = (int) $request->get("page"); // recup GET page dans url
        $maxResults = 5;
		
    	try {

    	    $this->get("session")->start();

            if (!$this->get("session")->get("id")) {
                return $this->redirectToRoute("main");
            }




    	    $criteria = new Criteria;

            if ($this->get("session")->get("page")) {
                $criteria ->setFirstResult(
                    ($this->get("session")->get("page")-1)* $maxResults
                );
            }

            $criteria
                ->where($criteria->expr()->gt("datingEnd", time())) // pour les evet dont la date n'est pas dépassée
                     ->setMaxResults(5)
                    //  ->setFirstResult(2)
                            ->orderBy(["datingEnd" => Criteria::ASC]);

//            if ($page && 0!== $page-1) {
//                echo 'yes ';
//                $criteria->setFirstResult(($page-1) * $maxResults);
//            }



            
            $dating = new \FollowMeBundle\Entity\Dating;
            
//            $liste = $this->getDoctrine()
//              ->getManager()
//              ->getRepository(Dating::class)
//              ->findAll();

            $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository(Dating::class)
                ->matching($criteria);

            dump($liste);


        
        }catch(\Throwable $e) { 
            echo $e;
            dump($e);
            exit;
        }

        dump($this->get("session")->get("id"));

    	return $this->render('FollowMeBundle:Dating:index.html.twig', array('liste'=>$liste));
		

    }
    
    
    
    /**
     * @Route("/modified", name="modified")
     */
    public function modified(Request $request)
    {
    	
    	//le gmt envoy� par le client
    	$clientGMT = $request->headers->get("if-modified-since");
    	
    	if ($clientGMT && time() - (new \DateTime($clientGMT))->getTimestamp() < 5) {
    		$response = new Response();
    		$response->setStatusCode(304);
    	} else {
    		$response = $this->render('FollowMeBundle:Dating:index.html.twig');
    		$response->setLastModified(new \DateTime());
    	}
    	
    	$response->setPublic();
    	return $response;
    	
    	$response->setLastModified(new \DateTime($gmt)); // new \DateTime -> convertit au bon format
    	
    	//     	le GMT de maintenant
    	$gmt = gmdate('D, d M Y H:i:s, T', time());
    	
    	var_dump($gmt);
    	
    	
    	
    	return $response;
    }
    

    
    
    /**
     * @Route("/etag", name="etag")
     */
    public function etag(Request $request)
    {
    	
    	$Etag = md5($request->getRequestUri()); // Converti l'URL en code Etag
    	var_dump(current($request->getETags()));
    	// if not match === etag alors reponse vide
    	if ('"'.$Etag.'"' === current($request->getEtags()) ) {
    		$response = new Response();
    		$response->setStatus(304);
    		// Sinon response avec un rendu
    	} else {
    		$response = $this->render('FollowMeBundle:Dating:index.html.twig');
    	}
    	
    	$response->setEtag($Etag);
    	$response->setPublic();
    	return $response;
    }
    
    
    
    
    
    /**
     * @Route("/psr6", name="psr6")
     */
    public function psr6()
    {
    	$pool = $this->get('cache.app');
    	$item = $pool->getItem('followme.users.three'); // followme.users.three -> nom de la cl�
    	$item->expiresAfter(3);
    	
    	if (!$item->isHit()) {
    		var_dump("REFRESH");
    		$users = $this
    		->getDoctrine()
    		->getManager()
    		->getRepository(User::class)
    		->findAll();
    		$item->set($users);
    		$pool->save($item);
    	}
    }
    

}

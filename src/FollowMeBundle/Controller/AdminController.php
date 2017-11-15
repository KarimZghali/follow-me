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

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction(Request $request)
    {

        $page = (int)$request->get("page"); // recup GET page dans url
        $maxResults = 5;

        try {

            $this->get("session")->start();

            if (!$this->get("session")->get("id")) {
                return $this->redirectToRoute("main");
            }


            $page = (int)$request->get("page"); // recup GET page dans url
            $maxResults = 5;

            $criteria = new Criteria;

            if ($this->get("session")->get("page")) {
                $criteria->setFirstResult(
                    ($this->get("session")->get("page") - 1) * $maxResults
                );
            }

//            $criteria
//                ->where($criteria->expr()->gt("datingEnd", time())) // pour les evet dont la date n'est pas dépassée
//                     ->setMaxResults(5);


            $criteria
                ->setMaxResults($maxResults);

//            $liste = $this->getDoctrine()
//              ->getManager()
//              ->getRepository(Dating::class)
//              ->findAll();
            if ($this->get("session")->get("page")) {
                $criteria->setFirstResult(
                    ($this->get("session")->get("page") - 1) * $maxResults
                );
            }

            $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository(User::class)
                ->matching($criteria);
            //->findAll();

            dump($liste);


        } catch (\Throwable $e) {
            echo $e;
            dump($e);
            exit;
        }

        dump($this->get("session")->get("id"));

        return $this->render('FollowMeBundle:Admin:index.html.twig', array('liste' => $liste));


    }


    /**
     * @Route("/admin/user/{id}", name="admin_user")
     */
    public function removeUserAction($id)
    {
        $url = $this->generateUrl("admin");


        try {

            if (!($user = $this
                ->getDoctrine()
                ->getManager()
                ->find(User::class, $id))) {

                return $this->redirect($url . "?e");
            }


            if (($dating = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository(Dating::class)
                    ->findBy(["user" => $user])) && 0 !== count($dating)) {

                // Si dating: boucle et remove et flush
                foreach ($dating as $date) {
                    $this->getDoctrine()->getManager()->remove($date);
                }

                $this->getDoctrine()->getManager()->flush();

            }


            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($url . "?e=" . $id);


        } catch (Exception $e) {
            echo $e;
        }
    }


}

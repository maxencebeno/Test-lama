<?php

namespace LamaFrance\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Article controller.
 *
 * @Route("/article")
 */
class AjaxController extends Controller {

    public function getMarqueAction($typeimprimante) {
        $em = $this->getDoctrine()->getManager();
        $marques = $em->getRepository('LamaFranceArticleBundle:Article')->findBy(array(
            'type' => $typeimprimante,
        ));
        
        $return = array();
        array_push($return, 'Marque');
        foreach ($marques as $marque) {
            if (!in_array($marque->getMarque(), $return)) {
                array_push($return, $marque->getMarque());
            }
        }
        return $this->render('LamaFranceArticleBundle:Ajax:marque.html.twig', array('marques' => $return));
    }
    
    public function getModeleAction($marque, $type) {
        $em = $this->getDoctrine()->getManager();
        $modeles = $em->getRepository('LamaFranceArticleBundle:Article')->findBy(array(
            'marque' => $marque,
            'type' => $type,
        ));
        
        $return = array();
        foreach ($modeles as $modele) {
            $return[$modele->getId()] = $modele->getModele();
        }
        return $this->render('LamaFranceArticleBundle:Ajax:modele.html.twig', array('modeles' => $return));
    }

}

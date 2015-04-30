<?php

namespace LamaFrance\ArticleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;
use LamaFrance\ArticleBundle\Entity\Article;
use LamaFrance\ArticleBundle\Form\ArticleType;
use LamaFrance\ArticleBundle\Form\ArticleFilterType;

/**
 * Article controller.
 *
 * @Route("/article")
 */
class ArticleController extends Controller {

    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        list($filterForm, $queryBuilder) = $this->filter(null);

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);
        $typeimprimante = array(
            'A' => 'Laser',
            'B' => 'Jet d\'encre compatible et remanufacturé',
            'C' => 'Transfert Thermique pour Fax',
            'D' => 'Jet d\'encre pour Machine à affranchir',
            'E' => 'Rubans pour imprimantes matricielles et machines à écrire',
            'F' => 'Cassettes pour caisses enregistreuses',
        );


        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'typeimprimante' => $typeimprimante,
            'marques' => null,
            'modeles' => null,
        );
    }

    /**
     * Create filter form and process filter request.
     *
     */
    protected function filter($modele) {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new ArticleFilterType());
        $em = $this->getDoctrine()->getManager();
        if ($modele == null) {
            $queryBuilder = $em->getRepository('LamaFranceArticleBundle:Article')->createQueryBuilder('e');

            // Reset filter
            if ($request->get('filter_action') == 'reset') {
                $session->remove('ArticleControllerFilter');
            }

            // Filter action
            if ($request->get('filter_action') == 'filter') {
                // Bind values from the request
                $filterForm->bind($request);

                if ($filterForm->isValid()) {
                    // Build the query from the given form object
                    $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                    // Save filter to session
                    $filterData = $filterForm->getData();
                    $session->set('ArticleControllerFilter', $filterData);
                }
            } else {
                // Get filter from session
                if ($session->has('ArticleControllerFilter')) {
                    $filterData = $session->get('ArticleControllerFilter');
                    $filterForm = $this->createForm(new ArticleFilterType(), $filterData);
                    $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                }
            }
        } else {
            $queryBuilder = $em->getRepository('LamaFranceArticleBundle:Article')->createQueryBuilder('e')
                    ->where('e.id = :id')
                    ->setParameter('id', $modele);
            // Reset filter
            if ($request->get('filter_action') == 'reset') {
                $session->remove('ArticleControllerFilter');
            }

            // Filter action
            if ($request->get('filter_action') == 'filter') {
                // Bind values from the request
                $filterForm->bind($request);

                if ($filterForm->isValid()) {
                    // Build the query from the given form object
                    $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                    // Save filter to session
                    $filterData = $filterForm->getData();
                    $session->set('ArticleControllerFilter', $filterData);
                }
            } else {
                // Get filter from session
                if ($session->has('ArticleControllerFilter')) {
                    $filterData = $session->get('ArticleControllerFilter');
                    $filterForm = $this->createForm(new ArticleFilterType(), $filterData);
                    $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                }
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
     * Get results from paginator and get paginator view.
     *
     */
    protected function paginator($queryBuilder) {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me) {
            return $me->generateUrl('article', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/", name="article_create")
     * @Method("POST")
     * @Template("LamaFranceArticleBundle:Article:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('article_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}", name="article_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LamaFranceArticleBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LamaFranceArticleBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}", name="article_update")
     * @Method("PUT")
     * @Template("LamaFranceArticleBundle:Article:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LamaFranceArticleBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ArticleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('article_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LamaFranceArticleBundle:Article')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('article'));
    }

    /**
     * Creates a form to delete a Article entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    public function searchAction() {
        $request = $this->getRequest();
        $modele = $request->get('modele');
        list($filterForm, $queryBuilder) = $this->filter($modele);

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);
        $typeimprimante = array(
            'A' => 'Laser',
            'B' => 'Jet d\'encre compatible et remanufacturé',
            'C' => 'Transfert Thermique pour Fax',
            'D' => 'Jet d\'encre pour Machine à affranchir',
            'E' => 'Rubans pour imprimantes matricielles et machines à écrire',
            'F' => 'Cassettes pour caisses enregistreuses',
        );


        return $this->render('LamaFranceArticleBundle:Article:index.html.twig', array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'typeimprimante' => $typeimprimante,
            'marques' => null,
            'modeles' => null,
        ));
    }

}

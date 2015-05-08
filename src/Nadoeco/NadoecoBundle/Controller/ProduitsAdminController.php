<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nadoeco\NadoecoBundle\Entity\Produits;
use Nadoeco\NadoecoBundle\Form\ProduitsType;

/**
 * Produits controller.
 *
 */
class ProduitsAdminController extends Controller
{

    /**
     * Lists all Produits entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NadoecoNadoecoBundle:Produits')->findAll();
        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Produits entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Produits();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $key      = '6LeWGwQTAAAAAMJSs-UZRF_c2cN8-TrtDsCrGv85';
            $response = $request->get('g-recaptcha-response');
            $ip       = $request->getClientIp();
            $gapi= 'https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$response;
            $json = json_decode(file_get_contents($gapi), true);
             if($json['success']){
                 $em = $this->getDoctrine()->getManager();
                 $em->persist($entity);
                 $em->flush();
             }else{
                 foreach($json['error-codes'] as $error){
                     echo  $error.'<br/>';
                 }
                 die();
                 return $this->redirect($this->generateUrl('produits_new'));
             }
            return $this->redirect($this->generateUrl('produits_show', array('id' => $entity->getId())));
        }

        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Produits entity.
     *
     * @param Produits $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Produits $entity)
    {
        $form = $this->createForm(new ProduitsType(), $entity, array('validation_groups' => array('aaa')));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Produits entity.
     *
     */
    public function newAction()
    {
        $entity = new Produits();
        $form   = $this->createCreateForm($entity);

        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Produits entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NadoecoNadoecoBundle:Produits')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Produits entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Produits entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NadoecoNadoecoBundle:Produits')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Produits entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Produits entity.
    *
    * @param Produits $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Produits $entity)
    {
        $form = $this->createForm(new ProduitsType(), $entity);

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Produits entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NadoecoNadoecoBundle:Produits')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Produits entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('produits_edit', array('id' => $id)));
        }

        return $this->render('NadoecoNadoecoBundle:administration:Produits/layout/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Produits entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NadoecoNadoecoBundle:Produits')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Produits entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('produitsAdmin'));
    }

    /**
     * Creates a form to delete a Produits entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produits_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

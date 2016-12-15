<?php

namespace Test\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Test\UserBundle\Entity\Contact;
use Test\UserBundle\Entity\User;
use Doctrine\ORM\Query;

class DefaultController extends Controller {

    public function createAction(Request $request) {
        $user = $this->getUser();
        $contact = new Contact();

        $formBuilder = $this->get('form.factory')->createBuilder('form', $contact);
        $formBuilder
                ->add('prenom', 'text')
                ->add('nom', 'text')
                ->add('mail', 'email', array('required' => false))
                ->add('adresse', 'text', array('required' => false))
                ->add('codePostal', 'text', array('required' => false))
                ->add('ville', 'text', array('required' => false))
                ->add('tel', 'text', array('required' => false))
                ->add('siteWeb', 'text', array('required' => false))
                ->add('save', 'submit');

        $form = $formBuilder->getForm();
        $view = $form->createView();

        if ($request->isMethod('POST')) {
            $user->getContact()->add($contact);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->redirect($this->generateUrl('test_user_accueil', array('user' => $user, 'contacts' => $user->getContact()->toArray())));
        }
        return $this->render('TestUserBundle:Default:create.html.twig', array('form' => $view));
    }

    public function modificationAction(Request $request, $id) {
        $user = $this->getUser();
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TestUserBundle:Contact');

        $contact = $repository->find($id);

        $formBuilder = $this->get('form.factory')->createBuilder('form', $contact);
        $formBuilder
                ->add('prenom', 'text')
                ->add('nom', 'text')
                ->add('mail', 'email', array('required' => false))
                ->add('adresse', 'text', array('required' => false))
                ->add('codePostal', 'text', array('required' => false))
                ->add('ville', 'text', array('required' => false))
                ->add('tel', 'text', array('required' => false))
                ->add('siteWeb', 'text', array('required' => false))
                ->add('save', 'submit');

        $form = $formBuilder->getForm();
        $view = $form->createView();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('test_user_accueil', array('user' => $user, 'contacts' => $user->getContact()->toArray())));
        }
        return $this->render('TestUserBundle:Default:modification.html.twig', array('contact' => $contact, 'form' => $view));
    }

    public function detailAction($id) {
        $user = $this->getUser();
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TestUserBundle:Contact');

        $contact = $repository->find($id);
        return $this->render('TestUserBundle:Default:detail.html.twig', array('contact' => $contact));
    }

    public function deleteAction($id) {
        $user = $this->getUser();
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TestUserBundle:Contact');

        $contact = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return $this->redirect($this->generateUrl('test_user_accueil', array('user' => $user)));
    }

    public function accueilAction() {
        $user = $this->getUser();
        if ($user != NULL)
            $contacts = $user->getContact();
        else
            $contacts = NULL;

        return $this->render('TestUserBundle:Default:accueil.html.twig', array('user' => $user, 'contacts' => $contacts));
    }

}

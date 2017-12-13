<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\User;

class UserController extends Controller
{
  public function showAction($id)
  {
      $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($id);

      return $this->render('user/show.html.twig', [ 'user' => $user ]);
  }

  public function newAction()
  {
    $user = new User();

    $form = $this->createFormBuilder($user)
                 ->add('email', EmailType::class)
                 ->add('password', PasswordType::class)
                 ->add('save', SubmitType::class, array('label' => 'Sign Up'))
                 ->getForm();

    return $this->render('user/new.html.twig', array('form' => $form->createView()));
  }

  public function createAction(Request $request)
  {
    $user = new User();
    
    $form = $this->createFormBuilder($user)
                 ->add('email', EmailType::class)
                 ->add('password', PasswordType::class)
                 ->add('save', SubmitType::class, array('label' => 'Sign Up'))
                 ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user = $form->getData();

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_show', array('id' => $user->getId()));
    }

    return $this->render('user/new.html.twig', array('form' => $form->createView()));
  }
}

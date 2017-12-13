<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;

class SessionController extends Controller {
  public function login(Request $request, AuthenticationUtils $authUtils) {
    $error = $authUtils->getLastAuthenticationError();
    $email = $authUtils->getLastUsername();

    return $this->render('session/new.html.twig', array('email' => $email, 'error' => $error));
  }
}

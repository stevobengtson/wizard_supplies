<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
  public function index()
  {
    return $this->render('cart/index.html.twig');
  }
}
?>

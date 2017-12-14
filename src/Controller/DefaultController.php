<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

use App\Entity\Item;

class DefaultController extends Controller {
  /**
   * @Route("/", name="index", methods="GET")
   */
  public function index() {
    $items = $this->getDoctrine()
                  ->getRepository(Item::class)
                  ->pageItems(1, 5);

    return $this->render('default/index.html.twig', ['items' => $items]);
  }
}
?>

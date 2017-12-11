<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
  public function index()
  {
    $items = Yaml::parseFile('data/items.yaml');
    return $this->render('default/index.html.twig', Array('items' => $items['items']));
  }
}
?>

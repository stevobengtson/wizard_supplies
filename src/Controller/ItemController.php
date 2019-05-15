<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Item;
use App\Form\ItemType;

class ItemController extends Controller {
  /**
   * @Route("/item", name="item", methods={"GET"})
   */
  public function index(Request $request) {
    $page = $request->query->get('page', 1);
    $items = $this->getDoctrine()
                  ->getRepository(Item::class)
                  ->pageItems($page);

    $totalPages = ceil($items->count() / 10);

    return $this->render('item/index.html.twig', ['items' => $items, 'totalPages' => $totalPages, 'page' => $page]);
  }

  /**
   * @Route("/item/{id}", name="item_show", methods={"GET"}, requirements={"id"="\d+"})
   */
  public function show(Item $item) {
    return $this->render('item/show.html.twig', ['item' => $item]);
  }

  /**
   * @Route("/item/new", name="item_new", methods={"GET","POST"})
   */
  public function new(Request $request) {
    // create a task and give it some dummy data for this example
    $item = new Item();
    $form = $this->createForm(ItemType::class, $item);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $imageFile = $item->getImage();
      $imageFileName = md5(uniqid()) . '.' . $imageFile->guessExtension();
      $imageFile->move($this->getParameter('items_directory'), $imageFileName);
      $item->setImage($imageFileName);

      $em = $this->getDoctrine()->getManager();
      $em->persist($item);
      $em->flush();

      $this->addFlash('success', 'Item created!');

      return $this->redirectToRoute('item_show', ['id' => $item->getId()]);
    }

    return $this->render('item/new.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/item/{id}/delete", name="item_delete", methods={"GET","DELETE"}, requirements={"id"="\d+"})
   */
  public function delete(Item $item) {
    $em = $this->getDoctrine()->getManager();
    $em->remove($item);
    $em->flush();

    $this->addFlash('success', 'Item deleted!');

    return $this->redirectToRoute('item');
  }
}
?>

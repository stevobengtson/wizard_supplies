<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\Cart;
use App\Entity\Item;

class CartController extends Controller {
  /**
   * @Route("/cart", name="cart", methods={"GET"})
   */
  public function index(Request $request) {
    $page = $request->query->get('page', 1);    
    $carts = $this->getDoctrine()
                  ->getRepository(Cart::class)
                  ->pageCarts($page);

    $totalPages = ceil($carts->count() / 10);
                  
    return $this->render('cart/index.html.twig', ['carts' => $carts, 'totalPages' => $totalPages, 'page' => $page]);
  }

  /**
   * @Route("/cart/{item_id}", name="cart_add_item", methods={"GET"}, requirements={"item_id"="\d+"})
   * @ParamConverter("item", class="App:Item", options={"id" = "item_id"})
   */  
  public function addItem(Item $item) {
    $em = $this->getDoctrine()->getManager();
    
    $cart = $this->getExistingCart($em);
    $cart->addItem($item);
    $em->persist($cart);
    $em->flush();

    $this->addFlash('success', 'Item added to cart!');
    return $this->redirectToRoute('item');
  }

  /**
   * @Route("/cart/{item_id}/remove", name="cart_remove_item", methods={"GET"}, requirements={"item_id"="\d+"})
   * @ParamConverter("item", class="App:Item", options={"id" = "item_id"})
   */  
  public function removeItem(Item $item) {
    $em = $this->getDoctrine()->getManager();
    $cart = $this->getExistingCart($em);    
    $cart->removeItem($item);
    $em->persist($cart);    
    $em->flush();

    $this->addFlash('success', 'Item removed from cart!');

    return $this->redirectToRoute('cart');    
  }

  /**
   * @Route("/cart/{id}/delete", name="cart_delete", methods={"GET","DELETE"}, requirements={"id"="\d+"})
   */  
  public function delete(Cart $cart) {
    $em = $this->getDoctrine()->getManager();
    $em->remove($cart);
    $em->flush();

    $this->addFlash('success', 'Cart deleted!');

    return $this->redirectToRoute('cart');
  }

  private function createNewCart($em, $session) {
    $cart = new Cart();
    $em->persist($cart);
    $em->flush();
    $session->set('cart', $cart->getId());
    return $cart;
  }

  private function getExistingCart($em) {
    $session = new Session();
    $session->start();

    $cartId = $session->get('cart');
    if (!$cartId) {
      return $this->createNewCart($em, $session);
    }

    $cart = $this->getDoctrine()
                 ->getRepository(Cart::class)
                 ->find($cartId);
    if (!$cart) {
      $cart = $this->createNewCart($em, $session);
    }

    return $cart;
  }
}
?>

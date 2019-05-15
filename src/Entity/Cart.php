<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Item;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 * @ORM\Table(name="carts")
 */
class Cart {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
  * @ORM\ManyToMany(targetEntity="Item", inversedBy="carts")
  * @ORM\JoinTable(name="carts_items")
  */
  private $items;

  public function __construct() {
    $this->items = new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function getId() {
    return $this->id;
  }

  public function getItems() {
    return $this->items;
  }

  public function addItem(Item $item) {
    $this->items->add($item);
    return $this;
  }

  public function removeItem(Item $item) {
    $this->items->removeElement($item);
    return $this;
  }
}
?>

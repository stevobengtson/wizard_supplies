<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ItemType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('title')
        ->add('description')
        ->add('image', Filetype::class)
        ->add('price')
        ->add('save', SubmitType::class);
  }
}
?>

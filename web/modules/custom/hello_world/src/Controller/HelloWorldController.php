<?php

namespace Drupal\hello_world\Controller;



use Drupal\Core\Controller\ControllerBase;

class HelloWorldController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    $url = \Drupal\Core\Url::fromRoute('hello_world.test_module');
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World! gggggg lkfjdlkfdjdslk') . $url->toString(),
    ];
  }

}

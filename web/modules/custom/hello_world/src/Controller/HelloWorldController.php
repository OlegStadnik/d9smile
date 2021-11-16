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
      '#markup' => $this->t('Hello, World! gggggg lkfjdlkfdjdslk ') . $url->toString(),
    ];
  }

  public function thursdayTask($firstArg, $secondArg) {
    $build = [];
    $routeparameters = [
      'firstArg' => $firstArg,
      'secondArg' => $secondArg,
    ];
    $entityTypeManager = $this->entityTypeManager();
    $nodeStorage = $entityTypeManager->getStorage('node');
    $node = $nodeStorage->load(10);
    $build['examples_link'] = [
    '#title' => $this->t('Examples'),
    '#type' => 'link',
    '#url' => \Drupal\Core\Url::fromRoute('hello_world.thursday', $routeparameters )
     ];
    $build ['markup'] = [
      '#type' => 'markup',
      '#markup' => $firstArg . ' : ' . $secondArg,
    ];
    $build ['markup2'] = [
      '#type' => 'markup',
      '#markup' => $firstArg . ' : ' . $secondArg,
    ];
   return $build;

  }

  public function sundayTask($type, $color) {
    $type_id = NULL;
    if (!empty($type)) {
      // Грузим сторедж таксономии
      $taxonomy_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

      // Грузим все термины, которые созданы в taxonomy vocabulary 'item_type' и имеют name $type (private or public)
      $terms = $taxonomy_storage->loadByProperties([
        'vid' => 'item_type',
        'name' => $type,
      ]);
      // Берем первый объект таксономии из результата.
      $term = reset($terms);
      // Берем айди его
      if ($term) {
        $type_id = $term->id();
      }
    }
    $color_id = NULL;
    if (!empty($color))
    {
      // Грузим сторедж таксономии
      $taxonomy_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

      // Грузим все термины, которые созданы в taxonomy vocabulare 'item_color' и имеют name $type (private or public)
      $terms = $taxonomy_storage->loadByProperties([
        'vid' => 'item_color',
        'name' => $color,
      ]);
      // Берем первый объект таксономии из результата.
      $term = reset($terms);
      // Берем айди его
      if ($term) {
        $color_id = $term->id();
      }
    }
    // Грузим сторедж ноды.
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    // готовим проперти по которым будет грузить наши ноды:
    $props = [];
    // добавляем наш тип ноды который нужно будет загрузить.
    $props['type'] = 'item';

    // prop для типа по таксономии.
    if (!empty($type_id)) {
      // field_item_type - машинное имя в нашей ноде, которая ссылается на таксономию.
      $props['field_item_type'] = $type_id;
    }

    // prop для цвета по таксономии.
    if (!empty($color_id)) {
      // field_item_color - машинное имя в нашей ноде, которая ссылается на таксономию.
      $props['field_item_color'] = $color_id;
    }

    // грузим ноды по наши пропсам:
    $nodes = $node_storage->loadByProperties($props);
    // готовим айтемы для отображения.
    $items = [];
    /**
     * @var
     * Drupal\node\NodeInterface
     * $node
     */
    foreach($nodes as $node) {
    $items[] = $node->GetTitle();
   }
    $content = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => 'My List',
      '#items' => $items,
      '#attributes' => ['class' => 'mylist'],
      '#wrapper_attributes' => ['class' => 'container'],
    ];
    return $content;
  }
}

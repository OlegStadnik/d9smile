<?php

namespace Drupal\hello_world\Plugin\Block;


use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Hello World Nodes Block' Block.
 *
 * @Block(
 *   id = "hello_world_nodes_block",
 *   admin_label = @Translation("Hello world nodes block"),
 *   category = @Translation("hello_world"),
 * )
 */

class HelloWorldNodesBlock extends BlockBase implements ContainerFactoryPluginInterface {


  /**
   * Acc proxy.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * EntityType
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Dependency Injection.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return \Drupal\hello_world\Plugin\Block\HelloWorldNodesBlock|static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->currentUser = $container->get('current_user');
    $instance->entityTypeManager = $container->get('entity_type.manager');
    return $instance;
  }

  /**
   *
   * @return array
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function build() {

    $logged_in = $this->currentUser->isAuthenticated();
    if ($logged_in) {
      $values = [
        'type' => 'item',
      ];
    }
    else {
      $values = [
        'type' => 'article',
      ];
    }

    $items = [];
    $nodes = $this->entityTypeManager
      ->getStorage('node')
      ->loadByProperties($values);
    foreach($nodes as $node) {
      $items[] = $node->getTitle();
    }

    $content = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => 'Nodes list',
      '#items' => $items,
      '#attributes' => ['class' => 'mylist'],
      '#wrapper_attributes' => ['class' => 'container'],
    ];
    /**
     *
     *
     */
    $render_array['details'] = [
      '#type' => 'details',
      '#title' => $this->t('DETAILS'),
      'list' => $content,
    ];
    return $render_array;

  }

//  function getCacheMaxAge() {
//    return 0;
//  }

}

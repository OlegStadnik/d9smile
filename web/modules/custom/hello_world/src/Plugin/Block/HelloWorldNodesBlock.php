<?php

namespace Drupal\hello_world\Plugin\Block;


use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;

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
  public function defaultConfiguration() {
    return array(
      'count' => 0,
    );
  }

  /**
   * Добавляем в стандартную форму блока свои поля.
   *
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    // Получаем оригинальную форму для блока.
    $form = parent::blockForm($form, $form_state);
    // Получаем конфиги для данного блока.
    $config = $this->getConfiguration();

    // Добавляем поле для ввода сообщения.
//    $form['message'] = array(
//      '#type' => 'textfield',
//      '#title' => t('Message to printing'),
//      '#default_value' => $config['message'],
//    );

    // Добавляем поле для количества сообщений.
    $form['count'] = array(
      '#type' => 'number',
      '#min' => 0,
      '#title' => t('How many items to show'),
      '#default_value' => $config['count'],
    );

    return $form;
  }

  /**
   * Валидируем значения на наши условия.
   * Количество должно быть >= 0,
   * Сообщение должно иметь минимум 5 символов.
   *
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $count = $form_state->getValue('count');
//    $message = $form_state->getValue('message');

    // Проверяем введенное число.
    if (!is_numeric($count) || $count < 0) {
      $form_state->setErrorByName('count', t('Needs to be an interger and more or equal 0.'));
    }

    // Проверяем на длину строки.
//    if (strlen($message) < 5) {
//      $form_state->setErrorByName('message', t('Message must contain more than 5 letters'));
//    }
  }

  /**
   * В субмите мы лишь сохраняем наши данные.
   *
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['count'] = $form_state->getValue('count');
//    $this->configuration['message'] = $form_state->getValue('message');
  }
  /**
   *
   * @return array
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function build() {
    $config = $this->getConfiguration();

  //  $logged_in = $this->currentUser->isAuthenticated();
    //if ($logged_in) {
      $values = [
        'type' => 'item',
      ];
    //}
    //else {
//      $values = [
//        'type' => 'article',
//      ];
//    }

    $items = [];

    $nodes = $this->entityTypeManager
      ->getStorage('node')
      ->loadByProperties($values);
    foreach($nodes as $node) {
      $items[] = $node->getTitle();
    }
    if ($config['count'] != 0) {
      $items = array_slice($items, 0, $config['count']);
    }
//    $randomkey = array_rand($items , 1);
//    if(!$logged_in) {
//      $items = [$items[$randomkey]];
//    }

    $content = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => 'Nodes list',
      '#items' => $items ,
      '#attributes' => ['class' => 'mylist'],
      '#wrapper_attributes' => ['class' => 'container'],
    ];
    /**
     *
     *
     */
    $render_array['url'] =[
      '#type' => 'markup',
      '#markup' => \Drupal::request()->getUri(),
    ];
    $render_array['details'] = [
      '#type' => 'details',
      '#title' => $this->t('DETAILS'),
      'list' => $content,
    ];
    return $render_array;

  }
  public function getCacheContexts() {
    //if you depends on \Drupal::routeMatch()
    //you must set context of this block with 'route' context tag.
    //Every new route this block will rebuild
    return Cache::mergeContexts(parent::getCacheContexts(), ['route']);
  }

//
//  public function getCacheMaxAge() {
//    return parent::getCacheMaxAge();
//  }
  public  function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), array('node_list:item'));

  }
}

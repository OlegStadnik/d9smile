<?php

namespace Drupal\hello_world\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Formatter for a text field on a file entity that links the field to the file.
 *
 * @FieldFormatter(
 *   id = "hello_world_formatter",
 *   label = @Translation("hello_world_formatter"),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary",
 *   }
 * )
 */
class HelloWorldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    $settings['link_to_file'] = TRUE;

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // We don't call the parent in order to bypass the link to file form.
    return $form;
  }

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elems = [];
    foreach ($items as $item) {
      $elems[] = ['#markup' => $this->viewValue($item)];
    }
    return $elems;
  }

  /**
   * {@inheritdoc}
   */
  protected function viewValue(FieldItemInterface $item) {
    return substr($item->value, 0 ,100);
  }


}

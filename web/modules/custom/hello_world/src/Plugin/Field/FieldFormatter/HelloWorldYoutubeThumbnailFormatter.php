<?php

namespace Drupal\hello_world\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'hello_world_youtube_thumbnail' formatter.
 *
 * @FieldFormatter(
 *   id = "hello_world_youtube_thumbnail",
 *   module = "hello_world",
 *   label = @Translation("Displays video thumbnail"),
 *   field_types = {
 *     "hello_world_youtube"
 *   }
 * )
 */
class HelloWorldYoutubeThumbnailFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $item->value, $matches);

      if (!empty($matches)) {
        $content = '<a href="' . $item->value . '" target="_blank"><img src="http://img.youtube.com/vi/' . $matches[0] . '/0.jpg"></a>';
        $elements[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => $content,
        ];
      }

    }

    return $elements;
  }

}

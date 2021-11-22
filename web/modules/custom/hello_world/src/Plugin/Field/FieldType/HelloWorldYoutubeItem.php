<?php

namespace Drupal\hello_world\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
* Plugin implementation of the 'hello_world_youtube' field type.
*
* @FieldType(
*   id = "hello_world_youtube",
*   label = @Translation("Embed Youtube video"),
*   module = "hello_world",
*   description = @Translation("Output video from Youtube."),
*   default_widget = "hello_world_youtube_widget",
*   default_formatter = "hello_world_youtube_thumbnail"
* )
*/
class hello_worldYoutubeItem extends FieldItemBase {
/**
* {@inheritdoc}
*/
public static function schema(FieldStorageDefinitionInterface $field_definition) {
return array(
'columns' => array(
'value' => array(
'type' => 'text',
'size' => 'tiny',
'not null' => FALSE,
),
),
);
}

/**
* {@inheritdoc}
*/
public function isEmpty() {
$value = $this->get('value')->getValue();
return $value === NULL || $value === '';
}

/**
* {@inheritdoc}
*/
public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
$properties['value'] = DataDefinition::create('string')
->setLabel(t('Youtube video URL'));

return $properties;
}

}

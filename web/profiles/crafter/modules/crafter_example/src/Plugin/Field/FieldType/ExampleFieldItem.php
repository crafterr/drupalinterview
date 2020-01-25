<?php

namespace Drupal\crafter_example\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'example_field_item' field type.
 *
 * @FieldType(
 *   id = "example_field_item",
 *   label = @Translation("Example field item"),
 *   description = @Translation("My Field Type"),
 *   default_widget = "example_field_widget",
 *   default_formatter = "example_field_formatter"
 *  )
 */
class ExampleFieldItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
        'max_length' => 255,
        'list_type' => 'tiny',
      ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];

    $properties['name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Name'));

    $properties['sex'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Sex'));

    $properties['age'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Age'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['name'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    $values['sex'] = 0;
    $values['age'] = 30;
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'name' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length'),
        ],
        'sex' => [
          'type' => 'int',
          'size' => $field_definition->getSetting('list_type'),
        ],
        'age' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length'),
        ],
      ],
    ];

    return $schema;
  }


  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['max_length'] = [
      '#type' => 'number',
      '#title' => t('Maximum length'),
      '#default_value' => $this->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => t('The maximum length of the field in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    // We consider the field empty if either of the properties is left empty.
    $name = $this->get('name')->getValue();
    $sex = $this->get('sex')->getValue();
    return $name === NULL || $sex === '';
  }

}

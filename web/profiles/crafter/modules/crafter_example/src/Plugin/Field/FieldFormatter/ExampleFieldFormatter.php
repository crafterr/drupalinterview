<?php

namespace Drupal\crafter_example\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'example_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "example_field_formatter",
 *   label = @Translation("Example field formatter"),
 *   field_types = {
 *     "example_field_item"
 *   }
 * )
 */
class ExampleFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        // Implement default settings.
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
        // Implement settings form.
      ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = $this->viewValue($item);
    }

    return $elements;
  }

  /**
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *
   * @return array
   * @throws \Drupal\Core\TypedData\Exception\MissingDataException
   */
  protected function viewValue(FieldItemInterface $item) {
    $name = $item->get('name')->getValue();
    $sex = $item->get('sex')->getValue();
    $age = $item->get('age')->getValue();
    return [
      '#theme' => 'crafter_example',
      '#name' => $name,
      '#sex' => $sex,
      '#age' => $age,

    ];
  }

}

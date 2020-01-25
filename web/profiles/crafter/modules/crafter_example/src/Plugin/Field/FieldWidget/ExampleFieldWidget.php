<?php

namespace Drupal\crafter_example\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
/**
 * Plugin implementation of the 'example_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "example_field_widget",
 *   module = "crafter_example",
 *   label = @Translation("Example field widget"),
 *   field_types = {
 *     "example_field_item"
 *   }
 * )
 */
class ExampleFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 60,
      'name_placeholder' => new TranslatableMarkup('Name'),
      'sex_placeholder' => new TranslatableMarkup('Sex'),
      'age_placeholder' => new TranslatableMarkup('Age'),
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $elements['name_placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for name'),
      '#default_value' => $this->getSetting('name_placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['sex_placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for sex'),
      '#default_value' => $this->getSetting('sex_placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['age_placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for age'),
      '#default_value' => $this->getSetting('age_placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: @size', ['@size' => $this->getSetting('size')]);
    if (!empty($this->getSetting('name_placeholder'))) {
      $summary[] = t('Placeholder for names: @placeholder', ['@placeholder' => $this->getSetting('name_placeholder')]);
    }
    if (!empty($this->getSetting('sex_placeholder'))) {
      $summary[] = t('Placeholder for names: @placeholder', ['@placeholder' => $this->getSetting('sex_placeholder')]);
    }
    if (!empty($this->getSetting('age_placeholder'))) {
      $summary[] = t('Placeholder for names: @placeholder', ['@placeholder' => $this->getSetting('age_placeholder')]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['name'] =  [
      '#type' => 'textfield',
      '#title' => $this->getSetting('name_placeholder'),
      '#default_value' => isset($items[$delta]->name) ? $items[$delta]->name : NULL,
      '#size' => $this->getSetting('size'),
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#required' => TRUE
    ];

    $element['sex'] = [
      '#type' => 'radios',
      '#options' => [
        '0' => $this->t('Male'),
        '1' => $this->t('Female'),
        '2' => $this->t('Child'),
      ],
      '#default_value' => isset($items[$delta]->sex) ?
         $items[$delta]->sex : 0,
      '#empty_value' => '',
      '#placeholder' => $this->t('Sex'),
      '#title' => $this->getSetting('sex_placeholder'),

    ];

    $element['age'] = [
        '#type' => 'textfield',
        '#default_value' => isset($items[$delta]->age) ? $items[$delta]->age : NULL,
        '#size' => $this->getSetting('size'),
        '#placeholder' => $this->getSetting('placeholder'),
        '#maxlength' => $this->getFieldSetting('max_length'),
        '#title' => $this->getSetting('age_placeholder'),
        '#states' => [
          'required' => array(
            ':input[name="field_example_field[0][sex]"]' => [
              'value' => 2
            ],
          ),
          'visible' => [
            ':input[name="field_example_field[0][sex]"]' => [
              'value' => 2
            ],
          ],


        ]
      ];


    return $element;
  }

  /**
   * Empty age value if sex value is not 0 or 1
   * @inheritDoc
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      if ($value['sex']!=2) {
        $value['age'] = '';
      }
    }
    return $values;
  }

}

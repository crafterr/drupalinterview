<?php

namespace Drupal\crafter_example\TwigExtension;

use Drupal\Core\StringTranslation\StringTranslationTrait;
/**
 * Class SexPropertyTwigExtension.
 */
class SexPropertyTwigExtension extends \Twig_Extension {
  use StringTranslationTrait;
  /**
   * Properties
   */
  const PROPERTIES = [
    0 => 'Male',
    1 => 'Female',
    2 => 'Child'
  ];

   /**
    * {@inheritdoc}
    */
    public function getFunctions() {
      return [
        new \Twig_SimpleFunction('get_sex_property',
          [$this, 'get_sex_property'],
          ['is_safe' => array('html')]
        ),
      ];
    }

  /**
   * @param $item
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   */
    public function get_sex_property($item) {
      return $this->t(self::PROPERTIES[$item]);
    }


   /**
    * {@inheritdoc}
    */
    public function getName() {
      return 'crafter_example.twig.extension';
    }

}

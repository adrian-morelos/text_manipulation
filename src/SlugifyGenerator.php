<?php

namespace Drupal\text_manipulation;

use Cocur\Slugify\Slugify;
use Drupal\Component\Utility\Unicode;

class SlugifyGenerator {

  /**
   * Slugify factory.
   *
   * @var \Cocur\Slugify\Slugify
   */
  protected $slugify;

  /**
   * Creates a new Slugify manager.
   */
  public function __construct() {
    if (class_exists('\Cocur\Slugify\Slugify')) {
      $this->slugify = new Slugify();
    }
    else {
      $this->notifyRequiredDependencies();
    }
  }

  /**
   * Converts the text value into a slug.
   *
   * @param $text
   *   The content for which a ROT13 will be generated.
   * @param $separator
   *   The separator used by Slugify
   *
   * @return
   *   The generated slug version of the given string
   */
  public function getSlug($text, $separator = '-') {
    if (Unicode::strlen($text) <= 0) {
      return $text;
    }

    if ($this->slugify instanceof \Cocur\Slugify\Slugify) {
      return $this->slugify->slugify($text, $separator);
    }
    else {
      $this->notifyRequiredDependencies();
      return $text;
    }

  }

  /**
   * Notify to the user through of an warning message that is required install
   * slugify package via: "composer require cocur/slugify" in order to use
   * this service.
   *
   */
  public function notifyRequiredDependencies() {
    drupal_set_message(t('Class "\Cocur\Slugify\Slugify" has not been defined! Please install slugify package via: "composer require cocur/slugify".'), 'warning');
  }
}
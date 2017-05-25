<?php

/**
 * @file
 * Contains \Drupal\text_manipulation\Element\TextTooltip.
 */

namespace Drupal\text_manipulation\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a Rot13 processed text render element.
 *
 * @RenderElement("tooltip_processed_text")
 */
class TextTooltip extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#theme' => 'text_tooltip',
      '#text' => '',
      '#format' => NULL,
      '#langcode' => '',
      '#attached' => [
        'library' => [
          'text_manipulation/text.tooltip-cdn',
        ],
      ],
    ];
  }

}
<?php

namespace Drupal\text_manipulation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'text_rot13_encoding' formatter.
 *
 * @FieldFormatter(
 *   id = "text_rot13_encoding",
 *   label = @Translation("ROT13 encoding"),
 *   field_types = {
 *     "string_long",
 *     "list_string",
 *     "text",
 *     "text_long",
 *     "text_with_summary",
 *     "string"
 *   }
 * )
 */
class TextRot13Formatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    // The ProcessedText element already handles cache context & tag bubbling.
    // @see \Drupal\filter\Element\ProcessedText::preRenderText()
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#text' => text_rot13($item->value),
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }

    return $elements;
  }

}

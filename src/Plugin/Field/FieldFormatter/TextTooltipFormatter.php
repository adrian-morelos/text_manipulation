<?php

namespace Drupal\text_manipulation\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'text_tooltip' formatter.
 *
 * @FieldFormatter(
 *   id = "text_tooltip",
 *   label = @Translation("Tooltip on hover"),
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
class TextTooltipFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    // The tooltip_processed_text element handles the rendering of this Formatter.
    // @see \Drupal\text_manipulation\Element\TextTooltip
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'tooltip_processed_text',
        '#text' => $this->viewValue($item),
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
      $elements[$delta]['#attributes']['class'][] = 'text-tooltip';
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }
}

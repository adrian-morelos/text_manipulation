<?php

namespace Drupal\text_manipulation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'text_slugify' formatter.
 *
 * @FieldFormatter(
 *   id = "text_slugify",
 *   label = @Translation("Slugify text"),
 *   field_types = {
 *     "string_long",
 *     "list_string",
 *     "text",
 *     "text_long",
 *     "text_with_summary",
 *     "string"
 *   },
 *   quickedit = {
 *     "editor" = "form"
 *   }
 * )
 */
class TextSlugFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'separator' => '-',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['separator'] = [
      '#title' => t('Slug separator'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('separator'),
      '#description' => t('By default Cocur/Slugify will use dashes as separators. If you want to use a different default separator, you can set the separator here.'),
      '#required' => TRUE,
      '#size' => 5,
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = t('Slug separator: @separator characters', ['@separator' => $this->getSetting('separator')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $render_as_slug = function (&$element) {
      // Make sure any default #pre_render callbacks are set on the element,
      // because text_pre_render_slugify() must run last.
      $element += \Drupal::service('element_info')->getInfo($element['#type']);
      // Add the #pre_render callback that renders the text into a slug.
      $element['#pre_render'][] = [
        TextSlugFormatter::class,
        'preRenderSlugify',
      ];
      // Pass on the separator to the #pre_render callback via a property.
      $element['#text_slug_separator'] = $this->getSetting('separator');
    };

    // The ProcessedText element already handles cache context & tag bubbling.
    // @see \Drupal\filter\Element\ProcessedText::preRenderText()
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#text' => $item->value,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
      $render_as_slug($elements[$delta]);
    }

    return $elements;
  }

  /**
   * Pre-render callback: Renders a processed text element's #markup as a
   * slugify.
   *
   * @param array $element
   *   A structured array with the following key-value pairs:
   *   - #markup: the slugify text
   *   - #text_slug_separator: the desired separator
   *     (used by text_slugify())
   *
   * @return array
   *   The passed-in element with the filtered text in the slugify '#markup' .
   *
   */
  public static function preRenderSlugify(array $element) {
    $element['#markup'] = \Drupal::service('text_manipulation.slugify_generator')
      ->getSlug($element['#markup'], $element['#text_slug_separator']);
    return $element;
  }


}

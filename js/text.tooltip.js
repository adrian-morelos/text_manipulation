/**
 * @file
 * Contains the definition of the behaviour TooltipText.
 */

(function ($, Drupal) {
    'use strict';
    /**
     * Attaches the JS test behavior to the Tooltip Text p tag.
     */
    Drupal.behaviors.TooltipText = {
        attach: function (context, settings) {
            if ($.qtip) {
                $('.text-tooltip').qtip({
                    position: {
                        my: "bottom right",
                        at: "top left"
                    }
                });
            }
        }
    };
})(jQuery, Drupal);

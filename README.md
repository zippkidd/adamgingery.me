Astra Child Theme by [Thomas Tylek](kutyl.me)
============================================

A lightweight Astra child theme without jQuery and minimal requests. Comes with some useful shortcodes, utility classes, and normalize.css v8.0.1.

## Shortcodes
1. form with validate.js and formsubmit.co ajax submission. **You will need to change the CHANGEME in shortcodes.php and contact-form.js to match your destination email address and formsubmit.co account** Please refer to [formsubmit.co documentation for more information](https://formsubmit.co/documentation)
2. Carousel using lightweight [Siema](https://pawelgrzybek.github.io/siema/) library
3. Chevron to jump to next section with anchor links

## Whitelabeling
My attempt at "whitelabel" for the parent Astra theme settings. Look for "WHITELABLE_CHANGEME" in inc/core/class-astra-admin-settings.php and change this to your client's site name so it says "WHITELABEL_CHANGEME Site Settings" instead of "Astra Site Settings". This file also attempts to remove some of the premium options for Astra.
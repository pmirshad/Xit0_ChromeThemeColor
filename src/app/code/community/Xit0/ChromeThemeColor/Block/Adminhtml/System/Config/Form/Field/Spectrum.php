<?php

/**
 * @author     Irshad Pananilath
 * @package    Xit0_ChromeThemeColor
 * @copyright  Copyright (c) 2014-15 Irshad Pananilath
 * @license    The MIT License (MIT)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Xit0_ChromeThemeColor_Block_Adminhtml_System_Config_Form_Field_Spectrum extends Mage_Adminhtml_Block_System_Config_Form_Field {
  /**
   * Add Spectrum color picker [https://github.com/bgrins/spectrum]
   *
   * @param Varien_Data_Form_Element_Abstract $element
   * @return String
   */
  protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
    $element->setStyle('width: 200px;');

    // Default HTML
    $html = $element->getElementHtml();
    $elementId = $element->getHtmlId();

    // Placeholder element for spectrum
    $html .= '<input type="text" id="' . $elementId . '-scp" style="max-width: 60px;display: none;"/>';

    $jqueryJsPath = $this->getJsUrl('xit0/chromethemecolor/jquery/jquery-1.11.3.min.js');
    $spectrumJsPath = $this->getJsUrl('xit0/chromethemecolor/spectrum/spectrum.min.js');
    $spectrumCssPath = $this->getSkinUrl('xit0/chromethemecolor/spectrum/spectrum.min.css');

    if (Mage::registry('xit0-chromeThemeColor-jqueryLoaded') == false) {
      $html .= '<script type="text/javascript" src="'. $jqueryJsPath .'"></script>';
      $html .= '<script type="text/javascript">jQuery.noConflict();</script>';

      Mage::register('xit0-chromeThemeColor-jqueryLoaded', 1);
    }

    if (Mage::registry('xit0-chromeThemeColor-spectrumLoaded') == false) {
      $html .= '<script type="text/javascript" src="'. $spectrumJsPath .'"></script>';
      $html .= '<link rel="stylesheet" type="text/css" href="'. $spectrumCssPath . '">';

      Mage::register('xit0-chromeThemeColor-spectrumLoaded', 1);
    }

    // Tie all components together
    $html .= '
      <script type="text/javascript">
        //<![CDATA[
          Validation.add("validate-xit0-color", "Please enter a valid color in hex format", function(v) {
            return (v == "" || (v == null) || (v.length == 0)) || /^#([a-f0-9]{6}|[a-f0-9]{3})\b$/i.test(v);
          });

          jQuery(function($){
            $("#' . $elementId . '-scp").spectrum({
              \'color\': "' . Mage::getStoreConfig('xit0_chromethemecolor/theme/toolbar_color') . '",
              allowEmpty:true,
              hideAfterPaletteSelect:true,
              preferredFormat: "hex",
              showInitial: true,
              showInput: true,
              showPalette: true,
              palette: [
                ["#FFCDD2", "#EF9A9A", "#E57373", "#EF5350", "#F44336", "#E53935", "#D32F2F", "#C62828"],
                ["#F8BBD0", "#F48FB1", "#F06292", "#EC407A", "#E91E63", "#D81B60", "#C2185B", "#AD1457"],
                ["#E1BEE7", "#CE93D8", "#BA68C8", "#AB47BC", "#9C27B0", "#8E24AA", "#7B1FA2", "#6A1B9A"],
                ["#D1C4E9", "#B39DDB", "#9575CD", "#7E57C2", "#673AB7", "#5E35B1", "#512DA8", "#4527A0"],
                ["#C5CAE9", "#9FA8DA", "#7986CB", "#5C6BC0", "#3F51B5", "#3949AB", "#303F9F", "#283593"],
                ["#BBDEFB", "#90CAF9", "#64B5F6", "#42A5F5", "#2196F3", "#1E88E5", "#1976D2", "#1565C0"],
                ["#B3E5FC", "#81D4FA", "#4FC3F7", "#29B6F6", "#03A9F4", "#039BE5", "#0288D1", "#0277BD"],
                ["#B2EBF2", "#80DEEA", "#4DD0E1", "#26C6DA", "#00BCD4", "#00ACC1", "#0097A7", "#00838F"],
                ["#B2DFDB", "#80CBC4", "#4DB6AC", "#26A69A", "#009688", "#00897B", "#00796B", "#00695C"],
                ["#C8E6C9", "#A5D6A7", "#81C784", "#66BB6A", "#4CAF50", "#43A047", "#388E3C", "#2E7D32"],
                ["#DCEDC8", "#C5E1A5", "#AED581", "#9CCC65", "#8BC34A", "#7CB342", "#689F38", "#558B2F"],
                ["#F0F4C3", "#E6EE9C", "#DCE775", "#D4E157", "#CDDC39", "#C0CA33", "#AFB42B", "#9E9D24"],
                ["#FFF9C4", "#FFF59D", "#FFF176", "#FFEE58", "#FFEB3B", "#FDD835", "#FBC02D", "#F9A825"],
                ["#FFECB3", "#FFE082", "#FFD54F", "#FFCA28", "#FFC107", "#FFB300", "#FFA000", "#FF8F00"],
                ["#FFE0B2", "#FFCC80", "#FFB74D", "#FFA726", "#FF9800", "#FB8C00", "#F57C00", "#EF6C00"],
                ["#FFCCBC", "#FFAB91", "#FF8A65", "#FF7043", "#FF5722", "#F4511E", "#E64A19", "#D84315"],
                ["#D7CCC8", "#BCAAA4", "#A1887F", "#8D6E63", "#795548", "#6D4C41", "#5D4037", "#4E342E"],
                ["#F5F5F5", "#EEEEEE", "#E0E0E0", "#BDBDBD", "#9E9E9E", "#757575", "#616161", "#424242"],
                ["#CFD8DC", "#B0BEC5", "#90A4AE", "#78909C", "#607D8B", "#546E7A", "#455A64", "#37474F"]
              ],
              hide: function(color) {
                var hexColor = color ? color.toHexString() : "";
                $("#' . $elementId . '").val(hexColor);
              },
              change: function(color) {
                var hexColor = color ? color.toHexString() : "";
                $("#' . $elementId . '").val(hexColor);
              }
            });

            $(".sp-input").css("background-color",  "#ffffff");

            $(".sp-replacer").on("click", function() {
                $("#' . $elementId . '-scp").hide();
            });

            $("#' . $elementId . '").on("keyup", function() {
                var userColor = $("#' . $elementId . '").val();
                var tiny = tinycolor(userColor);

                if((userColor && tiny.isValid()) || !userColor) {
                  $("#' . $elementId . '-scp").spectrum("set", userColor);
                }
            });
          });
        //]]>
      </script>';

    return $html;
  }
}

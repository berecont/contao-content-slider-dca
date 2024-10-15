<?php
// contao/dca/tl_content.php
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderStopAutoplay'] = [
    'label' => ['Stop Autoplay','Wenn angehakt, und der automatische Wechsel ist aktiviert, dann stoppt der Slider bei mouse-hover.
                Die Variable ist im Template mit <em>sliderStopAutoplay</em> verfügbar.'],
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w25 clr m12'],
    'sql' => ['type' => 'boolean', 'default' => false],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderInitClass'] = [
    'label' => ['Swiper-Klasse','Dient zur Initialisierung eines einzelnen Swiper-Elementes, wenn mehrere Swiper-Elemente mit unterschiedlichen Parameter pro Seite vorhanden sind.
                    Die Variable ist im Template mit <em>sliderInitClass</em> verfügbar.'],
    'inputType' => 'text',
    'eval' => ['tl_class' => 'clr w50', 'maxlength' => 64,],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderCustomOptions'] = [
    'label' => ['Parameter','Die Parameter sind im Template mit der Variable <em>sliderCustomOptions</em> verfügbar. 
                            Im Twig-Template mit <em>{{ data.sliderCustomOptions }}</em> statt <em>{# Put custom options here #}</em> einsetzen.<br>
                            Beispiel: <em>{% if data.sliderCustomOptions is defined and data.sliderCustomOptions is not empty %} {{ data.sliderCustomOptions|raw }} {% endif %}</em>'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr w50', 'rte' => 'ace|html', 'allowHtml' => true],
    'sql' => 'blob NULL',
    'load_callback' => [static function ($value) {
        if (empty($value)) {
            return null;
        }

        // HTML-Entities dekodieren (nur einmal)
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }],
    'save_callback' => [static function ($value) {
        if (empty($value)) {
            return null;
        }

        // Keine zusätzliche Kodierung, nur die Entities dekodieren, um doppelte Kodierung zu verhindern
        return Contao\StringUtil::decodeEntities($value);
    }],
];


PaletteManipulator::create()
    ->addField('sliderStopAutoplay', 'slider_legend', PaletteManipulator::POSITION_APPEND)    
    ->addField('sliderInitClass', 'slider_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('sliderCustomOptions', 'slider_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('swiper', 'tl_content')
;


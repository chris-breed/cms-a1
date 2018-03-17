<?php
/**
* @package   yoo_master2
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

 /*
 * Generate 3-column layout
 */
 $config          = $this['config'];
 $sidebars        = $config->get('sidebars', array());
 $columns         = array('main' => array('width' => 60, 'alignment' => 'right'));
 $sidebar_classes = '';
 $classes = array();
 $gcf = function($a, $b = 60) use(&$gcf) {
     return (int) ($b > 0 ? $gcf($b, $a % $b) : $a);
 };

 $fraction = function($nominator, $divider = 60) use(&$gcf) {
     return $nominator / ($factor = $gcf($nominator, $divider)) .'-'. $divider / $factor;
 };

 foreach ($sidebars as $name => $sidebar) {
 	if (!$this['widgets']->count($name)) {
         unset($sidebars[$name]);
         continue;
     }

     $columns['main']['width'] -= @$sidebar['width'];
     $sidebar_classes .= " tm-{$name}-".@$sidebar['alignment'];
 }

 if ($count = count($sidebars)) {
 	$sidebar_classes .= ' tm-sidebars-'.$count;
 }

 $columns += $sidebars;
 foreach ($columns as $name => &$column) {

     $column['width']     = isset($column['width']) ? $column['width'] : 0;
     $column['alignment'] = isset($column['alignment']) ? $column['alignment'] : 'left';

     $shift = 0;
     foreach (($column['alignment'] == 'left' ? $columns : array_reverse($columns, true)) as $n => $col) {
         if ($name == $n) break;
         if (@$col['alignment'] != $column['alignment']) {
             $shift += @$col['width'];
         }
     }
     $column['class'] = sprintf('tm-%s uk-width-medium-%s%s', $name, $fraction($column['width']), $shift ? ' uk-'.($column['alignment'] == 'left' ? 'pull' : 'push').'-'.$fraction($shift) : '');
 }

 /*
  * Grid
  */
 $displays  = array('small', 'medium', 'large');
 foreach (array_keys($config->get('grid', array())) as $name) {
     $grid = array("tm-{$name} uk-grid");
     if ($this['config']->get("grid.{$name}.divider", false)) {
         $grid[] = 'uk-grid-divider';
     }
     $widgets = $this['widgets']->load($name);
     foreach($displays as $display) {
         if (!array_filter($widgets, function($widget) use ($config, $display) { return (bool) $config->get("widgets.{$widget->id}.display.{$display}", true); })) {
             $grid[] = "uk-hidden-{$display}";
         }
     }
     $classes["grid.$name"] = $grid;
 }


 /*
  * Add body classes
  */
 $classes['body'][] = $this['system']->isBlog() ? 'tm-isblog' : 'tm-noblog';
 $classes['body'][] = $config->get('page_class');
 $classes['body'][] = ' '.$config->get('article');
 $classes['body'][] = $this['config']->get('page_title') ? 'tm-page-title-false' : '';

 /*
  * Flatten classes
  */
 $classes = array_map(function($array) { return implode(' ', $array); }, $classes);

 /*
  * Add body classes to config
  */
 $config->set('body_classes', trim($classes['body']));
 /*
  * Add social buttons
  */
 $config->set('body_config', json_encode(array(
     'twitter'  => (int) $config->get('twitter', 0),
     'plusone'  => (int) $config->get('plusone', 0),
     'facebook' => (int) $config->get('facebook', 0),
     'style'    => $config->get('style')
 )));

/*
 * Add assets
 */

// add css
$this['asset']->addFile('css', 'css:theme.css');
$this['asset']->addFile('css', 'css:custom.css');

// add scripts
$this['asset']->addFile('js', 'js:uikit.js');
$this['asset']->addFile('js', 'warp:vendor/uikit/js/components/autocomplete.js');
$this['asset']->addFile('js', 'warp:vendor/uikit/js/components/search.js');
$this['asset']->addFile('js', 'warp:vendor/uikit/js/components/tooltip.js');
$this['asset']->addFile('js', 'js:social.js');
$this['asset']->addFile('js', 'js:theme.js');


// internet explorer
if ($this['useragent']->browser() == 'msie') {
    $head[] = sprintf('<!--[if IE 8]><link rel="stylesheet" href="%s"><![endif]-->', $this['path']->url('css:ie8.css'));
    $head[] = sprintf('<!--[if lte IE 8]><script src="%s"></script><![endif]-->', $this['path']->url('js:html5.js'));
}

if (isset($head)) {
    $this['template']->set('head', implode("\n", $head));
}

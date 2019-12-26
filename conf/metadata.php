<?php
/**
 * Options for the ApexCharts plugin
 *
 * @author Karl Nickel <kazozaagir@gmail.com>
 */

$meta['url_yaml'] = array('string');
$meta['acharts_js'] = array('string');
$meta['width'] = array('string', '_pattern' => '/^(?:\d+(px|%))?$/');
$meta['height'] = array('string', '_pattern' => '/^(?:\d+(px|%))?$/');
$meta['align'] = array('multichoice', '_choices' => array('none','left','center','right'));

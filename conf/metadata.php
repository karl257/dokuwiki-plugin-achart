<?php
/**
 * Options for the ApexCharts plugin
 *
 * @author Karl Nickel <kazozaagir@gmail.com>
 */

$meta['width'] = array('string', '_pattern' => '/^(?:\d+(px|%))?$/');
$meta['height'] = array('string', '_pattern' => '/^(?:\d+(px|%))?$/');
$meta['align'] = array('multichoice', '_choices' => array('none','left','center','right'));

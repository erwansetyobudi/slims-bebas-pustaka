<?php
/**
 * Plugin Name: Bebas Pustaka
 * Plugin URI: https://github.com/erwansetyobudi/slims-bebas-pustaka
 * Description: Plugins untuk mencetak surat keterangan bebas pustaka. Plugin ini dimodifikasi dari https://github.com/drajathasan/slims-bebas-pustaka
 * Version: 2.0.0
 * Author: Erwan Setyo Budi
 * Author URI: https://github.com/erwansetyobudi/
 */
use SLiMS\Plugins;

$plugin = Plugins::getInstance();

Plugins::getInstance()->registerAutoload(__DIR__);
Plugins::menu('circulation', 'Bebas Pustaka', __DIR__ . '/pages/bebas_pustaka.php');
Plugins::menu('circulation', 'Daftar Bebas Pustaka', __DIR__ . '/pages/bebas_pustaka_history.php');
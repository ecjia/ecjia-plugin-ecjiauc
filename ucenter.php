<?php
/*
Plugin Name: UCenter
Plugin URI: http://www.ecjia.com/plugins/ecjia.ucenter/
Description: UCenter会员系统
Author: ECJIA TEAM
Version: 2.0.0
Author URI: http://www.ecjia.com/
Plugin App: integrate
*/
defined('IN_ECJIA') or exit('No permission resources.');

class plugin_integrate_ucenter {

    public static function install() {
        $param = array('file' => __FILE__);
        return RC_Api::api('integrate', 'integrate_install', $param);
    }


    public static function uninstall() {
        $param = array('file' => __FILE__);
        return RC_Api::api('integrate', 'integrate_uninstall', $param);
    }

}

Ecjia_PluginManager::extend('ucenter', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ucenter.class.php';
    return new ucenter();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_integrate_ucenter', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_integrate_ucenter', 'uninstall'));

/**
 * 调用UCenter的函数
 *
 * @param string $func
 * @param array $params
 *
 * @return mixed
 */
function uc_call($func, $params = null)
{
    if (ecjia::config('integrate_code') == 'ucenter') {
        restore_error_handler();
        $ucenter = royalcms('ucenter');
        $res = call_user_func_array([$ucenter, $func], $params);
        return $res;
    } else {
        return false;
    }
}

// end
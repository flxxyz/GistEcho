<?php
/**
 * typecho 显示gist插件
 * Gist 标签格式为: [gist gist地址] 
 *
 * @package GistEcho
 * @author flxxyz
 * @version 1.0.0
 * @link https://www.flxxyz.com
 */
class GistEcho_Plugin implements Typecho_Plugin_Interface{
        /**
         * 激活插件方法,如果激活失败,直接抛出异常
         *
         * @access public
         * @return void
         * @throws Typecho_Plugin_Exception
         */
        public static function activate() {
                Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = ['GistEcho_Plugin', 'parse'];
                Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = ['GistEcho_Plugin', 'parse'];
                return '安装成功';
        }

        /**
         * 禁用插件方法,如果禁用失败,直接抛出异常
         *
         * @static
         * @access public
         * @return void
         * @throws Typecho_Plugin_Exception
         */
        public static function deactivate() {
                return '卸载成功';
        }

        /**
         * 获取插件配置面板
         *
         * @access public
         * @param Typecho_Widget_Helper_Form $form 配置面板
         * @return void
         */
        public static function config(Typecho_Widget_Helper_Form $form) {}

        /**
         * 个人用户的配置面板
         *
         * @access public
         * @param Typecho_Widget_Helper_Form $form
         * @return void
         */
        public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

        /**
         * 插件实现方法
         *
         * @access public
         * @return string
         */
        public static function parse($text, $widget, $lastResult) {
                $text = empty($lastResult) ? $text : $lastResult;
                if ($widget instanceof Widget_Archive || $widget instanceof Widget_Abstract_Comments) {
                        if (preg_match("/\[gist <a href=\".*?\">(.*?)<\/a>\]/", $text, $matches)) {
                                $gist = trim($matches[1]);
                                $search = "[gist <a href=\"{$gist}\">{$gist}</a>]";
                                $replace = "<script src=\"{$gist}.js\"></script>";
                                return str_replace($search, $replace, $text);
                        }
                }
                return $text;
        }
}

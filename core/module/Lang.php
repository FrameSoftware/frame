<?php

    /**
 * Frame - A lightweight PHP Framework
 */

    namespace Frame\Core\Module;

     /**
      * Class Lang
      *
      * @package    Frame
      * @subpackage Modules
      * @category   Language
      * @author     Nana Axel <ax.lnana@outlook.com>
      */
    class Lang
    {

        /**
         * Lang Cache
         * Used to store already translated text
         * @static array
         * @access private
         */
        private static $langCache = array();

        /**
         * Currently used lang file
         * @var array
         * @access private
         */
        private $langFile;

        private function _getLangFile($lang)
        {

        }

    }
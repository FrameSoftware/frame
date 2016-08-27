<?php

    namespace Frame\Core\Module;

    use \Frame\Core\Exception;

    /**
     * Configurator class permit the user to acces XML , or JSON documennt
     *
     * @author Simo Adonis <simoadonis@gmail.com>
     */
    class Configuration
    {

        /**
         * Load a xml configuration file
         * @author Nana Axel <ax.lnana@outlook.com>
         * @param string $file_path
         * @return array
         * @access private
         */
        private function _loadXmlConfig($file_path)
        {
            return json_decode(json_encode(simplexml_load_file($file_path)), TRUE);
        }

        /**
         * Load a json configuration file
         * @author Nana Axel <ax.lnana@outlook.com>
         * @param string $file_path
         * @return array
         * @access private
         */
        private function _loadJsonConfig($file_path)
        {
            return json_decode(file_get_contents($file_path), TRUE);
        }

        /**
         * Load an ini configuration file
         * @author Nana Axel <ax.lnana@outlook.com>
         * @param string $file_path
         * @return array
         * @access private
         */
        private function _loadIniConfig($file_path)
        {
            return parse_ini_file($file_path);
        }

        /**
         * Load a configuration file
         * @author Nana Axel <ax.lnana@outlook.com>
         * @param string $filename The name of the configuration file. This file have to be stored in
         * @return array
         * @throws Exception
         */
        public function loadConfig($filename)
        {
            $file_path = FRAME_CONFIG_PATH . '/' . $filename;
            if (file_exists($file_path)) {
                $basename = basename($file_path);
                if (strrpos($basename, '.') !== FALSE) {
                    $extension = substr($basename, strrpos($basename, '.') + 1);
                    switch ($extension) {
                        case 'xml':
                            return $this->_loadXmlConfig($file_path);

                        case 'json':
                            return $this->_loadJsonConfig($file_path);

                        case 'ini':
                            return $this->_loadIniConfig($file_path);

                        default:
                            throw new Exception(array(
                                'message' => "Can't load the configuration file at the path \"{$file_path}\". Unsupported extension. Supported extensions are .xml, .json, .ini",
                                'status'  => 500
                            ));
                    }
                }
                throw new Exception(array(
                    'message' => "Can't load the configuration file at the path \"{$file_path}\". Unsupported extension. Supported extensions are .xml, .json, .ini",
                    'status'  => 500
                ));
            }
            throw new Exception(array(
                'message' => "Can't load the configuration file at the path \"{$file_path}\". The file doesn't exist.",
                'status'  => 500
            ));
        }

    }

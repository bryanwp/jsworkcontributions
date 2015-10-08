<?php
if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('WBC_UploadHandler')) {
    class WBC_UploadHandler extends UploadHandler
    {
        public function __construct() {

            $upload_dir = wp_upload_dir();

            $options = array(
                'script_url' => WBC_URL,
                'upload_dir' => $upload_dir['basedir'] . '/clipart/',
                'upload_url' => $upload_dir['baseurl'] . '/clipart/',
                'image_versions' => array(
                    // The empty image version key defines options for the original image:
                    '' => array(
                        // Automatically rotate images based on EXIF meta data:
                        'auto_orient' => true
                    ),
                    // Uncomment the following to create medium sized images:
                    /*
                    'medium' => array(
                        'max_width' => 800,
                        'max_height' => 600
                    ),
                    */
                    'thumbnail' => array(
                        // Uncomment the following to use a defined directory for the thumbnails
                        // instead of a subdirectory based on the version identifier.
                        // Make sure that this directory doesn't allow execution of files if you
                        // don't pose any restrictions on the type of uploaded files, e.g. by
                        // copying the .htaccess file from the files directory for Apache:
                        //'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/thumb/',
                        //'upload_url' => $this->get_full_url().'/thumb/',
                        // Uncomment the following to force the max
                        // dimensions and e.g. create square thumbnails:
                        //'crop' => true,
                        'max_width' => 80,
                        'max_height' => 80
                    )
                ),
                'print_response' => true
            );



            parent::__construct($options);
        }




        protected function initialize() {
            switch ($this->get_server_var('REQUEST_METHOD')) {
                case 'OPTIONS':
                case 'HEAD':
                    $this->head();
                    break;
                case 'GET':
                    $this->get($this->options['print_response']);
                    break;
                case 'PATCH':
                case 'PUT':
                case 'POST':
                    $this->post($this->options['print_response']);
                    break;
                case 'DELETE':
                    $this->delete($this->options['print_response']);
                    break;
                default:
                    $this->header('HTTP/1.1 405 Method Not Allowed');
            }


            if (defined('DOING_AJAX') && DOING_AJAX) {
                die;
            }
        }
    }
}


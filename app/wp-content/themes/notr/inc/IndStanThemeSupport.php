<?php
/**
 * IndStan Theme Support Class
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @author I N D U S T R I A L  S T A N D A R D S  L T D 
 * @package  Veritas Planning Ltd.
 *
*/
namespace Notr;

if (!defined('ABSPATH')) die();

class IndStanThemeSupport
{
    /**
     * holds singleton instance of the class
     */
    private static $instance;
    
    /**
     * get singleton instance
     *
    */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * triggers functions on class load
     *
    */
    private function __construct()
    {
        $this->addHooks();
    }

    private function addHooks() 
    {
        add_action('after_setup_theme', [ $this , 'themeSetup' ]);
    }

    /**
     * Essential theme supports
     * */
    public function themeSetup()
    {

            /** automatic feed link*/
            add_theme_support( 'automatic-feed-links' );
         
            /** tag-title **/
            add_theme_support( 'title-tag' );
         
            /** post formats */
            $post_formats = [
                'aside',
                'image',
                'gallery',
                'video',
                'audio',
                'link',
                'quote',
                'status'
            ];

            add_theme_support( 'post-formats', $post_formats);
         
            /** post thumbnail **/
            add_theme_support( 'post-thumbnails' );

            /** 
            * HTML5 support 
            * Switch default core markup for search form, comment form, and comments
            * to output valid HTML5.
            */
            add_theme_support(
                'html5',
                    array(
                      'search-form',
                      'comment-form',
                      'comment-list',
                      'gallery',
                      'caption',
                      'script',
                      'style',
                    )
            );
            
            /**
             * Adds block style Support
             * 
            */
            add_theme_support( 'wp-block-styles' );

            add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
         
            /** refresh widgest **/
            add_theme_support( 'customize-selective-refresh-widgets' );

         
            /** custom background **/
            // $bg_defaults = array(
            //     'default-image'          => '',
            //     'default-preset'         => 'default',
            //     'default-size'           => 'cover',
            //     'default-repeat'         => 'no-repeat',
            //     'default-attachment'     => 'scroll',
            // );
            // add_theme_support( 'custom-background', $bg_defaults );
         
            /** custom header **/
            $header_defaults = array(
                'default-image'          => '',
                'width'                  => 300,
                'height'                 => 60,
                'flex-height'            => true,
                'flex-width'             => true,
                'default-text-color'     => '',
                'header-text'            => true,
                'uploads'                => true,
            );

            add_theme_support( 'custom-header', $header_defaults );
         
            /** custom log **/
            add_theme_support( 'custom-logo', array(
                'height'      => 60,
                'width'       => 400,
                'flex-height' => true,
                'flex-width'  => true,
                'header-text' => array( 'site-title', 'site-description' ),
            ) );

            // Add support for responsive embeds.
            add_theme_support( 'responsive-embeds' );

            // Set content-width.
            global $content_width;

            if ( ! isset( $content_width ) ) {
                $content_width = 580;
            };

            //Set the Default post thumbnail size
            set_post_thumbnail_size( 388, 247, true);

             // Add custom image size used in Cover Template.
            add_image_size( 'full-size', '2048', 2048 );
            add_image_size( 'hero-img', 1920, 1080 );
            add_image_size( 'our-work', 636, 636 );

            
            // Custom logo.
            
            $logo_width  = 120;
            $logo_height = 90;

            add_theme_support(
                'custom-logo',
                array(
                  'height'      => $logo_height,
                  'width'       => $logo_width,
                  'flex-height' => true,
                  'flex-width'  => true,
                )
            );

            // If the retina setting is active, double the recommended width and height.
            
            if ( get_theme_mod( 'retina_logo', false ) ) {
                $logo_width  = floor( $logo_width * 2 );
                $logo_height = floor( $logo_height * 2 );
            }

            /*
            * Make theme available for translation.
            * Translations can be filed in the /languages/ directory.
            * If you're building a theme based on Twenty Twenty, use a find and replace
            * to change 'peplanning' to the name of your theme in all the template files.
            */
            load_theme_textdomain( 'indstan' );


            // Add support for full and wide align images.
            add_theme_support( 'align-wide' );

            register_nav_menus(
                    array(
                        'primary' => __( 'Primary menu',     'indstan' ),
                        'footer' => __( 'Footer menu',     'indstan' )
                    )
                );
            
            add_editor_style( 'style-editor.css' );

    }

 }
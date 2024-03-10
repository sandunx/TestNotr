<?php
/**
 * IndStan Discogs Class
 *
 *
 * @author I N D U S T R I A L  S T A N D A R D S  L T D
 * @package  Needle On The Record.
 *
 */
namespace Notr;

use \Discogs\ClientFactory;
use \Discogs\Subscriber\ThrottleSubscriber;
use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Middleware;

if (!defined('ABSPATH')) die();

class Discogs
{

    private const ACCESS_TOKEN = 'KxcQABXmszqZWHOcFAxDQhUcELsPvQuKBIwDXQKD';
    /**
     * holds singleton instance of the class
     */
    private static $instance;

    const DISCOGS_TERM_ATTR = ['year','format','genre', 'style','country','Record Label'];

    const DISCOGS_META_ATTR = ['cat_no','barcode'];


    /**
     * holds discogs client
     */
    private static $client;

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
        add_action( 'save_post', [$this, 'getReleaseInfo'], 10, 2 );
        add_action( 'update_post', [$this, 'getReleaseInfo'], 10, 2 );
//        add_filter( 'woocommerce_product_data_tabs', [$this, 'addProductTab']);
//        add_action( 'woocommerce_product_data_panels', [ $this, 'addVinylAttributesDataFields'] );
        add_action( 'woocommerce_update_product', [$this, 'getReleaseInfo'], 10, 2 );

    }

    public function addProductTab( $tabs )
    {
        $tabs['notr_vinyl_attributes'] = [
                'label' => __('Vinyl Attributes', 'notr'),
                'target' => 'vinyl_attributes',
                'class' => array(),
                'priority' => 50,
        ];
        return $tabs;
    }




        function addVinylAttributesDataFields() {


            global $woocommerce, $post;
            ?>
            <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
             <div id="vinyl_attributes" class="panel woocommerce_options_panel">
                <?php
                $prefix = '_notr_';

                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'genre',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Genre', 'notr' ),
                    'description'   => __( 'Genre taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'label',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Record Label', 'notr' ),
                    'description'   => __( 'Record Label taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'style',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Style', 'notr' ),
                    'description'   => __( 'Style Attribute taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'country',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Country', 'notr' ),
                    'description'      => __( 'Release Country Attribute taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'format',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Format', 'notr' ),
                    'description'      => __( 'Format taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                woocommerce_wp_text_input( array(
                    'id'            => $prefix. 'year',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Release Year', 'notr' ),
                    'description'      => __( 'Year taken from Discogs', 'notr' ),
                    'default'  		=> '0',
                    'desc_tip'    	=> true,
                ) );
                ?>
            </div>
            <?php

        }



    public function initDiscogsApi()
    {
        $handler = HandlerStack::create();
        $throttle = new ThrottleSubscriber();
        $handler->push( Middleware::retry($throttle->decider(), $throttle->delay()));

        $this->client = ClientFactory::factory([
            'handler'=>$handler,
            'headers' => [
                'User-Agent' => 'NeedleOnTheRecord/0.1',
                'Authorization' => 'Discogs token=' . $this::ACCESS_TOKEN,
            ]
        ]);


    }

    public function getReleaseInfo($post_id)
    {

        // Only for shop order
        if ('product' !== $_POST['post_type'])
            return $post_id;

        // Checking that is not an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user’s permissions (for 'shop_manager' and 'administrator' user roles)
        if (!current_user_can('edit_shop_order', $post_id) && !current_user_can('edit_shop_orders', $post_id))
            return $post_id;


        $product = wc_get_product( $_POST['ID'] );

        $product_attr = $product->get_attributes('edit');

       error_log(print_r($product_attr, TRUE));

        $sku = $product->get_sku();
        $this->initDiscogsApi();
        $response = $this->client->search(['barcode' => $sku, 'country' => 'UK']);

        foreach ($response['results'] as $result) {

            $product->set_name($result['title']);

            $thedata = [];
            $i = 0;
            foreach ($result as $key => $value) {
                $term_taxonomy_ids = wp_set_object_terms( $_POST['ID'], $key, 'pa_' . $key, true );
                $thedata[$i] = [
                        'name' => 'pa_' . $key,
                        'value'=> $value,
                        'is_visible' => '1',
                        'is_variation' => '0',
                        'is_taxonomy' => '1'
                    ];
                $i++;
                update_post_meta( $_POST['ID'],'_product_attributes', $thedata );
//                $rawAttributes[$key] = [
//                    'name' => $key,
//                    'value' => $value,
//                    'position' => 0,
//                    'is_visible' => 1,
//                    'is_variation' => 0,
//                    'is_taxonomy' => 1
//                ];

//
//                $attr = [
//                    'label' => $result['label'],
//                    'style' => $result['style'],
//                    'country' => $result['country'],
//                    'year' => $result['year'],
//                    'format' => $result['format'],
//                    'catno' => $result['catno'],
//                    'barcode' => $result['barcode'],
//                ];
            };
            $product->save();
        }
    }
}
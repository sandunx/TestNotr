<?php

namespace UkrSolution\BarcodeScanner\API\classes;

use UkrSolution\BarcodeScanner\features\locations\Locations;

class ResultsHelper
{
    private static $locationsList = array();

    public static function getLocationsList()
    {
        if (!self::$locationsList) {
            $Locations = new Locations();
            self::$locationsList = $Locations->get();
        }

        return self::$locationsList;
    }

    public static function getStoreData()
    {
        $baseLocation = \wc_get_base_location();
        $_country = "";
        $_state = "";
        if ($baseLocation && isset($baseLocation["country"]) && $baseLocation["country"]) {
            $_country = \WC()->countries->countries[$baseLocation["country"]];
            $states = \WC()->countries->get_states($baseLocation["country"]);

            if ($states && isset($baseLocation["state"]) && $baseLocation["state"]) {
                $_state = isset($states[$baseLocation["state"]]) ? $states[$baseLocation["state"]] : "";
            }
        }
        return array(
            "name" => get_bloginfo("name"),
            "address" => array(
                "address" => get_option('woocommerce_store_address'),
                "address_2" => get_option('woocommerce_store_address_2'),
                "country" => $_country,
                "state" => $_state,
                "city" => get_option('woocommerce_store_city'),
                "postcode" => get_option('woocommerce_store_postcode'),
            ),
        );

        return self::$locationsList;
    }
}

<?php

use UkrSolution\BarcodeScanner\features\settings\Settings;

$settings = new Settings();

?>
<title>Barcode Scanner mobile</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<a href="#barcode-scanner-mobile"></a>
<div id="ukrsolution-barcode-scanner"></div>
<div id="ukrsolution-barcode-scanner-mobile"></div>

<div id="barcode-scanner-mobile-preloader">
    <div style="user-select: none;">Loading...</div>
</div>
<style class="usbs-style"><?php echo $customCssMobile; ?></style>
<script>
    window.usbsLangsMobile = <?php echo json_encode($this->getLangs()); ?>;
</script>
<script>
    window.usbsInterfaceMobile = <?php echo json_encode(apply_filters("scanner_product_fields_filter", $interfaceData::getFields(true))); ?>;
</script>
<script>
    window.usbsCategoriesMobile = <?php echo json_encode($productCategories); ?>;
</script>
<script>
    window.usbsMobile = <?php echo json_encode($jsData); ?>;
</script>
<script>
    window.usbsHistory = <?php echo json_encode($usbsHistory); ?>;
</script>
<script>
    window.usbsUserCF = <?php echo json_encode($usbsUserCF); ?>;
</script>

<script>
    <?php
    $field = $settings->getSettings("modifyPreProcessSearchString");
    $fnContent = $field === null ? "" : trim($field->value);

    if ($fnContent) {
        echo "window.usbsModifyPreProcessSearchString = function (bs_search_string) {" . $fnContent . " ; \n return bs_search_string; };";
    } ?>
</script>
<form class="bs-settings-input-conditions" id="bs-settings-orders-tab" method="POST" action="<?php echo $actualLink; ?>">
    <input type="hidden" name="tab" value="orders" />
    <input type="hidden" name="storage" value="table" />
    <table class="form-table">
        <tbody>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("Order Status", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- Default order status -->
            <tr>
                <th scope="row" style="width: 240px;">
                    <?php echo __("Default order status", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("defaultOrderStatus");
                    $defaultValue = $defaultValue === null ? $settings->getField("general", "defaultOrderStatus", "wc-processing") : $defaultValue->value;
                    ?>
                    <select name="defaultOrderStatus">
                        <?php
                        foreach ($settings->getOrderStatuses() as $key => $value) {
                            $selected = "";
                            if ($defaultValue === $key) {
                                $selected = ' selected=selected ';
                            }
                        ?>
                            <option value="<?php esc_html_e($key, 'us-barcode-scanner'); ?>" <?php esc_html_e($selected, 'us-barcode-scanner'); ?>><?php esc_html_e($value, 'us-barcode-scanner'); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <!-- Change order status automatically if all items picked/fulfilled. -->
            <tr>
                <th scope="row" style="width: 240px;">
                    <?php echo __("Change order status automatically if all items picked/fulfilled.", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("autoStatusFulfilled");
                    $defaultValue = $defaultValue === null ? "" : $defaultValue->value;
                    ?>
                    <select name="autoStatusFulfilled">
                        <option value=""><?php echo __('Not selected', 'us-barcode-scanner'); ?></option>
                        <?php
                        foreach ($settings->getOrderStatuses() as $key => $value) {
                            $selected = "";
                            if ($defaultValue === $key) {
                                $selected = ' selected=selected ';
                            }
                        ?>
                            <option value="<?php esc_html_e($key, 'us-barcode-scanner'); ?>" <?php esc_html_e($selected, 'us-barcode-scanner'); ?>><?php esc_html_e($value, 'us-barcode-scanner'); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("Shipping Method", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- Default shipping method -->
            <tr>
                <th scope="row" style="width: 240px;">
                    <?php echo __("Default shipping method", "us-barcode-scanner"); ?>
                </th>
                <td class="shipping-methods">
                    <?php
                    $shippingsMethods = $settings->getAllShippingMethod();

                    $field = $settings->getSettings("defaultShippingMethods");
                    $shippingMethodsValue = $field === null ? "" : $field->value;
                    $shippingMethodsValueArr = $shippingMethodsValue ? explode(",", $shippingMethodsValue) : array();

                    usort($shippingsMethods, function ($a, $b) use ($shippingMethodsValueArr) {
                        $aIndex = array_search($a['id'], $shippingMethodsValueArr);
                        $bIndex = array_search($b['id'], $shippingMethodsValueArr);

                        $aIndex = ($aIndex === false) ? PHP_INT_MAX : $aIndex;
                        $bIndex = ($bIndex === false) ? PHP_INT_MAX : $bIndex;

                        return $aIndex - $bIndex;
                    });
                    ?>
                    <input type="hidden" name='defaultShippingMethods[]' value="<?php echo $shippingMethodsValue; ?>" />
                    <select multiple data-placeholder='Choose a shipping...' multiple class='chosen-select-shipping-methods' style="width:300px;">
                        <?php foreach ($shippingsMethods as $method) : ?>
                            <option value="<?php echo $method['id']; ?>"><?php echo $method['title']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php  ?>
                </td>
            </tr>
            <!-- Shipping method is required -->
            <tr id="bs_shipping_required">
                <th scope="row">
                    <?php echo __("Shipping method is required", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("shippingRequired");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_shipping_required input[name='shippingRequired']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="shippingRequired" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("Order fulfillment", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- Enable Order fulfillment -->
            <tr id="bs_enable_order_fulfillment">
                <th scope="row">
                    <?php echo __("Enable Order fulfillment", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("orderFulfillmentEnabled");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_enable_order_fulfillment input[name='orderFulfillmentEnabled']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="orderFulfillmentEnabled" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Order fulfillment enabled by default - Disable by default -->
            <tr id="bs_order_fulfillment_enabled">
                <th scope="row">
                    <?php echo __("Enabled by default (no need to press button)", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("orderFulfillmentByDefault");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_order_fulfillment_enabled input[name='orderFulfillmentByDefault']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="orderFulfillmentByDefault" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label><br />
                    <i><?php echo __('If this option enabled then "fulfillment" mode will be active by default.', "us-barcode-scanner"); ?></i>
                </td>
            </tr>
            <!-- Order fulfillment -->
            <tr id="fulfillment_scan_item_qty">
                <th scope="row">
                    <?php echo __("Take into account item's quantity", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("fulfillmentScanItemQty");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#fulfillment_scan_item_qty input[name='fulfillmentScanItemQty']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="fulfillmentScanItemQty" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label><br />
                    <i><?php echo __("In order fulfillment mode, this option will take into account amount of the purchased items (qty). So, order item will be  fulfilled (marked with green arrow) as soon as product is scanned in the same amount as was purchased. E.g. if 10 the same items were purchased - you will have to scan the barcode 10 times.", "us-barcode-scanner"); ?></i>
                </td>
            </tr>
            <!-- Use tracking number for fulfillment -->
            <tr>
                <th scope="row">
                    <?php echo __("Use tracking number for fulfillment", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("orderFulFillmentField");
                    $defaultValue = $defaultValue === null ? "" : $defaultValue->value;
                    ?>
                    <span>
                        <input type="text" name="orderFulFillmentField" value="<?php esc_html_e($defaultValue); ?>" placeholder="<?php echo __("Field name", "us-barcode-scanner"); ?>" />
                        <div>
                            <i><?php echo __("Specify meta custom field name of the tracking number (you may need help of web-developer to find it)", "us-barcode-scanner"); ?></i>
                        </div>
                    </span>
                </td>
            </tr>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("Email notifications", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- Send new order email to admin - Disable by default -->
            <tr id="bs_send_email_for_created_order">
                <th scope="row">
                    <?php echo __("Send new order email to admin", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("sendAdminEmailCreatedOrder");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_send_email_for_created_order input[name='sendAdminEmailCreatedOrder']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="sendAdminEmailCreatedOrder" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Send new order email to client - Enable by default -->
            <tr id="bs_send_email_for_created_order">
                <th scope="row">
                    <?php echo __("Send new order email to client", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("sendClientEmailCreatedOrder");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_send_email_for_created_order input[name='sendClientEmailCreatedOrder']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="sendClientEmailCreatedOrder" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("Display / hide fields", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- Display "Coupon" field -->
            <tr id="display_coupon_field">
                <th scope="row">
                    <?php echo __('Display "Coupon" field', "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("displayCouponField");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#display_coupon_field input[name='displayCouponField']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="displayCouponField" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Display "Customer provided note" field -->
            <tr id="display_note_field">
                <th scope="row">
                    <?php echo __('Display "Customer provided note" field', "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("displayNoteField");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#display_note_field input[name='displayNoteField']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="displayNoteField" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Display "PAY" buttons -->
            <tr id="displayPayButton">
                <th scope="row">
                    <?php echo __('Display "PAY" buttons', "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("displayPayButton");
                    $defaultValue = $defaultValue === null ? 'on' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#displayPayButton input[name='displayPayButton']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="displayPayButton" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <tr class="usbs-section-label">
                <td>
                    <h2><?php echo __("New order", "us-barcode-scanner"); ?></h2>
                </td>
            </tr>
            <!-- New order default user -->
            <tr>
                <th scope="row" style="width: 240px;">
                    <?php echo __("New order default user", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("nowOrderDefaultUser");
                    $defaultValue = $defaultValue === null ? "" : $defaultValue->value;
                    $userName = "";
                    if ($defaultValue) {
                        $user = get_user_by("ID", $defaultValue);
                        if ($user) {
                            $userName = $user->display_name . " (" . $user->user_login . ") - " . $user->user_email;
                        }
                    }
                    ?>
                    <span style="position: relative;">
                        <input type="text" value="<?php esc_html_e($userName); ?>" placeholder="<?php echo __("Find user", "us-barcode-scanner"); ?>" class="order-default-user-search-input" />
                        <input type="hidden" name="nowOrderDefaultUser" value="<?php esc_html_e($defaultValue); ?>" class="order-default-user-id-search-input" />
                        <span style="position: relative;">
                            <span style="position: absolute; top: -5px; left: 0; display: none;" id="order-default-user-search-preloader">
                                <span id="barcode-scanner-action-preloader">
                                    <span class="a4b-action-preloader-icon"></span>
                                </span>
                            </span>
                        </span>
                        <ul class="order-default-users-search-list"></ul>
                        <div>
                            <i><?php echo __("Link this user (by default) to all newly created orders via Barcode Scanner popup.", "us-barcode-scanner"); ?></i>
                        </div>
                    </span>
                </td>
            </tr>
            <!-- Require to select user -->
            <tr id="bs_new_order_user_required">
                <th scope="row">
                    <?php echo __("Require to select user", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("newOrderUserRequired");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_new_order_user_required input[name='newOrderUserRequired']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="newOrderUserRequired" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Require Payment Method -->
            <tr id="bs_payment_required">
                <th scope="row">
                    <?php echo __("Payment method is required", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("paymentRequired");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_payment_required input[name='paymentRequired']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="paymentRequired" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr>
            <!-- Open order after creation -->
            <tr id="bs_open_order_after_creation">
                <th scope="row">
                    <?php echo __("Open order after creation", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("openOrderAfterCreation");
                    $defaultValue = $defaultValue === null ? 'off' : $defaultValue->value;
                    ?>
                    <label>
                        <?php $checked = $defaultValue !== "off" ? ' checked=checked ' : ''; ?>
                        <input type="checkbox" <?php esc_html_e($checked, 'us-barcode-scanner'); ?> onchange="WebbsSettingsCheckboxChange(`#bs_open_order_after_creation input[name='openOrderAfterCreation']`,this.checked ? 'on' : 'off')" />
                        <input type="hidden" name="openOrderAfterCreation" value="<?php echo $checked ? "on" : "off"; ?>" />
                        <?php echo __("Enable", "us-barcode-scanner"); ?>
                    </label>
                </td>
            </tr><!-- Use price to create order -->
            <tr>
                <th scope="row" style="width: 240px;">
                    <?php echo __("Use price to create order", "us-barcode-scanner"); ?>
                </th>
                <td>
                    <?php
                    $defaultValue = $settings->getSettings("defaultPriceField");
                    $defaultValue = $defaultValue === null ? $settings->getField("prices", "defaultPriceField") : $defaultValue->value;
                    ?>
                    <select name="defaultPriceField" style="max-width: 175px;">
                        <?php $selected = $defaultValue === "wc_default" || $settings->getField("prices", "defaultPriceField", "wc_default") ? 'selected="selected"' : ""; ?>
                        <option value="wc_default" <?php esc_html_e($selected, 'us-barcode-scanner'); ?>><?php esc_html_e("WooCommerce default", 'us-barcode-scanner'); ?></option>

                        <?php
                        ?>
                        <?php foreach ($interfaceData::getFields(true) as $field) : ?>
                            <?php if ($field["type"] == "price" && $field["status"] == 1) : ?>
                                <?php $selected = $defaultValue === $field["field_name"] ? 'selected="selected"' : ""; ?>
                                <option value="<?php echo $field["field_name"]; ?>" <?php esc_html_e($selected, 'us-barcode-scanner'); ?>><?php esc_html_e("Always use " . $field["field_label"], 'us-barcode-scanner'); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="submit">
        <input type="submit" class="button button-primary" value="<?php echo __("Save Changes", "us-barcode-scanner"); ?>">
    </div>
</form>
<style>
    .order-default-user-search-input {
        min-width: 250px;
    }
</style>
<script>
    jQuery(document).ready(() => {
        const chosenOption = {
            width: "300px",
            no_results_text: "Loading:"
        };
        jQuery(".chosen-select-shipping-methods").chosen(chosenOption);

        const listUpdated = () => {
            const selectedListEl = jQuery('.shipping-methods .chosen-container .chosen-choices');
            const optionsEl = selectedListEl.find('.search-choice');
            let values = '';
            let orderIndex = [];
            let options = [];

            for (let index = 0; index < optionsEl.length; index++) {
                const element = jQuery(optionsEl[index]).find('a[data-option-array-index]');
                const optionIndex = element.attr('data-option-array-index');
                orderIndex.push(optionIndex)
            }

            var allOptions = jQuery(".chosen-select-shipping-methods option");
            for (let index = 0; index < allOptions.length; index++) {
                const id = jQuery(allOptions[index]).attr('value');
                options.push(id);
            }

            const sortedOptions = orderIndex.map(index => options[index]);

            const selectedItems = jQuery(".chosen-select-shipping-methods").val();

            jQuery('input[name="defaultShippingMethods[]"]').val(sortedOptions.join(','))
        };

        let timer = null;
        jQuery(".chosen-select-shipping-methods").on('change', (event, params) => {
            if (timer) clearTimeout(timer);
            timer = setTimeout(listUpdated, 50);
        });

        var defaultValue = '<?php echo $shippingMethodsValue; ?>'.split(',');
        jQuery(".chosen-select-shipping-methods").val(defaultValue).trigger("chosen:updated");
    });
</script>
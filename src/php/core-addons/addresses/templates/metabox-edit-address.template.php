<?php /** Template version: 1.0.0 */ ?>

<?php
/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
?>

<?php /** @var $address array */ ?>
<?php /** @var $address_id string */ ?>
<?php /** @var $address_class string */ ?>
<?php /** @var $address_label string */ ?>
<?php /** @var $address_actions array */ ?>
<?php /** @var $extra_scripts string */ ?>

<div class="cuar-address cuar-<?php echo $address_class; ?>">
    <?php wp_nonce_field('cuar_' . $address_id, 'cuar_nonce'); ?>

    <div class="cuar-progress" style="display: none;">
        <span class="indeterminate"></span>
    </div>

    <?php if (!empty($address_actions)) : ?>
    <div class="row">
        <div class="form-group cuar-address-actions">
            <?php foreach ($address_actions as $action => $desc) : ?>
                <a href="#" class="button cuar-action cuar-<?php echo esc_attr($action); ?>" title="<?php echo esc_attr($desc['tooltip']); ?>"><?php
                    echo $desc['label'];
                    ?></a>&nbsp;
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="form-group cuar-address-name">
            <label for="<?php echo $address_id; ?>_name" class="control-label"><?php _e('Name', 'cuarin'); ?></label>

            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[name]" id="<?php echo $address_id; ?>_name"
                       value="<?php echo esc_attr($address['name']); ?>"
                       placeholder="<?php esc_attr_e('Name', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>

        <div class="form-group cuar-address-company">
            <label for="<?php echo $address_id; ?>_company" class="control-label"><?php _e('Company', 'cuarin'); ?></label>

            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[company]" id="<?php echo $address_id; ?>_company"
                       value="<?php echo esc_attr($address['company']); ?>"
                       placeholder="<?php esc_attr_e('Company', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group cuar-address-line1">
            <label for="<?php echo $address_id; ?>_line1" class="control-label"><?php _e('Street address', 'cuarin'); ?></label>

            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[line1]" id="<?php echo $address_id; ?>_line1"
                       value="<?php echo esc_attr($address['line1']); ?>"
                       placeholder="<?php esc_attr_e('Street address, line 1', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group cuar-address-line2">
            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[line2]" id="<?php echo $address_id; ?>_line2"
                       value="<?php echo esc_attr($address['line2']); ?>"
                       placeholder="<?php esc_attr_e('Street address, line 2', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group cuar-address-zip">
            <label for="<?php echo $address_id; ?>_zip" class="control-label"><?php _e('Zip/Postal code', 'cuarin'); ?></label>

            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[zip]" id="<?php echo $address_id; ?>_zip" value="<?php echo esc_attr($address['zip']); ?>"
                       placeholder="<?php esc_attr_e('Zip/Postal code', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>

        <div class="form-group cuar-address-city">
            <label for="<?php echo $address_id; ?>_city" class="control-label"><?php _e('City', 'cuarin'); ?></label>

            <div class="control-container">
                <input type="text" name="<?php echo $address_id; ?>[city]" id="<?php echo $address_id; ?>_city"
                       value="<?php echo esc_attr($address['city']); ?>"
                       placeholder="<?php esc_attr_e('City', 'cuarin'); ?>" class="form-control cuar-address-field"/>
            </div>
        </div>
    </div>
    <div class="row cuar-country-state-inputs">
        <div class="form-group cuar-address-country">
            <label for="<?php echo $address_id; ?>_country" class="control-label"><?php _e('Country', 'cuarin'); ?></label>

            <div class="control-container">
                <select name="<?php echo $address_id; ?>[country]" id="<?php echo $address_id; ?>_country" class="form-control cuar-address-field" data-address-id="<?php echo $address_id; ?>">
                    <?php foreach (CUAR_CountryHelper::getCountries() as $code => $label) : ?>
                        <option value="<?php echo esc_attr($code); ?>" <?php selected($address['country'], $code); ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php $country_states = CUAR_CountryHelper::getStates($address['country']); ?>
        <div class="form-group cuar-address-state" <?php if (empty($country_states)) echo 'style="display: none;"'; ?>>
            <label for="<?php echo $address_id; ?>_state" class="control-label"><?php _e('State/Province', 'cuarin'); ?></label>

            <div class="control-container">
                <select name="<?php echo $address_id; ?>[state]" id="<?php echo $address_id; ?>_state" class="form-control cuar-address-field" autocomplete="off">
                    <?php foreach ($country_states as $code => $label) : ?>
                        <option value="<?php echo esc_attr($code); ?>" <?php selected($address['state'], $code); ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.cuar-<?php echo $address_class; ?>').manageAddressInputs();
        $('.cuar-<?php echo $address_class; ?> .cuar-country-state-inputs').bindCountryStateInputs();
        <?php echo $extra_scripts; ?>
    });
</script>
gform.addFilter( 'gform_editor_field_settings', function( settings, field ) {
    if (jQuery.inArray(field['type'], gfcem_object.gfcem_settings) >= 0) {
        settings.push('.gfcemAllowed_field_setting')
    }

    return settings;
} );

jQuery(document).on("gform_load_field_settings", function(event, field, form){
    jQuery( '#field_gfcemAllowed' ).prop( 'checked', Boolean( rgar( field, 'gfcemAllowed' ) ) );

    GFCEMCreateInputs(field);
    GFCEMToggleInputs(true);

    jQuery('#field_gfcem_message_required').val(rgar(field, 'inputGFCEMMessageRequired'));
    jQuery('#field_gfcem_message_valid_email').val(rgar(field, 'inputGFCEMMessageValidEmail'));
    jQuery('#field_gfcem_message_unique').val(rgar(field, 'inputGFCEMMessageUnique'));
}).on('input propertychange change', '.gfcem_input', function(){
    GFCEMSetInput(this.value, jQuery(this).data('key'));
});

function GFCEMSetInput(value, key){
    var field = GetSelectedField();

    if(value) {
        value = value.trim();
    }

    field[key] = value;
}


function GFCEMToggleInputs(){
    if(jQuery('#field_gfcemAllowed').is(":checked")){
        jQuery('#field_gfcem_container').show();
    }
    else{
        jQuery('#field_gfcem_container').hide();
        jQuery("#field_gfcem_container input").val("");
    }
}

function GFCEMCreateInputs(field) {
    var field_str = "<div class='gfcem-input-row'><label for='field_gfcem_message_required'>" + gfcem_object.gfcem_rem_title + "</label>";
    field_str += "<input type='text' id='field_gfcem_message_required' class='gfcem_input' data-key='inputGFCEMMessageRequired' /></div>";

    if (jQuery.inArray(field['type'], gfcem_object.gfcem_not_unique) === -1) {
        field_str += "<div class='gfcem-input-row'><label for='field_gfcem_message_unique'>" + gfcem_object.gfcem_uem_title + "</label>";
        field_str += "<input type='text' id='field_gfcem_message_unique' class='gfcem_input' data-key='inputGFCEMMessageUnique' /></div>";
    }

    if ('email' === field['type']) {
        field_str += "<div class='gfcem-input-row'><label for='field_gfcem_message_valid_email'>" + gfcem_object.gfcem_evem_title + "</label>";
        field_str += "<input type='text' id='field_gfcem_message_valid_email' class='gfcem_input' data-key='inputGFCEMMessageValidEmail' /></div>";
    }

    jQuery("#field_gfcem_container").html(field_str);
}
fieldSettings.text += ", .gfcemAllowed_field_setting";
fieldSettings.email += ", .gfcemAllowed_field_setting";
//binding to the load field settings event to initialize the checkbox
jQuery(document).on("gform_load_field_settings", function(event, field, form){
    jQuery( '#field_gfcemAllowed' ).prop( 'checked', Boolean( rgar( field, 'gfcemAllowed' ) ) );

    GFCEMCreateInputs(field);
    GFCEMToggleInputs(true);

    jQuery('#field_gfcem_message_required').val(rgar(field, 'inputGFCEMMessageRequired'));
    jQuery('#field_gfcem_message_valid_email').val(rgar(field, 'inputGFCEMMessageValidEmail'));
    jQuery('#field_gfcem_message_unique').val(rgar(field, 'inputGFCEMMessageUnique'));
});

jQuery('#field_gfcem_container')
    .on('input propertychange change', '.gfcem_input', function(){
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
    var field_str = "", id, value, inputs;

    var inputType = GetInputType(field);
    var legacy = jQuery.inArray(inputType, ['date', 'email', 'time', 'password'])>-1;
    inputs = !legacy ? field['inputs'] : null;

    if (!inputs || GetInputType(field) === "checkbox") {
        field_str = "<div class='gfcem-input-row'><label for='field_gfcem_message_required' class='inline'>Required error message&nbsp;</label>";
        field_str += "<input type='text' id='field_gfcem_message_required' class='gfcem_input' data-key='inputGFCEMMessageRequired' /></div>";

        if ('email' === field['type']) {
            field_str += "<div class='gfcem-input-row'><label for='field_gfcem_message_valid_email' class='inline'>Valid email message&nbsp;</label>";
            field_str += "<input type='text' id='field_gfcem_message_valid_email' class='gfcem_input' data-key='inputGFCEMMessageValidEmail' /></div>";
        }

        field_str += "<div class='gfcem-input-row'><label for='field_gfcem_message_unique' class='inline'>Unique error message&nbsp;</label>";
        field_str += "<input type='text' id='field_gfcem_message_unique' class='gfcem_input' data-key='inputGFCEMMessageUnique' /></div>";
    }

    jQuery("#field_gfcem_container").html(field_str);
}
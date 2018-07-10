(function() {

    tinymce.PluginManager.add('rem_shortcodes', function( editor )
    {
        var shortcodeValues = [
            {
                text: 'Register Agents',
                value: 'rem_register_agent',
                args: 'redirect=""',
                inner: 'You are already registered!'
            },
            {
                text: 'Search Properties',
                value: 'rem_search_property',
                args: 'fields_to_show="property_address,search,property_type,property_country,property_purpose,property_price" columns="6"',
                inner: ''
            },
            {
                text: 'Agent Login',
                value: 'rem_agent_login',
                args: 'heading="Please Login Here" redirect="http://redirect_after_login"',
                inner: 'You are already logged in'
            },
            {
                text: 'Create Property',
                value: 'rem_create_property',
                args: '',
                inner: 'Please login to create property'
            },
            {
                text: 'My Properties',
                value: 'rem_my_properties',
                args: '',
                inner: 'Please login to see your properties'
            },
            {
                text: 'List Properties',
                value: 'rem_list_properties',
                args: 'posts="10" order="ASC" orderby="date" style="3" class="col-sm-3"',
                inner: ''
            },
            {
                text: 'Properties Map',
                value: 'rem_maps',
                args: 'query_type="p_query" total_properties="10"',
                inner: ''
            },
            {
                text: 'Agent Page',
                value: 'rem_agent_profile',
                args: 'author_id="1"',
                inner: ''
            },
            {
                text: 'Edit Agent',
                value: 'rem_agent_edit',
                args: '',
                inner: ''
            },
            {
                text: 'Single Property',
                value: 'rem_property',
                args: 'id=""',
                inner: ''
            },
            {
                text: 'Carousel Slider',
                value: 'rem_carousel',
                args: 'style="6" arrows="enable" speed="2000" total_properties="6" slidestoshow="3" slidestoscroll="1"',
                inner: ''
            },
        ];

        // console.log(shortcodeValues);
        editor.addButton('rem_shortcodes', {
            type: 'listbox',
            text: 'Real Estate Manager',
            onselect: function(e) {
                var v = e.control.settings.value;
                var args = e.control.settings.args;
                var inner = e.control.settings.inner;
                tinyMCE.activeEditor.selection.setContent( '[' + v + ' '+args+']'+inner+'[/' + v + ']' );
            },
            values: shortcodeValues
        });
    });
})();
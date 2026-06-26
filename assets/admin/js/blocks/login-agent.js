/**
 * Real Estate Manager Blocks for Gutenberg 
 *
 */
( function( blocks, i18n, element ) {
	var el = element.createElement;
	var __ = i18n.__;
	var Editable = blocks.Editable;
	var AlignmentToolbar = wp.blocks.AlignmentToolbar;
	var BlockControls = wp.blocks.BlockControls;
	var InspectorControls = wp.blocks.InspectorControls;
	var TextControl = wp.components.TextControl;
	var ServerSideRender = wp.components.ServerSideRender;
	var RangeControl = wp.components.RangeControl;
	var PanelColorSettings = wp.editor.PanelColorSettings;
	var ColorPalette = wp.components.ColorPalette;
	var SelectControl = wp.components.SelectControl;
	var TextareaControl = wp.components.TextareaControl;
	var RichText = wp.editor.RichText;

	var blockStyle = {
		backgroundColor: '#003C70',
		textAlign: 'center',
		color: '#fff',
		padding: '20px'
	};

	var blockColors = [ { name: 'red', color: '#f00' }, { name: 'white', color: '#fff' }, { name: 'blue', color: '#00f' } ];

	/**
	 * Agent Login Block
	 * @param  heading, redirect
	 * @return {null}       Rendered through PHP
	 */
	blocks.registerBlockType( 'real-estate-manager/login-agent', {
		title: __( 'Login Agent' ),
		icon: 'admin-users',
		category: 'rem',
	    keywords: [
            __('Real Estate Manager'),
            __('REM'),
            __('form')
	    ],
		attributes: {
			heading: {
				type: 'string',
				default: 'Login Here'
			},
			redirect: {
				type: 'string',
				default: 'http://site.com/profile'
			},
			content: {
				source: 'html',
				default: 'Content for already logged in users.'
			},
		},	    
	    edit: function(props) {
	        return [!!props.isSelected && el(
	                wp.editor.InspectorControls, {
	                    key: 'inspector'
	                },
	                el(
	                    TextControl, {
	                        key: 'rem_heading',
	                        type: 'text',
	                        label: __('Title of form'),
	                        value: props.attributes.heading,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                heading: value
	                            });
	                        },
	                    }
	                ),
	                el(
	                    TextControl, {
	                        key: 'rem_redirect',
	                        type: 'url',
	                        label: __('Redirect url after login'),
	                        value: props.attributes.redirect,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                redirect: value
	                            });
	                        },
	                    }
	                ),
	            ),
                el(
                    RichText, {
                        label: __('Content for Logged In'),
                        value: props.attributes.content,
                        onChange: function(value) {
                            props.setAttributes({
                                content: value
                            });
                        },
                    }
                ),
	        ];
	    },
		save: function(props) {
	        return el( RichText.Content, {
	            value: props.attributes.content
	        } );
		},
	});

} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element
);
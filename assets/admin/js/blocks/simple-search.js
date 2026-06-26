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

	/**
	 * Simple Search Block
	 * @return {null}       Rendered through PHP
	 */
	blocks.registerBlockType( 'real-estate-manager/simple-search', {
		title: __( 'Simple Search' ),
		icon: 'search',
		category: 'rem',
	    keywords: [
            __('Real Estate Manager'),
            __('search'),
            __('simple search')
	    ],
		attributes: {
			placeholder: {
				type: 'string',
				default: 'Type to Search...'
			},
			width: {
				type: 'string',
				default: '450px'
			},
			border_color: {
				type: 'string',
				default: '#E4E4E4'
			},
			results_page: {
				type: 'string',
				default: '#'
			},
			search_icon: {
				type: 'html',
				default: '<i class="glyphicon glyphicon-search"></i>'
			},
		},	    
	    edit: function(props) {
	        return [!!props.isSelected && el(
	                wp.editor.InspectorControls, {
	                    key: 'inspector'
	                },
	                el(
	                    TextControl, {
	                        type: 'text',
	                        label: __('Placeholder'),
	                        value: props.attributes.placeholder,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                placeholder: value
	                            });
	                        },
	                    }
	                ),
	                el(
	                    TextControl, {
	                        type: 'text',
	                        label: __('Width'),
	                        value: props.attributes.width,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                width: value
	                            });
	                        },
	                    }
	                ),
	                el(
	                    TextControl, {
	                        type: 'text',
	                        label: __('Results Page Url'),
	                        value: props.attributes.results_page,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                results_page: value
	                            });
	                        },
	                    }
	                ),
	                el(
	                    TextControl, {
	                        type: 'text',
	                        label: __('Search Icon'),
	                        value: props.attributes.search_icon,
	                        onChange: function(value) {
	                            props.setAttributes({
	                                search_icon: value
	                            });
	                        },
	                    }
	                ),
	                el(
	                	PanelColorSettings,{
	                		initialOpen: false,
	                		title:__('Color Settings'),
	                		colorSettings:[
		                    {
		                        value: props.attributes.border_color,
		                        label: __( 'Border Color' ),
		                        onChange: function(value) {
		                            props.setAttributes({
		                                border_color: value
		                            });
		                        },
		                    },
	                		]
	                	},
	                ),
	            ),
				el(ServerSideRender, {
					key: "editable",
					block: "real-estate-manager/simple-search",
					attributes:  props.attributes
				})
	        ];
	    },
		save: function(props) {
	        return null;
		},
	});

} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element
);
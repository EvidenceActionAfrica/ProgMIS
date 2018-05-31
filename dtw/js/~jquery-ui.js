/*! jQuery UI - v1.10.4 - 2014-01-17
* http://jqueryui.com
* Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.position.js, jquery.ui.accordion.js, jquery.ui.autocomplete.js, jquery.ui.button.js, jquery.ui.datepicker.js, jquery.ui.dialog.js, jquery.ui.draggable.js, jquery.ui.droppable.js, jquery.ui.effect.js, jquery.ui.effect-blind.js, jquery.ui.effect-bounce.js, jquery.ui.effect-clip.js, jquery.ui.effect-drop.js, jquery.ui.effect-explode.js, jquery.ui.effect-fade.js, jquery.ui.effect-fold.js, jquery.ui.effect-highlight.js, jquery.ui.effect-pulsate.js, jquery.ui.effect-scale.js, jquery.ui.effect-shake.js, jquery.ui.effect-slide.js, jquery.ui.effect-transfer.js, jquery.ui.menu.js, jquery.ui.progressbar.js, jquery.ui.resizable.js, jquery.ui.selectable.js, jquery.ui.slider.js, jquery.ui.sortable.js, jquery.ui.spinner.js, jquery.ui.tabs.js, jquery.ui.tooltip.js
* Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */

(function( $, undefined ) {

var uuid = 0,
	runiqueId = /^ui-id-\d+$/;

// $.ui might exist from components with no dependencies, e.g., $.ui.position
$.ui = $.ui || {};

$.extend( $.ui, {
	version: "1.10.4",

	keyCode: {
		BACKSPACE: 8,
		COMMA: 188,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		LEFT: 37,
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SPACE: 32,
		TAB: 9,
		UP: 38
	}
});

// plugins
$.fn.extend({
	focus: (function( orig ) {
		return function( delay, fn ) {
			return typeof delay === "number" ?
				this.each(function() {
					var elem = this;
					setTimeout(function() {
						$( elem ).focus();
						if ( fn ) {
							fn.call( elem );
						}
					}, delay );
				}) :
				orig.apply( this, arguments );
		};
	})( $.fn.focus ),

	scrollParent: function() {
		var scrollParent;
		if (($.ui.ie && (/(static|relative)/).test(this.css("position"))) || (/absolute/).test(this.css("position"))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.css(this,"position")) && (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
			}).eq(0);
		}

		return (/fixed/).test(this.css("position")) || !scrollParent.length ? $(document) : scrollParent;
	},

	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ), 10 );
					if ( !isNaN( value ) && value !== 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	},

	uniqueId: function() {
		return this.each(function() {
			if ( !this.id ) {
				this.id = "ui-id-" + (++uuid);
			}
		});
	},

	removeUniqueId: function() {
		return this.each(function() {
			if ( runiqueId.test( this.id ) ) {
				$( this ).removeAttr( "id" );
			}
		});
	}
});

// selectors
function focusable( element, isTabIndexNotNaN ) {
	var map, mapName, img,
		nodeName = element.nodeName.toLowerCase();
	if ( "area" === nodeName ) {
		map = element.parentNode;
		mapName = map.name;
		if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
			return false;
		}
		img = $( "img[usemap=#" + mapName + "]" )[0];
		return !!img && visible( img );
	}
	return ( /input|select|textarea|button|object/.test( nodeName ) ?
		!element.disabled :
		"a" === nodeName ?
			element.href || isTabIndexNotNaN :
			isTabIndexNotNaN) &&
		// the element and all of its ancestors must be visible
		visible( element );
}

function visible( element ) {
	return $.expr.filters.visible( element ) &&
		!$( element ).parents().addBack().filter(function() {
			return $.css( this, "visibility" ) === "hidden";
		}).length;
}

$.extend( $.expr[ ":" ], {
	data: $.expr.createPseudo ?
		$.expr.createPseudo(function( dataName ) {
			return function( elem ) {
				return !!$.data( elem, dataName );
			};
		}) :
		// support: jQuery <1.8
		function( elem, i, match ) {
			return !!$.data( elem, match[ 3 ] );
		},

	focusable: function( element ) {
		return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
	},

	tabbable: function( element ) {
		var tabIndex = $.attr( element, "tabindex" ),
			isTabIndexNaN = isNaN( tabIndex );
		return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
	}
});

// support: jQuery <1.8
if ( !$( "<a>" ).outerWidth( 1 ).jquery ) {
	$.each( [ "Width", "Height" ], function( i, name ) {
		var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
			type = name.toLowerCase(),
			orig = {
				innerWidth: $.fn.innerWidth,
				innerHeight: $.fn.innerHeight,
				outerWidth: $.fn.outerWidth,
				outerHeight: $.fn.outerHeight
			};

		function reduce( elem, size, border, margin ) {
			$.each( side, function() {
				size -= parseFloat( $.css( elem, "padding" + this ) ) || 0;
				if ( border ) {
					size -= parseFloat( $.css( elem, "border" + this + "Width" ) ) || 0;
				}
				if ( margin ) {
					size -= parseFloat( $.css( elem, "margin" + this ) ) || 0;
				}
			});
			return size;
		}

		$.fn[ "inner" + name ] = function( size ) {
			if ( size === undefined ) {
				return orig[ "inner" + name ].call( this );
			}

			return this.each(function() {
				$( this ).css( type, reduce( this, size ) + "px" );
			});
		};

		$.fn[ "outer" + name] = function( size, margin ) {
			if ( typeof size !== "number" ) {
				return orig[ "outer" + name ].call( this, size );
			}

			return this.each(function() {
				$( this).css( type, reduce( this, size, true, margin ) + "px" );
			});
		};
	});
}

// support: jQuery <1.8
if ( !$.fn.addBack ) {
	$.fn.addBack = function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter( selector )
		);
	};
}

// support: jQuery 1.6.1, 1.6.2 (http://bugs.jquery.com/ticket/9413)
if ( $( "<a>" ).data( "a-b", "a" ).removeData( "a-b" ).data( "a-b" ) ) {
	$.fn.removeData = (function( removeData ) {
		return function( key ) {
			if ( arguments.length ) {
				return removeData.call( this, $.camelCase( key ) );
			} else {
				return removeData.call( this );
			}
		};
	})( $.fn.removeData );
}





// deprecated
$.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );

$.support.selectstart = "onselectstart" in document.createElement( "div" );
$.fn.extend({
	disableSelection: function() {
		return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
			".ui-disableSelection", function( event ) {
				event.preventDefault();
			});
	},

	enableSelection: function() {
		return this.unbind( ".ui-disableSelection" );
	}
});

$.extend( $.ui, {
	// $.ui.plugin is deprecated. Use $.widget() extensions instead.
	plugin: {
		add: function( module, option, set ) {
			var i,
				proto = $.ui[ module ].prototype;
			for ( i in set ) {
				proto.plugins[ i ] = proto.plugins[ i ] || [];
				proto.plugins[ i ].push( [ option, set[ i ] ] );
			}
		},
		call: function( instance, name, args ) {
			var i,
				set = instance.plugins[ name ];
			if ( !set || !instance.element[ 0 ].parentNode || instance.element[ 0 ].parentNode.nodeType === 11 ) {
				return;
			}

			for ( i = 0; i < set.length; i++ ) {
				if ( instance.options[ set[ i ][ 0 ] ] ) {
					set[ i ][ 1 ].apply( instance.element, args );
				}
			}
		}
	},

	// only used by resizable
	hasScroll: function( el, a ) {

		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ( $( el ).css( "overflow" ) === "hidden") {
			return false;
		}

		var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
			has = false;

		if ( el[ scroll ] > 0 ) {
			return true;
		}

		// TODO: determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[ scroll ] = 1;
		has = ( el[ scroll ] > 0 );
		el[ scroll ] = 0;
		return has;
	}
});

})( jQuery );
(function( $, undefined ) {

var uuid = 0,
	slice = Array.prototype.slice,
	_cleanData = $.cleanData;
$.cleanData = function( elems ) {
	for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
		try {
			$( elem ).triggerHandler( "remove" );
		// http://bugs.jquery.com/ticket/8235
		} catch( e ) {}
	}
	_cleanData( elems );
};

$.widget = function( name, base, prototype ) {
	var fullName, existingConstructor, constructor, basePrototype,
		// proxiedPrototype allows the provided prototype to remain unmodified
		// so that it can be used as a mixin for multiple widgets (#8876)
		proxiedPrototype = {},
		namespace = name.split( "." )[ 0 ];

	name = name.split( "." )[ 1 ];
	fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	// create selector for plugin
	$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {
		// allow instantiation without "new" keyword
		if ( !this._createWidget ) {
			return new constructor( options, element );
		}

		// allow instantiation without initializing for simple inheritance
		// must use "new" keyword (the code above always passes args)
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};
	// extend with the existing constructor to carry over any static properties
	$.extend( constructor, existingConstructor, {
		version: prototype.version,
		// copy the object used to create the prototype in case we need to
		// redefine the widget later
		_proto: $.extend( {}, prototype ),
		// track widgets that inherit from this widget in case this widget is
		// redefined after a widget inherits from it
		_childConstructors: []
	});

	basePrototype = new base();
	// we need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
	basePrototype.options = $.widget.extend( {}, basePrototype.options );
	$.each( prototype, function( prop, value ) {
		if ( !$.isFunction( value ) ) {
			proxiedPrototype[ prop ] = value;
			return;
		}
		proxiedPrototype[ prop ] = (function() {
			var _super = function() {
					return base.prototype[ prop ].apply( this, arguments );
				},
				_superApply = function( args ) {
					return base.prototype[ prop ].apply( this, args );
				};
			return function() {
				var __super = this._super,
					__superApply = this._superApply,
					returnValue;

				this._super = _super;
				this._superApply = _superApply;

				returnValue = value.apply( this, arguments );

				this._super = __super;
				this._superApply = __superApply;

				return returnValue;
			};
		})();
	});
	constructor.prototype = $.widget.extend( basePrototype, {
		// TODO: remove support for widgetEventPrefix
		// always use the name + a colon as the prefix, e.g., draggable:start
		// don't prefix for widgets that aren't DOM-based
		widgetEventPrefix: existingConstructor ? (basePrototype.widgetEventPrefix || name) : name
	}, proxiedPrototype, {
		constructor: constructor,
		namespace: namespace,
		widgetName: name,
		widgetFullName: fullName
	});

	// If this widget is being redefined then we need to find all widgets that
	// are inheriting from it and redefine all of them so that they inherit from
	// the new version of this widget. We're essentially trying to replace one
	// level in the prototype chain.
	if ( existingConstructor ) {
		$.each( existingConstructor._childConstructors, function( i, child ) {
			var childPrototype = child.prototype;

			// redefine the child widget using the same prototype that was
			// originally used, but inherit from the new version of the base
			$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor, child._proto );
		});
		// remove the list of existing child constructors from the old constructor
		// so the old child constructors can be garbage collected
		delete existingConstructor._childConstructors;
	} else {
		base._childConstructors.push( constructor );
	}

	$.widget.bridge( name, constructor );
};

$.widget.extend = function( target ) {
	var input = slice.call( arguments, 1 ),
		inputIndex = 0,
		inputLength = input.length,
		key,
		value;
	for ( ; inputIndex < inputLength; inputIndex++ ) {
		for ( key in input[ inputIndex ] ) {
			value = input[ inputIndex ][ key ];
			if ( input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {
				// Clone objects
				if ( $.isPlainObject( value ) ) {
					target[ key ] = $.isPlainObject( target[ key ] ) ?
						$.widget.extend( {}, target[ key ], value ) :
						// Don't extend strings, arrays, etc. with objects
						$.widget.extend( {}, value );
				// Copy everything else by reference
				} else {
					target[ key ] = value;
				}
			}
		}
	}
	return target;
};

$.widget.bridge = function( name, object ) {
	var fullName = object.prototype.widgetFullName || name;
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string",
			args = slice.call( arguments, 1 ),
			returnValue = this;

		// allow multiple hashes to be passed on init
		options = !isMethodCall && args.length ?
			$.widget.extend.apply( null, [ options ].concat(args) ) :
			options;

		if ( isMethodCall ) {
			this.each(function() {
				var methodValue,
					instance = $.data( this, fullName );
				if ( !instance ) {
					return $.error( "cannot call methods on " + name + " prior to initialization; " +
						"attempted to call method '" + options + "'" );
				}
				if ( !$.isFunction( instance[options] ) || options.charAt( 0 ) === "_" ) {
					return $.error( "no such method '" + options + "' for " + name + " widget instance" );
				}
				methodValue = instance[ options ].apply( instance, args );
				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue && methodValue.jquery ?
						returnValue.pushStack( methodValue.get() ) :
						methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, fullName );
				if ( instance ) {
					instance.option( options || {} )._init();
				} else {
					$.data( this, fullName, new object( options, this ) );
				}
			});
		}

		return returnValue;
	};
};

$.Widget = function( /* options, element */ ) {};
$.Widget._childConstructors = [];

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	defaultElement: "<div>",
	options: {
		disabled: false,

		// callbacks
		create: null
	},
	_createWidget: function( options, element ) {
		element = $( element || this.defaultElement || this )[ 0 ];
		this.element = $( element );
		this.uuid = uuid++;
		this.eventNamespace = "." + this.widgetName + this.uuid;
		this.options = $.widget.extend( {},
			this.options,
			this._getCreateOptions(),
			options );

		this.bindings = $();
		this.hoverable = $();
		this.focusable = $();

		if ( element !== this ) {
			$.data( element, this.widgetFullName, this );
			this._on( true, this.element, {
				remove: function( event ) {
					if ( event.target === element ) {
						this.destroy();
					}
				}
			});
			this.document = $( element.style ?
				// element within the document
				element.ownerDocument :
				// element is window or document
				element.document || element );
			this.window = $( this.document[0].defaultView || this.document[0].parentWindow );
		}

		this._create();
		this._trigger( "create", null, this._getCreateEventData() );
		this._init();
	},
	_getCreateOptions: $.noop,
	_getCreateEventData: $.noop,
	_create: $.noop,
	_init: $.noop,

	destroy: function() {
		this._destroy();
		// we can probably remove the unbind calls in 2.0
		// all event bindings should go through this._on()
		this.element
			.unbind( this.eventNamespace )
			// 1.9 BC for #7810
			// TODO remove dual storage
			.removeData( this.widgetName )
			.removeData( this.widgetFullName )
			// support: jquery <1.6.3
			// http://bugs.jquery.com/ticket/9413
			.removeData( $.camelCase( this.widgetFullName ) );
		this.widget()
			.unbind( this.eventNamespace )
			.removeAttr( "aria-disabled" )
			.removeClass(
				this.widgetFullName + "-disabled " +
				"ui-state-disabled" );

		// clean up events and states
		this.bindings.unbind( this.eventNamespace );
		this.hoverable.removeClass( "ui-state-hover" );
		this.focusable.removeClass( "ui-state-focus" );
	},
	_destroy: $.noop,

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key,
			parts,
			curOption,
			i;

		if ( arguments.length === 0 ) {
			// don't return a reference to the internal hash
			return $.widget.extend( {}, this.options );
		}

		if ( typeof key === "string" ) {
			// handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
			options = {};
			parts = key.split( "." );
			key = parts.shift();
			if ( parts.length ) {
				curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
				for ( i = 0; i < parts.length - 1; i++ ) {
					curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
					curOption = curOption[ parts[ i ] ];
				}
				key = parts.pop();
				if ( arguments.length === 1 ) {
					return curOption[ key ] === undefined ? null : curOption[ key ];
				}
				curOption[ key ] = value;
			} else {
				if ( arguments.length === 1 ) {
					return this.options[ key ] === undefined ? null : this.options[ key ];
				}
				options[ key ] = value;
			}
		}

		this._setOptions( options );

		return this;
	},
	_setOptions: function( options ) {
		var key;

		for ( key in options ) {
			this._setOption( key, options[ key ] );
		}

		return this;
	},
	_setOption: function( key, value ) {
		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this.widget()
				.toggleClass( this.widgetFullName + "-disabled ui-state-disabled", !!value )
				.attr( "aria-disabled", value );
			this.hoverable.removeClass( "ui-state-hover" );
			this.focusable.removeClass( "ui-state-focus" );
		}

		return this;
	},

	enable: function() {
		return this._setOption( "disabled", false );
	},
	disable: function() {
		return this._setOption( "disabled", true );
	},

	_on: function( suppressDisabledCheck, element, handlers ) {
		var delegateElement,
			instance = this;

		// no suppressDisabledCheck flag, shuffle arguments
		if ( typeof suppressDisabledCheck !== "boolean" ) {
			handlers = element;
			element = suppressDisabledCheck;
			suppressDisabledCheck = false;
		}

		// no element argument, shuffle and use this.element
		if ( !handlers ) {
			handlers = element;
			element = this.element;
			delegateElement = this.widget();
		} else {
			// accept selectors, DOM elements
			element = delegateElement = $( element );
			this.bindings = this.bindings.add( element );
		}

		$.each( handlers, function( event, handler ) {
			function handlerProxy() {
				// allow widgets to customize the disabled handling
				// - disabled as an array instead of boolean
				// - disabled class as method for disabling individual parts
				if ( !suppressDisabledCheck &&
						( instance.options.disabled === true ||
							$( this ).hasClass( "ui-state-disabled" ) ) ) {
					return;
				}
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}

			// copy the guid so direct unbinding works
			if ( typeof handler !== "string" ) {
				handlerProxy.guid = handler.guid =
					handler.guid || handlerProxy.guid || $.guid++;
			}

			var match = event.match( /^(\w+)\s*(.*)$/ ),
				eventName = match[1] + instance.eventNamespace,
				selector = match[2];
			if ( selector ) {
				delegateElement.delegate( selector, eventName, handlerProxy );
			} else {
				element.bind( eventName, handlerProxy );
			}
		});
	},

	_off: function( element, eventName ) {
		eventName = (eventName || "").split( " " ).join( this.eventNamespace + " " ) + this.eventNamespace;
		element.unbind( eventName ).undelegate( eventName );
	},

	_delay: function( handler, delay ) {
		function handlerProxy() {
			return ( typeof handler === "string" ? instance[ handler ] : handler )
				.apply( instance, arguments );
		}
		var instance = this;
		return setTimeout( handlerProxy, delay || 0 );
	},

	_hoverable: function( element ) {
		this.hoverable = this.hoverable.add( element );
		this._on( element, {
			mouseenter: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-hover" );
			},
			mouseleave: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-hover" );
			}
		});
	},

	_focusable: function( element ) {
		this.focusable = this.focusable.add( element );
		this._on( element, {
			focusin: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-focus" );
			},
			focusout: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-focus" );
			}
		});
	},

	_trigger: function( type, event, data ) {
		var prop, orig,
			callback = this.options[ type ];

		data = data || {};
		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();
		// the original event may come from any element
		// so we need to reset the target on the new event
		event.target = this.element[ 0 ];

		// copy original event properties over to the new event
		orig = event.originalEvent;
		if ( orig ) {
			for ( prop in orig ) {
				if ( !( prop in event ) ) {
					event[ prop ] = orig[ prop ];
				}
			}
		}

		this.element.trigger( event, data );
		return !( $.isFunction( callback ) &&
			callback.apply( this.element[0], [ event ].concat( data ) ) === false ||
			event.isDefaultPrevented() );
	}
};

$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
	$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
		if ( typeof options === "string" ) {
			options = { effect: options };
		}
		var hasOptions,
			effectName = !options ?
				method :
				options === true || typeof options === "number" ?
					defaultEffect :
					options.effect || defaultEffect;
		options = options || {};
		if ( typeof options === "number" ) {
			options = { duration: options };
		}
		hasOptions = !$.isEmptyObject( options );
		options.complete = callback;
		if ( options.delay ) {
			element.delay( options.delay );
		}
		if ( hasOptions && $.effects && $.effects.effect[ effectName ] ) {
			element[ method ]( options );
		} else if ( effectName !== method && element[ effectName ] ) {
			element[ effectName ]( options.duration, options.easing, callback );
		} else {
			element.queue(function( next ) {
				$( this )[ method ]();
				if ( callback ) {
					callback.call( element[ 0 ] );
				}
				next();
			});
		}
	};
});

})( jQuery );
(function( $, undefined ) {

var mouseHandled = false;
$( document ).mouseup( function() {
	mouseHandled = false;
});

$.widget("ui.mouse", {
	version: "1.10.4",
	options: {
		cancel: "input,textarea,button,select,option",
		distance: 1,
		delay: 0
	},
	_mouseInit: function() {
		var that = this;

		this.element
			.bind("mousedown."+this.widgetName, function(event) {
				return that._mouseDown(event);
			})
			.bind("click."+this.widgetName, function(event) {
				if (true === $.data(event.target, that.widgetName + ".preventClickEvent")) {
					$.removeData(event.target, that.widgetName + ".preventClickEvent");
					event.stopImmediatePropagation();
					return false;
				}
			});

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	_mouseDestroy: function() {
		this.element.unbind("."+this.widgetName);
		if ( this._mouseMoveDelegate ) {
			$(document)
				.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
				.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);
		}
	},

	_mouseDown: function(event) {
		// don't let more than one widget handle mouseStart
		if( mouseHandled ) { return; }

		// we may have missed mouseup (out of window)
		(this._mouseStarted && this._mouseUp(event));

		this._mouseDownEvent = event;

		var that = this,
			btnIsLeft = (event.which === 1),
			// event.target.nodeName works around a bug in IE 8 with
			// disabled inputs (#7620)
			elIsCancel = (typeof this.options.cancel === "string" && event.target.nodeName ? $(event.target).closest(this.options.cancel).length : false);
		if (!btnIsLeft || elIsCancel || !this._mouseCapture(event)) {
			return true;
		}

		this.mouseDelayMet = !this.options.delay;
		if (!this.mouseDelayMet) {
			this._mouseDelayTimer = setTimeout(function() {
				that.mouseDelayMet = true;
			}, this.options.delay);
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted = (this._mouseStart(event) !== false);
			if (!this._mouseStarted) {
				event.preventDefault();
				return true;
			}
		}

		// Click event may never have fired (Gecko & Opera)
		if (true === $.data(event.target, this.widgetName + ".preventClickEvent")) {
			$.removeData(event.target, this.widgetName + ".preventClickEvent");
		}

		// these delegates are required to keep context
		this._mouseMoveDelegate = function(event) {
			return that._mouseMove(event);
		};
		this._mouseUpDelegate = function(event) {
			return that._mouseUp(event);
		};
		$(document)
			.bind("mousemove."+this.widgetName, this._mouseMoveDelegate)
			.bind("mouseup."+this.widgetName, this._mouseUpDelegate);

		event.preventDefault();

		mouseHandled = true;
		return true;
	},

	_mouseMove: function(event) {
		// IE mouseup check - mouseup happened when mouse was out of window
		if ($.ui.ie && ( !document.documentMode || document.documentMode < 9 ) && !event.button) {
			return this._mouseUp(event);
		}

		if (this._mouseStarted) {
			this._mouseDrag(event);
			return event.preventDefault();
		}

		if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
			this._mouseStarted =
				(this._mouseStart(this._mouseDownEvent, event) !== false);
			(this._mouseStarted ? this._mouseDrag(event) : this._mouseUp(event));
		}

		return !this._mouseStarted;
	},

	_mouseUp: function(event) {
		$(document)
			.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
			.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);

		if (this._mouseStarted) {
			this._mouseStarted = false;

			if (event.target === this._mouseDownEvent.target) {
				$.data(event.target, this.widgetName + ".preventClickEvent", true);
			}

			this._mouseStop(event);
		}

		return false;
	},

	_mouseDistanceMet: function(event) {
		return (Math.max(
				Math.abs(this._mouseDownEvent.pageX - event.pageX),
				Math.abs(this._mouseDownEvent.pageY - event.pageY)
			) >= this.options.distance
		);
	},

	_mouseDelayMet: function(/* event */) {
		return this.mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	_mouseStart: function(/* event */) {},
	_mouseDrag: function(/* event */) {},
	_mouseStop: function(/* event */) {},
	_mouseCapture: function(/* event */) { return true; }
});

})(jQuery);
(function( $, undefined ) {

$.ui = $.ui || {};

var cachedScrollbarWidth,
	max = Math.max,
	abs = Math.abs,
	round = Math.round,
	rhorizontal = /left|center|right/,
	rvertical = /top|center|bottom/,
	roffset = /[\+\-]\d+(\.[\d]+)?%?/,
	rposition = /^\w+/,
	rpercent = /%$/,
	_position = $.fn.position;

function getOffsets( offsets, width, height ) {
	return [
		parseFloat( offsets[ 0 ] ) * ( rpercent.test( offsets[ 0 ] ) ? width / 100 : 1 ),
		parseFloat( offsets[ 1 ] ) * ( rpercent.test( offsets[ 1 ] ) ? height / 100 : 1 )
	];
}

function parseCss( element, property ) {
	return parseInt( $.css( element, property ), 10 ) || 0;
}

function getDimensions( elem ) {
	var raw = elem[0];
	if ( raw.nodeType === 9 ) {
		return {
			width: elem.width(),
			height: elem.height(),
			offset: { top: 0, left: 0 }
		};
	}
	if ( $.isWindow( raw ) ) {
		return {
			width: elem.width(),
			height: elem.height(),
			offset: { top: elem.scrollTop(), left: elem.scrollLeft() }
		};
	}
	if ( raw.preventDefault ) {
		return {
			width: 0,
			height: 0,
			offset: { top: raw.pageY, left: raw.pageX }
		};
	}
	return {
		width: elem.outerWidth(),
		height: elem.outerHeight(),
		offset: elem.offset()
	};
}

$.position = {
	scrollbarWidth: function() {
		if ( cachedScrollbarWidth !== undefined ) {
			return cachedScrollbarWidth;
		}
		var w1, w2,
			div = $( "<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>" ),
			innerDiv = div.children()[0];

		$( "body" ).append( div );
		w1 = innerDiv.offsetWidth;
		div.css( "overflow", "scroll" );

		w2 = innerDiv.offsetWidth;

		if ( w1 === w2 ) {
			w2 = div[0].clientWidth;
		}

		div.remove();

		return (cachedScrollbarWidth = w1 - w2);
	},
	getScrollInfo: function( within ) {
		var overflowX = within.isWindow || within.isDocument ? "" :
				within.element.css( "overflow-x" ),
			overflowY = within.isWindow || within.isDocument ? "" :
				within.element.css( "overflow-y" ),
			hasOverflowX = overflowX === "scroll" ||
				( overflowX === "auto" && within.width < within.element[0].scrollWidth ),
			hasOverflowY = overflowY === "scroll" ||
				( overflowY === "auto" && within.height < within.element[0].scrollHeight );
		return {
			width: hasOverflowY ? $.position.scrollbarWidth() : 0,
			height: hasOverflowX ? $.position.scrollbarWidth() : 0
		};
	},
	getWithinInfo: function( element ) {
		var withinElement = $( element || window ),
			isWindow = $.isWindow( withinElement[0] ),
			isDocument = !!withinElement[ 0 ] && withinElement[ 0 ].nodeType === 9;
		return {
			element: withinElement,
			isWindow: isWindow,
			isDocument: isDocument,
			offset: withinElement.offset() || { left: 0, top: 0 },
			scrollLeft: withinElement.scrollLeft(),
			scrollTop: withinElement.scrollTop(),
			width: isWindow ? withinElement.width() : withinElement.outerWidth(),
			height: isWindow ? withinElement.height() : withinElement.outerHeight()
		};
	}
};

$.fn.position = function( options ) {
	if ( !options || !options.of ) {
		return _position.apply( this, arguments );
	}

	// make a copy, we don't want to modify arguments
	options = $.extend( {}, options );

	var atOffset, targetWidth, targetHeight, targetOffset, basePosition, dimensions,
		target = $( options.of ),
		within = $.position.getWithinInfo( options.within ),
		scrollInfo = $.position.getScrollInfo( within ),
		collision = ( options.collision || "flip" ).split( " " ),
		offsets = {};

	dimensions = getDimensions( target );
	if ( target[0].preventDefault ) {
		// force left top to allow flipping
		options.at = "left top";
	}
	targetWidth = dimensions.width;
	targetHeight = dimensions.height;
	targetOffset = dimensions.offset;
	// clone to reuse original targetOffset later
	basePosition = $.extend( {}, targetOffset );

	// force my and at to have valid horizontal and vertical positions
	// if a value is missing or invalid, it will be converted to center
	$.each( [ "my", "at" ], function() {
		var pos = ( options[ this ] || "" ).split( " " ),
			horizontalOffset,
			verticalOffset;

		if ( pos.length === 1) {
			pos = rhorizontal.test( pos[ 0 ] ) ?
				pos.concat( [ "center" ] ) :
				rvertical.test( pos[ 0 ] ) ?
					[ "center" ].concat( pos ) :
					[ "center", "center" ];
		}
		pos[ 0 ] = rhorizontal.test( pos[ 0 ] ) ? pos[ 0 ] : "center";
		pos[ 1 ] = rvertical.test( pos[ 1 ] ) ? pos[ 1 ] : "center";

		// calculate offsets
		horizontalOffset = roffset.exec( pos[ 0 ] );
		verticalOffset = roffset.exec( pos[ 1 ] );
		offsets[ this ] = [
			horizontalOffset ? horizontalOffset[ 0 ] : 0,
			verticalOffset ? verticalOffset[ 0 ] : 0
		];

		// reduce to just the positions without the offsets
		options[ this ] = [
			rposition.exec( pos[ 0 ] )[ 0 ],
			rposition.exec( pos[ 1 ] )[ 0 ]
		];
	});

	// normalize collision option
	if ( collision.length === 1 ) {
		collision[ 1 ] = collision[ 0 ];
	}

	if ( options.at[ 0 ] === "right" ) {
		basePosition.left += targetWidth;
	} else if ( options.at[ 0 ] === "center" ) {
		basePosition.left += targetWidth / 2;
	}

	if ( options.at[ 1 ] === "bottom" ) {
		basePosition.top += targetHeight;
	} else if ( options.at[ 1 ] === "center" ) {
		basePosition.top += targetHeight / 2;
	}

	atOffset = getOffsets( offsets.at, targetWidth, targetHeight );
	basePosition.left += atOffset[ 0 ];
	basePosition.top += atOffset[ 1 ];

	return this.each(function() {
		var collisionPosition, using,
			elem = $( this ),
			elemWidth = elem.outerWidth(),
			elemHeight = elem.outerHeight(),
			marginLeft = parseCss( this, "marginLeft" ),
			marginTop = parseCss( this, "marginTop" ),
			collisionWidth = elemWidth + marginLeft + parseCss( this, "marginRight" ) + scrollInfo.width,
			collisionHeight = elemHeight + marginTop + parseCss( this, "marginBottom" ) + scrollInfo.height,
			position = $.extend( {}, basePosition ),
			myOffset = getOffsets( offsets.my, elem.outerWidth(), elem.outerHeight() );

		if ( options.my[ 0 ] === "right" ) {
			position.left -= elemWidth;
		} else if ( options.my[ 0 ] === "center" ) {
			position.left -= elemWidth / 2;
		}

		if ( options.my[ 1 ] === "bottom" ) {
			position.top -= elemHeight;
		} else if ( options.my[ 1 ] === "center" ) {
			position.top -= elemHeight / 2;
		}

		position.left += myOffset[ 0 ];
		position.top += myOffset[ 1 ];

		// if the browser doesn't support fractions, then round for consistent results
		if ( !$.support.offsetFractions ) {
			position.left = round( position.left );
			position.top = round( position.top );
		}

		collisionPosition = {
			marginLeft: marginLeft,
			marginTop: marginTop
		};

		$.each( [ "left", "top" ], function( i, dir ) {
			if ( $.ui.position[ collision[ i ] ] ) {
				$.ui.position[ collision[ i ] ][ dir ]( position, {
					targetWidth: targetWidth,
					targetHeight: targetHeight,
					elemWidth: elemWidth,
					elemHeight: elemHeight,
					collisionPosition: collisionPosition,
					collisionWidth: collisionWidth,
					collisionHeight: collisionHeight,
					offset: [ atOffset[ 0 ] + myOffset[ 0 ], atOffset [ 1 ] + myOffset[ 1 ] ],
					my: options.my,
					at: options.at,
					within: within,
					elem : elem
				});
			}
		});

		if ( options.using ) {
			// adds feedback as second argument to using callback, if present
			using = function( props ) {
				var left = targetOffset.left - position.left,
					right = left + targetWidth - elemWidth,
					top = targetOffset.top - position.top,
					bottom = top + targetHeight - elemHeight,
					feedback = {
						target: {
							element: target,
							left: targetOffset.left,
							top: targetOffset.top,
							width: targetWidth,
							height: targetHeight
						},
						element: {
							element: elem,
							left: position.left,
							top: position.top,
							width: elemWidth,
							height: elemHeight
						},
						horizontal: right < 0 ? "left" : left > 0 ? "right" : "center",
						vertical: bottom < 0 ? "top" : top > 0 ? "bottom" : "middle"
					};
				if ( targetWidth < elemWidth && abs( left + right ) < targetWidth ) {
					feedback.horizontal = "center";
				}
				if ( targetHeight < elemHeight && abs( top + bottom ) < targetHeight ) {
					feedback.vertical = "middle";
				}
				if ( max( abs( left ), abs( right ) ) > max( abs( top ), abs( bottom ) ) ) {
					feedback.important = "horizontal";
				} else {
					feedback.important = "vertical";
				}
				options.using.call( this, props, feedback );
			};
		}

		elem.offset( $.extend( position, { using: using } ) );
	});
};

$.ui.position = {
	fit: {
		left: function( position, data ) {
			var within = data.within,
				withinOffset = within.isWindow ? within.scrollLeft : within.offset.left,
				outerWidth = within.width,
				collisionPosLeft = position.left - data.collisionPosition.marginLeft,
				overLeft = withinOffset - collisionPosLeft,
				overRight = collisionPosLeft + data.collisionWidth - outerWidth - withinOffset,
				newOverRight;

			// element is wider than within
			if ( data.collisionWidth > outerWidth ) {
				// element is initially over the left side of within
				if ( overLeft > 0 && overRight <= 0 ) {
					newOverRight = position.left + overLeft + data.collisionWidth - outerWidth - withinOffset;
					position.left += overLeft - newOverRight;
				// element is initially over right side of within
				} else if ( overRight > 0 && overLeft <= 0 ) {
					position.left = withinOffset;
				// element is initially over both left and right sides of within
				} else {
					if ( overLeft > overRight ) {
						position.left = withinOffset + outerWidth - data.collisionWidth;
					} else {
						position.left = withinOffset;
					}
				}
			// too far left -> align with left edge
			} else if ( overLeft > 0 ) {
				position.left += overLeft;
			// too far right -> align with right edge
			} else if ( overRight > 0 ) {
				position.left -= overRight;
			// adjust based on position and margin
			} else {
				position.left = max( position.left - collisionPosLeft, position.left );
			}
		},
		top: function( position, data ) {
			var within = data.within,
				withinOffset = within.isWindow ? within.scrollTop : within.offset.top,
				outerHeight = data.within.height,
				collisionPosTop = position.top - data.collisionPosition.marginTop,
				overTop = withinOffset - collisionPosTop,
				overBottom = collisionPosTop + data.collisionHeight - outerHeight - withinOffset,
				newOverBottom;

			// element is taller than within
			if ( data.collisionHeight > outerHeight ) {
				// element is initially over the top of within
				if ( overTop > 0 && overBottom <= 0 ) {
					newOverBottom = position.top + overTop + data.collisionHeight - outerHeight - withinOffset;
					position.top += overTop - newOverBottom;
				// element is initially over bottom of within
				} else if ( overBottom > 0 && overTop <= 0 ) {
					position.top = withinOffset;
				// element is initially over both top and bottom of within
				} else {
					if ( overTop > overBottom ) {
						position.top = withinOffset + outerHeight - data.collisionHeight;
					} else {
						position.top = withinOffset;
					}
				}
			// too far up -> align with top
			} else if ( overTop > 0 ) {
				position.top += overTop;
			// too far down -> align with bottom edge
			} else if ( overBottom > 0 ) {
				position.top -= overBottom;
			// adjust based on position and margin
			} else {
				position.top = max( position.top - collisionPosTop, position.top );
			}
		}
	},
	flip: {
		left: function( position, data ) {
			var within = data.within,
				withinOffset = within.offset.left + within.scrollLeft,
				outerWidth = within.width,
				offsetLeft = within.isWindow ? within.scrollLeft : within.offset.left,
				collisionPosLeft = position.left - data.collisionPosition.marginLeft,
				overLeft = collisionPosLeft - offsetLeft,
				overRight = collisionPosLeft + data.collisionWidth - outerWidth - offsetLeft,
				myOffset = data.my[ 0 ] === "left" ?
					-data.elemWidth :
					data.my[ 0 ] === "right" ?
						data.elemWidth :
						0,
				atOffset = data.at[ 0 ] === "left" ?
					data.targetWidth :
					data.at[ 0 ] === "right" ?
						-data.targetWidth :
						0,
				offset = -2 * data.offset[ 0 ],
				newOverRight,
				newOverLeft;

			if ( overLeft < 0 ) {
				newOverRight = position.left + myOffset + atOffset + offset + data.collisionWidth - outerWidth - withinOffset;
				if ( newOverRight < 0 || newOverRight < abs( overLeft ) ) {
					position.left += myOffset + atOffset + offset;
				}
			}
			else if ( overRight > 0 ) {
				newOverLeft = position.left - data.collisionPosition.marginLeft + myOffset + atOffset + offset - offsetLeft;
				if ( newOverLeft > 0 || abs( newOverLeft ) < overRight ) {
					position.left += myOffset + atOffset + offset;
				}
			}
		},
		top: function( position, data ) {
			var within = data.within,
				withinOffset = within.offset.top + within.scrollTop,
				outerHeight = within.height,
				offsetTop = within.isWindow ? within.scrollTop : within.offset.top,
				collisionPosTop = position.top - data.collisionPosition.marginTop,
				overTop = collisionPosTop - offsetTop,
				overBottom = collisionPosTop + data.collisionHeight - outerHeight - offsetTop,
				top = data.my[ 1 ] === "top",
				myOffset = top ?
					-data.elemHeight :
					data.my[ 1 ] === "bottom" ?
						data.elemHeight :
						0,
				atOffset = data.at[ 1 ] === "top" ?
					data.targetHeight :
					data.at[ 1 ] === "bottom" ?
						-data.targetHeight :
						0,
				offset = -2 * data.offset[ 1 ],
				newOverTop,
				newOverBottom;
			if ( overTop < 0 ) {
				newOverBottom = position.top + myOffset + atOffset + offset + data.collisionHeight - outerHeight - withinOffset;
				if ( ( position.top + myOffset + atOffset + offset) > overTop && ( newOverBottom < 0 || newOverBottom < abs( overTop ) ) ) {
					position.top += myOffset + atOffset + offset;
				}
			}
			else if ( overBottom > 0 ) {
				newOverTop = position.top - data.collisionPosition.marginTop + myOffset + atOffset + offset - offsetTop;
				if ( ( position.top + myOffset + atOffset + offset) > overBottom && ( newOverTop > 0 || abs( newOverTop ) < overBottom ) ) {
					position.top += myOffset + atOffset + offset;
				}
			}
		}
	},
	flipfit: {
		left: function() {
			$.ui.position.flip.left.apply( this, arguments );
			$.ui.position.fit.left.apply( this, arguments );
		},
		top: function() {
			$.ui.position.flip.top.apply( this, arguments );
			$.ui.position.fit.top.apply( this, arguments );
		}
	}
};

// fraction support test
(function () {
	var testElement, testElementParent, testElementStyle, offsetLeft, i,
		body = document.getElementsByTagName( "body" )[ 0 ],
		div = document.createElement( "div" );

	//Create a "fake body" for testing based on method used in jQuery.support
	testElement = document.createElement( body ? "div" : "body" );
	testElementStyle = {
		visibility: "hidden",
		width: 0,
		height: 0,
		border: 0,
		margin: 0,
		background: "none"
	};
	if ( body ) {
		$.extend( testElementStyle, {
			position: "absolute",
			left: "-1000px",
			top: "-1000px"
		});
	}
	for ( i in testElementStyle ) {
		testElement.style[ i ] = testElementStyle[ i ];
	}
	testElement.appendChild( div );
	testElementParent = body || document.documentElement;
	testElementParent.insertBefore( testElement, testElementParent.firstChild );

	div.style.cssText = "position: absolute; left: 10.7432222px;";

	offsetLeft = $( div ).offset().left;
	$.support.offsetFractions = offsetLeft > 10 && offsetLeft < 11;

	testElement.innerHTML = "";
	testElementParent.removeChild( testElement );
})();

}( jQuery ) );
(function( $, undefined ) {

var uid = 0,
	hideProps = {},
	showProps = {};

hideProps.height = hideProps.paddingTop = hideProps.paddingBottom =
	hideProps.borderTopWidth = hideProps.borderBottomWidth = "hide";
showProps.height = showProps.paddingTop = showProps.paddingBottom =
	showProps.borderTopWidth = showProps.borderBottomWidth = "show";

$.widget( "ui.accordion", {
	version: "1.10.4",
	options: {
		active: 0,
		animate: {},
		collapsible: false,
		event: "click",
		header: "> li > :first-child,> :not(li):even",
		heightStyle: "auto",
		icons: {
			activeHeader: "ui-icon-triangle-1-s",
			header: "ui-icon-triangle-1-e"
		},

		// callbacks
		activate: null,
		beforeActivate: null
	},

	_create: function() {
		var options = this.options;
		this.prevShow = this.prevHide = $();
		this.element.addClass( "ui-accordion ui-widget ui-helper-reset" )
			// ARIA
			.attr( "role", "tablist" );

		// don't allow collapsible: false and active: false / null
		if ( !options.collapsible && (options.active === false || options.active == null) ) {
			options.active = 0;
		}

		this._processPanels();
		// handle negative values
		if ( options.active < 0 ) {
			options.active += this.headers.length;
		}
		this._refresh();
	},

	_getCreateEventData: function() {
		return {
			header: this.active,
			panel: !this.active.length ? $() : this.active.next(),
			content: !this.active.length ? $() : this.active.next()
		};
	},

	_createIcons: function() {
		var icons = this.options.icons;
		if ( icons ) {
			$( "<span>" )
				.addClass( "ui-accordion-header-icon ui-icon " + icons.header )
				.prependTo( this.headers );
			this.active.children( ".ui-accordion-header-icon" )
				.removeClass( icons.header )
				.addClass( icons.activeHeader );
			this.headers.addClass( "ui-accordion-icons" );
		}
	},

	_destroyIcons: function() {
		this.headers
			.removeClass( "ui-accordion-icons" )
			.children( ".ui-accordion-header-icon" )
				.remove();
	},

	_destroy: function() {
		var contents;

		// clean up main element
		this.element
			.removeClass( "ui-accordion ui-widget ui-helper-reset" )
			.removeAttr( "role" );

		// clean up headers
		this.headers
			.removeClass( "ui-accordion-header ui-accordion-header-active ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top" )
			.removeAttr( "role" )
			.removeAttr( "aria-expanded" )
			.removeAttr( "aria-selected" )
			.removeAttr( "aria-controls" )
			.removeAttr( "tabIndex" )
			.each(function() {
				if ( /^ui-accordion/.test( this.id ) ) {
					this.removeAttribute( "id" );
				}
			});
		this._destroyIcons();

		// clean up content panels
		contents = this.headers.next()
			.css( "display", "" )
			.removeAttr( "role" )
			.removeAttr( "aria-hidden" )
			.removeAttr( "aria-labelledby" )
			.removeClass( "ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-state-disabled" )
			.each(function() {
				if ( /^ui-accordion/.test( this.id ) ) {
					this.removeAttribute( "id" );
				}
			});
		if ( this.options.heightStyle !== "content" ) {
			contents.css( "height", "" );
		}
	},

	_setOption: function( key, value ) {
		if ( key === "active" ) {
			// _activate() will handle invalid values and update this.options
			this._activate( value );
			return;
		}

		if ( key === "event" ) {
			if ( this.options.event ) {
				this._off( this.headers, this.options.event );
			}
			this._setupEvents( value );
		}

		this._super( key, value );

		// setting collapsible: false while collapsed; open first panel
		if ( key === "collapsible" && !value && this.options.active === false ) {
			this._activate( 0 );
		}

		if ( key === "icons" ) {
			this._destroyIcons();
			if ( value ) {
				this._createIcons();
			}
		}

		// #5332 - opacity doesn't cascade to positioned elements in IE
		// so we need to add the disabled class to the headers and panels
		if ( key === "disabled" ) {
			this.headers.add( this.headers.next() )
				.toggleClass( "ui-state-disabled", !!value );
		}
	},

	_keydown: function( event ) {
		if ( event.altKey || event.ctrlKey ) {
			return;
		}

		var keyCode = $.ui.keyCode,
			length = this.headers.length,
			currentIndex = this.headers.index( event.target ),
			toFocus = false;

		switch ( event.keyCode ) {
			case keyCode.RIGHT:
			case keyCode.DOWN:
				toFocus = this.headers[ ( currentIndex + 1 ) % length ];
				break;
			case keyCode.LEFT:
			case keyCode.UP:
				toFocus = this.headers[ ( currentIndex - 1 + length ) % length ];
				break;
			case keyCode.SPACE:
			case keyCode.ENTER:
				this._eventHandler( event );
				break;
			case keyCode.HOME:
				toFocus = this.headers[ 0 ];
				break;
			case keyCode.END:
				toFocus = this.headers[ length - 1 ];
				break;
		}

		if ( toFocus ) {
			$( event.target ).attr( "tabIndex", -1 );
			$( toFocus ).attr( "tabIndex", 0 );
			toFocus.focus();
			event.preventDefault();
		}
	},

	_panelKeyDown : function( event ) {
		if ( event.keyCode === $.ui.keyCode.UP && event.ctrlKey ) {
			$( event.currentTarget ).prev().focus();
		}
	},

	refresh: function() {
		var options = this.options;
		this._processPanels();

		// was collapsed or no panel
		if ( ( options.active === false && options.collapsible === true ) || !this.headers.length ) {
			options.active = false;
			this.active = $();
		// active false only when collapsible is true
		} else if ( options.active === false ) {
			this._activate( 0 );
		// was active, but active panel is gone
		} else if ( this.active.length && !$.contains( this.element[ 0 ], this.active[ 0 ] ) ) {
			// all remaining panel are disabled
			if ( this.headers.length === this.headers.find(".ui-state-disabled").length ) {
				options.active = false;
				this.active = $();
			// activate previous panel
			} else {
				this._activate( Math.max( 0, options.active - 1 ) );
			}
		// was active, active panel still exists
		} else {
			// make sure active index is correct
			options.active = this.headers.index( this.active );
		}

		this._destroyIcons();

		this._refresh();
	},

	_processPanels: function() {
		this.headers = this.element.find( this.options.header )
			.addClass( "ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" );

		this.headers.next()
			.addClass( "ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" )
			.filter(":not(.ui-accordion-content-active)")
			.hide();
	},

	_refresh: function() {
		var maxHeight,
			options = this.options,
			heightStyle = options.heightStyle,
			parent = this.element.parent(),
			accordionId = this.accordionId = "ui-accordion-" +
				(this.element.attr( "id" ) || ++uid);

		this.active = this._findActive( options.active )
			.addClass( "ui-accordion-header-active ui-state-active ui-corner-top" )
			.removeClass( "ui-corner-all" );
		this.active.next()
			.addClass( "ui-accordion-content-active" )
			.show();

		this.headers
			.attr( "role", "tab" )
			.each(function( i ) {
				var header = $( this ),
					headerId = header.attr( "id" ),
					panel = header.next(),
					panelId = panel.attr( "id" );
				if ( !headerId ) {
					headerId = accordionId + "-header-" + i;
					header.attr( "id", headerId );
				}
				if ( !panelId ) {
					panelId = accordionId + "-panel-" + i;
					panel.attr( "id", panelId );
				}
				header.attr( "aria-controls", panelId );
				panel.attr( "aria-labelledby", headerId );
			})
			.next()
				.attr( "role", "tabpanel" );

		this.headers
			.not( this.active )
			.attr({
				"aria-selected": "false",
				"aria-expanded": "false",
				tabIndex: -1
			})
			.next()
				.attr({
					"aria-hidden": "true"
				})
				.hide();

		// make sure at least one header is in the tab order
		if ( !this.active.length ) {
			this.headers.eq( 0 ).attr( "tabIndex", 0 );
		} else {
			this.active.attr({
				"aria-selected": "true",
				"aria-expanded": "true",
				tabIndex: 0
			})
			.next()
				.attr({
					"aria-hidden": "false"
				});
		}

		this._createIcons();

		this._setupEvents( options.event );

		if ( heightStyle === "fill" ) {
			maxHeight = parent.height();
			this.element.siblings( ":visible" ).each(function() {
				var elem = $( this ),
					position = elem.css( "position" );

				if ( position === "absolute" || position === "fixed" ) {
					return;
				}
				maxHeight -= elem.outerHeight( true );
			});

			this.headers.each(function() {
				maxHeight -= $( this ).outerHeight( true );
			});

			this.headers.next()
				.each(function() {
					$( this ).height( Math.max( 0, maxHeight -
						$( this ).innerHeight() + $( this ).height() ) );
				})
				.css( "overflow", "auto" );
		} else if ( heightStyle === "auto" ) {
			maxHeight = 0;
			this.headers.next()
				.each(function() {
					maxHeight = Math.max( maxHeight, $( this ).css( "height", "" ).height() );
				})
				.height( maxHeight );
		}
	},

	_activate: function( index ) {
		var active = this._findActive( index )[ 0 ];

		// trying to activate the already active panel
		if ( active === this.active[ 0 ] ) {
			return;
		}

		// trying to collapse, simulate a click on the currently active header
		active = active || this.active[ 0 ];

		this._eventHandler({
			target: active,
			currentTarget: active,
			preventDefault: $.noop
		});
	},

	_findActive: function( selector ) {
		return typeof selector === "number" ? this.headers.eq( selector ) : $();
	},

	_setupEvents: function( event ) {
		var events = {
			keydown: "_keydown"
		};
		if ( event ) {
			$.each( event.split(" "), function( index, eventName ) {
				events[ eventName ] = "_eventHandler";
			});
		}

		this._off( this.headers.add( this.headers.next() ) );
		this._on( this.headers, events );
		this._on( this.headers.next(), { keydown: "_panelKeyDown" });
		this._hoverable( this.headers );
		this._focusable( this.headers );
	},

	_eventHandler: function( event ) {
		var options = this.options,
			active = this.active,
			clicked = $( event.currentTarget ),
			clickedIsActive = clicked[ 0 ] === active[ 0 ],
			collapsing = clickedIsActive && options.collapsible,
			toShow = collapsing ? $() : clicked.next(),
			toHide = active.next(),
			eventData = {
				oldHeader: active,
				oldPanel: toHide,
				newHeader: collapsing ? $() : clicked,
				newPanel: toShow
			};

		event.preventDefault();

		if (
				// click on active header, but not collapsible
				( clickedIsActive && !options.collapsible ) ||
				// allow canceling activation
				( this._trigger( "beforeActivate", event, eventData ) === false ) ) {
			return;
		}

		options.active = collapsing ? false : this.headers.index( clicked );

		// when the call to ._toggle() comes after the class changes
		// it causes a very odd bug in IE 8 (see #6720)
		this.active = clickedIsActive ? $() : clicked;
		this._toggle( eventData );

		// switch classes
		// corner classes on the previously active header stay after the animation
		active.removeClass( "ui-accordion-header-active ui-state-active" );
		if ( options.icons ) {
			active.children( ".ui-accordion-header-icon" )
				.removeClass( options.icons.activeHeader )
				.addClass( options.icons.header );
		}

		if ( !clickedIsActive ) {
			clicked
				.removeClass( "ui-corner-all" )
				.addClass( "ui-accordion-header-active ui-state-active ui-corner-top" );
			if ( options.icons ) {
				clicked.children( ".ui-accordion-header-icon" )
					.removeClass( options.icons.header )
					.addClass( options.icons.activeHeader );
			}

			clicked
				.next()
				.addClass( "ui-accordion-content-active" );
		}
	},

	_toggle: function( data ) {
		var toShow = data.newPanel,
			toHide = this.prevShow.length ? this.prevShow : data.oldPanel;

		// handle activating a panel during the animation for another activation
		this.prevShow.add( this.prevHide ).stop( true, true );
		this.prevShow = toShow;
		this.prevHide = toHide;

		if ( this.options.animate ) {
			this._animate( toShow, toHide, data );
		} else {
			toHide.hide();
			toShow.show();
			this._toggleComplete( data );
		}

		toHide.attr({
			"aria-hidden": "true"
		});
		toHide.prev().attr( "aria-selected", "false" );
		// if we're switching panels, remove the old header from the tab order
		// if we're opening from collapsed state, remove the previous header from the tab order
		// if we're collapsing, then keep the collapsing header in the tab order
		if ( toShow.length && toHide.length ) {
			toHide.prev().attr({
				"tabIndex": -1,
				"aria-expanded": "false"
			});
		} else if ( toShow.length ) {
			this.headers.filter(function() {
				return $( this ).attr( "tabIndex" ) === 0;
			})
			.attr( "tabIndex", -1 );
		}

		toShow
			.attr( "aria-hidden", "false" )
			.prev()
				.attr({
					"aria-selected": "true",
					tabIndex: 0,
					"aria-expanded": "true"
				});
	},

	_animate: function( toShow, toHide, data ) {
		var total, easing, duration,
			that = this,
			adjust = 0,
			down = toShow.length &&
				( !toHide.length || ( toShow.index() < toHide.index() ) ),
			animate = this.options.animate || {},
			options = down && animate.down || animate,
			complete = function() {
				that._toggleComplete( data );
			};

		if ( typeof options === "number" ) {
			duration = options;
		}
		if ( typeof options === "string" ) {
			easing = options;
		}
		// fall back from options to animation in case of partial down settings
		easing = easing || options.easing || animate.easing;
		duration = duration || options.duration || animate.duration;

		if ( !toHide.length ) {
			return toShow.animate( showProps, duration, easing, complete );
		}
		if ( !toShow.length ) {
			return toHide.animate( hideProps, duration, easing, complete );
		}

		total = toShow.show().outerHeight();
		toHide.animate( hideProps, {
			duration: duration,
			easing: easing,
			step: function( now, fx ) {
				fx.now = Math.round( now );
			}
		});
		toShow
			.hide()
			.animate( showProps, {
				duration: duration,
				easing: easing,
				complete: complete,
				step: function( now, fx ) {
					fx.now = Math.round( now );
					if ( fx.prop !== "height" ) {
						adjust += fx.now;
					} else if ( that.options.heightStyle !== "content" ) {
						fx.now = Math.round( total - toHide.outerHeight() - adjust );
						adjust = 0;
					}
				}
			});
	},

	_toggleComplete: function( data ) {
		var toHide = data.oldPanel;

		toHide
			.removeClass( "ui-accordion-content-active" )
			.prev()
				.removeClass( "ui-corner-top" )
				.addClass( "ui-corner-all" );

		// Work around for rendering bug in IE (#5421)
		if ( toHide.length ) {
			toHide.parent()[0].className = toHide.parent()[0].className;
		}
		this._trigger( "activate", null, data );
	}
});

})( jQuery );
(function( $, undefined ) {

$.widget( "ui.autocomplete", {
	version: "1.10.4",
	defaultElement: "<input>",
	options: {
		appendTo: null,
		autoFocus: false,
		delay: 300,
		minLength: 1,
		position: {
			my: "left top",
			at: "left bottom",
			collision: "none"
		},
		source: null,

		// callbacks
		change: null,
		close: null,
		focus: null,
		open: null,
		response: null,
		search: null,
		select: null
	},

	requestIndex: 0,
	pending: 0,

	_create: function() {
		// Some browsers only repeat keydown events, not keypress events,
		// so we use the suppressKeyPress flag to determine if we've already
		// handled the keydown event. #7269
		// Unfortunately the code for & in keypress is the same as the up arrow,
		// so we use the suppressKeyPressRepeat flag to avoid handling keypress
		// events when we know the keydown event was used to modify the
		// search term. #7799
		var suppressKeyPress, suppressKeyPressRepeat, suppressInput,
			nodeName = this.element[0].nodeName.toLowerCase(),
			isTextarea = nodeName === "textarea",
			isInput = nodeName === "input";

		this.isMultiLine =
			// Textareas are always multi-line
			isTextarea ? true :
			// Inputs are always single-line, even if inside a contentEditable element
			// IE also treats inputs as contentEditable
			isInput ? false :
			// All other element types are determined by whether or not they're contentEditable
			this.element.prop( "isContentEditable" );

		this.valueMethod = this.element[ isTextarea || isInput ? "val" : "text" ];
		this.isNewMenu = true;

		this.element
			.addClass( "ui-autocomplete-input" )
			.attr( "autocomplete", "off" );

		this._on( this.element, {
			keydown: function( event ) {
				if ( this.element.prop( "readOnly" ) ) {
					suppressKeyPress = true;
					suppressInput = true;
					suppressKeyPressRepeat = true;
					return;
				}

				suppressKeyPress = false;
				suppressInput = false;
				suppressKeyPressRepeat = false;
				var keyCode = $.ui.keyCode;
				switch( event.keyCode ) {
				case keyCode.PAGE_UP:
					suppressKeyPress = true;
					this._move( "previousPage", event );
					break;
				case keyCode.PAGE_DOWN:
					suppressKeyPress = true;
					this._move( "nextPage", event );
					break;
				case keyCode.UP:
					suppressKeyPress = true;
					this._keyEvent( "previous", event );
					break;
				case keyCode.DOWN:
					suppressKeyPress = true;
					this._keyEvent( "next", event );
					break;
				case keyCode.ENTER:
				case keyCode.NUMPAD_ENTER:
					// when menu is open and has focus
					if ( this.menu.active ) {
						// #6055 - Opera still allows the keypress to occur
						// which causes forms to submit
						suppressKeyPress = true;
						event.preventDefault();
						this.menu.select( event );
					}
					break;
				case keyCode.TAB:
					if ( this.menu.active ) {
						this.menu.select( event );
					}
					break;
				case keyCode.ESCAPE:
					if ( this.menu.element.is( ":visible" ) ) {
						this._value( this.term );
						this.close( event );
						// Different browsers have different default behavior for escape
						// Single press can mean undo or clear
						// Double press in IE means clear the whole form
						event.preventDefault();
					}
					break;
				default:
					suppressKeyPressRepeat = true;
					// search timeout should be triggered before the input value is changed
					this._searchTimeout( event );
					break;
				}
			},
			keypress: function( event ) {
				if ( suppressKeyPress ) {
					suppressKeyPress = false;
					if ( !this.isMultiLine || this.menu.element.is( ":visible" ) ) {
						event.preventDefault();
					}
					return;
				}
				if ( suppressKeyPressRepeat ) {
					return;
				}

				// replicate some key handlers to allow them to repeat in Firefox and Opera
				var keyCode = $.ui.keyCode;
				switch( event.keyCode ) {
				case keyCode.PAGE_UP:
					this._move( "previousPage", event );
					break;
				case keyCode.PAGE_DOWN:
					this._move( "nextPage", event );
					break;
				case keyCode.UP:
					this._keyEvent( "previous", event );
					break;
				case keyCode.DOWN:
					this._keyEvent( "next", event );
					break;
				}
			},
			input: function( event ) {
				if ( suppressInput ) {
					suppressInput = false;
					event.preventDefault();
					return;
				}
				this._searchTimeout( event );
			},
			focus: function() {
				this.selectedItem = null;
				this.previous = this._value();
			},
			blur: function( event ) {
				if ( this.cancelBlur ) {
					delete this.cancelBlur;
					return;
				}

				clearTimeout( this.searching );
				this.close( event );
				this._change( event );
			}
		});

		this._initSource();
		this.menu = $( "<ul>" )
			.addClass( "ui-autocomplete ui-front" )
			.appendTo( this._appendTo() )
			.menu({
				// disable ARIA support, the live region takes care of that
				role: null
			})
			.hide()
			.data( "ui-menu" );

		this._on( this.menu.element, {
			mousedown: function( event ) {
				// prevent moving focus out of the text field
				event.preventDefault();

				// IE doesn't prevent moving focus even with event.preventDefault()
				// so we set a flag to know when we should ignore the blur event
				this.cancelBlur = true;
				this._delay(function() {
					delete this.cancelBlur;
				});

				// clicking on the scrollbar causes focus to shift to the body
				// but we can't detect a mouseup or a click immediately afterward
				// so we have to track the next mousedown and close the menu if
				// the user clicks somewhere outside of the autocomplete
				var menuElement = this.menu.element[ 0 ];
				if ( !$( event.target ).closest( ".ui-menu-item" ).length ) {
					this._delay(function() {
						var that = this;
						this.document.one( "mousedown", function( event ) {
							if ( event.target !== that.element[ 0 ] &&
									event.target !== menuElement &&
									!$.contains( menuElement, event.target ) ) {
								that.close();
							}
						});
					});
				}
			},
			menufocus: function( event, ui ) {
				// support: Firefox
				// Prevent accidental activation of menu items in Firefox (#7024 #9118)
				if ( this.isNewMenu ) {
					this.isNewMenu = false;
					if ( event.originalEvent && /^mouse/.test( event.originalEvent.type ) ) {
						this.menu.blur();

						this.document.one( "mousemove", function() {
							$( event.target ).trigger( event.originalEvent );
						});

						return;
					}
				}

				var item = ui.item.data( "ui-autocomplete-item" );
				if ( false !== this._trigger( "focus", event, { item: item } ) ) {
					// use value to match what will end up in the input, if it was a key event
					if ( event.originalEvent && /^key/.test( event.originalEvent.type ) ) {
						this._value( item.value );
					}
				} else {
					// Normally the input is populated with the item's value as the
					// menu is navigated, causing screen readers to notice a change and
					// announce the item. Since the focus event was canceled, this doesn't
					// happen, so we update the live region so that screen readers can
					// still notice the change and announce it.
					this.liveRegion.text( item.value );
				}
			},
			menuselect: function( event, ui ) {
				var item = ui.item.data( "ui-autocomplete-item" ),
					previous = this.previous;

				// only trigger when focus was lost (click on menu)
				if ( this.element[0] !== this.document[0].activeElement ) {
					this.element.focus();
					this.previous = previous;
					// #6109 - IE triggers two focus events and the second
					// is asynchronous, so we need to reset the previous
					// term synchronously and asynchronously :-(
					this._delay(function() {
						this.previous = previous;
						this.selectedItem = item;
					});
				}

				if ( false !== this._trigger( "select", event, { item: item } ) ) {
					this._value( item.value );
				}
				// reset the term after the select event
				// this allows custom select handling to work properly
				this.term = this._value();

				this.close( event );
				this.selectedItem = item;
			}
		});

		this.liveRegion = $( "<span>", {
				role: "status",
				"aria-live": "polite"
			})
			.addClass( "ui-helper-hidden-accessible" )
			.insertBefore( this.element );

		// turning off autocomplete prevents the browser from remembering the
		// value when navigating through history, so we re-enable autocomplete
		// if the page is unloaded before the widget is destroyed. #7790
		this._on( this.window, {
			beforeunload: function() {
				this.element.removeAttr( "autocomplete" );
			}
		});
	},

	_destroy: function() {
		clearTimeout( this.searching );
		this.element
			.removeClass( "ui-autocomplete-input" )
			.removeAttr( "autocomplete" );
		this.menu.element.remove();
		this.liveRegion.remove();
	},

	_setOption: function( key, value ) {
		this._super( key, value );
		if ( key === "source" ) {
			this._initSource();
		}
		if ( key === "appendTo" ) {
			this.menu.element.appendTo( this._appendTo() );
		}
		if ( key === "disabled" && value && this.xhr ) {
			this.xhr.abort();
		}
	},

	_appendTo: function() {
		var element = this.options.appendTo;

		if ( element ) {
			element = element.jquery || element.nodeType ?
				$( element ) :
				this.document.find( element ).eq( 0 );
		}

		if ( !element ) {
			element = this.element.closest( ".ui-front" );
		}

		if ( !element.length ) {
			element = this.document[0].body;
		}

		return element;
	},

	_initSource: function() {
		var array, url,
			that = this;
		if ( $.isArray(this.options.source) ) {
			array = this.options.source;
			this.source = function( request, response ) {
				response( $.ui.autocomplete.filter( array, request.term ) );
			};
		} else if ( typeof this.options.source === "string" ) {
			url = this.options.source;
			this.source = function( request, response ) {
				if ( that.xhr ) {
					that.xhr.abort();
				}
				that.xhr = $.ajax({
					url: url,
					data: request,
					dataType: "json",
					success: function( data ) {
						response( data );
					},
					error: function() {
						response( [] );
					}
				});
			};
		} else {
			this.source = this.options.source;
		}
	},

	_searchTimeout: function( event ) {
		clearTimeout( this.searching );
		this.searching = this._delay(function() {
			// only search if the value has changed
			if ( this.term !== this._value() ) {
				this.selectedItem = null;
				this.search( null, event );
			}
		}, this.options.delay );
	},

	search: function( value, event ) {
		value = value != null ? value : this._value();

		// always save the actual value, not the one passed as an argument
		this.term = this._value();

		if ( value.length < this.options.minLength ) {
			return this.close( event );
		}

		if ( this._trigger( "search", event ) === false ) {
			return;
		}

		return this._search( value );
	},

	_search: function( value ) {
		this.pending++;
		this.element.addClass( "ui-autocomplete-loading" );
		this.cancelSearch = false;

		this.source( { term: value }, this._response() );
	},

	_response: function() {
		var index = ++this.requestIndex;

		return $.proxy(function( content ) {
			if ( index === this.requestIndex ) {
				this.__response( content );
			}

			this.pending--;
			if ( !this.pending ) {
				this.element.removeClass( "ui-autocomplete-loading" );
			}
		}, this );
	},

	__response: function( content ) {
		if ( content ) {
			content = this._normalize( content );
		}
		this._trigger( "response", null, { content: content } );
		if ( !this.options.disabled && content && content.length && !this.cancelSearch ) {
			this._suggest( content );
			this._trigger( "open" );
		} else {
			// use ._close() instead of .close() so we don't cancel future searches
			this._close();
		}
	},

	close: function( event ) {
		this.cancelSearch = true;
		this._close( event );
	},

	_close: function( event ) {
		if ( this.menu.element.is( ":visible" ) ) {
			this.menu.element.hide();
			this.menu.blur();
			this.isNewMenu = true;
			this._trigger( "close", event );
		}
	},

	_change: function( event ) {
		if ( this.previous !== this._value() ) {
			this._trigger( "change", event, { item: this.selectedItem } );
		}
	},

	_normalize: function( items ) {
		// assume all items have the right format when the first item is complete
		if ( items.length && items[0].label && items[0].value ) {
			return items;
		}
		return $.map( items, function( item ) {
			if ( typeof item === "string" ) {
				return {
					label: item,
					value: item
				};
			}
			return $.extend({
				label: item.label || item.value,
				value: item.value || item.label
			}, item );
		});
	},

	_suggest: function( items ) {
		var ul = this.menu.element.empty();
		this._renderMenu( ul, items );
		this.isNewMenu = true;
		this.menu.refresh();

		// size and position menu
		ul.show();
		this._resizeMenu();
		ul.position( $.extend({
			of: this.element
		}, this.options.position ));

		if ( this.options.autoFocus ) {
			this.menu.next();
		}
	},

	_resizeMenu: function() {
		var ul = this.menu.element;
		ul.outerWidth( Math.max(
			// Firefox wraps long text (possibly a rounding bug)
			// so we add 1px to avoid the wrapping (#7513)
			ul.width( "" ).outerWidth() + 1,
			this.element.outerWidth()
		) );
	},

	_renderMenu: function( ul, items ) {
		var that = this;
		$.each( items, function( index, item ) {
			that._renderItemData( ul, item );
		});
	},

	_renderItemData: function( ul, item ) {
		return this._renderItem( ul, item ).data( "ui-autocomplete-item", item );
	},

	_renderItem: function( ul, item ) {
		return $( "<li>" )
			.append( $( "<a>" ).text( item.label ) )
			.appendTo( ul );
	},

	_move: function( direction, event ) {
		if ( !this.menu.element.is( ":visible" ) ) {
			this.search( null, event );
			return;
		}
		if ( this.menu.isFirstItem() && /^previous/.test( direction ) ||
				this.menu.isLastItem() && /^next/.test( direction ) ) {
			this._value( this.term );
			this.menu.blur();
			return;
		}
		this.menu[ direction ]( event );
	},

	widget: function() {
		return this.menu.element;
	},

	_value: function() {
		return this.valueMethod.apply( this.element, arguments );
	},

	_keyEvent: function( keyEvent, event ) {
		if ( !this.isMultiLine || this.menu.element.is( ":visible" ) ) {
			this._move( keyEvent, event );

			// prevents moving cursor to beginning/end of the text field in some browsers
			event.preventDefault();
		}
	}
});

$.extend( $.ui.autocomplete, {
	escapeRegex: function( value ) {
		return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
	},
	filter: function(array, term) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(term), "i" );
		return $.grep( array, function(value) {
			return matcher.test( value.label || value.value || value );
		});
	}
});


// live region extension, adding a `messages` option
// NOTE: This is an experimental API. We are still investigating
// a full solution for string manipulation and internationalization.
$.widget( "ui.autocomplete", $.ui.autocomplete, {
	options: {
		messages: {
			noResults: "No search results.",
			results: function( amount ) {
				return amount + ( amount > 1 ? " results are" : " result is" ) +
					" available, use up and down arrow keys to navigate.";
			}
		}
	},

	__response: function( content ) {
		var message;
		this._superApply( arguments );
		if ( this.options.disabled || this.cancelSearch ) {
			return;
		}
		if ( content && content.length ) {
			message = this.options.messages.results( content.length );
		} else {
			message = this.options.messages.noResults;
		}
		this.liveRegion.text( message );
	}
});

}( jQuery ));
(function( $, undefined ) {

var lastActive,
	baseClasses = "ui-button ui-widget ui-state-default ui-corner-all",
	typeClasses = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",
	formResetHandler = function() {
		var form = $( this );
		setTimeout(function() {
			form.find( ":ui-button" ).button( "refresh" );
		}, 1 );
	},
	radioGroup = function( radio ) {
		var name = radio.name,
			form = radio.form,
			radios = $( [] );
		if ( name ) {
			name = name.replace( /'/g, "\\'" );
			if ( form ) {
				radios = $( form ).find( "[name='" + name + "']" );
			} else {
				radios = $( "[name='" + name + "']", radio.ownerDocument )
					.filter(function() {
						return !this.form;
					});
			}
		}
		return radios;
	};

$.widget( "ui.button", {
	version: "1.10.4",
	defaultElement: "<button>",
	options: {
		disabled: null,
		text: true,
		label: null,
		icons: {
			primary: null,
			secondary: null
		}
	},
	_create: function() {
		this.element.closest( "form" )
			.unbind( "reset" + this.eventNamespace )
			.bind( "reset" + this.eventNamespace, formResetHandler );

		if ( typeof this.options.disabled !== "boolean" ) {
			this.options.disabled = !!this.element.prop( "disabled" );
		} else {
			this.element.prop( "disabled", this.options.disabled );
		}

		this._determineButtonType();
		this.hasTitle = !!this.buttonElement.attr( "title" );

		var that = this,
			options = this.options,
			toggleButton = this.type === "checkbox" || this.type === "radio",
			activeClass = !toggleButton ? "ui-state-active" : "";

		if ( options.label === null ) {
			options.label = (this.type === "input" ? this.buttonElement.val() : this.buttonElement.html());
		}

		this._hoverable( this.buttonElement );

		this.buttonElement
			.addClass( baseClasses )
			.attr( "role", "button" )
			.bind( "mouseenter" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return;
				}
				if ( this === lastActive ) {
					$( this ).addClass( "ui-state-active" );
				}
			})
			.bind( "mouseleave" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return;
				}
				$( this ).removeClass( activeClass );
			})
			.bind( "click" + this.eventNamespace, function( event ) {
				if ( options.disabled ) {
					event.preventDefault();
					event.stopImmediatePropagation();
				}
			});

		// Can't use _focusable() because the element that receives focus
		// and the element that gets the ui-state-focus class are different
		this._on({
			focus: function() {
				this.buttonElement.addClass( "ui-state-focus" );
			},
			blur: function() {
				this.buttonElement.removeClass( "ui-state-focus" );
			}
		});

		if ( toggleButton ) {
			this.element.bind( "change" + this.eventNamespace, function() {
				that.refresh();
			});
		}

		if ( this.type === "checkbox" ) {
			this.buttonElement.bind( "click" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return false;
				}
			});
		} else if ( this.type === "radio" ) {
			this.buttonElement.bind( "click" + this.eventNamespace, function() {
				if ( options.disabled ) {
					return false;
				}
				$( this ).addClass( "ui-state-active" );
				that.buttonElement.attr( "aria-pressed", "true" );

				var radio = that.element[ 0 ];
				radioGroup( radio )
					.not( radio )
					.map(function() {
						return $( this ).button( "widget" )[ 0 ];
					})
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			});
		} else {
			this.buttonElement
				.bind( "mousedown" + this.eventNamespace, function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).addClass( "ui-state-active" );
					lastActive = this;
					that.document.one( "mouseup", function() {
						lastActive = null;
					});
				})
				.bind( "mouseup" + this.eventNamespace, function() {
					if ( options.disabled ) {
						return false;
					}
					$( this ).removeClass( "ui-state-active" );
				})
				.bind( "keydown" + this.eventNamespace, function(event) {
					if ( options.disabled ) {
						return false;
					}
					if ( event.keyCode === $.ui.keyCode.SPACE || event.keyCode === $.ui.keyCode.ENTER ) {
						$( this ).addClass( "ui-state-active" );
					}
				})
				// see #8559, we bind to blur here in case the button element loses
				// focus between keydown and keyup, it would be left in an "active" state
				.bind( "keyup" + this.eventNamespace + " blur" + this.eventNamespace, function() {
					$( this ).removeClass( "ui-state-active" );
				});

			if ( this.buttonElement.is("a") ) {
				this.buttonElement.keyup(function(event) {
					if ( event.keyCode === $.ui.keyCode.SPACE ) {
						// TODO pass through original event correctly (just as 2nd argument doesn't work)
						$( this ).click();
					}
				});
			}
		}

		// TODO: pull out $.Widget's handling for the disabled option into
		// $.Widget.prototype._setOptionDisabled so it's easy to proxy and can
		// be overridden by individual plugins
		this._setOption( "disabled", options.disabled );
		this._resetButton();
	},

	_determineButtonType: function() {
		var ancestor, labelSelector, checked;

		if ( this.element.is("[type=checkbox]") ) {
			this.type = "checkbox";
		} else if ( this.element.is("[type=radio]") ) {
			this.type = "radio";
		} else if ( this.element.is("input") ) {
			this.type = "input";
		} else {
			this.type = "button";
		}

		if ( this.type === "checkbox" || this.type === "radio" ) {
			// we don't search against the document in case the element
			// is disconnected from the DOM
			ancestor = this.element.parents().last();
			labelSelector = "label[for='" + this.element.attr("id") + "']";
			this.buttonElement = ancestor.find( labelSelector );
			if ( !this.buttonElement.length ) {
				ancestor = ancestor.length ? ancestor.siblings() : this.element.siblings();
				this.buttonElement = ancestor.filter( labelSelector );
				if ( !this.buttonElement.length ) {
					this.buttonElement = ancestor.find( labelSelector );
				}
			}
			this.element.addClass( "ui-helper-hidden-accessible" );

			checked = this.element.is( ":checked" );
			if ( checked ) {
				this.buttonElement.addClass( "ui-state-active" );
			}
			this.buttonElement.prop( "aria-pressed", checked );
		} else {
			this.buttonElement = this.element;
		}
	},

	widget: function() {
		return this.buttonElement;
	},

	_destroy: function() {
		this.element
			.removeClass( "ui-helper-hidden-accessible" );
		this.buttonElement
			.removeClass( baseClasses + " ui-state-active " + typeClasses )
			.removeAttr( "role" )
			.removeAttr( "aria-pressed" )
			.html( this.buttonElement.find(".ui-button-text").html() );

		if ( !this.hasTitle ) {
			this.buttonElement.removeAttr( "title" );
		}
	},

	_setOption: function( key, value ) {
		this._super( key, value );
		if ( key === "disabled" ) {
			this.element.prop( "disabled", !!value );
			if ( value ) {
				this.buttonElement.removeClass( "ui-state-focus" );
			}
			return;
		}
		this._resetButton();
	},

	refresh: function() {
		//See #8237 & #8828
		var isDisabled = this.element.is( "input, button" ) ? this.element.is( ":disabled" ) : this.element.hasClass( "ui-button-disabled" );

		if ( isDisabled !== this.options.disabled ) {
			this._setOption( "disabled", isDisabled );
		}
		if ( this.type === "radio" ) {
			radioGroup( this.element[0] ).each(function() {
				if ( $( this ).is( ":checked" ) ) {
					$( this ).button( "widget" )
						.addClass( "ui-state-active" )
						.attr( "aria-pressed", "true" );
				} else {
					$( this ).button( "widget" )
						.removeClass( "ui-state-active" )
						.attr( "aria-pressed", "false" );
				}
			});
		} else if ( this.type === "checkbox" ) {
			if ( this.element.is( ":checked" ) ) {
				this.buttonElement
					.addClass( "ui-state-active" )
					.attr( "aria-pressed", "true" );
			} else {
				this.buttonElement
					.removeClass( "ui-state-active" )
					.attr( "aria-pressed", "false" );
			}
		}
	},

	_resetButton: function() {
		if ( this.type === "input" ) {
			if ( this.options.label ) {
				this.element.val( this.options.label );
			}
			return;
		}
		var buttonElement = this.buttonElement.removeClass( typeClasses ),
			buttonText = $( "<span></span>", this.document[0] )
				.addClass( "ui-button-text" )
				.html( this.options.label )
				.appendTo( buttonElement.empty() )
				.text(),
			icons = this.options.icons,
			multipleIcons = icons.primary && icons.secondary,
			buttonClasses = [];

		if ( icons.primary || icons.secondary ) {
			if ( this.options.text ) {
				buttonClasses.push( "ui-button-text-icon" + ( multipleIcons ? "s" : ( icons.primary ? "-primary" : "-secondary" ) ) );
			}

			if ( icons.primary ) {
				buttonElement.prepend( "<span class='ui-button-icon-primary ui-icon " + icons.primary + "'></span>" );
			}

			if ( icons.secondary ) {
				buttonElement.append( "<span class='ui-button-icon-secondary ui-icon " + icons.secondary + "'></span>" );
			}

			if ( !this.options.text ) {
				buttonClasses.push( multipleIcons ? "ui-button-icons-only" : "ui-button-icon-only" );

				if ( !this.hasTitle ) {
					buttonElement.attr( "title", $.trim( buttonText ) );
				}
			}
		} else {
			buttonClasses.push( "ui-button-text-only" );
		}
		buttonElement.addClass( buttonClasses.join( " " ) );
	}
});

$.widget( "ui.buttonset", {
	version: "1.10.4",
	options: {
		items: "button, input[type=button], input[type=submit], input[type=reset], input[type=checkbox], input[type=radio], a, :data(ui-button)"
	},

	_create: function() {
		this.element.addClass( "ui-buttonset" );
	},

	_init: function() {
		this.refresh();
	},

	_setOption: function( key, value ) {
		if ( key === "disabled" ) {
			this.buttons.button( "option", key, value );
		}

		this._super( key, value );
	},

	refresh: function() {
		var rtl = this.element.css( "direction" ) === "rtl";

		this.buttons = this.element.find( this.options.items )
			.filter( ":ui-button" )
				.button( "refresh" )
			.end()
			.not( ":ui-button" )
				.button()
			.end()
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-all ui-corner-left ui-corner-right" )
				.filter( ":first" )
					.addClass( rtl ? "ui-corner-right" : "ui-corner-left" )
				.end()
				.filter( ":last" )
					.addClass( rtl ? "ui-corner-left" : "ui-corner-right" )
				.end()
			.end();
	},

	_destroy: function() {
		this.element.removeClass( "ui-buttonset" );
		this.buttons
			.map(function() {
				return $( this ).button( "widget" )[ 0 ];
			})
				.removeClass( "ui-corner-left ui-corner-right" )
			.end()
			.button( "destroy" );
	}
});

}( jQuery ) );
(function( $, undefined ) {

$.extend($.ui, { datepicker: { version: "1.10.4" } });

var PROP_NAME = "datepicker",
	instActive;

/* Date picker manager.
   Use the singleton instance of this class, $.datepicker, to interact with the date picker.
   Settings for (groups of) date pickers are maintained in an instance object,
   allowing multiple different settings on the same page. */

function Datepicker() {
	this._curInst = null; // The current instance in use
	this._keyEvent = false; // If the last event was a key event
	this._disabledInputs = []; // List of date picker inputs that have been disabled
	this._datepickerShowing = false; // True if the popup picker is showing , false if not
	this._inDialog = false; // True if showing within a "dialog", false if not
	this._mainDivId = "ui-datepicker-div"; // The ID of the main datepicker division
	this._inlineClass = "ui-datepicker-inline"; // The name of the inline marker class
	this._appendClass = "ui-datepicker-append"; // The name of the append marker class
	this._triggerClass = "ui-datepicker-trigger"; // The name of the trigger marker class
	this._dialogClass = "ui-datepicker-dialog"; // The name of the dialog marker class
	this._disableClass = "ui-datepicker-disabled"; // The name of the disabled covering marker class
	this._unselectableClass = "ui-datepicker-unselectable"; // The name of the unselectable cell marker class
	this._currentClass = "ui-datepicker-current-day"; // The name of the current day marker class
	this._dayOverClass = "ui-datepicker-days-cell-over"; // The name of the day hover marker class
	this.regional = []; // Available regional settings, indexed by language code
	this.regional[""] = { // Default regional settings
		closeText: "Done", // Display text for close link
		prevText: "Prev", // Display text for previous month link
		nextText: "Next", // Display text for next month link
		currentText: "Today", // Display text for current month link
		monthNames: ["January","February","March","April","May","June",
			"July","August","September","October","November","December"], // Names of months for drop-down and formatting
		monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], // For formatting
		dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], // For formatting
		dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"], // For formatting
		dayNamesMin: ["Su","Mo","Tu","We","Th","Fr","Sa"], // Column headings for days starting at Sunday
		weekHeader: "Wk", // Column header for week of the year
		dateFormat: "mm/dd/yy", // See format options on parseDate
		firstDay: 0, // The first day of the week, Sun = 0, Mon = 1, ...
		isRTL: false, // True if right-to-left language, false if left-to-right
		showMonthAfterYear: false, // True if the year select precedes month, false for month then year
		yearSuffix: "" // Additional text to append to the year in the month headers
	};
	this._defaults = { // Global defaults for all the date picker instances
		showOn: "focus", // "focus" for popup on focus,
			// "button" for trigger button, or "both" for either
		showAnim: "fadeIn", // Name of jQuery animation for popup
		showOptions: {}, // Options for enhanced animations
		defaultDate: null, // Used when field is blank: actual date,
			// +/-number for offset from today, null for today
		appendText: "", // Display text following the input box, e.g. showing the format
		buttonText: "...", // Text for trigger button
		buttonImage: "", // URL for trigger button image
		buttonImageOnly: false, // True if the image appears alone, false if it appears on a button
		hideIfNoPrevNext: false, // True to hide next/previous month links
			// if not applicable, false to just disable them
		navigationAsDateFormat: false, // True if date formatting applied to prev/today/next links
		gotoCurrent: false, // True if today link goes back to current selection instead
		changeMonth: false, // True if month can be selected directly, false if only prev/next
		changeYear: false, // True if year can be selected directly, false if only prev/next
		yearRange: "c-10:c+10", // Range of years to display in drop-down,
			// either relative to today's year (-nn:+nn), relative to currently displayed year
			// (c-nn:c+nn), absolute (nnnn:nnnn), or a combination of the above (nnnn:-n)
		showOtherMonths: false, // True to show dates in other months, false to leave blank
		selectOtherMonths: false, // True to allow selection of dates in other months, false for unselectable
		showWeek: false, // True to show week of the year, false to not show it
		calculateWeek: this.iso8601Week, // How to calculate the week of the year,
			// takes a Date and returns the number of the week for it
		shortYearCutoff: "+10", // Short year values < this are in the current century,
			// > this are in the previous century,
			// string value starting with "+" for current year + value
		minDate: null, // The earliest selectable date, or null for no limit
		maxDate: null, // The latest selectable date, or null for no limit
		duration: "fast", // Duration of display/closure
		beforeShowDay: null, // Function that takes a date and returns an array with
			// [0] = true if selectable, false if not, [1] = custom CSS class name(s) or "",
			// [2] = cell title (optional), e.g. $.datepicker.noWeekends
		beforeShow: null, // Function that takes an input field and
			// returns a set of custom settings for the date picker
		onSelect: null, // Define a callback function when a date is selected
		onChangeMonthYear: null, // Define a callback function when the month or year is changed
		onClose: null, // Define a callback function when the datepicker is closed
		numberOfMonths: 1, // Number of months to show at a time
		showCurrentAtPos: 0, // The position in multipe months at which to show the current month (starting at 0)
		stepMonths: 1, // Number of months to step back/forward
		stepBigMonths: 12, // Number of months to step back/forward for the big links
		altField: "", // Selector for an alternate field to store selected dates into
		altFormat: "", // The date format to use for the alternate field
		constrainInput: true, // The input is constrained by the current date format
		showButtonPanel: false, // True to show button panel, false to not show it
		autoSize: false, // True to size the input for the date format, false to leave as is
		disabled: false // The initial disabled state
	};
	$.extend(this._defaults, this.regional[""]);
	this.dpDiv = bindHover($("<div id='" + this._mainDivId + "' class='ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>"));
}

$.extend(Datepicker.prototype, {
	/* Class name added to elements to indicate already configured with a date picker. */
	markerClassName: "hasDatepicker",

	//Keep track of the maximum number of rows displayed (see #7043)
	maxRows: 4,

	// TODO rename to "widget" when switching to widget factory
	_widgetDatepicker: function() {
		return this.dpDiv;
	},

	/* Override the default settings for all instances of the date picker.
	 * @param  settings  object - the new settings to use as defaults (anonymous object)
	 * @return the manager object
	 */
	setDefaults: function(settings) {
		extendRemove(this._defaults, settings || {});
		return this;
	},

	/* Attach the date picker to a jQuery selection.
	 * @param  target	element - the target input field or division or span
	 * @param  settings  object - the new settings to use for this date picker instance (anonymous)
	 */
	_attachDatepicker: function(target, settings) {
		var nodeName, inline, inst;
		nodeName = target.nodeName.toLowerCase();
		inline = (nodeName === "div" || nodeName === "span");
		if (!target.id) {
			this.uuid += 1;
			target.id = "dp" + this.uuid;
		}
		inst = this._newInst($(target), inline);
		inst.settings = $.extend({}, settings || {});
		if (nodeName === "input") {
			this._connectDatepicker(target, inst);
		} else if (inline) {
			this._inlineDatepicker(target, inst);
		}
	},

	/* Create a new instance object. */
	_newInst: function(target, inline) {
		var id = target[0].id.replace(/([^A-Za-z0-9_\-])/g, "\\\\$1"); // escape jQuery meta chars
		return {id: id, input: target, // associated target
			selectedDay: 0, selectedMonth: 0, selectedYear: 0, // current selection
			drawMonth: 0, drawYear: 0, // month being drawn
			inline: inline, // is datepicker inline or not
			dpDiv: (!inline ? this.dpDiv : // presentation div
			bindHover($("<div class='" + this._inlineClass + " ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>")))};
	},

	/* Attach the date picker to an input field. */
	_connectDatepicker: function(target, inst) {
		var input = $(target);
		inst.append = $([]);
		inst.trigger = $([]);
		if (input.hasClass(this.markerClassName)) {
			return;
		}
		this._attachments(input, inst);
		input.addClass(this.markerClassName).keydown(this._doKeyDown).
			keypress(this._doKeyPress).keyup(this._doKeyUp);
		this._autoSize(inst);
		$.data(target, PROP_NAME, inst);
		//If disabled option is true, disable the datepicker once it has been attached to the input (see ticket #5665)
		if( inst.settings.disabled ) {
			this._disableDatepicker( target );
		}
	},

	/* Make attachments based on settings. */
	_attachments: function(input, inst) {
		var showOn, buttonText, buttonImage,
			appendText = this._get(inst, "appendText"),
			isRTL = this._get(inst, "isRTL");

		if (inst.append) {
			inst.append.remove();
		}
		if (appendText) {
			inst.append = $("<span class='" + this._appendClass + "'>" + appendText + "</span>");
			input[isRTL ? "before" : "after"](inst.append);
		}

		input.unbind("focus", this._showDatepicker);

		if (inst.trigger) {
			inst.trigger.remove();
		}

		showOn = this._get(inst, "showOn");
		if (showOn === "focus" || showOn === "both") { // pop-up date picker when in the marked field
			input.focus(this._showDatepicker);
		}
		if (showOn === "button" || showOn === "both") { // pop-up date picker when button clicked
			buttonText = this._get(inst, "buttonText");
			buttonImage = this._get(inst, "buttonImage");
			inst.trigger = $(this._get(inst, "buttonImageOnly") ?
				$("<img/>").addClass(this._triggerClass).
					attr({ src: buttonImage, alt: buttonText, title: buttonText }) :
				$("<button type='button'></button>").addClass(this._triggerClass).
					html(!buttonImage ? buttonText : $("<img/>").attr(
					{ src:buttonImage, alt:buttonText, title:buttonText })));
			input[isRTL ? "before" : "after"](inst.trigger);
			inst.trigger.click(function() {
				if ($.datepicker._datepickerShowing && $.datepicker._lastInput === input[0]) {
					$.datepicker._hideDatepicker();
				} else if ($.datepicker._datepickerShowing && $.datepicker._lastInput !== input[0]) {
					$.datepicker._hideDatepicker();
					$.datepicker._showDatepicker(input[0]);
				} else {
					$.datepicker._showDatepicker(input[0]);
				}
				return false;
			});
		}
	},

	/* Apply the maximum length for the date format. */
	_autoSize: function(inst) {
		if (this._get(inst, "autoSize") && !inst.inline) {
			var findMax, max, maxI, i,
				date = new Date(2009, 12 - 1, 20), // Ensure double digits
				dateFormat = this._get(inst, "dateFormat");

			if (dateFormat.match(/[DM]/)) {
				findMax = function(names) {
					max = 0;
					maxI = 0;
					for (i = 0; i < names.length; i++) {
						if (names[i].length > max) {
							max = names[i].length;
							maxI = i;
						}
					}
					return maxI;
				};
				date.setMonth(findMax(this._get(inst, (dateFormat.match(/MM/) ?
					"monthNames" : "monthNamesShort"))));
				date.setDate(findMax(this._get(inst, (dateFormat.match(/DD/) ?
					"dayNames" : "dayNamesShort"))) + 20 - date.getDay());
			}
			inst.input.attr("size", this._formatDate(inst, date).length);
		}
	},

	/* Attach an inline date picker to a div. */
	_inlineDatepicker: function(target, inst) {
		var divSpan = $(target);
		if (divSpan.hasClass(this.markerClassName)) {
			return;
		}
		divSpan.addClass(this.markerClassName).append(inst.dpDiv);
		$.data(target, PROP_NAME, inst);
		this._setDate(inst, this._getDefaultDate(inst), true);
		this._updateDatepicker(inst);
		this._updateAlternate(inst);
		//If disabled option is true, disable the datepicker before showing it (see ticket #5665)
		if( inst.settings.disabled ) {
			this._disableDatepicker( target );
		}
		// Set display:block in place of inst.dpDiv.show() which won't work on disconnected elements
		// http://bugs.jqueryui.com/ticket/7552 - A Datepicker created on a detached div has zero height
		inst.dpDiv.css( "display", "block" );
	},

	/* Pop-up the date picker in a "dialog" box.
	 * @param  input element - ignored
	 * @param  date	string or Date - the initial date to display
	 * @param  onSelect  function - the function to call when a date is selected
	 * @param  settings  object - update the dialog date picker instance's settings (anonymous object)
	 * @param  pos int[2] - coordinates for the dialog's position within the screen or
	 *					event - with x/y coordinates or
	 *					leave empty for default (screen centre)
	 * @return the manager object
	 */
	_dialogDatepicker: function(input, date, onSelect, settings, pos) {
		var id, browserWidth, browserHeight, scrollX, scrollY,
			inst = this._dialogInst; // internal instance

		if (!inst) {
			this.uuid += 1;
			id = "dp" + this.uuid;
			this._dialogInput = $("<input type='text' id='" + id +
				"' style='position: absolute; top: -100px; width: 0px;'/>");
			this._dialogInput.keydown(this._doKeyDown);
			$("body").append(this._dialogInput);
			inst = this._dialogInst = this._newInst(this._dialogInput, false);
			inst.settings = {};
			$.data(this._dialogInput[0], PROP_NAME, inst);
		}
		extendRemove(inst.settings, settings || {});
		date = (date && date.constructor === Date ? this._formatDate(inst, date) : date);
		this._dialogInput.val(date);

		this._pos = (pos ? (pos.length ? pos : [pos.pageX, pos.pageY]) : null);
		if (!this._pos) {
			browserWidth = document.documentElement.clientWidth;
			browserHeight = document.documentElement.clientHeight;
			scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
			scrollY = document.documentElement.scrollTop || document.body.scrollTop;
			this._pos = // should use actual width/height below
				[(browserWidth / 2) - 100 + scrollX, (browserHeight / 2) - 150 + scrollY];
		}

		// move input on screen for focus, but hidden behind dialog
		this._dialogInput.css("left", (this._pos[0] + 20) + "px").css("top", this._pos[1] + "px");
		inst.settings.onSelect = onSelect;
		this._inDialog = true;
		this.dpDiv.addClass(this._dialogClass);
		this._showDatepicker(this._dialogInput[0]);
		if ($.blockUI) {
			$.blockUI(this.dpDiv);
		}
		$.data(this._dialogInput[0], PROP_NAME, inst);
		return this;
	},

	/* Detach a datepicker from its control.
	 * @param  target	element - the target input field or division or span
	 */
	_destroyDatepicker: function(target) {
		var nodeName,
			$target = $(target),
			inst = $.data(target, PROP_NAME);

		if (!$target.hasClass(this.markerClassName)) {
			return;
		}

		nodeName = target.nodeName.toLowerCase();
		$.removeData(target, PROP_NAME);
		if (nodeName === "input") {
			inst.append.remove();
			inst.trigger.remove();
			$target.removeClass(this.markerClassName).
				unbind("focus", this._showDatepicker).
				unbind("keydown", this._doKeyDown).
				unbind("keypress", this._doKeyPress).
				unbind("keyup", this._doKeyUp);
		} else if (nodeName === "div" || nodeName === "span") {
			$target.removeClass(this.markerClassName).empty();
		}
	},

	/* Enable the date picker to a jQuery selection.
	 * @param  target	element - the target input field or division or span
	 */
	_enableDatepicker: function(target) {
		var nodeName, inline,
			$target = $(target),
			inst = $.data(target, PROP_NAME);

		if (!$target.hasClass(this.markerClassName)) {
			return;
		}

		nodeName = target.nodeName.toLowerCase();
		if (nodeName === "input") {
			target.disabled = false;
			inst.trigger.filter("button").
				each(function() { this.disabled = false; }).end().
				filter("img").css({opacity: "1.0", cursor: ""});
		} else if (nodeName === "div" || nodeName === "span") {
			inline = $target.children("." + this._inlineClass);
			inline.children().removeClass("ui-state-disabled");
			inline.find("select.ui-datepicker-month, select.ui-datepicker-year").
				prop("disabled", false);
		}
		this._disabledInputs = $.map(this._disabledInputs,
			function(value) { return (value === target ? null : value); }); // delete entry
	},

	/* Disable the date picker to a jQuery selection.
	 * @param  target	element - the target input field or division or span
	 */
	_disableDatepicker: function(target) {
		var nodeName, inline,
			$target = $(target),
			inst = $.data(target, PROP_NAME);

		if (!$target.hasClass(this.markerClassName)) {
			return;
		}

		nodeName = target.nodeName.toLowerCase();
		if (nodeName === "input") {
			target.disabled = true;
			inst.trigger.filter("button").
				each(function() { this.disabled = true; }).end().
				filter("img").css({opacity: "0.5", cursor: "default"});
		} else if (nodeName === "div" || nodeName === "span") {
			inline = $target.children("." + this._inlineClass);
			inline.children().addClass("ui-state-disabled");
			inline.find("select.ui-datepicker-month, select.ui-datepicker-year").
				prop("disabled", true);
		}
		this._disabledInputs = $.map(this._disabledInputs,
			function(value) { return (value === target ? null : value); }); // delete entry
		this._disabledInputs[this._disabledInputs.length] = target;
	},

	/* Is the first field in a jQuery collection disabled as a datepicker?
	 * @param  target	element - the target input field or division or span
	 * @return boolean - true if disabled, false if enabled
	 */
	_isDisabledDatepicker: function(target) {
		if (!target) {
			return false;
		}
		for (var i = 0; i < this._disabledInputs.length; i++) {
			if (this._disabledInputs[i] === target) {
				return true;
			}
		}
		return false;
	},

	/* Retrieve the instance data for the target control.
	 * @param  target  element - the target input field or division or span
	 * @return  object - the associated instance data
	 * @throws  error if a jQuery problem getting data
	 */
	_getInst: function(target) {
		try {
			return $.data(target, PROP_NAME);
		}
		catch (err) {
			throw "Missing instance data for this datepicker";
		}
	},

	/* Update or retrieve the settings for a date picker attached to an input field or division.
	 * @param  target  element - the target input field or division or span
	 * @param  name	object - the new settings to update or
	 *				string - the name of the setting to change or retrieve,
	 *				when retrieving also "all" for all instance settings or
	 *				"defaults" for all global defaults
	 * @param  value   any - the new value for the setting
	 *				(omit if above is an object or to retrieve a value)
	 */
	_optionDatepicker: function(target, name, value) {
		var settings, date, minDate, maxDate,
			inst = this._getInst(target);

		if (arguments.length === 2 && typeof name === "string") {
			return (name === "defaults" ? $.extend({}, $.datepicker._defaults) :
				(inst ? (name === "all" ? $.extend({}, inst.settings) :
				this._get(inst, name)) : null));
		}

		settings = name || {};
		if (typeof name === "string") {
			settings = {};
			settings[name] = value;
		}

		if (inst) {
			if (this._curInst === inst) {
				this._hideDatepicker();
			}

			date = this._getDateDatepicker(target, true);
			minDate = this._getMinMaxDate(inst, "min");
			maxDate = this._getMinMaxDate(inst, "max");
			extendRemove(inst.settings, settings);
			// reformat the old minDate/maxDate values if dateFormat changes and a new minDate/maxDate isn't provided
			if (minDate !== null && settings.dateFormat !== undefined && settings.minDate === undefined) {
				inst.settings.minDate = this._formatDate(inst, minDate);
			}
			if (maxDate !== null && settings.dateFormat !== undefined && settings.maxDate === undefined) {
				inst.settings.maxDate = this._formatDate(inst, maxDate);
			}
			if ( "disabled" in settings ) {
				if ( settings.disabled ) {
					this._disableDatepicker(target);
				} else {
					this._enableDatepicker(target);
				}
			}
			this._attachments($(target), inst);
			this._autoSize(inst);
			this._setDate(inst, date);
			this._updateAlternate(inst);
			this._updateDatepicker(inst);
		}
	},

	// change method deprecated
	_changeDatepicker: function(target, name, value) {
		this._optionDatepicker(target, name, value);
	},

	/* Redraw the date picker attached to an input field or division.
	 * @param  target  element - the target input field or division or span
	 */
	_refreshDatepicker: function(target) {
		var inst = this._getInst(target);
		if (inst) {
			this._updateDatepicker(inst);
		}
	},

	/* Set the dates for a jQuery selection.
	 * @param  target element - the target input field or division or span
	 * @param  date	Date - the new date
	 */
	_setDateDatepicker: function(target, date) {
		var inst = this._getInst(target);
		if (inst) {
			this._setDate(inst, date);
			this._updateDatepicker(inst);
			this._updateAlternate(inst);
		}
	},

	/* Get the date(s) for the first entry in a jQuery selection.
	 * @param  target element - the target input field or division or span
	 * @param  noDefault boolean - true if no default date is to be used
	 * @return Date - the current date
	 */
	_getDateDatepicker: function(target, noDefault) {
		var inst = this._getInst(target);
		if (inst && !inst.inline) {
			this._setDateFromField(inst, noDefault);
		}
		return (inst ? this._getDate(inst) : null);
	},

	/* Handle keystrokes. */
	_doKeyDown: function(event) {
		var onSelect, dateStr, sel,
			inst = $.datepicker._getInst(event.target),
			handled = true,
			isRTL = inst.dpDiv.is(".ui-datepicker-rtl");

		inst._keyEvent = true;
		if ($.datepicker._datepickerShowing) {
			switch (event.keyCode) {
				case 9: $.datepicker._hideDatepicker();
						handled = false;
						break; // hide on tab out
				case 13: sel = $("td." + $.datepicker._dayOverClass + ":not(." +
									$.datepicker._currentClass + ")", inst.dpDiv);
						if (sel[0]) {
							$.datepicker._selectDay(event.target, inst.selectedMonth, inst.selectedYear, sel[0]);
						}

						onSelect = $.datepicker._get(inst, "onSelect");
						if (onSelect) {
							dateStr = $.datepicker._formatDate(inst);

							// trigger custom callback
							onSelect.apply((inst.input ? inst.input[0] : null), [dateStr, inst]);
						} else {
							$.datepicker._hideDatepicker();
						}

						return false; // don't submit the form
				case 27: $.datepicker._hideDatepicker();
						break; // hide on escape
				case 33: $.datepicker._adjustDate(event.target, (event.ctrlKey ?
							-$.datepicker._get(inst, "stepBigMonths") :
							-$.datepicker._get(inst, "stepMonths")), "M");
						break; // previous month/year on page up/+ ctrl
				case 34: $.datepicker._adjustDate(event.target, (event.ctrlKey ?
							+$.datepicker._get(inst, "stepBigMonths") :
							+$.datepicker._get(inst, "stepMonths")), "M");
						break; // next month/year on page down/+ ctrl
				case 35: if (event.ctrlKey || event.metaKey) {
							$.datepicker._clearDate(event.target);
						}
						handled = event.ctrlKey || event.metaKey;
						break; // clear on ctrl or command +end
				case 36: if (event.ctrlKey || event.metaKey) {
							$.datepicker._gotoToday(event.target);
						}
						handled = event.ctrlKey || event.metaKey;
						break; // current on ctrl or command +home
				case 37: if (event.ctrlKey || event.metaKey) {
							$.datepicker._adjustDate(event.target, (isRTL ? +1 : -1), "D");
						}
						handled = event.ctrlKey || event.metaKey;
						// -1 day on ctrl or command +left
						if (event.originalEvent.altKey) {
							$.datepicker._adjustDate(event.target, (event.ctrlKey ?
								-$.datepicker._get(inst, "stepBigMonths") :
								-$.datepicker._get(inst, "stepMonths")), "M");
						}
						// next month/year on alt +left on Mac
						break;
				case 38: if (event.ctrlKey || event.metaKey) {
							$.datepicker._adjustDate(event.target, -7, "D");
						}
						handled = event.ctrlKey || event.metaKey;
						break; // -1 week on ctrl or command +up
				case 39: if (event.ctrlKey || event.metaKey) {
							$.datepicker._adjustDate(event.target, (isRTL ? -1 : +1), "D");
						}
						handled = event.ctrlKey || event.metaKey;
						// +1 day on ctrl or command +right
						if (event.originalEvent.altKey) {
							$.datepicker._adjustDate(event.target, (event.ctrlKey ?
								+$.datepicker._get(inst, "stepBigMonths") :
								+$.datepicker._get(inst, "stepMonths")), "M");
						}
						// next month/year on alt +right
						break;
				case 40: if (event.ctrlKey || event.metaKey) {
							$.datepicker._adjustDate(event.target, +7, "D");
						}
						handled = event.ctrlKey || event.metaKey;
						break; // +1 week on ctrl or command +down
				default: handled = false;
			}
		} else if (event.keyCode === 36 && event.ctrlKey) { // display the date picker on ctrl+home
			$.datepicker._showDatepicker(this);
		} else {
			handled = false;
		}

		if (handled) {
			event.preventDefault();
			event.stopPropagation();
		}
	},

	/* Filter entered characters - based on date format. */
	_doKeyPress: function(event) {
		var chars, chr,
			inst = $.datepicker._getInst(event.target);

		if ($.datepicker._get(inst, "constrainInput")) {
			chars = $.datepicker._possibleChars($.datepicker._get(inst, "dateFormat"));
			chr = String.fromCharCode(event.charCode == null ? event.keyCode : event.charCode);
			return event.ctrlKey || event.metaKey || (chr < " " || !chars || chars.indexOf(chr) > -1);
		}
	},

	/* Synchronise manual entry and field/alternate field. */
	_doKeyUp: function(event) {
		var date,
			inst = $.datepicker._getInst(event.target);

		if (inst.input.val() !== inst.lastVal) {
			try {
				date = $.datepicker.parseDate($.datepicker._get(inst, "dateFormat"),
					(inst.input ? inst.input.val() : null),
					$.datepicker._getFormatConfig(inst));

				if (date) { // only if valid
					$.datepicker._setDateFromField(inst);
					$.datepicker._updateAlternate(inst);
					$.datepicker._updateDatepicker(inst);
				}
			}
			catch (err) {
			}
		}
		return true;
	},

	/* Pop-up the date picker for a given input field.
	 * If false returned from beforeShow event handler do not show.
	 * @param  input  element - the input field attached to the date picker or
	 *					event - if triggered by focus
	 */
	_showDatepicker: function(input) {
		input = input.target || input;
		if (input.nodeName.toLowerCase() !== "input") { // find from button/image trigger
			input = $("input", input.parentNode)[0];
		}

		if ($.datepicker._isDisabledDatepicker(input) || $.datepicker._lastInput === input) { // already here
			return;
		}

		var inst, beforeShow, beforeShowSettings, isFixed,
			offset, showAnim, duration;

		inst = $.datepicker._getInst(input);
		if ($.datepicker._curInst && $.datepicker._curInst !== inst) {
			$.datepicker._curInst.dpDiv.stop(true, true);
			if ( inst && $.datepicker._datepickerShowing ) {
				$.datepicker._hideDatepicker( $.datepicker._curInst.input[0] );
			}
		}

		beforeShow = $.datepicker._get(inst, "beforeShow");
		beforeShowSettings = beforeShow ? beforeShow.apply(input, [input, inst]) : {};
		if(beforeShowSettings === false){
			return;
		}
		extendRemove(inst.settings, beforeShowSettings);

		inst.lastVal = null;
		$.datepicker._lastInput = input;
		$.datepicker._setDateFromField(inst);

		if ($.datepicker._inDialog) { // hide cursor
			input.value = "";
		}
		if (!$.datepicker._pos) { // position below input
			$.datepicker._pos = $.datepicker._findPos(input);
			$.datepicker._pos[1] += input.offsetHeight; // add the height
		}

		isFixed = false;
		$(input).parents().each(function() {
			isFixed |= $(this).css("position") === "fixed";
			return !isFixed;
		});

		offset = {left: $.datepicker._pos[0], top: $.datepicker._pos[1]};
		$.datepicker._pos = null;
		//to avoid flashes on Firefox
		inst.dpDiv.empty();
		// determine sizing offscreen
		inst.dpDiv.css({position: "absolute", display: "block", top: "-1000px"});
		$.datepicker._updateDatepicker(inst);
		// fix width for dynamic number of date pickers
		// and adjust position before showing
		offset = $.datepicker._checkOffset(inst, offset, isFixed);
		inst.dpDiv.css({position: ($.datepicker._inDialog && $.blockUI ?
			"static" : (isFixed ? "fixed" : "absolute")), display: "none",
			left: offset.left + "px", top: offset.top + "px"});

		if (!inst.inline) {
			showAnim = $.datepicker._get(inst, "showAnim");
			duration = $.datepicker._get(inst, "duration");
			inst.dpDiv.zIndex($(input).zIndex()+1);
			$.datepicker._datepickerShowing = true;

			if ( $.effects && $.effects.effect[ showAnim ] ) {
				inst.dpDiv.show(showAnim, $.datepicker._get(inst, "showOptions"), duration);
			} else {
				inst.dpDiv[showAnim || "show"](showAnim ? duration : null);
			}

			if ( $.datepicker._shouldFocusInput( inst ) ) {
				inst.input.focus();
			}

			$.datepicker._curInst = inst;
		}
	},

	/* Generate the date picker content. */
	_updateDatepicker: function(inst) {
		this.maxRows = 4; //Reset the max number of rows being displayed (see #7043)
		instActive = inst; // for delegate hover events
		inst.dpDiv.empty().append(this._generateHTML(inst));
		this._attachHandlers(inst);
		inst.dpDiv.find("." + this._dayOverClass + " a").mouseover();

		var origyearshtml,
			numMonths = this._getNumberOfMonths(inst),
			cols = numMonths[1],
			width = 17;

		inst.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width("");
		if (cols > 1) {
			inst.dpDiv.addClass("ui-datepicker-multi-" + cols).css("width", (width * cols) + "em");
		}
		inst.dpDiv[(numMonths[0] !== 1 || numMonths[1] !== 1 ? "add" : "remove") +
			"Class"]("ui-datepicker-multi");
		inst.dpDiv[(this._get(inst, "isRTL") ? "add" : "remove") +
			"Class"]("ui-datepicker-rtl");

		if (inst === $.datepicker._curInst && $.datepicker._datepickerShowing && $.datepicker._shouldFocusInput( inst ) ) {
			inst.input.focus();
		}

		// deffered render of the years select (to avoid flashes on Firefox)
		if( inst.yearshtml ){
			origyearshtml = inst.yearshtml;
			setTimeout(function(){
				//assure that inst.yearshtml didn't change.
				if( origyearshtml === inst.yearshtml && inst.yearshtml ){
					inst.dpDiv.find("select.ui-datepicker-year:first").replaceWith(inst.yearshtml);
				}
				origyearshtml = inst.yearshtml = null;
			}, 0);
		}
	},

	// #6694 - don't focus the input if it's already focused
	// this breaks the change event in IE
	// Support: IE and jQuery <1.9
	_shouldFocusInput: function( inst ) {
		return inst.input && inst.input.is( ":visible" ) && !inst.input.is( ":disabled" ) && !inst.input.is( ":focus" );
	},

	/* Check positioning to remain on screen. */
	_checkOffset: function(inst, offset, isFixed) {
		var dpWidth = inst.dpDiv.outerWidth(),
			dpHeight = inst.dpDiv.outerHeight(),
			inputWidth = inst.input ? inst.input.outerWidth() : 0,
			inputHeight = inst.input ? inst.input.outerHeight() : 0,
			viewWidth = document.documentElement.clientWidth + (isFixed ? 0 : $(document).scrollLeft()),
			viewHeight = document.documentElement.clientHeight + (isFixed ? 0 : $(document).scrollTop());

		offset.left -= (this._get(inst, "isRTL") ? (dpWidth - inputWidth) : 0);
		offset.left -= (isFixed && offset.left === inst.input.offset().left) ? $(document).scrollLeft() : 0;
		offset.top -= (isFixed && offset.top === (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0;

		// now check if datepicker is showing outside window viewport - move to a better place if so.
		offset.left -= Math.min(offset.left, (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ?
			Math.abs(offset.left + dpWidth - viewWidth) : 0);
		offset.top -= Math.min(offset.top, (offset.top + dpHeight > viewHeight && viewHeight > dpHeight) ?
			Math.abs(dpHeight + inputHeight) : 0);

		return offset;
	},

	/* Find an object's position on the screen. */
	_findPos: function(obj) {
		var position,
			inst = this._getInst(obj),
			isRTL = this._get(inst, "isRTL");

		while (obj && (obj.type === "hidden" || obj.nodeType !== 1 || $.expr.filters.hidden(obj))) {
			obj = obj[isRTL ? "previousSibling" : "nextSibling"];
		}

		position = $(obj).offset();
		return [position.left, position.top];
	},

	/* Hide the date picker from view.
	 * @param  input  element - the input field attached to the date picker
	 */
	_hideDatepicker: function(input) {
		var showAnim, duration, postProcess, onClose,
			inst = this._curInst;

		if (!inst || (input && inst !== $.data(input, PROP_NAME))) {
			return;
		}

		if (this._datepickerShowing) {
			showAnim = this._get(inst, "showAnim");
			duration = this._get(inst, "duration");
			postProcess = function() {
				$.datepicker._tidyDialog(inst);
			};

			// DEPRECATED: after BC for 1.8.x $.effects[ showAnim ] is not needed
			if ( $.effects && ( $.effects.effect[ showAnim ] || $.effects[ showAnim ] ) ) {
				inst.dpDiv.hide(showAnim, $.datepicker._get(inst, "showOptions"), duration, postProcess);
			} else {
				inst.dpDiv[(showAnim === "slideDown" ? "slideUp" :
					(showAnim === "fadeIn" ? "fadeOut" : "hide"))]((showAnim ? duration : null), postProcess);
			}

			if (!showAnim) {
				postProcess();
			}
			this._datepickerShowing = false;

			onClose = this._get(inst, "onClose");
			if (onClose) {
				onClose.apply((inst.input ? inst.input[0] : null), [(inst.input ? inst.input.val() : ""), inst]);
			}

			this._lastInput = null;
			if (this._inDialog) {
				this._dialogInput.css({ position: "absolute", left: "0", top: "-100px" });
				if ($.blockUI) {
					$.unblockUI();
					$("body").append(this.dpDiv);
				}
			}
			this._inDialog = false;
		}
	},

	/* Tidy up after a dialog display. */
	_tidyDialog: function(inst) {
		inst.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar");
	},

	/* Close date picker if clicked elsewhere. */
	_checkExternalClick: function(event) {
		if (!$.datepicker._curInst) {
			return;
		}

		var $target = $(event.target),
			inst = $.datepicker._getInst($target[0]);

		if ( ( ( $target[0].id !== $.datepicker._mainDivId &&
				$target.parents("#" + $.datepicker._mainDivId).length === 0 &&
				!$target.hasClass($.datepicker.markerClassName) &&
				!$target.closest("." + $.datepicker._triggerClass).length &&
				$.datepicker._datepickerShowing && !($.datepicker._inDialog && $.blockUI) ) ) ||
			( $target.hasClass($.datepicker.markerClassName) && $.datepicker._curInst !== inst ) ) {
				$.datepicker._hideDatepicker();
		}
	},

	/* Adjust one of the date sub-fields. */
	_adjustDate: function(id, offset, period) {
		var target = $(id),
			inst = this._getInst(target[0]);

		if (this._isDisabledDatepicker(target[0])) {
			return;
		}
		this._adjustInstDate(inst, offset +
			(period === "M" ? this._get(inst, "showCurrentAtPos") : 0), // undo positioning
			period);
		this._updateDatepicker(inst);
	},

	/* Action for current link. */
	_gotoToday: function(id) {
		var date,
			target = $(id),
			inst = this._getInst(target[0]);

		if (this._get(inst, "gotoCurrent") && inst.currentDay) {
			inst.selectedDay = inst.currentDay;
			inst.drawMonth = inst.selectedMonth = inst.currentMonth;
			inst.drawYear = inst.selectedYear = inst.currentYear;
		} else {
			date = new Date();
			inst.selectedDay = date.getDate();
			inst.drawMonth = inst.selectedMonth = date.getMonth();
			inst.drawYear = inst.selectedYear = date.getFullYear();
		}
		this._notifyChange(inst);
		this._adjustDate(target);
	},

	/* Action for selecting a new month/year. */
	_selectMonthYear: function(id, select, period) {
		var target = $(id),
			inst = this._getInst(target[0]);

		inst["selected" + (period === "M" ? "Month" : "Year")] =
		inst["draw" + (period === "M" ? "Month" : "Year")] =
			parseInt(select.options[select.selectedIndex].value,10);

		this._notifyChange(inst);
		this._adjustDate(target);
	},

	/* Action for selecting a day. */
	_selectDay: function(id, month, year, td) {
		var inst,
			target = $(id);

		if ($(td).hasClass(this._unselectableClass) || this._isDisabledDatepicker(target[0])) {
			return;
		}

		inst = this._getInst(target[0]);
		inst.selectedDay = inst.currentDay = $("a", td).html();
		inst.selectedMonth = inst.currentMonth = month;
		inst.selectedYear = inst.currentYear = year;
		this._selectDate(id, this._formatDate(inst,
			inst.currentDay, inst.currentMonth, inst.currentYear));
	},

	/* Erase the input field and hide the date picker. */
	_clearDate: function(id) {
		var target = $(id);
		this._selectDate(target, "");
	},

	/* Update the input field with the selected date. */
	_selectDate: function(id, dateStr) {
		var onSelect,
			target = $(id),
			inst = this._getInst(target[0]);

		dateStr = (dateStr != null ? dateStr : this._formatDate(inst));
		if (inst.input) {
			inst.input.val(dateStr);
		}
		this._updateAlternate(inst);

		onSelect = this._get(inst, "onSelect");
		if (onSelect) {
			onSelect.apply((inst.input ? inst.input[0] : null), [dateStr, inst]);  // trigger custom callback
		} else if (inst.input) {
			inst.input.trigger("change"); // fire the change event
		}

		if (inst.inline){
			this._updateDatepicker(inst);
		} else {
			this._hideDatepicker();
			this._lastInput = inst.input[0];
			if (typeof(inst.input[0]) !== "object") {
				inst.input.focus(); // restore focus
			}
			this._lastInput = null;
		}
	},

	/* Update any alternate field to synchronise with the main field. */
	_updateAlternate: function(inst) {
		var altFormat, date, dateStr,
			altField = this._get(inst, "altField");

		if (altField) { // update alternate field too
			altFormat = this._get(inst, "altFormat") || this._get(inst, "dateFormat");
			date = this._getDate(inst);
			dateStr = this.formatDate(altFormat, date, this._getFormatConfig(inst));
			$(altField).each(function() { $(this).val(dateStr); });
		}
	},

	/* Set as beforeShowDay function to prevent selection of weekends.
	 * @param  date  Date - the date to customise
	 * @return [boolean, string] - is this date selectable?, what is its CSS class?
	 */
	noWeekends: function(date) {
		var day = date.getDay();
		return [(day > 0 && day < 6), ""];
	},

	/* Set as calculateWeek to determine the week of the year based on the ISO 8601 definition.
	 * @param  date  Date - the date to get the week for
	 * @return  number - the number of the week within the year that contains this date
	 */
	iso8601Week: function(date) {
		var time,
			checkDate = new Date(date.getTime());

		// Find Thursday of this week starting on Monday
		checkDate.setDate(checkDate.getDate() + 4 - (checkDate.getDay() || 7));

		time = checkDate.getTime();
		checkDate.setMonth(0); // Compare with Jan 1
		checkDate.setDate(1);
		return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
	},

	/* Parse a string value into a date object.
	 * See formatDate below for the possible formats.
	 *
	 * @param  format string - the expected format of the date
	 * @param  value string - the date in the above format
	 * @param  settings Object - attributes include:
	 *					shortYearCutoff  number - the cutoff year for determining the century (optional)
	 *					dayNamesShort	string[7] - abbreviated names of the days from Sunday (optional)
	 *					dayNames		string[7] - names of the days from Sunday (optional)
	 *					monthNamesShort string[12] - abbreviated names of the months (optional)
	 *					monthNames		string[12] - names of the months (optional)
	 * @return  Date - the extracted date value or null if value is blank
	 */
	parseDate: function (format, value, settings) {
		if (format == null || value == null) {
			throw "Invalid arguments";
		}

		value = (typeof value === "object" ? value.toString() : value + "");
		if (value === "") {
			return null;
		}

		var iFormat, dim, extra,
			iValue = 0,
			shortYearCutoffTemp = (settings ? settings.shortYearCutoff : null) || this._defaults.shortYearCutoff,
			shortYearCutoff = (typeof shortYearCutoffTemp !== "string" ? shortYearCutoffTemp :
				new Date().getFullYear() % 100 + parseInt(shortYearCutoffTemp, 10)),
			dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort,
			dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames,
			monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort,
			monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames,
			year = -1,
			month = -1,
			day = -1,
			doy = -1,
			literal = false,
			date,
			// Check whether a format character is doubled
			lookAhead = function(match) {
				var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) === match);
				if (matches) {
					iFormat++;
				}
				return matches;
			},
			// Extract a number from the string value
			getNumber = function(match) {
				var isDoubled = lookAhead(match),
					size = (match === "@" ? 14 : (match === "!" ? 20 :
					(match === "y" && isDoubled ? 4 : (match === "o" ? 3 : 2)))),
					digits = new RegExp("^\\d{1," + size + "}"),
					num = value.substring(iValue).match(digits);
				if (!num) {
					throw "Missing number at position " + iValue;
				}
				iValue += num[0].length;
				return parseInt(num[0], 10);
			},
			// Extract a name from the string value and convert to an index
			getName = function(match, shortNames, longNames) {
				var index = -1,
					names = $.map(lookAhead(match) ? longNames : shortNames, function (v, k) {
						return [ [k, v] ];
					}).sort(function (a, b) {
						return -(a[1].length - b[1].length);
					});

				$.each(names, function (i, pair) {
					var name = pair[1];
					if (value.substr(iValue, name.length).toLowerCase() === name.toLowerCase()) {
						index = pair[0];
						iValue += name.length;
						return false;
					}
				});
				if (index !== -1) {
					return index + 1;
				} else {
					throw "Unknown name at position " + iValue;
				}
			},
			// Confirm that a literal character matches the string value
			checkLiteral = function() {
				if (value.charAt(iValue) !== format.charAt(iFormat)) {
					throw "Unexpected literal at position " + iValue;
				}
				iValue++;
			};

		for (iFormat = 0; iFormat < format.length; iFormat++) {
			if (literal) {
				if (format.charAt(iFormat) === "'" && !lookAhead("'")) {
					literal = false;
				} else {
					checkLiteral();
				}
			} else {
				switch (format.charAt(iFormat)) {
					case "d":
						day = getNumber("d");
						break;
					case "D":
						getName("D", dayNamesShort, dayNames);
						break;
					case "o":
						doy = getNumber("o");
						break;
					case "m":
						month = getNumber("m");
						break;
					case "M":
						month = getName("M", monthNamesShort, monthNames);
						break;
					case "y":
						year = getNumber("y");
						break;
					case "@":
						date = new Date(getNumber("@"));
						year = date.getFullYear();
						month = date.getMonth() + 1;
						day = date.getDate();
						break;
					case "!":
						date = new Date((getNumber("!") - this._ticksTo1970) / 10000);
						year = date.getFullYear();
						month = date.getMonth() + 1;
						day = date.getDate();
						break;
					case "'":
						if (lookAhead("'")){
							checkLiteral();
						} else {
							literal = true;
						}
						break;
					default:
						checkLiteral();
				}
			}
		}

		if (iValue < value.length){
			extra = value.substr(iValue);
			if (!/^\s+/.test(extra)) {
				throw "Extra/unparsed characters found in date: " + extra;
			}
		}

		if (year === -1) {
			year = new Date().getFullYear();
		} else if (year < 100) {
			year += new Date().getFullYear() - new Date().getFullYear() % 100 +
				(year <= shortYearCutoff ? 0 : -100);
		}

		if (doy > -1) {
			month = 1;
			day = doy;
			do {
				dim = this._getDaysInMonth(year, month - 1);
				if (day <= dim) {
					break;
				}
				month++;
				day -= dim;
			} while (true);
		}

		date = this._daylightSavingAdjust(new Date(year, month - 1, day));
		if (date.getFullYear() !== year || date.getMonth() + 1 !== month || date.getDate() !== day) {
			throw "Invalid date"; // E.g. 31/02/00
		}
		return date;
	},

	/* Standard date formats. */
	ATOM: "yy-mm-dd", // RFC 3339 (ISO 8601)
	COOKIE: "D, dd M yy",
	ISO_8601: "yy-mm-dd",
	RFC_822: "D, d M y",
	RFC_850: "DD, dd-M-y",
	RFC_1036: "D, d M y",
	RFC_1123: "D, d M yy",
	RFC_2822: "D, d M yy",
	RSS: "D, d M y", // RFC 822
	TICKS: "!",
	TIMESTAMP: "@",
	W3C: "yy-mm-dd", // ISO 8601

	_ticksTo1970: (((1970 - 1) * 365 + Math.floor(1970 / 4) - Math.floor(1970 / 100) +
		Math.floor(1970 / 400)) * 24 * 60 * 60 * 10000000),

	/* Format a date object into a string value.
	 * The format can be combinations of the following:
	 * d  - day of month (no leading zero)
	 * dd - day of month (two digit)
	 * o  - day of year (no leading zeros)
	 * oo - day of year (three digit)
	 * D  - day name short
	 * DD - day name long
	 * m  - month of year (no leading zero)
	 * mm - month of year (two digit)
	 * M  - month name short
	 * MM - month name long
	 * y  - year (two digit)
	 * yy - year (four digit)
	 * @ - Unix timestamp (ms since 01/01/1970)
	 * ! - Windows ticks (100ns since 01/01/0001)
	 * "..." - literal text
	 * '' - single quote
	 *
	 * @param  format string - the desired format of the date
	 * @param  date Date - the date value to format
	 * @param  settings Object - attributes include:
	 *					dayNamesShort	string[7] - abbreviated names of the days from Sunday (optional)
	 *					dayNames		string[7] - names of the days from Sunday (optional)
	 *					monthNamesShort string[12] - abbreviated names of the months (optional)
	 *					monthNames		string[12] - names of the months (optional)
	 * @return  string - the date in the above format
	 */
	formatDate: function (format, date, settings) {
		if (!date) {
			return "";
		}

		var iFormat,
			dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort,
			dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames,
			monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort,
			monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames,
			// Check whether a format character is doubled
			lookAhead = function(match) {
				var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) === match);
				if (matches) {
					iFormat++;
				}
				return matches;
			},
			// Format a number, with leading zero if necessary
			formatNumber = function(match, value, len) {
				var num = "" + value;
				if (lookAhead(match)) {
					while (num.length < len) {
						num = "0" + num;
					}
				}
				return num;
			},
			// Format a name, short or long as requested
			formatName = function(match, value, shortNames, longNames) {
				return (lookAhead(match) ? longNames[value] : shortNames[value]);
			},
			output = "",
			literal = false;

		if (date) {
			for (iFormat = 0; iFormat < format.length; iFormat++) {
				if (literal) {
					if (format.charAt(iFormat) === "'" && !lookAhead("'")) {
						literal = false;
					} else {
						output += format.charAt(iFormat);
					}
				} else {
					switch (format.charAt(iFormat)) {
						case "d":
							output += formatNumber("d", date.getDate(), 2);
							break;
						case "D":
							output += formatName("D", date.getDay(), dayNamesShort, dayNames);
							break;
						case "o":
							output += formatNumber("o",
								Math.round((new Date(date.getFullYear(), date.getMonth(), date.getDate()).getTime() - new Date(date.getFullYear(), 0, 0).getTime()) / 86400000), 3);
							break;
						case "m":
							output += formatNumber("m", date.getMonth() + 1, 2);
							break;
						case "M":
							output += formatName("M", date.getMonth(), monthNamesShort, monthNames);
							break;
						case "y":
							output += (lookAhead("y") ? date.getFullYear() :
								(date.getYear() % 100 < 10 ? "0" : "") + date.getYear() % 100);
							break;
						case "@":
							output += date.getTime();
							break;
						case "!":
							output += date.getTime() * 10000 + this._ticksTo1970;
							break;
						case "'":
							if (lookAhead("'")) {
								output += "'";
							} else {
								literal = true;
							}
							break;
						default:
							output += format.charAt(iFormat);
					}
				}
			}
		}
		return output;
	},

	/* Extract all possible characters from the date format. */
	_possibleChars: function (format) {
		var iFormat,
			chars = "",
			literal = false,
			// Check whether a format character is doubled
			lookAhead = function(match) {
				var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) === match);
				if (matches) {
					iFormat++;
				}
				return matches;
			};

		for (iFormat = 0; iFormat < format.length; iFormat++) {
			if (literal) {
				if (format.charAt(iFormat) === "'" && !lookAhead("'")) {
					literal = false;
				} else {
					chars += format.charAt(iFormat);
				}
			} else {
				switch (format.charAt(iFormat)) {
					case "d": case "m": case "y": case "@":
						chars += "0123456789";
						break;
					case "D": case "M":
						return null; // Accept anything
					case "'":
						if (lookAhead("'")) {
							chars += "'";
						} else {
							literal = true;
						}
						break;
					default:
						chars += format.charAt(iFormat);
				}
			}
		}
		return chars;
	},

	/* Get a setting value, defaulting if necessary. */
	_get: function(inst, name) {
		return inst.settings[name] !== undefined ?
			inst.settings[name] : this._defaults[name];
	},

	/* Parse existing date and initialise date picker. */
	_setDateFromField: function(inst, noDefault) {
		if (inst.input.val() === inst.lastVal) {
			return;
		}

		var dateFormat = this._get(inst, "dateFormat"),
			dates = inst.lastVal = inst.input ? inst.input.val() : null,
			defaultDate = this._getDefaultDate(inst),
			date = defaultDate,
			settings = this._getFormatConfig(inst);

		try {
			date = this.parseDate(dateFormat, dates, settings) || defaultDate;
		} catch (event) {
			dates = (noDefault ? "" : dates);
		}
		inst.selectedDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = date.getFullYear();
		inst.currentDay = (dates ? date.getDate() : 0);
		inst.currentMonth = (dates ? date.getMonth() : 0);
		inst.currentYear = (dates ? date.getFullYear() : 0);
		this._adjustInstDate(inst);
	},

	/* Retrieve the default date shown on opening. */
	_getDefaultDate: function(inst) {
		return this._restrictMinMax(inst,
			this._determineDate(inst, this._get(inst, "defaultDate"), new Date()));
	},

	/* A date may be specified as an exact value or a relative one. */
	_determineDate: function(inst, date, defaultDate) {
		var offsetNumeric = function(offset) {
				var date = new Date();
				date.setDate(date.getDate() + offset);
				return date;
			},
			offsetString = function(offset) {
				try {
					return $.datepicker.parseDate($.datepicker._get(inst, "dateFormat"),
						offset, $.datepicker._getFormatConfig(inst));
				}
				catch (e) {
					// Ignore
				}

				var date = (offset.toLowerCase().match(/^c/) ?
					$.datepicker._getDate(inst) : null) || new Date(),
					year = date.getFullYear(),
					month = date.getMonth(),
					day = date.getDate(),
					pattern = /([+\-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g,
					matches = pattern.exec(offset);

				while (matches) {
					switch (matches[2] || "d") {
						case "d" : case "D" :
							day += parseInt(matches[1],10); break;
						case "w" : case "W" :
							day += parseInt(matches[1],10) * 7; break;
						case "m" : case "M" :
							month += parseInt(matches[1],10);
							day = Math.min(day, $.datepicker._getDaysInMonth(year, month));
							break;
						case "y": case "Y" :
							year += parseInt(matches[1],10);
							day = Math.min(day, $.datepicker._getDaysInMonth(year, month));
							break;
					}
					matches = pattern.exec(offset);
				}
				return new Date(year, month, day);
			},
			newDate = (date == null || date === "" ? defaultDate : (typeof date === "string" ? offsetString(date) :
				(typeof date === "number" ? (isNaN(date) ? defaultDate : offsetNumeric(date)) : new Date(date.getTime()))));

		newDate = (newDate && newDate.toString() === "Invalid Date" ? defaultDate : newDate);
		if (newDate) {
			newDate.setHours(0);
			newDate.setMinutes(0);
			newDate.setSeconds(0);
			newDate.setMilliseconds(0);
		}
		return this._daylightSavingAdjust(newDate);
	},

	/* Handle switch to/from daylight saving.
	 * Hours may be non-zero on daylight saving cut-over:
	 * > 12 when midnight changeover, but then cannot generate
	 * midnight datetime, so jump to 1AM, otherwise reset.
	 * @param  date  (Date) the date to check
	 * @return  (Date) the corrected date
	 */
	_daylightSavingAdjust: function(date) {
		if (!date) {
			return null;
		}
		date.setHours(date.getHours() > 12 ? date.getHours() + 2 : 0);
		return date;
	},

	/* Set the date(s) directly. */
	_setDate: function(inst, date, noChange) {
		var clear = !date,
			origMonth = inst.selectedMonth,
			origYear = inst.selectedYear,
			newDate = this._restrictMinMax(inst, this._determineDate(inst, date, new Date()));

		inst.selectedDay = inst.currentDay = newDate.getDate();
		inst.drawMonth = inst.selectedMonth = inst.currentMonth = newDate.getMonth();
		inst.drawYear = inst.selectedYear = inst.currentYear = newDate.getFullYear();
		if ((origMonth !== inst.selectedMonth || origYear !== inst.selectedYear) && !noChange) {
			this._notifyChange(inst);
		}
		this._adjustInstDate(inst);
		if (inst.input) {
			inst.input.val(clear ? "" : this._formatDate(inst));
		}
	},

	/* Retrieve the date(s) directly. */
	_getDate: function(inst) {
		var startDate = (!inst.currentYear || (inst.input && inst.input.val() === "") ? null :
			this._daylightSavingAdjust(new Date(
			inst.currentYear, inst.currentMonth, inst.currentDay)));
			return startDate;
	},

	/* Attach the onxxx handlers.  These are declared statically so
	 * they work with static code transformers like Caja.
	 */
	_attachHandlers: function(inst) {
		var stepMonths = this._get(inst, "stepMonths"),
			id = "#" + inst.id.replace( /\\\\/g, "\\" );
		inst.dpDiv.find("[data-handler]").map(function () {
			var handler = {
				prev: function () {
					$.datepicker._adjustDate(id, -stepMonths, "M");
				},
				next: function () {
					$.datepicker._adjustDate(id, +stepMonths, "M");
				},
				hide: function () {
					$.datepicker._hideDatepicker();
				},
				today: function () {
					$.datepicker._gotoToday(id);
				},
				selectDay: function () {
					$.datepicker._selectDay(id, +this.getAttribute("data-month"), +this.getAttribute("data-year"), this);
					return false;
				},
				selectMonth: function () {
					$.datepicker._selectMonthYear(id, this, "M");
					return false;
				},
				selectYear: function () {
					$.datepicker._selectMonthYear(id, this, "Y");
					return false;
				}
			};
			$(this).bind(this.getAttribute("data-event"), handler[this.getAttribute("data-handler")]);
		});
	},

	/* Generate the HTML for the current state of the date picker. */
	_generateHTML: function(inst) {
		var maxDraw, prevText, prev, nextText, next, currentText, gotoDate,
			controls, buttonPanel, firstDay, showWeek, dayNames, dayNamesMin,
			monthNames, monthNamesShort, beforeShowDay, showOtherMonths,
			selectOtherMonths, defaultDate, html, dow, row, group, col, selectedDate,
			cornerClass, calender, thead, day, daysInMonth, leadDays, curRows, numRows,
			printDate, dRow, tbody, daySettings, otherMonth, unselectable,
			tempDate = new Date(),
			today = this._daylightSavingAdjust(
				new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate())), // clear time
			isRTL = this._get(inst, "isRTL"),
			showButtonPanel = this._get(inst, "showButtonPanel"),
			hideIfNoPrevNext = this._get(inst, "hideIfNoPrevNext"),
			navigationAsDateFormat = this._get(inst, "navigationAsDateFormat"),
			numMonths = this._getNumberOfMonths(inst),
			showCurrentAtPos = this._get(inst, "showCurrentAtPos"),
			stepMonths = this._get(inst, "stepMonths"),
			isMultiMonth = (numMonths[0] !== 1 || numMonths[1] !== 1),
			currentDate = this._daylightSavingAdjust((!inst.currentDay ? new Date(9999, 9, 9) :
				new Date(inst.currentYear, inst.currentMonth, inst.currentDay))),
			minDate = this._getMinMaxDate(inst, "min"),
			maxDate = this._getMinMaxDate(inst, "max"),
			drawMonth = inst.drawMonth - showCurrentAtPos,
			drawYear = inst.drawYear;

		if (drawMonth < 0) {
			drawMonth += 12;
			drawYear--;
		}
		if (maxDate) {
			maxDraw = this._daylightSavingAdjust(new Date(maxDate.getFullYear(),
				maxDate.getMonth() - (numMonths[0] * numMonths[1]) + 1, maxDate.getDate()));
			maxDraw = (minDate && maxDraw < minDate ? minDate : maxDraw);
			while (this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1)) > maxDraw) {
				drawMonth--;
				if (drawMonth < 0) {
					drawMonth = 11;
					drawYear--;
				}
			}
		}
		inst.drawMonth = drawMonth;
		inst.drawYear = drawYear;

		prevText = this._get(inst, "prevText");
		prevText = (!navigationAsDateFormat ? prevText : this.formatDate(prevText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth - stepMonths, 1)),
			this._getFormatConfig(inst)));

		prev = (this._canAdjustMonth(inst, -1, drawYear, drawMonth) ?
			"<a class='ui-datepicker-prev ui-corner-all' data-handler='prev' data-event='click'" +
			" title='" + prevText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "e" : "w") + "'>" + prevText + "</span></a>" :
			(hideIfNoPrevNext ? "" : "<a class='ui-datepicker-prev ui-corner-all ui-state-disabled' title='"+ prevText +"'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "e" : "w") + "'>" + prevText + "</span></a>"));

		nextText = this._get(inst, "nextText");
		nextText = (!navigationAsDateFormat ? nextText : this.formatDate(nextText,
			this._daylightSavingAdjust(new Date(drawYear, drawMonth + stepMonths, 1)),
			this._getFormatConfig(inst)));

		next = (this._canAdjustMonth(inst, +1, drawYear, drawMonth) ?
			"<a class='ui-datepicker-next ui-corner-all' data-handler='next' data-event='click'" +
			" title='" + nextText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "w" : "e") + "'>" + nextText + "</span></a>" :
			(hideIfNoPrevNext ? "" : "<a class='ui-datepicker-next ui-corner-all ui-state-disabled' title='"+ nextText + "'><span class='ui-icon ui-icon-circle-triangle-" + ( isRTL ? "w" : "e") + "'>" + nextText + "</span></a>"));

		currentText = this._get(inst, "currentText");
		gotoDate = (this._get(inst, "gotoCurrent") && inst.currentDay ? currentDate : today);
		currentText = (!navigationAsDateFormat ? currentText :
			this.formatDate(currentText, gotoDate, this._getFormatConfig(inst)));

		controls = (!inst.inline ? "<button type='button' class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all' data-handler='hide' data-event='click'>" +
			this._get(inst, "closeText") + "</button>" : "");

		buttonPanel = (showButtonPanel) ? "<div class='ui-datepicker-buttonpane ui-widget-content'>" + (isRTL ? controls : "") +
			(this._isInRange(inst, gotoDate) ? "<button type='button' class='ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all' data-handler='today' data-event='click'" +
			">" + currentText + "</button>" : "") + (isRTL ? "" : controls) + "</div>" : "";

		firstDay = parseInt(this._get(inst, "firstDay"),10);
		firstDay = (isNaN(firstDay) ? 0 : firstDay);

		showWeek = this._get(inst, "showWeek");
		dayNames = this._get(inst, "dayNames");
		dayNamesMin = this._get(inst, "dayNamesMin");
		monthNames = this._get(inst, "monthNames");
		monthNamesShort = this._get(inst, "monthNamesShort");
		beforeShowDay = this._get(inst, "beforeShowDay");
		showOtherMonths = this._get(inst, "showOtherMonths");
		selectOtherMonths = this._get(inst, "selectOtherMonths");
		defaultDate = this._getDefaultDate(inst);
		html = "";
		dow;
		for (row = 0; row < numMonths[0]; row++) {
			group = "";
			this.maxRows = 4;
			for (col = 0; col < numMonths[1]; col++) {
				selectedDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, inst.selectedDay));
				cornerClass = " ui-corner-all";
				calender = "";
				if (isMultiMonth) {
					calender += "<div class='ui-datepicker-group";
					if (numMonths[1] > 1) {
						switch (col) {
							case 0: calender += " ui-datepicker-group-first";
								cornerClass = " ui-corner-" + (isRTL ? "right" : "left"); break;
							case numMonths[1]-1: calender += " ui-datepicker-group-last";
								cornerClass = " ui-corner-" + (isRTL ? "left" : "right"); break;
							default: calender += " ui-datepicker-group-middle"; cornerClass = ""; break;
						}
					}
					calender += "'>";
				}
				calender += "<div class='ui-datepicker-header ui-widget-header ui-helper-clearfix" + cornerClass + "'>" +
					(/all|left/.test(cornerClass) && row === 0 ? (isRTL ? next : prev) : "") +
					(/all|right/.test(cornerClass) && row === 0 ? (isRTL ? prev : next) : "") +
					this._generateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate,
					row > 0 || col > 0, monthNames, monthNamesShort) + // draw month headers
					"</div><table class='ui-datepicker-calendar'><thead>" +
					"<tr>";
				thead = (showWeek ? "<th class='ui-datepicker-week-col'>" + this._get(inst, "weekHeader") + "</th>" : "");
				for (dow = 0; dow < 7; dow++) { // days of the week
					day = (dow + firstDay) % 7;
					thead += "<th" + ((dow + firstDay + 6) % 7 >= 5 ? " class='ui-datepicker-week-end'" : "") + ">" +
						"<span title='" + dayNames[day] + "'>" + dayNamesMin[day] + "</span></th>";
				}
				calender += thead + "</tr></thead><tbody>";
				daysInMonth = this._getDaysInMonth(drawYear, drawMonth);
				if (drawYear === inst.selectedYear && drawMonth === inst.selectedMonth) {
					inst.selectedDay = Math.min(inst.selectedDay, daysInMonth);
				}
				leadDays = (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7;
				curRows = Math.ceil((leadDays + daysInMonth) / 7); // calculate the number of rows to generate
				numRows = (isMultiMonth ? this.maxRows > curRows ? this.maxRows : curRows : curRows); //If multiple months, use the higher number of rows (see #7043)
				this.maxRows = numRows;
				printDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1 - leadDays));
				for (dRow = 0; dRow < numRows; dRow++) { // create date picker rows
					calender += "<tr>";
					tbody = (!showWeek ? "" : "<td class='ui-datepicker-week-col'>" +
						this._get(inst, "calculateWeek")(printDate) + "</td>");
					for (dow = 0; dow < 7; dow++) { // create date picker days
						daySettings = (beforeShowDay ?
							beforeShowDay.apply((inst.input ? inst.input[0] : null), [printDate]) : [true, ""]);
						otherMonth = (printDate.getMonth() !== drawMonth);
						unselectable = (otherMonth && !selectOtherMonths) || !daySettings[0] ||
							(minDate && printDate < minDate) || (maxDate && printDate > maxDate);
						tbody += "<td class='" +
							((dow + firstDay + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + // highlight weekends
							(otherMonth ? " ui-datepicker-other-month" : "") + // highlight days from other months
							((printDate.getTime() === selectedDate.getTime() && drawMonth === inst.selectedMonth && inst._keyEvent) || // user pressed key
							(defaultDate.getTime() === printDate.getTime() && defaultDate.getTime() === selectedDate.getTime()) ?
							// or defaultDate is current printedDate and defaultDate is selectedDate
							" " + this._dayOverClass : "") + // highlight selected day
							(unselectable ? " " + this._unselectableClass + " ui-state-disabled": "") +  // highlight unselectable days
							(otherMonth && !showOtherMonths ? "" : " " + daySettings[1] + // highlight custom dates
							(printDate.getTime() === currentDate.getTime() ? " " + this._currentClass : "") + // highlight selected day
							(printDate.getTime() === today.getTime() ? " ui-datepicker-today" : "")) + "'" + // highlight today (if different)
							((!otherMonth || showOtherMonths) && daySettings[2] ? " title='" + daySettings[2].replace(/'/g, "&#39;") + "'" : "") + // cell title
							(unselectable ? "" : " data-handler='selectDay' data-event='click' data-month='" + printDate.getMonth() + "' data-year='" + printDate.getFullYear() + "'") + ">" + // actions
							(otherMonth && !showOtherMonths ? "&#xa0;" : // display for other months
							(unselectable ? "<span class='ui-state-default'>" + printDate.getDate() + "</span>" : "<a class='ui-state-default" +
							(printDate.getTime() === today.getTime() ? " ui-state-highlight" : "") +
							(printDate.getTime() === currentDate.getTime() ? " ui-state-active" : "") + // highlight selected day
							(otherMonth ? " ui-priority-secondary" : "") + // distinguish dates from other months
							"' href='#'>" + printDate.getDate() + "</a>")) + "</td>"; // display selectable date
						printDate.setDate(printDate.getDate() + 1);
						printDate = this._daylightSavingAdjust(printDate);
					}
					calender += tbody + "</tr>";
				}
				drawMonth++;
				if (drawMonth > 11) {
					drawMonth = 0;
					drawYear++;
				}
				calender += "</tbody></table>" + (isMultiMonth ? "</div>" +
							((numMonths[0] > 0 && col === numMonths[1]-1) ? "<div class='ui-datepicker-row-break'></div>" : "") : "");
				group += calender;
			}
			html += group;
		}
		html += buttonPanel;
		inst._keyEvent = false;
		return html;
	},

	/* Generate the month and year header. */
	_generateMonthYearHeader: function(inst, drawMonth, drawYear, minDate, maxDate,
			secondary, monthNames, monthNamesShort) {

		var inMinYear, inMaxYear, month, years, thisYear, determineYear, year, endYear,
			changeMonth = this._get(inst, "changeMonth"),
			changeYear = this._get(inst, "changeYear"),
			showMonthAfterYear = this._get(inst, "showMonthAfterYear"),
			html = "<div class='ui-datepicker-title'>",
			monthHtml = "";

		// month selection
		if (secondary || !changeMonth) {
			monthHtml += "<span class='ui-datepicker-month'>" + monthNames[drawMonth] + "</span>";
		} else {
			inMinYear = (minDate && minDate.getFullYear() === drawYear);
			inMaxYear = (maxDate && maxDate.getFullYear() === drawYear);
			monthHtml += "<select class='ui-datepicker-month' data-handler='selectMonth' data-event='change'>";
			for ( month = 0; month < 12; month++) {
				if ((!inMinYear || month >= minDate.getMonth()) && (!inMaxYear || month <= maxDate.getMonth())) {
					monthHtml += "<option value='" + month + "'" +
						(month === drawMonth ? " selected='selected'" : "") +
						">" + monthNamesShort[month] + "</option>";
				}
			}
			monthHtml += "</select>";
		}

		if (!showMonthAfterYear) {
			html += monthHtml + (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "");
		}

		// year selection
		if ( !inst.yearshtml ) {
			inst.yearshtml = "";
			if (secondary || !changeYear) {
				html += "<span class='ui-datepicker-year'>" + drawYear + "</span>";
			} else {
				// determine range of years to display
				years = this._get(inst, "yearRange").split(":");
				thisYear = new Date().getFullYear();
				determineYear = function(value) {
					var year = (value.match(/c[+\-].*/) ? drawYear + parseInt(value.substring(1), 10) :
						(value.match(/[+\-].*/) ? thisYear + parseInt(value, 10) :
						parseInt(value, 10)));
					return (isNaN(year) ? thisYear : year);
				};
				year = determineYear(years[0]);
				endYear = Math.max(year, determineYear(years[1] || ""));
				year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
				endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
				inst.yearshtml += "<select class='ui-datepicker-year' data-handler='selectYear' data-event='change'>";
				for (; year <= endYear; year++) {
					inst.yearshtml += "<option value='" + year + "'" +
						(year === drawYear ? " selected='selected'" : "") +
						">" + year + "</option>";
				}
				inst.yearshtml += "</select>";

				html += inst.yearshtml;
				inst.yearshtml = null;
			}
		}

		html += this._get(inst, "yearSuffix");
		if (showMonthAfterYear) {
			html += (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "") + monthHtml;
		}
		html += "</div>"; // Close datepicker_header
		return html;
	},

	/* Adjust one of the date sub-fields. */
	_adjustInstDate: function(inst, offset, period) {
		var year = inst.drawYear + (period === "Y" ? offset : 0),
			month = inst.drawMonth + (period === "M" ? offset : 0),
			day = Math.min(inst.selectedDay, this._getDaysInMonth(year, month)) + (period === "D" ? offset : 0),
			date = this._restrictMinMax(inst, this._daylightSavingAdjust(new Date(year, month, day)));

		inst.selectedDay = date.getDate();
		inst.drawMonth = inst.selectedMonth = date.getMonth();
		inst.drawYear = inst.selectedYear = date.getFullYear();
		if (period === "M" || period === "Y") {
			this._notifyChange(inst);
		}
	},

	/* Ensure a date is within any min/max bounds. */
	_restrictMinMax: function(inst, date) {
		var minDate = this._getMinMaxDate(inst, "min"),
			maxDate = this._getMinMaxDate(inst, "max"),
			newDate = (minDate && date < minDate ? minDate : date);
		return (maxDate && newDate > maxDate ? maxDate : newDate);
	},

	/* Notify change of month/year. */
	_notifyChange: function(inst) {
		var onChange = this._get(inst, "onChangeMonthYear");
		if (onChange) {
			onChange.apply((inst.input ? inst.input[0] : null),
				[inst.selectedYear, inst.selectedMonth + 1, inst]);
		}
	},

	/* Determine the number of months to show. */
	_getNumberOfMonths: function(inst) {
		var numMonths = this._get(inst, "numberOfMonths");
		return (numMonths == null ? [1, 1] : (typeof numMonths === "number" ? [1, numMonths] : numMonths));
	},

	/* Determine the current maximum date - ensure no time components are set. */
	_getMinMaxDate: function(inst, minMax) {
		return this._determineDate(inst, this._get(inst, minMax + "Date"), null);
	},

	/* Find the number of days in a given month. */
	_getDaysInMonth: function(year, month) {
		return 32 - this._daylightSavingAdjust(new Date(year, month, 32)).getDate();
	},

	/* Find the day of the week of the first of a month. */
	_getFirstDayOfMonth: function(year, month) {
		return new Date(year, month, 1).getDay();
	},

	/* Determines if we should allow a "next/prev" month display change. */
	_canAdjustMonth: function(inst, offset, curYear, curMonth) {
		var numMonths = this._getNumberOfMonths(inst),
			date = this._daylightSavingAdjust(new Date(curYear,
			curMonth + (offset < 0 ? offset : numMonths[0] * numMonths[1]), 1));

		if (offset < 0) {
			date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth()));
		}
		return this._isInRange(inst, date);
	},

	/* Is the given date in the accepted range? */
	_isInRange: function(inst, date) {
		var yearSplit, currentYear,
			minDate = this._getMinMaxDate(inst, "min"),
			maxDate = this._getMinMaxDate(inst, "max"),
			minYear = null,
			maxYear = null,
			years = this._get(inst, "yearRange");
			if (years){
				yearSplit = years.split(":");
				currentYear = new Date().getFullYear();
				minYear = parseInt(yearSplit[0], 10);
				maxYear = parseInt(yearSplit[1], 10);
				if ( yearSplit[0].match(/[+\-].*/) ) {
					minYear += currentYear;
				}
				if ( yearSplit[1].match(/[+\-].*/) ) {
					maxYear += currentYear;
				}
			}

		return ((!minDate || date.getTime() >= minDate.getTime()) &&
			(!maxDate || date.getTime() <= maxDate.getTime()) &&
			(!minYear || date.getFullYear() >= minYear) &&
			(!maxYear || date.getFullYear() <= maxYear));
	},

	/* Provide the configuration settings for formatting/parsing. */
	_getFormatConfig: function(inst) {
		var shortYearCutoff = this._get(inst, "shortYearCutoff");
		shortYearCutoff = (typeof shortYearCutoff !== "string" ? shortYearCutoff :
			new Date().getFullYear() % 100 + parseInt(shortYearCutoff, 10));
		return {shortYearCutoff: shortYearCutoff,
			dayNamesShort: this._get(inst, "dayNamesShort"), dayNames: this._get(inst, "dayNames"),
			monthNamesShort: this._get(inst, "monthNamesShort"), monthNames: this._get(inst, "monthNames")};
	},

	/* Format the given date for display. */
	_formatDate: function(inst, day, month, year) {
		if (!day) {
			inst.currentDay = inst.selectedDay;
			inst.currentMonth = inst.selectedMonth;
			inst.currentYear = inst.selectedYear;
		}
		var date = (day ? (typeof day === "object" ? day :
			this._daylightSavingAdjust(new Date(year, month, day))) :
			this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
		return this.formatDate(this._get(inst, "dateFormat"), date, this._getFormatConfig(inst));
	}
});

/*
 * Bind hover events for datepicker elements.
 * Done via delegate so the binding only occurs once in the lifetime of the parent div.
 * Global instActive, set by _updateDatepicker allows the handlers to find their way back to the active picker.
 */
function bindHover(dpDiv) {
	var selector = "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
	return dpDiv.delegate(selector, "mouseout", function() {
			$(this).removeClass("ui-state-hover");
			if (this.className.indexOf("ui-datepicker-prev") !== -1) {
				$(this).removeClass("ui-datepicker-prev-hover");
			}
			if (this.className.indexOf("ui-datepicker-next") !== -1) {
				$(this).removeClass("ui-datepicker-next-hover");
			}
		})
		.delegate(selector, "mouseover", function(){
			if (!$.datepicker._isDisabledDatepicker( instActive.inline ? dpDiv.parent()[0] : instActive.input[0])) {
				$(this).parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover");
				$(this).addClass("ui-state-hover");
				if (this.className.indexOf("ui-datepicker-prev") !== -1) {
					$(this).addClass("ui-datepicker-prev-hover");
				}
				if (this.className.indexOf("ui-datepicker-next") !== -1) {
					$(this).addClass("ui-datepicker-next-hover");
				}
			}
		});
}

/* jQuery extend now ignores nulls! */
function extendRemove(target, props) {
	$.extend(target, props);
	for (var name in props) {
		if (props[name] == null) {
			target[name] = props[name];
		}
	}
	return target;
}

/* Invoke the datepicker functionality.
   @param  options  string - a command, optionally followed by additional parameters or
					Object - settings for attaching new datepicker functionality
   @return  jQuery object */
$.fn.datepicker = function(options){

	/* Verify an empty collection wasn't passed - Fixes #6976 */
	if ( !this.length ) {
		return this;
	}

	/* Initialise the date picker. */
	if (!$.datepicker.initialized) {
		$(document).mousedown($.datepicker._checkExternalClick);
		$.datepicker.initialized = true;
	}

	/* Append datepicker main container to body if not exist. */
	if ($("#"+$.datepicker._mainDivId).length === 0) {
		$("body").append($.datepicker.dpDiv);
	}

	var otherArgs = Array.prototype.slice.call(arguments, 1);
	if (typeof options === "string" && (options === "isDisabled" || options === "getDate" || options === "widget")) {
		return $.datepicker["_" + options + "Datepicker"].
			apply($.datepicker, [this[0]].concat(otherArgs));
	}
	if (options === "option" && arguments.length === 2 && typeof arguments[1] === "string") {
		return $.datepicker["_" + options + "Datepicker"].
			apply($.datepicker, [this[0]].concat(otherArgs));
	}
	return this.each(function() {
		typeof options === "string" ?
			$.datepicker["_" + options + "Datepicker"].
				apply($.datepicker, [this].concat(otherArgs)) :
			$.datepicker._attachDatepicker(this, options);
	});
};

$.datepicker = new Datepicker(); // singleton instance
$.datepicker.initialized = false;
$.datepicker.uuid = new Date().getTime();
$.datepicker.version = "1.10.4";

})(jQuery);
(function( $, undefined ) {

var sizeRelatedOptions = {
		buttons: true,
		height: true,
		maxHeight: true,
		maxWidth: true,
		minHeight: true,
		minWidth: true,
		width: true
	},
	resizableRelatedOptions = {
		maxHeight: true,
		maxWidth: true,
		minHeight: true,
		minWidth: true
	};

$.widget( "ui.dialog", {
	version: "1.10.4",
	options: {
		appendTo: "body",
		autoOpen: true,
		buttons: [],
		closeOnEscape: true,
		closeText: "close",
		dialogClass: "",
		draggable: true,
		hide: null,
		height: "auto",
		maxHeight: null,
		maxWidth: null,
		minHeight: 150,
		minWidth: 150,
		modal: false,
		position: {
			my: "center",
			at: "center",
			of: window,
			collision: "fit",
			// Ensure the titlebar is always visible
			using: function( pos ) {
				var topOffset = $( this ).css( pos ).offset().top;
				if ( topOffset < 0 ) {
					$( this ).css( "top", pos.top - topOffset );
				}
			}
		},
		resizable: true,
		show: null,
		title: null,
		width: 300,

		// callbacks
		beforeClose: null,
		close: null,
		drag: null,
		dragStart: null,
		dragStop: null,
		focus: null,
		open: null,
		resize: null,
		resizeStart: null,
		resizeStop: null
	},

	_create: function() {
		this.originalCss = {
			display: this.element[0].style.display,
			width: this.element[0].style.width,
			minHeight: this.element[0].style.minHeight,
			maxHeight: this.element[0].style.maxHeight,
			height: this.element[0].style.height
		};
		this.originalPosition = {
			parent: this.element.parent(),
			index: this.element.parent().children().index( this.element )
		};
		this.originalTitle = this.element.attr("title");
		this.options.title = this.options.title || this.originalTitle;

		this._createWrapper();

		this.element
			.show()
			.removeAttr("title")
			.addClass("ui-dialog-content ui-widget-content")
			.appendTo( this.uiDialog );

		this._createTitlebar();
		this._createButtonPane();

		if ( this.options.draggable && $.fn.draggable ) {
			this._makeDraggable();
		}
		if ( this.options.resizable && $.fn.resizable ) {
			this._makeResizable();
		}

		this._isOpen = false;
	},

	_init: function() {
		if ( this.options.autoOpen ) {
			this.open();
		}
	},

	_appendTo: function() {
		var element = this.options.appendTo;
		if ( element && (element.jquery || element.nodeType) ) {
			return $( element );
		}
		return this.document.find( element || "body" ).eq( 0 );
	},

	_destroy: function() {
		var next,
			originalPosition = this.originalPosition;

		this._destroyOverlay();

		this.element
			.removeUniqueId()
			.removeClass("ui-dialog-content ui-widget-content")
			.css( this.originalCss )
			// Without detaching first, the following becomes really slow
			.detach();

		this.uiDialog.stop( true, true ).remove();

		if ( this.originalTitle ) {
			this.element.attr( "title", this.originalTitle );
		}

		next = originalPosition.parent.children().eq( originalPosition.index );
		// Don't try to place the dialog next to itself (#8613)
		if ( next.length && next[0] !== this.element[0] ) {
			next.before( this.element );
		} else {
			originalPosition.parent.append( this.element );
		}
	},

	widget: function() {
		return this.uiDialog;
	},

	disable: $.noop,
	enable: $.noop,

	close: function( event ) {
		var activeElement,
			that = this;

		if ( !this._isOpen || this._trigger( "beforeClose", event ) === false ) {
			return;
		}

		this._isOpen = false;
		this._destroyOverlay();

		if ( !this.opener.filter(":focusable").focus().length ) {

			// support: IE9
			// IE9 throws an "Unspecified error" accessing document.activeElement from an <iframe>
			try {
				activeElement = this.document[ 0 ].activeElement;

				// Support: IE9, IE10
				// If the <body> is blurred, IE will switch windows, see #4520
				if ( activeElement && activeElement.nodeName.toLowerCase() !== "body" ) {

					// Hiding a focused element doesn't trigger blur in WebKit
					// so in case we have nothing to focus on, explicitly blur the active element
					// https://bugs.webkit.org/show_bug.cgi?id=47182
					$( activeElement ).blur();
				}
			} catch ( error ) {}
		}

		this._hide( this.uiDialog, this.options.hide, function() {
			that._trigger( "close", event );
		});
	},

	isOpen: function() {
		return this._isOpen;
	},

	moveToTop: function() {
		this._moveToTop();
	},

	_moveToTop: function( event, silent ) {
		var moved = !!this.uiDialog.nextAll(":visible").insertBefore( this.uiDialog ).length;
		if ( moved && !silent ) {
			this._trigger( "focus", event );
		}
		return moved;
	},

	open: function() {
		var that = this;
		if ( this._isOpen ) {
			if ( this._moveToTop() ) {
				this._focusTabbable();
			}
			return;
		}

		this._isOpen = true;
		this.opener = $( this.document[0].activeElement );

		this._size();
		this._position();
		this._createOverlay();
		this._moveToTop( null, true );
		this._show( this.uiDialog, this.options.show, function() {
			that._focusTabbable();
			that._trigger("focus");
		});

		this._trigger("open");
	},

	_focusTabbable: function() {
		// Set focus to the first match:
		// 1. First element inside the dialog matching [autofocus]
		// 2. Tabbable element inside the content element
		// 3. Tabbable element inside the buttonpane
		// 4. The close button
		// 5. The dialog itself
		var hasFocus = this.element.find("[autofocus]");
		if ( !hasFocus.length ) {
			hasFocus = this.element.find(":tabbable");
		}
		if ( !hasFocus.length ) {
			hasFocus = this.uiDialogButtonPane.find(":tabbable");
		}
		if ( !hasFocus.length ) {
			hasFocus = this.uiDialogTitlebarClose.filter(":tabbable");
		}
		if ( !hasFocus.length ) {
			hasFocus = this.uiDialog;
		}
		hasFocus.eq( 0 ).focus();
	},

	_keepFocus: function( event ) {
		function checkFocus() {
			var activeElement = this.document[0].activeElement,
				isActive = this.uiDialog[0] === activeElement ||
					$.contains( this.uiDialog[0], activeElement );
			if ( !isActive ) {
				this._focusTabbable();
			}
		}
		event.preventDefault();
		checkFocus.call( this );
		// support: IE
		// IE <= 8 doesn't prevent moving focus even with event.preventDefault()
		// so we check again later
		this._delay( checkFocus );
	},

	_createWrapper: function() {
		this.uiDialog = $("<div>")
			.addClass( "ui-dialog ui-widget ui-widget-content ui-corner-all ui-front " +
				this.options.dialogClass )
			.hide()
			.attr({
				// Setting tabIndex makes the div focusable
				tabIndex: -1,
				role: "dialog"
			})
			.appendTo( this._appendTo() );

		this._on( this.uiDialog, {
			keydown: function( event ) {
				if ( this.options.closeOnEscape && !event.isDefaultPrevented() && event.keyCode &&
						event.keyCode === $.ui.keyCode.ESCAPE ) {
					event.preventDefault();
					this.close( event );
					return;
				}

				// prevent tabbing out of dialogs
				if ( event.keyCode !== $.ui.keyCode.TAB ) {
					return;
				}
				var tabbables = this.uiDialog.find(":tabbable"),
					first = tabbables.filter(":first"),
					last  = tabbables.filter(":last");

				if ( ( event.target === last[0] || event.target === this.uiDialog[0] ) && !event.shiftKey ) {
					first.focus( 1 );
					event.preventDefault();
				} else if ( ( event.target === first[0] || event.target === this.uiDialog[0] ) && event.shiftKey ) {
					last.focus( 1 );
					event.preventDefault();
				}
			},
			mousedown: function( event ) {
				if ( this._moveToTop( event ) ) {
					this._focusTabbable();
				}
			}
		});

		// We assume that any existing aria-describedby attribute means
		// that the dialog content is marked up properly
		// otherwise we brute force the content as the description
		if ( !this.element.find("[aria-describedby]").length ) {
			this.uiDialog.attr({
				"aria-describedby": this.element.uniqueId().attr("id")
			});
		}
	},

	_createTitlebar: function() {
		var uiDialogTitle;

		this.uiDialogTitlebar = $("<div>")
			.addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix")
			.prependTo( this.uiDialog );
		this._on( this.uiDialogTitlebar, {
			mousedown: function( event ) {
				// Don't prevent click on close button (#8838)
				// Focusing a dialog that is partially scrolled out of view
				// causes the browser to scroll it into view, preventing the click event
				if ( !$( event.target ).closest(".ui-dialog-titlebar-close") ) {
					// Dialog isn't getting focus when dragging (#8063)
					this.uiDialog.focus();
				}
			}
		});

		// support: IE
		// Use type="button" to prevent enter keypresses in textboxes from closing the
		// dialog in IE (#9312)
		this.uiDialogTitlebarClose = $( "<button type='button'></button>" )
			.button({
				label: this.options.closeText,
				icons: {
					primary: "ui-icon-closethick"
				},
				text: false
			})
			.addClass("ui-dialog-titlebar-close")
			.appendTo( this.uiDialogTitlebar );
		this._on( this.uiDialogTitlebarClose, {
			click: function( event ) {
				event.preventDefault();
				this.close( event );
			}
		});

		uiDialogTitle = $("<span>")
			.uniqueId()
			.addClass("ui-dialog-title")
			.prependTo( this.uiDialogTitlebar );
		this._title( uiDialogTitle );

		this.uiDialog.attr({
			"aria-labelledby": uiDialogTitle.attr("id")
		});
	},

	_title: function( title ) {
		if ( !this.options.title ) {
			title.html("&#160;");
		}
		title.text( this.options.title );
	},

	_createButtonPane: function() {
		this.uiDialogButtonPane = $("<div>")
			.addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix");

		this.uiButtonSet = $("<div>")
			.addClass("ui-dialog-buttonset")
			.appendTo( this.uiDialogButtonPane );

		this._createButtons();
	},

	_createButtons: function() {
		var that = this,
			buttons = this.options.buttons;

		// if we already have a button pane, remove it
		this.uiDialogButtonPane.remove();
		this.uiButtonSet.empty();

		if ( $.isEmptyObject( buttons ) || ($.isArray( buttons ) && !buttons.length) ) {
			this.uiDialog.removeClass("ui-dialog-buttons");
			return;
		}

		$.each( buttons, function( name, props ) {
			var click, buttonOptions;
			props = $.isFunction( props ) ?
				{ click: props, text: name } :
				props;
			// Default to a non-submitting button
			props = $.extend( { type: "button" }, props );
			// Change the context for the click callback to be the main element
			click = props.click;
			props.click = function() {
				click.apply( that.element[0], arguments );
			};
			buttonOptions = {
				icons: props.icons,
				text: props.showText
			};
			delete props.icons;
			delete props.showText;
			$( "<button></button>", props )
				.button( buttonOptions )
				.appendTo( that.uiButtonSet );
		});
		this.uiDialog.addClass("ui-dialog-buttons");
		this.uiDialogButtonPane.appendTo( this.uiDialog );
	},

	_makeDraggable: function() {
		var that = this,
			options = this.options;

		function filteredUi( ui ) {
			return {
				position: ui.position,
				offset: ui.offset
			};
		}

		this.uiDialog.draggable({
			cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
			handle: ".ui-dialog-titlebar",
			containment: "document",
			start: function( event, ui ) {
				$( this ).addClass("ui-dialog-dragging");
				that._blockFrames();
				that._trigger( "dragStart", event, filteredUi( ui ) );
			},
			drag: function( event, ui ) {
				that._trigger( "drag", event, filteredUi( ui ) );
			},
			stop: function( event, ui ) {
				options.position = [
					ui.position.left - that.document.scrollLeft(),
					ui.position.top - that.document.scrollTop()
				];
				$( this ).removeClass("ui-dialog-dragging");
				that._unblockFrames();
				that._trigger( "dragStop", event, filteredUi( ui ) );
			}
		});
	},

	_makeResizable: function() {
		var that = this,
			options = this.options,
			handles = options.resizable,
			// .ui-resizable has position: relative defined in the stylesheet
			// but dialogs have to use absolute or fixed positioning
			position = this.uiDialog.css("position"),
			resizeHandles = typeof handles === "string" ?
				handles	:
				"n,e,s,w,se,sw,ne,nw";

		function filteredUi( ui ) {
			return {
				originalPosition: ui.originalPosition,
				originalSize: ui.originalSize,
				position: ui.position,
				size: ui.size
			};
		}

		this.uiDialog.resizable({
			cancel: ".ui-dialog-content",
			containment: "document",
			alsoResize: this.element,
			maxWidth: options.maxWidth,
			maxHeight: options.maxHeight,
			minWidth: options.minWidth,
			minHeight: this._minHeight(),
			handles: resizeHandles,
			start: function( event, ui ) {
				$( this ).addClass("ui-dialog-resizing");
				that._blockFrames();
				that._trigger( "resizeStart", event, filteredUi( ui ) );
			},
			resize: function( event, ui ) {
				that._trigger( "resize", event, filteredUi( ui ) );
			},
			stop: function( event, ui ) {
				options.height = $( this ).height();
				options.width = $( this ).width();
				$( this ).removeClass("ui-dialog-resizing");
				that._unblockFrames();
				that._trigger( "resizeStop", event, filteredUi( ui ) );
			}
		})
		.css( "position", position );
	},

	_minHeight: function() {
		var options = this.options;

		return options.height === "auto" ?
			options.minHeight :
			Math.min( options.minHeight, options.height );
	},

	_position: function() {
		// Need to show the dialog to get the actual offset in the position plugin
		var isVisible = this.uiDialog.is(":visible");
		if ( !isVisible ) {
			this.uiDialog.show();
		}
		this.uiDialog.position( this.options.position );
		if ( !isVisible ) {
			this.uiDialog.hide();
		}
	},

	_setOptions: function( options ) {
		var that = this,
			resize = false,
			resizableOptions = {};

		$.each( options, function( key, value ) {
			that._setOption( key, value );

			if ( key in sizeRelatedOptions ) {
				resize = true;
			}
			if ( key in resizableRelatedOptions ) {
				resizableOptions[ key ] = value;
			}
		});

		if ( resize ) {
			this._size();
			this._position();
		}
		if ( this.uiDialog.is(":data(ui-resizable)") ) {
			this.uiDialog.resizable( "option", resizableOptions );
		}
	},

	_setOption: function( key, value ) {
		var isDraggable, isResizable,
			uiDialog = this.uiDialog;

		if ( key === "dialogClass" ) {
			uiDialog
				.removeClass( this.options.dialogClass )
				.addClass( value );
		}

		if ( key === "disabled" ) {
			return;
		}

		this._super( key, value );

		if ( key === "appendTo" ) {
			this.uiDialog.appendTo( this._appendTo() );
		}

		if ( key === "buttons" ) {
			this._createButtons();
		}

		if ( key === "closeText" ) {
			this.uiDialogTitlebarClose.button({
				// Ensure that we always pass a string
				label: "" + value
			});
		}

		if ( key === "draggable" ) {
			isDraggable = uiDialog.is(":data(ui-draggable)");
			if ( isDraggable && !value ) {
				uiDialog.draggable("destroy");
			}

			if ( !isDraggable && value ) {
				this._makeDraggable();
			}
		}

		if ( key === "position" ) {
			this._position();
		}

		if ( key === "resizable" ) {
			// currently resizable, becoming non-resizable
			isResizable = uiDialog.is(":data(ui-resizable)");
			if ( isResizable && !value ) {
				uiDialog.resizable("destroy");
			}

			// currently resizable, changing handles
			if ( isResizable && typeof value === "string" ) {
				uiDialog.resizable( "option", "handles", value );
			}

			// currently non-resizable, becoming resizable
			if ( !isResizable && value !== false ) {
				this._makeResizable();
			}
		}

		if ( key === "title" ) {
			this._title( this.uiDialogTitlebar.find(".ui-dialog-title") );
		}
	},

	_size: function() {
		// If the user has resized the dialog, the .ui-dialog and .ui-dialog-content
		// divs will both have width and height set, so we need to reset them
		var nonContentHeight, minContentHeight, maxContentHeight,
			options = this.options;

		// Reset content sizing
		this.element.show().css({
			width: "auto",
			minHeight: 0,
			maxHeight: "none",
			height: 0
		});

		if ( options.minWidth > options.width ) {
			options.width = options.minWidth;
		}

		// reset wrapper sizing
		// determine the height of all the non-content elements
		nonContentHeight = this.uiDialog.css({
				height: "auto",
				width: options.width
			})
			.outerHeight();
		minContentHeight = Math.max( 0, options.minHeight - nonContentHeight );
		maxContentHeight = typeof options.maxHeight === "number" ?
			Math.max( 0, options.maxHeight - nonContentHeight ) :
			"none";

		if ( options.height === "auto" ) {
			this.element.css({
				minHeight: minContentHeight,
				maxHeight: maxContentHeight,
				height: "auto"
			});
		} else {
			this.element.height( Math.max( 0, options.height - nonContentHeight ) );
		}

		if (this.uiDialog.is(":data(ui-resizable)") ) {
			this.uiDialog.resizable( "option", "minHeight", this._minHeight() );
		}
	},

	_blockFrames: function() {
		this.iframeBlocks = this.document.find( "iframe" ).map(function() {
			var iframe = $( this );

			return $( "<div>" )
				.css({
					position: "absolute",
					width: iframe.outerWidth(),
					height: iframe.outerHeight()
				})
				.appendTo( iframe.parent() )
				.offset( iframe.offset() )[0];
		});
	},

	_unblockFrames: function() {
		if ( this.iframeBlocks ) {
			this.iframeBlocks.remove();
			delete this.iframeBlocks;
		}
	},

	_allowInteraction: function( event ) {
		if ( $( event.target ).closest(".ui-dialog").length ) {
			return true;
		}

		// TODO: Remove hack when datepicker implements
		// the .ui-front logic (#8989)
		return !!$( event.target ).closest(".ui-datepicker").length;
	},

	_createOverlay: function() {
		if ( !this.options.modal ) {
			return;
		}

		var that = this,
			widgetFullName = this.widgetFullName;
		if ( !$.ui.dialog.overlayInstances ) {
			// Prevent use of anchors and inputs.
			// We use a delay in case the overlay is created from an
			// event that we're going to be cancelling. (#2804)
			this._delay(function() {
				// Handle .dialog().dialog("close") (#4065)
				if ( $.ui.dialog.overlayInstances ) {
					this.document.bind( "focusin.dialog", function( event ) {
						if ( !that._allowInteraction( event ) ) {
							event.preventDefault();
							$(".ui-dialog:visible:last .ui-dialog-content")
								.data( widgetFullName )._focusTabbable();
						}
					});
				}
			});
		}

		this.overlay = $("<div>")
			.addClass("ui-widget-overlay ui-front")
			.appendTo( this._appendTo() );
		this._on( this.overlay, {
			mousedown: "_keepFocus"
		});
		$.ui.dialog.overlayInstances++;
	},

	_destroyOverlay: function() {
		if ( !this.options.modal ) {
			return;
		}

		if ( this.overlay ) {
			$.ui.dialog.overlayInstances--;

			if ( !$.ui.dialog.overlayInstances ) {
				this.document.unbind( "focusin.dialog" );
			}
			this.overlay.remove();
			this.overlay = null;
		}
	}
});

$.ui.dialog.overlayInstances = 0;

// DEPRECATED
if ( $.uiBackCompat !== false ) {
	// position option with array notation
	// just override with old implementation
	$.widget( "ui.dialog", $.ui.dialog, {
		_position: function() {
			var position = this.options.position,
				myAt = [],
				offset = [ 0, 0 ],
				isVisible;

			if ( position ) {
				if ( typeof position === "string" || (typeof position === "object" && "0" in position ) ) {
					myAt = position.split ? position.split(" ") : [ position[0], position[1] ];
					if ( myAt.length === 1 ) {
						myAt[1] = myAt[0];
					}

					$.each( [ "left", "top" ], function( i, offsetPosition ) {
						if ( +myAt[ i ] === myAt[ i ] ) {
							offset[ i ] = myAt[ i ];
							myAt[ i ] = offsetPosition;
						}
					});

					position = {
						my: myAt[0] + (offset[0] < 0 ? offset[0] : "+" + offset[0]) + " " +
							myAt[1] + (offset[1] < 0 ? offset[1] : "+" + offset[1]),
						at: myAt.join(" ")
					};
				}

				position = $.extend( {}, $.ui.dialog.prototype.options.position, position );
			} else {
				position = $.ui.dialog.prototype.options.position;
			}

			// need to show the dialog to get the actual offset in the position plugin
			isVisible = this.uiDialog.is(":visible");
			if ( !isVisible ) {
				this.uiDialog.show();
			}
			this.uiDialog.position( position );
			if ( !isVisible ) {
				this.uiDialog.hide();
			}
		}
	});
}

}( jQuery ) );
(function( $, undefined ) {

$.widget("ui.draggable", $.ui.mouse, {
	version: "1.10.4",
	widgetEventPrefix: "drag",
	options: {
		addClasses: true,
		appendTo: "parent",
		axis: false,
		connectToSortable: false,
		containment: false,
		cursor: "auto",
		cursorAt: false,
		grid: false,
		handle: false,
		helper: "original",
		iframeFix: false,
		opacity: false,
		refreshPositions: false,
		revert: false,
		revertDuration: 500,
		scope: "default",
		scroll: true,
		scrollSensitivity: 20,
		scrollSpeed: 20,
		snap: false,
		snapMode: "both",
		snapTolerance: 20,
		stack: false,
		zIndex: false,

		// callbacks
		drag: null,
		start: null,
		stop: null
	},
	_create: function() {

		if (this.options.helper === "original" && !(/^(?:r|a|f)/).test(this.element.css("position"))) {
			this.element[0].style.position = "relative";
		}
		if (this.options.addClasses){
			this.element.addClass("ui-draggable");
		}
		if (this.options.disabled){
			this.element.addClass("ui-draggable-disabled");
		}

		this._mouseInit();

	},

	_destroy: function() {
		this.element.removeClass( "ui-draggable ui-draggable-dragging ui-draggable-disabled" );
		this._mouseDestroy();
	},

	_mouseCapture: function(event) {

		var o = this.options;

		// among others, prevent a drag on a resizable-handle
		if (this.helper || o.disabled || $(event.target).closest(".ui-resizable-handle").length > 0) {
			return false;
		}

		//Quit if we're not on a valid handle
		this.handle = this._getHandle(event);
		if (!this.handle) {
			return false;
		}

		$(o.iframeFix === true ? "iframe" : o.iframeFix).each(function() {
			$("<div class='ui-draggable-iframeFix' style='background: #fff;'></div>")
			.css({
				width: this.offsetWidth+"px", height: this.offsetHeight+"px",
				position: "absolute", opacity: "0.001", zIndex: 1000
			})
			.css($(this).offset())
			.appendTo("body");
		});

		return true;

	},

	_mouseStart: function(event) {

		var o = this.options;

		//Create and append the visible helper
		this.helper = this._createHelper(event);

		this.helper.addClass("ui-draggable-dragging");

		//Cache the helper size
		this._cacheHelperProportions();

		//If ddmanager is used for droppables, set the global draggable
		if($.ui.ddmanager) {
			$.ui.ddmanager.current = this;
		}

		/*
		 * - Position generation -
		 * This block generates everything position related - it's the core of draggables.
		 */

		//Cache the margins of the original element
		this._cacheMargins();

		//Store the helper's css position
		this.cssPosition = this.helper.css( "position" );
		this.scrollParent = this.helper.scrollParent();
		this.offsetParent = this.helper.offsetParent();
		this.offsetParentCssPosition = this.offsetParent.css( "position" );

		//The element's absolute position on the page minus margins
		this.offset = this.positionAbs = this.element.offset();
		this.offset = {
			top: this.offset.top - this.margins.top,
			left: this.offset.left - this.margins.left
		};

		//Reset scroll cache
		this.offset.scroll = false;

		$.extend(this.offset, {
			click: { //Where the click happened, relative to the element
				left: event.pageX - this.offset.left,
				top: event.pageY - this.offset.top
			},
			parent: this._getParentOffset(),
			relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
		});

		//Generate the original position
		this.originalPosition = this.position = this._generatePosition(event);
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;

		//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
		(o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));

		//Set a containment if given in the options
		this._setContainment();

		//Trigger event + callbacks
		if(this._trigger("start", event) === false) {
			this._clear();
			return false;
		}

		//Recache the helper size
		this._cacheHelperProportions();

		//Prepare the droppable offsets
		if ($.ui.ddmanager && !o.dropBehaviour) {
			$.ui.ddmanager.prepareOffsets(this, event);
		}


		this._mouseDrag(event, true); //Execute the drag once - this causes the helper not to be visible before getting its correct position

		//If the ddmanager is used for droppables, inform the manager that dragging has started (see #5003)
		if ( $.ui.ddmanager ) {
			$.ui.ddmanager.dragStart(this, event);
		}

		return true;
	},

	_mouseDrag: function(event, noPropagation) {
		// reset any necessary cached properties (see #5009)
		if ( this.offsetParentCssPosition === "fixed" ) {
			this.offset.parent = this._getParentOffset();
		}

		//Compute the helpers position
		this.position = this._generatePosition(event);
		this.positionAbs = this._convertPositionTo("absolute");

		//Call plugins and callbacks and use the resulting position if something is returned
		if (!noPropagation) {
			var ui = this._uiHash();
			if(this._trigger("drag", event, ui) === false) {
				this._mouseUp({});
				return false;
			}
			this.position = ui.position;
		}

		if(!this.options.axis || this.options.axis !== "y") {
			this.helper[0].style.left = this.position.left+"px";
		}
		if(!this.options.axis || this.options.axis !== "x") {
			this.helper[0].style.top = this.position.top+"px";
		}
		if($.ui.ddmanager) {
			$.ui.ddmanager.drag(this, event);
		}

		return false;
	},

	_mouseStop: function(event) {

		//If we are using droppables, inform the manager about the drop
		var that = this,
			dropped = false;
		if ($.ui.ddmanager && !this.options.dropBehaviour) {
			dropped = $.ui.ddmanager.drop(this, event);
		}

		//if a drop comes from outside (a sortable)
		if(this.dropped) {
			dropped = this.dropped;
			this.dropped = false;
		}

		//if the original element is no longer in the DOM don't bother to continue (see #8269)
		if ( this.options.helper === "original" && !$.contains( this.element[ 0 ].ownerDocument, this.element[ 0 ] ) ) {
			return false;
		}

		if((this.options.revert === "invalid" && !dropped) || (this.options.revert === "valid" && dropped) || this.options.revert === true || ($.isFunction(this.options.revert) && this.options.revert.call(this.element, dropped))) {
			$(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
				if(that._trigger("stop", event) !== false) {
					that._clear();
				}
			});
		} else {
			if(this._trigger("stop", event) !== false) {
				this._clear();
			}
		}

		return false;
	},

	_mouseUp: function(event) {
		//Remove frame helpers
		$("div.ui-draggable-iframeFix").each(function() {
			this.parentNode.removeChild(this);
		});

		//If the ddmanager is used for droppables, inform the manager that dragging has stopped (see #5003)
		if( $.ui.ddmanager ) {
			$.ui.ddmanager.dragStop(this, event);
		}

		return $.ui.mouse.prototype._mouseUp.call(this, event);
	},

	cancel: function() {

		if(this.helper.is(".ui-draggable-dragging")) {
			this._mouseUp({});
		} else {
			this._clear();
		}

		return this;

	},

	_getHandle: function(event) {
		return this.options.handle ?
			!!$( event.target ).closest( this.element.find( this.options.handle ) ).length :
			true;
	},

	_createHelper: function(event) {

		var o = this.options,
			helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event])) : (o.helper === "clone" ? this.element.clone().removeAttr("id") : this.element);

		if(!helper.parents("body").length) {
			helper.appendTo((o.appendTo === "parent" ? this.element[0].parentNode : o.appendTo));
		}

		if(helper[0] !== this.element[0] && !(/(fixed|absolute)/).test(helper.css("position"))) {
			helper.css("position", "absolute");
		}

		return helper;

	},

	_adjustOffsetFromHelper: function(obj) {
		if (typeof obj === "string") {
			obj = obj.split(" ");
		}
		if ($.isArray(obj)) {
			obj = {left: +obj[0], top: +obj[1] || 0};
		}
		if ("left" in obj) {
			this.offset.click.left = obj.left + this.margins.left;
		}
		if ("right" in obj) {
			this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
		}
		if ("top" in obj) {
			this.offset.click.top = obj.top + this.margins.top;
		}
		if ("bottom" in obj) {
			this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
		}
	},

	_getParentOffset: function() {

		//Get the offsetParent and cache its position
		var po = this.offsetParent.offset();

		// This is a special case where we need to modify a offset calculated on start, since the following happened:
		// 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
		// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
		//    the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
		if(this.cssPosition === "absolute" && this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) {
			po.left += this.scrollParent.scrollLeft();
			po.top += this.scrollParent.scrollTop();
		}

		//This needs to be actually done for all browsers, since pageX/pageY includes this information
		//Ugly IE fix
		if((this.offsetParent[0] === document.body) ||
			(this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() === "html" && $.ui.ie)) {
			po = { top: 0, left: 0 };
		}

		return {
			top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"),10) || 0),
			left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"),10) || 0)
		};

	},

	_getRelativeOffset: function() {

		if(this.cssPosition === "relative") {
			var p = this.element.position();
			return {
				top: p.top - (parseInt(this.helper.css("top"),10) || 0) + this.scrollParent.scrollTop(),
				left: p.left - (parseInt(this.helper.css("left"),10) || 0) + this.scrollParent.scrollLeft()
			};
		} else {
			return { top: 0, left: 0 };
		}

	},

	_cacheMargins: function() {
		this.margins = {
			left: (parseInt(this.element.css("marginLeft"),10) || 0),
			top: (parseInt(this.element.css("marginTop"),10) || 0),
			right: (parseInt(this.element.css("marginRight"),10) || 0),
			bottom: (parseInt(this.element.css("marginBottom"),10) || 0)
		};
	},

	_cacheHelperProportions: function() {
		this.helperProportions = {
			width: this.helper.outerWidth(),
			height: this.helper.outerHeight()
		};
	},

	_setContainment: function() {

		var over, c, ce,
			o = this.options;

		if ( !o.containment ) {
			this.containment = null;
			return;
		}

		if ( o.containment === "window" ) {
			this.containment = [
				$( window ).scrollLeft() - this.offset.relative.left - this.offset.parent.left,
				$( window ).scrollTop() - this.offset.relative.top - this.offset.parent.top,
				$( window ).scrollLeft() + $( window ).width() - this.helperProportions.width - this.margins.left,
				$( window ).scrollTop() + ( $( window ).height() || document.body.parentNode.scrollHeight ) - this.helperProportions.height - this.margins.top
			];
			return;
		}

		if ( o.containment === "document") {
			this.containment = [
				0,
				0,
				$( document ).width() - this.helperProportions.width - this.margins.left,
				( $( document ).height() || document.body.parentNode.scrollHeight ) - this.helperProportions.height - this.margins.top
			];
			return;
		}

		if ( o.containment.constructor === Array ) {
			this.containment = o.containment;
			return;
		}

		if ( o.containment === "parent" ) {
			o.containment = this.helper[ 0 ].parentNode;
		}

		c = $( o.containment );
		ce = c[ 0 ];

		if( !ce ) {
			return;
		}

		over = c.css( "overflow" ) !== "hidden";

		this.containment = [
			( parseInt( c.css( "borderLeftWidth" ), 10 ) || 0 ) + ( parseInt( c.css( "paddingLeft" ), 10 ) || 0 ),
			( parseInt( c.css( "borderTopWidth" ), 10 ) || 0 ) + ( parseInt( c.css( "paddingTop" ), 10 ) || 0 ) ,
			( over ? Math.max( ce.scrollWidth, ce.offsetWidth ) : ce.offsetWidth ) - ( parseInt( c.css( "borderRightWidth" ), 10 ) || 0 ) - ( parseInt( c.css( "paddingRight" ), 10 ) || 0 ) - this.helperProportions.width - this.margins.left - this.margins.right,
			( over ? Math.max( ce.scrollHeight, ce.offsetHeight ) : ce.offsetHeight ) - ( parseInt( c.css( "borderBottomWidth" ), 10 ) || 0 ) - ( parseInt( c.css( "paddingBottom" ), 10 ) || 0 ) - this.helperProportions.height - this.margins.top  - this.margins.bottom
		];
		this.relative_container = c;
	},

	_convertPositionTo: function(d, pos) {

		if(!pos) {
			pos = this.position;
		}

		var mod = d === "absolute" ? 1 : -1,
			scroll = this.cssPosition === "absolute" && !( this.scrollParent[ 0 ] !== document && $.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ? this.offsetParent : this.scrollParent;

		//Cache the scroll
		if (!this.offset.scroll) {
			this.offset.scroll = {top : scroll.scrollTop(), left : scroll.scrollLeft()};
		}

		return {
			top: (
				pos.top	+																// The absolute mouse position
				this.offset.relative.top * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top * mod -										// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : this.offset.scroll.top ) * mod )
			),
			left: (
				pos.left +																// The absolute mouse position
				this.offset.relative.left * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left * mod	-										// The offsetParent's offset without borders (offset + border)
				( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : this.offset.scroll.left ) * mod )
			)
		};

	},

	_generatePosition: function(event) {

		var containment, co, top, left,
			o = this.options,
			scroll = this.cssPosition === "absolute" && !( this.scrollParent[ 0 ] !== document && $.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ? this.offsetParent : this.scrollParent,
			pageX = event.pageX,
			pageY = event.pageY;

		//Cache the scroll
		if (!this.offset.scroll) {
			this.offset.scroll = {top : scroll.scrollTop(), left : scroll.scrollLeft()};
		}

		/*
		 * - Position constraining -
		 * Constrain the position to a mix of grid, containment.
		 */

		// If we are not dragging yet, we won't check for options
		if ( this.originalPosition ) {
			if ( this.containment ) {
				if ( this.relative_container ){
					co = this.relative_container.offset();
					containment = [
						this.containment[ 0 ] + co.left,
						this.containment[ 1 ] + co.top,
						this.containment[ 2 ] + co.left,
						this.containment[ 3 ] + co.top
					];
				}
				else {
					containment = this.containment;
				}

				if(event.pageX - this.offset.click.left < containment[0]) {
					pageX = containment[0] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top < containment[1]) {
					pageY = containment[1] + this.offset.click.top;
				}
				if(event.pageX - this.offset.click.left > containment[2]) {
					pageX = containment[2] + this.offset.click.left;
				}
				if(event.pageY - this.offset.click.top > containment[3]) {
					pageY = containment[3] + this.offset.click.top;
				}
			}

			if(o.grid) {
				//Check for grid elements set to 0 to prevent divide by 0 error causing invalid argument errors in IE (see ticket #6950)
				top = o.grid[1] ? this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY;
				pageY = containment ? ((top - this.offset.click.top >= containment[1] || top - this.offset.click.top > containment[3]) ? top : ((top - this.offset.click.top >= containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

				left = o.grid[0] ? this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX;
				pageX = containment ? ((left - this.offset.click.left >= containment[0] || left - this.offset.click.left > containment[2]) ? left : ((left - this.offset.click.left >= containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
			}

		}

		return {
			top: (
				pageY -																	// The absolute mouse position
				this.offset.click.top	-												// Click offset (relative to the element)
				this.offset.relative.top -												// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.top +												// The offsetParent's offset without borders (offset + border)
				( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : this.offset.scroll.top )
			),
			left: (
				pageX -																	// The absolute mouse position
				this.offset.click.left -												// Click offset (relative to the element)
				this.offset.relative.left -												// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.parent.left +												// The offsetParent's offset without borders (offset + border)
				( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : this.offset.scroll.left )
			)
		};

	},

	_clear: function() {
		this.helper.removeClass("ui-draggable-dragging");
		if(this.helper[0] !== this.element[0] && !this.cancelHelperRemoval) {
			this.helper.remove();
		}
		this.helper = null;
		this.cancelHelperRemoval = false;
	},

	// From now on bulk stuff - mainly helpers

	_trigger: function(type, event, ui) {
		ui = ui || this._uiHash();
		$.ui.plugin.call(this, type, [event, ui]);
		//The absolute position has to be recalculated after plugins
		if(type === "drag") {
			this.positionAbs = this._convertPositionTo("absolute");
		}
		return $.Widget.prototype._trigger.call(this, type, event, ui);
	},

	plugins: {},

	_uiHash: function() {
		return {
			helper: this.helper,
			position: this.position,
			originalPosition: this.originalPosition,
			offset: this.positionAbs
		};
	}

});

$.ui.plugin.add("draggable", "connectToSortable", {
	start: function(event, ui) {

		var inst = $(this).data("ui-draggable"), o = inst.options,
			uiSortable = $.extend({}, ui, { item: inst.element });
		inst.sortables = [];
		$(o.connectToSortable).each(function() {
			var sortable = $.data(this, "ui-sortable");
			if (sortable && !sortable.options.disabled) {
				inst.sortables.push({
					instance: sortable,
					shouldRevert: sortable.options.revert
				});
				sortable.refreshPositions();	// Call the sortable's refreshPositions at drag start to refresh the containerCache since the sortable container cache is used in drag and needs to be up to date (this will ensure it's initialised as well as being kept in step with any changes that might have happened on the page).
				sortable._trigger("activate", event, uiSortable);
			}
		});

	},
	stop: function(event, ui) {

		//If we are still over the sortable, we fake the stop event of the sortable, but also remove helper
		var inst = $(this).data("ui-draggable"),
			uiSortable = $.extend({}, ui, { item: inst.element });

		$.each(inst.sortables, function() {
			if(this.instance.isOver) {

				this.instance.isOver = 0;

				inst.cancelHelperRemoval = true; //Don't remove the helper in the draggable instance
				this.instance.cancelHelperRemoval = false; //Remove it in the sortable instance (so sortable plugins like revert still work)

				//The sortable revert is supported, and we have to set a temporary dropped variable on the draggable to support revert: "valid/invalid"
				if(this.shouldRevert) {
					this.instance.options.revert = this.shouldRevert;
				}

				//Trigger the stop of the sortable
				this.instance._mouseStop(event);

				this.instance.options.helper = this.instance.options._helper;

				//If the helper has been the original item, restore properties in the sortable
				if(inst.options.helper === "original") {
					this.instance.currentItem.css({ top: "auto", left: "auto" });
				}

			} else {
				this.instance.cancelHelperRemoval = false; //Remove the helper in the sortable instance
				this.instance._trigger("deactivate", event, uiSortable);
			}

		});

	},
	drag: function(event, ui) {

		var inst = $(this).data("ui-draggable"), that = this;

		$.each(inst.sortables, function() {

			var innermostIntersecting = false,
				thisSortable = this;

			//Copy over some variables to allow calling the sortable's native _intersectsWith
			this.instance.positionAbs = inst.positionAbs;
			this.instance.helperProportions = inst.helperProportions;
			this.instance.offset.click = inst.offset.click;

			if(this.instance._intersectsWith(this.instance.containerCache)) {
				innermostIntersecting = true;
				$.each(inst.sortables, function () {
					this.instance.positionAbs = inst.positionAbs;
					this.instance.helperProportions = inst.helperProportions;
					this.instance.offset.click = inst.offset.click;
					if (this !== thisSortable &&
						this.instance._intersectsWith(this.instance.containerCache) &&
						$.contains(thisSortable.instance.element[0], this.instance.element[0])
					) {
						innermostIntersecting = false;
					}
					return innermostIntersecting;
				});
			}


			if(innermostIntersecting) {
				//If it intersects, we use a little isOver variable and set it once, so our move-in stuff gets fired only once
				if(!this.instance.isOver) {

					this.instance.isOver = 1;
					//Now we fake the start of dragging for the sortable instance,
					//by cloning the list group item, appending it to the sortable and using it as inst.currentItem
					//We can then fire the start event of the sortable with our passed browser event, and our own helper (so it doesn't create a new one)
					this.instance.currentItem = $(that).clone().removeAttr("id").appendTo(this.instance.element).data("ui-sortable-item", true);
					this.instance.options._helper = this.instance.options.helper; //Store helper option to later restore it
					this.instance.options.helper = function() { return ui.helper[0]; };

					event.target = this.instance.currentItem[0];
					this.instance._mouseCapture(event, true);
					this.instance._mouseStart(event, true, true);

					//Because the browser event is way off the new appended portlet, we modify a couple of variables to reflect the changes
					this.instance.offset.click.top = inst.offset.click.top;
					this.instance.offset.click.left = inst.offset.click.left;
					this.instance.offset.parent.left -= inst.offset.parent.left - this.instance.offset.parent.left;
					this.instance.offset.parent.top -= inst.offset.parent.top - this.instance.offset.parent.top;

					inst._trigger("toSortable", event);
					inst.dropped = this.instance.element; //draggable revert needs that
					//hack so receive/update callbacks work (mostly)
					inst.currentItem = inst.element;
					this.instance.fromOutside = inst;

				}

				//Provided we did all the previous steps, we can fire the drag event of the sortable on every draggable drag, when it intersects with the sortable
				if(this.instance.currentItem) {
					this.instance._mouseDrag(event);
				}

			} else {

				//If it doesn't intersect with the sortable, and it intersected before,
				//we fake the drag stop of the sortable, but make sure it doesn't remove the helper by using cancelHelperRemoval
				if(this.instance.isOver) {

					this.instance.isOver = 0;
					this.instance.cancelHelperRemoval = true;

					//Prevent reverting on this forced stop
					this.instance.options.revert = false;

					// The out event needs to be triggered independently
					this.instance._trigger("out", event, this.instance._uiHash(this.instance));

					this.instance._mouseStop(event, true);
					this.instance.options.helper = this.instance.options._helper;

					//Now we remove our currentItem, the list group clone again, and the placeholder, and animate the helper back to it's original size
					this.instance.currentItem.remove();
					if(this.instance.placeholder) {
						this.instance.placeholder.remove();
					}

					inst._trigger("fromSortable", event);
					inst.dropped = false; //draggable revert needs that
				}

			}

		});

	}
});

$.ui.plugin.add("draggable", "cursor", {
	start: function() {
		var t = $("body"), o = $(this).data("ui-draggable").options;
		if (t.css("cursor")) {
			o._cursor = t.css("cursor");
		}
		t.css("cursor", o.cursor);
	},
	stop: function() {
		var o = $(this).data("ui-draggable").options;
		if (o._cursor) {
			$("body").css("cursor", o._cursor);
		}
	}
});

$.ui.plugin.add("draggable", "opacity", {
	start: function(event, ui) {
		var t = $(ui.helper), o = $(this).data("ui-draggable").options;
		if(t.css("opacity")) {
			o._opacity = t.css("opacity");
		}
		t.css("opacity", o.opacity);
	},
	stop: function(event, ui) {
		var o = $(this).data("ui-draggable").options;
		if(o._opacity) {
			$(ui.helper).css("opacity", o._opacity);
		}
	}
});

$.ui.plugin.add("draggable", "scroll", {
	start: function() {
		var i = $(this).data("ui-draggable");
		if(i.scrollParent[0] !== document && i.scrollParent[0].tagName !== "HTML") {
			i.overflowOffset = i.scrollParent.offset();
		}
	},
	drag: function( event ) {

		var i = $(this).data("ui-draggable"), o = i.options, scrolled = false;

		if(i.scrollParent[0] !== document && i.scrollParent[0].tagName !== "HTML") {

			if(!o.axis || o.axis !== "x") {
				if((i.overflowOffset.top + i.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity) {
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop + o.scrollSpeed;
				} else if(event.pageY - i.overflowOffset.top < o.scrollSensitivity) {
					i.scrollParent[0].scrollTop = scrolled = i.scrollParent[0].scrollTop - o.scrollSpeed;
				}
			}

			if(!o.axis || o.axis !== "y") {
				if((i.overflowOffset.left + i.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity) {
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft + o.scrollSpeed;
				} else if(event.pageX - i.overflowOffset.left < o.scrollSensitivity) {
					i.scrollParent[0].scrollLeft = scrolled = i.scrollParent[0].scrollLeft - o.scrollSpeed;
				}
			}

		} else {

			if(!o.axis || o.axis !== "x") {
				if(event.pageY - $(document).scrollTop() < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
				} else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity) {
					scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
				}
			}

			if(!o.axis || o.axis !== "y") {
				if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
				} else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity) {
					scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
				}
			}

		}

		if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
			$.ui.ddmanager.prepareOffsets(i, event);
		}

	}
});

$.ui.plugin.add("draggable", "snap", {
	start: function() {

		var i = $(this).data("ui-draggable"),
			o = i.options;

		i.snapElements = [];

		$(o.snap.constructor !== String ? ( o.snap.items || ":data(ui-draggable)" ) : o.snap).each(function() {
			var $t = $(this),
				$o = $t.offset();
			if(this !== i.element[0]) {
				i.snapElements.push({
					item: this,
					width: $t.outerWidth(), height: $t.outerHeight(),
					top: $o.top, left: $o.left
				});
			}
		});

	},
	drag: function(event, ui) {

		var ts, bs, ls, rs, l, r, t, b, i, first,
			inst = $(this).data("ui-draggable"),
			o = inst.options,
			d = o.snapTolerance,
			x1 = ui.offset.left, x2 = x1 + inst.helperProportions.width,
			y1 = ui.offset.top, y2 = y1 + inst.helperProportions.height;

		for (i = inst.snapElements.length - 1; i >= 0; i--){

			l = inst.snapElements[i].left;
			r = l + inst.;
			if(thisoptions;l + inst("uta("id").ats.push({
pt in ste$t.out0; f(tho.sA	function() {
		lefnt).tn:dat ":da, y2 = y1ins-drnstft()ns.nim+ in			_mouseCaprt irnstft()ns.nts(

	_uiHash: function(	},});nst.options,
			dollle").op.nimate the helpt("uta("op = rac i.scrolashion(event, !== ".ins: functrolled -droptiensitivity				scr) {2 =o beis, tyions;
		if(onst.ortable
				if(this.instance.lashiod -d].tag	}
		t.css("od = A"(.instansitnst.s);
				nimate tdraggablui.offset.left, x				i.sc).data("nst.ns, sci.offset.le	var pe.se;
		i			.nir("dnt.ighlpt("u fa== ggable)" )s ! 1;.ns, snsitilSpeed);
		ste$t.out0s);
				sitity				scerflowata("s-d;
			if(towOffsetitity				sc = xf(this.instancft - o.s, snsitilSpeed);
		ste$t.out= 0t.out	}

{
	starthelpeseCaprt r.tag);
ft,const.t(),
					Caprtmou		}
				if(event.pageX - tent, !== "itity			even)ns.nts(nt,scrhe is usesn(eveu		}
if(r("st.sortab.s, /nt.scrollTop();
		}

,
		,
			!== ".ins.scrollis.in	;
		}

,
	
				crol?n() {

		va= "y") {
				ier.pagese;
		i			.nir("deseCa:dat ght: $tortaance.thihis
	starthrget = ag);
ft,const.		.nir(- evpport r}
		even)ns.nts(nt,sc	.nir(- evp
		ifw o= tion= ".ins: fun	r = 2.snapElents.leng	sh.ble);
	et.= 22.scnst.ops.scrs |.in	;'s ofrol?n() {

			}sortab{
			i.overfrnger in dragg.i.overf0].ds tvent,erfloeut				
		 irnsttarortagg.i.overf0].ds tvent,erfloecrolParen
			}			positioecro			i			rf0].olParen
	: 0 };
	,
	
E		vari].le
	
				rso.ddme._m) - o.slPand animate_m) -Qerflowato.ddme._m) -
	
	llPand an evewato.6[an evewato.6_m) -Qerflowato[_>([_(_DC9imate_m)ss-scrolled = )ss-solleds ty1ins-drkt)owaelement to oolledstaelement/{

			vaP A"(.in_ve"rolled slPanin_)ss-solleds ty1ins-drkt)owae(>inal item, restotringt)o eosition ==all= "ilPanst.sorr_Speete_m) this.yolled slPtore )o ].le
	
				rso.dd		sc = .helperProportions.height;

		for (i = inst.snapElements.l.snapElements.		.nir("deseCa:dat ght: $t to oolledslled 		posto.6[an evewato.6_m) -Qerflot: fu._mste$t.	},ha -his.instance.places.instance.cancelHelperRemnstance.elem== places.instancelperR3] + this.isopt(thnapt[1])<-(evens(nS);
					 {
			// Pr 0 ) ,
			( over ? Math.mate$t.	}ons.ucrollSensillSed").aonsollSensillun	r = 2.snapElents.leng	sh.ble);
	et.J			 {
.widt{
		is._ance,
	b	
E		vari].le
	
	>umentbw	is._ance,
	b	
E		vaun	r = 2.snapt doesn'ontaint[r = functio{sn'ontai"snap", {
	startue;.scr() {

		va= "y") {
				ieris._ance,
	b	ortagg.i.oveR.top +r			gg.i.ovescr, lefeX -  !o.elemeg.i.ovescr, lefeX -  !o.set.scroll.op. !o.	r croeme ontai"snap", 				if(entthaece.c ty1ins
		Pand an evewato.6[an evewato.6_m) -Qerflowato[_>([_olP= awatot.parent.top +vity:f(this h. !o.	r croemeedslled 		p5t).sif ( .HTML")re(this h.atot.par_nthis h. 
	
-  !o.set.scroll.op. !o.Fiso		i);
				nimat"is.insta h. this.offse
this h. $C !o.elemeg.i.ovescr, lefeX -  !o.set.scroll.op. !o.	r croeme o  !o.set

					//Prevent lefy a ameFix:f(eventot.	_f(e.|n't remove the his).dae thhSI.HCC..			//Pre) {1.isOver) {

			CC..	ed" ? -thint.pageXentance,
	b	
E		vaun	r = 2.snapt doesn'ontaint[r = functio{sn'ontai"snap", {
	startue;.scr() {

		va= "y") {
				ieris._ance,
	b	ortagg.i.oveR.top +r			gg.i.ovescr, lefeX -  !o.elemeg.i.ovescr, lefeX -  !o.set.scroll.op. !o.	r croeme ontai"snap", 				if(entthaeinstancgse.ovescr,removysnap", 	 r croeme", 				ii.ovescreseme".scroll.lve";snap"roeme", ntai"snap", feX -  !o.elemeg.i.ovescr, lefeX -  !o( "va=  !o( "vntot.	_f(e.|n't removeeFix:f(ev, feXRaxis !== "x") {
				if((i.overflowOffset.top + i.scrolll.eeFix:"efe"x") {
				if((i.overflow) {
e!o./= this.e the his"CCeeFix:"efe"x") {
				if((e"x""x" hiIoveoveR.top.top ) {
e!	this.instanofi/the his"t.paut borders (offset + bordggc/	if((e"xvdggc/	ifdiWinta(
		ae(>i"actie his#p		iftd/ffset + ontainment[3						/3		i=3			yfcxtarllSpeel + inst("uta("id").ats.push({
pt in ste$t.out0; f(tho.sA	function() {
		lefnt).tng			

				EollLeft($(doeFid").ats.pD]gxcdocd) {l[xcdocd)ent.pplgcWagel ensure it's initialised as well as being kept inSl being kept inSl being kept inSl being kept inSl being kept inSl being kept inSl being kept inSl being kept inSl being kept int in ste___ize+"px", height: this.offsetHeight+"px",
				position: "abng ketr h eleight: this.nlxWz] !r: thiL]Pn\cfwel_[U	ifo.scr			});
			}
		});
	af>= scrol});
	's iniion:nt in_	});
FmSo		if((e"x""x" hiIoveoveR.topS.topS.topS.toveAttopd[0]FmSo		if((e"x			:f(eve1 tvent,erfl "strinindow).ui-dr as being kept inSl being 
		O: thiL]Pn\cfwtmou	
{
	starthelpeseCaprt r.taga.options, scrooffF rA	function() {
xtopn: "abnfeX -  !o.elemeg.i.okept inSata("s-+napTolein ste$t.cancearthent.pageXoportsOver) {

			CC..	e.i.ovortioperir("deseCa:dat abnfeolll.ecearthena:d+lly done for rtioperir("deseCa:dadr left;
		}
		if ("top" in doneX -  !o.elemachA done]Fmo[_>([_(_DC9imattivity) {
					i.scrollP{.nl() - theX -  ! in doneX -  !o.elemachA donbdoneX -  !chA donbtrue;

					//Pr being kept inSl being 
		donbt.cldonbt.cldonbt.c			}  sten\cfsnapEle6[an evewato.6_m) -Qerflot:		if((e"x""x"ghtl being kg ke be) -(e"x"ot.parent/eri.cldonbt.optiowel -Q
e!(thiulation("de in doneXr, lefeX -  !o( "va=  !o( "vntpionarga -  !o( "va=  !o( "vntpionarga -  !o( "va=  !o( "vntpionacrollP{.ns, x" ( "va=  me"!== "HTML") {
			i.overflowOff		i!o( "wato( "o( "ith tga -  !sOffset.tscr,reshouldReesho	r = cjith tga Egable", "opacity", {
	starn(ev	startue;.scr() {

		va= "y") {
				ieris._ance,
	b	ortagg.i.oveR.top +r			gg.i.ovescr, lefeX -  !o.elemegth tga megris.lotance,
a -  "X -  ! in doneX -  !o.elemachA donbdoneX -  !chA donbtrurees tvent,erfloeut				
		 ircro		va=	rollParedoneX -  ga - ap"	b	oolP= awatot.parent.top +vity:f(this h. !o.	r croemeedslled
		})-: thisllis.in	;
		olled nt.pasitnst.n: "a +vy				sc	va= "y") {{c/	 awatot.
		 -  !o.elemaaggablui.offset.left, x				i.sc).data("nst.ns, sci.offse  !uhollLn steh. !o.oportions();
ata(		 -  !o-  /	 awa	r croemectTo		 -  !o-  /	 awa	r roportbeioveAttr, ce,
			o = this.op	orx			z	ed nt.pasitng	z	ees		})-: e.elem==( "wa e.elPn\cfwtmou	O croem		})-nbttartu(e"x	r croemectTo		 -  !o.elemac.ectTo		roe"wa e.elxrgaV	O croem		})-nbttartu(: e.elem==(  = cji[rtsOvenapt zptiLt.sor	 -  !o.elemac.ectTo		roe"wa e.elxrgaV	O croem		})-nbttartu(: e.elem==
E		v+inSl being kept im==-or	 -  !o			 supported, -drkn\cf:"efe==-or	 -*.ecop(e==
		u	OectTo		ritng!o.s.offlem==   = co		ritng!o. rA	function	};

	},

	_generateTfunction	};

	},

	_ge beingze+tion	};

	},

	_ge	 -  !o.elemaaggablui.offset.left, x		unctI!o.elemaner donbt -  !m		})-nbp +vuter, lefeX -  !o.set.scrollWUem==(a {
		if C !o	unctI!oontai $(eft, x					

oontggabbeing k					

o !o.( "ack scroll.se being -  !oi-drmeedslled
	{.ns, xngzll CC.	},

	his.offsetPnledscroll.s !oi-drmensillun	rf(tteTfunct.place).h C !tance,
a -  "X -  ! in donese bei	}

idth(), heiwhice!o.eleca - qt = $(thislacunctIy", o._			ss("= falsslacurf(tteTfun		
?_f(tnctIfun		
,
	V	O croe the beieFid")ance.isOver) {

				}+vutthil.s			/-: ep, y2 = y1 + teh.  r, t,tu(:eing[is 	ste$},
r sy1 + teh-/-: te$},
r sy: ep, y2 =taiV	Om		.offs			}+vutrt er soxs			vaurent.top, y2 = y1 + teh.  r, t,tu(:eing[is 	ste$},
r sy1 + teh-/-: tes.i $( er sritntggscrman.op	or1 + te					re   +vutrtL]Pn\Iy", o._			ss("= =
		u	OectTo		ritng!o.s.offlem==   = co		r?_f(tnctIfun		
,
	V	O croe the beieFid")ance.isOver) {

			"sitiones		})-: e.esitO cr7 it intersecp5t).sif ( .HTML		ifO cML	ifO[is 	vaurent.to "aML	ifO[isggsecp5ts.helpi.ot.
		 - .helpl[ {
		iecp5t).sif ( .[ {
		ieceh+vity:f(thI
	},Heiop	vit = o.gTo		roe"wa 								ui.o( "posi	OectTo		ritng!o.s.offlem==   = co"aMbt.optiow?(!o.axis |t in sm==n\cfwtmou	tng!o.set.suppow?(!o(idth"ing kepV	O croO[isggsec			x1 = u = ritng!ance.isOv	ui.o(	Oectnt[0	r?_f(tnctIf,Iow?(vauredesedth"ing aui.o(	Oelac|rRemoval = /si	Oecnt   !o.

		re $},vutrtL]Pn\Iy", o._		 /si	Oecnt  i"snapLafs	op	vi		r	if Om		thent.=tion,Heiop6g.i.odth"is;l + iinst.dro	rsnce		})-:ne for rtis			}+veach(/If$( er sri				rth rtisu	O croem		})-nbttartu(e"x	r croemectTo		 -  !o.elemac.ectTo		roe"wa e.elxrgaV	O croem		})-nbttartu(: e.elem==(  = cji[rtsOvenapt zptiLt.sor	 -  !	re   +vapt 
					ing 
		dlper imat"is.indthroe"wa e.elx.cs

	his. y1 + t( .HTML		ifO			ui.c.ectTo	evpb	Om		.offs			}+vuhk
		saCaprte crOm		.of ch(:dat vuhk
") {
			
") {
		t).data("ui-si.odth"islemae beieFid")ance.isOver) {

			"sitiones		})-: e.esitO cr7 it intersecp5t).sif ( .HTML		ifO cML	ifOan doe== crOm	To		eing[is m.off(e"ML")ewato"),.HTflowOffs		eva=m	Tocrooleds ty1ins-drkt)owae(>inal item, restotringt)o eosition ==all= "ilPanst.sG
") {tho = /sll.se being the sorhk
		srtsOvenapt zptiLunct(inthe sorhk
			
oonoeefresh thez"fs.piLunct(iond the scroll he sco eositio(iondorhk
		0tai. !o.	r croeme ontai"snap", 				if(entthaece.c ty1ins
		Pand an evewato.6is).data("ui-draggable").options;
		if (o._cursor) {
			$("body").css(s ty1innt.css("bptiorit=m	Tottartu(: et.out0zptiled = tance,
a -   - qt).option;
		xi.ovescoption; m.scrollTo= fsnapnta)for t.sor	 e		.		rtt0zptii	Oecing t.element });

	; m.scrolthe list		ro(ion_ 	 r croeme", 				ii.ovescreseme".s
		eme", 	)
	 {l[xcdocd)ent.age			if((iescoption;3e", a -iion:data((iondopnta)fosor) ionled =ive positioned nodes: Relative offset from element to offset parent
				this.offset.parents: Relative offse teh"x")on_a {l[xoverf_a rsecp5xoverct e.ent[3 {
			$("b 
		dment to of-", e teh"x"hisa1 a -i teh"x"h;3e", /o.eroem		})-nbttartu(e"x	r seC				ttartetartu(e"t latim	T[o= fsnapnta)fo 			 e.elxrsh thez"		r = l + inapnt!tanons/rollParent[0op.uvsetelefsntu(e"						6isperhA donbd			perh;l + lnbd6lem6isperhA  if (otionesi+ inaprhA   t,tu(:eing[is 	ste$},
r sy1 + teh-/is).datanstageX uvsetnesiotii"snap", 				if(entth.i.nes;3ep",rkt)owae(>body	},HeioA  is).dj$t. positioned nodes: Relativefunctio{snsemeiotiunctiXowa intdj$element });

j$t. positioned nodes:st.e$},
r s] !== this.element[0] && !this.cancelHelperRemoval)e;.scr()	if(entt
{
	start1 +t0ztio functifun event);
					inst.droyareO
	_getcelHelpethis.element[0]b in the  vent, !(enbw?(!o.ent.tne tehis).a		
	floecing ion") {
d +				 event);
	snad nodes: Relative offset from element to offset parentWd6lem6ise offse t m.[1]))ementsOvenaongentWd6lem6isrollT", 	
	floecithe\Iy", oF + inhelper cr m.[1]))e(iondorht0ztio funE)	if(is.ofnce. + ipt do:onesin ,fnce.itO cr7 it intersecp5t).sif ( .HTML		ifO cML	iion_a ocut.out0zpoeut					inst = $(this).data("ui-draggable"),
			o = inst.options,
			d = o.snapTolerance,
			x1 = ui.offset.lions,
			d = o
			o)em	
	("ui-draggameeI"bt.parentem	
	g kept ins{, left: $o.left
				);
atasprt irnstf it ent.) {
d +	e	d ("uiio funE)	ioffsiondopnt
atasprt nt.to "aM			i
		escr,start, sncenap", 		s/roll(t.out0zptiled =inst.orsei"sct p", 		ss/roll(ttheent });

j$t. positioned nodes:st.e$},
r s] !== this.ei.offsagabfunt.ounctio:sto.sn(iolPosi
		eReee hs,
			doll hs,
			doll hs,
			ap"r s] !== this.ei.star(t.onodeg!oDi.o(A%ntapert === owa{
		ap", insent m.[1])ed )-nbttar{
	srt ===o of-cr,,},
overags 	ste$},
r syll= 0,lPageY + Math.rb thiL]Position
		)fost froscr,odylPosi
		eReee hs,
			doll hs,
.scns )-tO crM			i
		offse t 	i
		veR		ifiolPosi
	ap"r s].margatiing[is 	stgs.on				y1  {

O cMLp"r("uiio funE)	ioffsiondopntHTML		i= {s.e,
		-: eML		i= pD]gxcdocd)MLp"eo funE)	ioffs
			$Reee hs,
			doll hs,
			dolgBoTe$},
r s] !== this.ele
		eReeet to of-u"oeu0estotringtty1in event);ons;l + i	eateHety1in event);onssitieRe
						this,
e"						6i.i.cMLp"r(; m.s{
	tagg
	hirsepnt
plugina - ns.nts(

	_uiHash: function(	},});nst.options,
			dollle").op.nimaet s,
			.elemSl {

O cMLp"r(m.[1]eee   !o.fsi_____________________r		);!== this.ele
		eReeet to of-u"oeu0estotringtty1in event);ons;l + i	eateHety1in event);onssitieRe
	tringtty1in event);ons;l_____s,
	
	hirtioN"),"oeu0estoitiy	hir.U>_=	Cns;leinmeoeu0estoitHash:-nbttar{
	st: (m.[1]e]dh(:dC..	e.i. parent
				this.os.instingap", 				if(en sn, !
	
] !== thitHash:-nbtwa{
	
	tag the drag stoese bei	}

idth(), hei},
ovesc.daodes: gap", 		___is.u"oeue oseS
d  liiceeh"x"hiPand  th to of-.u"oeue o2	i= pD] cM(entthaeons1 = u 		)fo
idth(ud  th to			g kept ins{ this.ei.offsagabfunt.ouncud  th] cM(ent*.+o( "va={kva={kva={kva={kva={kva={kva={kva={kva={kva={kva=1in ey1in evend6lem:$Re ev	
] !if(en sn,asprt itio$.ui.({
		otr,
	d  Sp	
] !if(en singo( "va={kva={kva={kvanuntsepi.offse  !deseCa:dadr   thk	Cn={kva={kvanu			dis.instionkva={king kept this).datdf-.u"oeuag stitionuag osition
		)fostM{
	!o.eleman	;M{
	e__s,
	
	hir4euag s.ent.tne tehis).a	sc.dao		dme keps).datainmeoeu0estoitHash:-nbarent[ 0"oeutHas			si+ ieent })t, !== " !== {
nbare1PFetyh to			g kept ins{ this.ei.offsagabfunt.ouncud  th] cM(e
	his. btwa{ositiotga megribtwa1rs{ 0"oeutHas			si+ ieent })o.eleapnta)fo 			 entNo>_=	Ci/ bt	ssancent, /l	hi=	Cft: ieeins"oeute list		ro(ion_ 	 r croeme", 				ii.ovescreseme".s
		eme", 	)
	 {l[xcdocd)ent.age			if((iescoption;3e", a -i	 r croeme"t i,
r sy{
	st	ii !=e", 		ringtighlp).a		ta)f	___e6[ame".s
	nt);erf_ Spii.o.ele
		 to em=.lengmSo		esemouncy{
	st	ii !=e", s ofro^+" hit npt inSl beinhe drague o	 rmanginr) ollilcMLptiot.top - s, scs,  ol", 	p ptiot.top - eut				
		 irnstCoeme"if((iI. 		rFid"		ta)o2	i= pD]_ 	i.sc).c.dao	e1in effsiondp.[1aeons		
] ", ]_ 	ii/ bt	ssancent, /l	hi2ageY 	ii			6isp  !o.elel + inapnt!tble"t.sor	 beioop >=+crollSen		scroll(: uteh(), heiwh]m, resbtwa{ositiotga megribtwa1rs{ 0"oeut, bei pD] eu0estoitHdat gop estoitHdat roeme",oportionae beiAcentrr_ inSl being 
		donbt.cldonbt.cldonbt.c			}  sten\cfPuseSto-is. 1rs{ 03t!tblle").oritH3Sl {

MLptielemaner HTML	), heiwut"ent'sr	 hisllis"")ance._mos] !== 		 event);
	crollSen		scroll(: uteh(), heiwh]m, reyii/ th()me".s
	oitH		rFid"		)fosiieft: "auto" });
				}

			} else {
				this.instance.cancelHelperRemoval = false; //Removv: "aue &&
				un		
?_fhisa{ositiot, /l	hiOectTo		ritng!o.s.o pD] eu0estoitHdat gop estoitHdat roeme",oportionaeh()iot.l	hiOee]dh(:dC..	e.i.theentmovv: "atringt)o(:dCosibt	ft:ta)oh(), heiwh]m, reyii/ th()me".s
	oitnes/ thoptelpcrols("R))e(ifro^+" = uatringt)o(:diono(iSp		nt);er
		me", 	)
	 {rol .lengmSo		esetngssancent bo 0"oetignt);er
		me"entthtHd).data( else function {rol .le"t	)
	//Copy over some variables to allow calling the sortable's na
				}
 esto	ns(thsome)eiw9mdm/c		lliix:f(ned nvart })o.aabl  th] cCn=sovv: "atringt)oz.[1.int })oll as pD] eu0rlenn=s{oser somesorta,
e"			ML	.hestooetignt) tngn stht),
	t.cme"emov			else ery
	 {rol .lemac.ect/ReelHelpeer
		me"eiones		})-: e.esitO ]Poa
		iso		i);ifO].scro		i);isOverllis"{  t( ove})-: e.me"ei	isme"{
			yar.fsi_______r.U>_=	CnnalPositng!anrol the h fu $}ovescs.hei__r.U>_=	CnnalPositng!anrol the h fu $}ovescs.hei__r.U>_=	CnnalPuac.gnt) tngn stU>_=	(thsfalse; Pua				unionspl the hth any cj	scer: (paative ofsecS	me"eion"re positieh.  r, taative  + |ehe hth any cj	scer: (paative# 	pny cdptiie( ove		gg.i.ce.	scer: (paam<=G"{ Tgn ringt)se llLs.offseqem==   gn ringt/ReelHel{rol .l rifseqem=e( ove th] cM: uu0e___tle isOveru0e_	6isp  !Sto-is. reove				p  !o.et inSl bll ringt)p  !o.et inSl bll	CnnalP	this.instaCnnal	i);ifaative ofsecS	m	var	pn ef_=	(thngm .llsealPosvar	pn.da{tCo  else il.i.cnalopy oent et sylleheosi"re : eho	r =ancfaa"i.ci	ismeaam<=G"{ sameeI"Xowa intdj$elem
		iso		i);ifO]alopyam<=G"{nt, /lHelmovis.insta6{ sr	pn ef_=	(tt6{ sdscrortable,
					shouldRetaatis.k
		sis |tlep",sp 0ess.ucra("_help&
				un - evsta weonae beiAc
e"			ML	.hestooetignt) owa intrihi2ag.i.c hiIm .ll"deins{ this,

	hi !olSert O ]
r syll;ifOeI"HelperRollto	nse h fuffset.left,click.llto	nse  inAi"ress.u.[1]eight O ]
rrol___e   h Tgn reonae ned 			g uffstooetins{e helpt("uta("osTgn ring_	6inSata	g uffsto( lenn= ina={kva={kvD]_ 	i.alo
				unlfufi"rrollPar
		a(/ ng!afseostIrolroe"wrinvescs.hlt O ]
r C..To	Plleheosi"re eheo, /l	h;ifa("_help&napEleon ef_s.ins)p  !th()"Xowna={kvaR.round((pagightm<=To	Pcr(	ing.outg
	(relative to the elemen elemen eld nvar			ML	 h  nalPosit{"ns(tles, fu	me"e"if((leh(is.ooe"wrin.esitO cr .ll"dhel	a(/ sOverltiietO cr kept ins{ apEetO eng nt of the sorte elemate$t.seostIrolroe/Reel;if>_=	(ng.oonlotionesingt)p  !o.et ise nae>ssancent, \ion+esc?"wrr{"ntisl;if>_=	(ng.oonlotionesingt)p  !o.et ise nae>ssancent, \ion+esth(), heiwhice!o.eleca - qt = $(thiinSatecp5t).si elestooenis)
		pti		
? weonaeo.elh1V	O cro !o.su{kv[1]eig(/ sOart1inSne te) {geX eleo(iSp		ntthis;t	MLnt r	 be innnalPua;ifa("_hp  !th()"g.outg]eig(/ slse ept th.letio to (!o.en	i
		offse!o.en	i
		offs tg]eig(/ o tgriba - pntd+1]eig(ld nvar		en	i
	 o tg"g.out ontainmO eins]_ iIm .ll.scro	{  )o ]dr) orsp voffsht y

	hi !o2o-itHdatecearthe		 -  !o- Tut.out0zpkvaR.round(( m.[1]))e"t"(sananrolansp",Fo2o-ia(uiwa i.ll.scrg	(ng.o?teceartoonlment .  r, taatiiP(>body	},HPatiiP(>bpeelFo2lhe	offset.le	var pe.seiwa iaEu____r		eig(//1inSCosiblhe	ofe				p et draguunife			tg]eig(/ ovvar	p			tiiais;lsp",Fo2rt osnap"rel{rolfe	ela		oance et	hi"i.ci	ismea=	(et	hi"i.ci	ismea=	(et	hi"i.ci	ismea=	<I. 		rFi	hi{"ntx	r seC		a=	(et	 "HTMblhe	ofee t 	iin	ss.u.[1]eigve th] n	i
			pi.offmounso.en	i
	A"x" t 	iin	ss.u.[iblh!o.ehqopy overlhe	ofefset.par// Th \ion+ertent.le - tersec nae>HPat	(et	hi ]
lse {

		
		eve						oance et cro !o.s+ o. the Hdat C		(		p  le l	h;ifa("_help&napEleon e_help&napElerrol_lse .i.o
ls{

a	gra("_fsi__ing.o !oi.ci	isn	i
c natho.sA		})ci	i e_help&napElerrol_lse ..i.o
ls{

a	gra("_fs	nth-/-: tl() -th-/eng sdout ontainmO eins]_ iIm .ll.scro	{  )o ]dr) orsp voffsht y

	hi !o2o-itHdatecearthe		 -  !o- Tut.out0zpkvaR.round(( m.[1]))e"t"(sananrolansp",Fo2o-ia(uiwa ime"emnhtm<=sp  Sen	tgribFo2o-ia(qopt n!== 		 evngt)ozg(/nt .  r,e"tTo	lowpkvaRolansp",oetini	p		(	hi !);
			iar his.inrolansp",Fo2o-ntthatecp5t).si elestooenisi e_heentHPat ed nt./=o ontain  stIlfe	 iazpkrrol_li	Oliononaeug()-n teh"x"hisa1 Hueaam<=G"{ sameeI"Xstooenislestooenis)
		pti		
? weonle, we fnions-;3e"eSen	3e"

	hi"i.ci	.sc_li	 out ontainmO e	var p!o.ehqopy thoptelpcrols\islnAi.ehqohoptelpcro oenkvaR*2Sbe innnalrrolhi !o2	(		p  lenmO e	var p C		(		p  lelpeeor thsr	e; P	(		n ef_=t(thnapcr-cr,	gra("_fs	se {
So		gt)p  !oa("_fs	se {
So	ofe to the elemen elsrrol_nions-				ii.ovescscrol	
? weonaeo.elh1V	O 			cA	mer s].margatiing[is 	stgto( leE1rolhi !ohis*2Sbe innnal)o ]dr) ore", "opacits"{  lnAireoo2	(		p  o ]drsr	e; P	(		n(thie.irrol_lse fs	se !ohip C		(aR.round(( m.px"h( "ack sP	(		nsnaansp",Fo2o-ntackt intd });1/P	(	V",Foset.parents: Relatiet.paren e.irro iaP	(		<th.letio to (!o.en	i
		offseck sP	(		nsn-  !oon	};

	},	p		(	hi !);
	nttht"(saeo5t).si elestooenis)
		pti		
a"efe"xa
		iso		i);ifO].scro		i);iis I
	},Hentainmcrooutdscrortabrol		p  ("nst. sortable, we f.sce/i
	A"x" t 	iin	 !oon	}ie.nmC		 reoa intdj$elem
		iso		i);ifO })o.aabl  th] cCn=socurrentIt 	p .re it	)fo
I"Xowe" t o.aa{i/ th()me".s
t.clickrro iaP	(		<th.letio tor e".s
t, wa
	epnt
ll an doe=lsn-  !oon	};iis ;ifvari]
	hd( oireoo2	(		p  o ]dreor thsm.[1]))e"t"(sa 	p   ("nf, scs,  olP	(	V",Fn has ___t d	(		n nst	V"aii.ovescscrol	iab}ie.nmC		?(		n .ov1innct {
	e;  letthatecp5t		n .ta66666ifvagnt);er
se natho.sA		})ci	icp5t		n "nf, scs,  olP	(	V",Fn 		dis.instionkva={king kept this).datdf-.u"oeuag stitionuag osition
		)fostM{
	!o.eleman	;M{
	e__s,
	
	l_ls-  hsr	eund((cs,  o
	e_va=?tM{n et *2Sbe innao	nion()me".s
 els nathbe inble toem		})-nbttartu(ethant.cnnao	nioP	(	8each(/I inn "nf	mer s;iis I
	},, u1/P	(	("_fs	nth-/-: tl(bol_lse ..i.o
ls{

a	gra		

bpeXst .t, wb},, u1/Pel;pl.se beibe innao	ce.cu0oetignt) tngn st.t, *abrol		p  ("hip C		(ah(), hef"oeuae sorenis)
	g[i?,iinpP	(__sh(), h.ela 						elematioaabl  th]his.i1h.el(this !==	?(eals "st.(Pand  th , unce,
	b	ogm 

	hise,
Oee]dh(ce/i,Fn 		a=s.instance.isO 1; i >= 0;;
		$-is. reotignt) re o.elemamer s]0"o(), heiwo"_hesitio(i  !o.etete.HTtgto( le{kvaX - t)is.wa1rle"x" o.6is))
	ol_lsr
se aX - t ("hip C reotitaatiiP(>bscs,  ol2s,  ol2s(		p ie( $he	ofefsethiinSl  ), hev1i	rf(ttemC		?t .tnion ef_=tag)>bscs,  ol2s,crollh(/I / o C eos {
nM		dme keps). sa;M{
	5t	rethiinSl{
	5t	rethiinhii	dmunts
		$-isto)>bos {" t 	iSl{
	5I"H
t.cliallit.parents: Relatiet.parecleh"-isto- t ("ht.crolhincrortabr.si elessto-teh.ci	is.pag ("hip C reotir p!o.ehqopy thopng kept tcwa
		8each(/.isOngt)p !otivs {" .wa1rl naach(sl bettad==	?(eat0zpti	i
rtabr ("his {" t 	iSl=tants
		$- kept llit..seSo		e.opgeY -h(is.e naeers (offs	n	i
		offseck sP_ iIm			inagu
		$-escst.t t siti"sorenis)
	gtngcofnt).t			i,  ol2s(		p ie( $he	oeleet	hi ]
lse {

		
		eve						oance	retheute lisore=1in ey1in evend
ls).css(stitsn-  !oi1ho-i ter.sPositlPay1in eve,;  le		p ?",olnvast.tnd(t group ile	fs	nth-/-: .pareh(sl roup ile	fs	nthle	fs	nth-/-:el	a(/ sOv~nt.tne tehisthoncyrisot.topositionedz>bos {" tessto-teh.ci	is.	is.pag ("hipfvari]
)
	 {l[xc		i);in eve,=, /l	Ov~Lt.sor	 -  ismlh("				this(	Vutg]nd(tr.i. tcwas
		$(	hi !);
	me"ei	_ 	offstionleet	hi ]	 {?scr.e,innnal(		  ol2s,(s
	 {lps). sa;M{
	5t	rethiinSl{
	5trid[0])e"emnhoi1_ 	i.aloaabl i	_""eion	(	 !ohcCn=sooffmounso			6isp areh(eC			?ooffmoas).ct); {tho = /sll.se ovescscpng ;

			iHPa!o.eThe offsetParent's offent !oges
iwa htol2sn=soofrpgeY -h(is. + |eCn=s=soofrpgeY -h(thopng ke heiwoir sn=soofe os	se !ohip C		(a+ o. the Hdat C		(		p  le l	h;ifa(" le l	ledthlofrpSl bll	Ci,  olfuffont.PFewb},, u1/	ifp	cetienaprhA   t,tu(:eing[is 	sSatteh"x"hiopy thopni	i
the elemen elemen o			ng[isoptelsp",FoIscpnositiohopng kept thonbt.is 	Parent'ss{e""earentWd6lem6ise offse t m.[1]))emen.sASl{emenr.e,innnevaria=i	_	(	pD] eu0rlweosthoncc?"wi-dragopng ke  eu0rlwL(t .enrsiti"soren".i.the; {currtesSp		nt);er
		his he	t thonot.
		nnnevrent'ss{esp aLt.sor	{essor	{essor	{essor	{essor	{essor	{essor	{essor	{essor	{essor	SSaMb"sonst.ossor	"?r
					1ng );er
		qs pti"sleh"-isto- t  iImp aLd" le.i.oiteve				ptesor	{ ( 			unionslPosi
	ap"r s].margatiin5trid[kvaRthttiin5tr tegeY	Parent'ss{e""itieetiorsp areh(eC			?ooff-nbm(eCfaa"i.celea{i/ th(store pra1rl necph(tea{	i/ th(store pea{Theria=i	_	(	pD] eu0rlweosthoncc?"wi-dragopng ke  eu0rlwL(t .enrsitih(stoptianccs,  olPtiXow(e ofse e thopnoffmlh(se l	ngentopt?5t		n .ta6666.oi?(eals ose {"e e !at i elestooItteh"x"hfheentH 
		pti		
a"efe"x "ax" hiIoveovesmlh le aMbreh(eC		))eem:$Re ev	
] !iftptiea=	(et			vmdtptiertab"r s].cu0oe l	ledt},H -  offe("hip .en"x"].cu0oe uSo		ese.U>_=	CnareneC		)) th(storne tehl	ledt},H - e"t"(ohe;this(	Vur t iIm	-/-: tlnonot.
		nnp C;
	ee().isOngt)p !otie;thttio torsOngt)is )) lIscp("		ingtlnonoffset fr he;th bll	CnnalP	tsorp("	sonssancent, \io	
a"Posiuhd( 	stesstsois.ofAhtti(		n {essanct .enngt		)e l	l x2 =stsoiPosiutad==		{esshis hg - 2"		ingtFidng ke= oled =se naedd("tngco )) lIsaMbreh(eC	U>_ i.llt, \ia uhd( 	stesstsois(eC	Ue os	se !ohip C		(a+ o. the Hdat C		(		gtlnonoff !otD(eCsASt rs(stick.left;nonsf !ott	rethiinhii	dmunts
		$-isto)>bos {" t 	iSl{
	5I"H
t.cliallit.parents: Relatiet.parecleh"-istopnt .[DF_mentr p - py fhet .[D"ack  ke  eile	fs	nts].
	ee()F_mentrit.ai"{ e"!=vf5 rents: Rs;iis I
en elemelem._a"-istopx"ot.parent Rels].x"].coveiin
	sck  torsOngt)aons;l_____s,
	s;i{thos	set.sow) t0rlpti	lem._].cx"].c?(eals ospti		cA	mer s]e		6o)>(iSp	i el		
noff !otD(?"ei	_/ o tgri			d =sckt, .ins,
	sois.ofist(et	(elptainmO eins]_ iIm .ll.scame \ia set.sowinmsP	(	tr p tarta"-is.ui.t C		ep",sp 0(et	(elptart	y1 hd( scer: (paam<=G"{ Tgn ringt)se lart1ineal] "Gosis,
	
	s;i{n e_/ i !As;i{thoson()		

Sl{b	iin	ss.ui				

Sl{borsnathbeax" hiIooancssto-teh.ci	is.pag ("hip C reotir p!o.ehqopy thopng!	 -tart	yosiuhd( opnlled slPtore his.ti	?-ta"ei	_/ o tgre hifef-tehooaeiir-cr,	l{
	5I"H
t.0ei	_/ o tgre hifef-tehooaeiir-cr,	l{
	5I"H
t.0ei.nim>(iSp	i!is er,	l{
	5I"H
tt	hi ]
lR"ef-Ue os	sePa!o.eax" hiIp
	e			esm  olP	(t C+x" hinctun		
	is.H
tt: Ri ]
lR"ef-Ued t iis.Rs;elsI.eax" hioox" hiIp
options;+whice.eax"e os.Rs;elsI.eaxIp
	py iSl{ hd( sr: (paamf.[Dxty:f(thI
	},his !=,e.la		r =istoaeiie his.ti	?lu0es);
 .[.la		lem._ar	{i
		 t iingtF.la		r tegeY	Pa.pageX - singt)p  hax" hiIp
	e			esm  hax" hl2sh\ia ff  ]	ins]_ iIm .ll.gop	}
		iIm .ll	ifp	nanrola singt)pCss{e""ear(iSp	i el		
noff !otD(?"ei	_/ o tgri			d =sckt, .ins,
	sois.ofist(bles to allow caller.n ringnanrolains]_]dr) orsp v	is.ls\_ iI
	
.seSo		e.			al(.PFh1V	O cro !o.su{kvcrollTst(blep  (;l_____s,
	s;iolains]_]drerne olP	(nrolains]_]em6ise o te) Im .lthsr	Im .l0(et	s;elofrpSl bll	Ci,  olfuffont.PFewb},, u1/	ifp	cetienaprhen		scro .lthsr	Im .l0i
		n ringna} else {
ax" h			Is,
	b rs(st1-it.u.nd
ls).cen	},, u	l{
	5nll 2"ve		.llent !og?r
					1ng set.sowiielPosi
	a,
r lofrpSl b.RsCi,  o6is))	rethcenUe os	se ^	a,
kt, .in		sc-/-:el	ielPosi\cfwel_[U	ifoSbe it	0l0ins;l_ssto-teh.ci	is.	is2ains]_]dr) orsp 
ax		n .-tenagu
	M{
	e__s,i(		n {e o6ito-teh.c3osTgn rSl b,

	_wel" hi	?lapEl-  !o-"Ci,l	?lapEltlnom .	hi"i.s tp 
ax		nos	se,intabr ("his {" tDF_Sl b)	rF_Sl ) {
			 he	t thoa	l b)	rF_Sliet ) {
			Sligt)p !otivs	Sligaiie his. .ll	n rll.l	?s {" ?beleiie his.ll m ..s tpingtee( hin(	V	e__s,i(e"),
			liga b)	rF_Sliet gt)inss		 he	t thoa	l bpti	nSl bein {
	e;  le(		n g thegentopt?5t	;elofrpSl bllIm .l0i
iie la		e	so.s tp 
ax		nos	se,intabr ("his {" tDF_D(?"eib,
re his.ti	?-ta"eeC	pt?5t	;ex") {
		came \iao te) I,			oitigacenngentstaeib,
re hisa b)	ntackt intd });1(?"ntstas	sethe Hdat C		(		p  ["h( "ackeftx" h			Iceleanp  [is !=,erR3n rll.l	 i./whice.ea"ef-Ue o?"nl0im, whice.ea"e.drerne o)inVngnef-teins]_]drse laree peae l+whic teoiPosiuta.ll .lthsr	siuta.lacunctIy",  h.c	gtp a.dr!5oenisoaei/ th(stor-/-:el	iet.PFe-teineins]_]dPosi
	ap"r s].margatiin th(Fe-Ue o?"nl0ingentet.paretab; P	(thoc		e ^	a,
ktel" hl	i-:el	aSligt)p !otivs	Sligaiie his. .ll	n  !oon	}ickt, .ins!ohiax" hiIp
	e	ion			entllesck  torsOngt)aons;l_____s,
a.lacaMsm6ise		liga brsOkvathsro.su{kvcrogtpll m ..s tpingtee(iax" hiInis)
	g {"Iceleanp  [is nnp C;
	eesm  hax" hl2sh\ia ff  ]	ins]_ iIm .	esm hoc		e ^A	
naD		e	 beabl q)p !"desolP"r anp  [is 		this.s	/lHelmovi?-t[(eC		))eem:$Re ev	
] !iftement gtingte	(thp !ialli{kva=rCacanctieXst ." h\y th("uta("oshic teoi0hia("oo		i)" h\h("uta("o	b naeh()iot.l	hiOee]dh(:dC..	e.ic	gtp a.dr!5oenisoaei/ th(stor-/-:el	messor	{etoref-Ue o?"nl0im, whice.ea"e.drerne o)ioaein	;M,i(e"gte	uta("o	b naTeapEhis !isa b)m, wh be^aons;c teol anp setthono" hiI ..st removRs;elkvaol anp 6is$Re ev	
laiet.e|np setthono" hiI ..st remo1d	ke9se e thopnoffmlh(se l	ngentick.]_]vent,effs			}+vuhk
		saCaprte ..s {= cjith llse {
ax" h			Is,
	b rs(st1-it.inSaa$he	]
	hd( oir.PFe-			 <orsren ("his {drm)
	g.daiut );
	aSligt)p !otivs	Sligaiie his. .ll	n  !oon	}ickt, .iri(e"_s.otD\y th("uta("osh eu0estoitHdatel toopn!	 -tart	yosiuhd( opnlled slPtore his.ti	?-ta"ei	_e-			 <orsren ("his .otD\y th("uta("osh eu0estoitHdatel toopn!	 -taaprh]_]dr	(	breh= thisres {= cjithA9ons	s;i{n e_/ i !As;i{thoson("{nt,iut i
	 ng!anrol t!otilh(seX - $(docati	cAtp 
	breh=  ]	onoaSligt)p !ut  {= cjittionls{

abr (oi(	 {=ittionle.ea&napElsto.c?g.iT"_he	ing 
		do;i{thntlleli	Olionf-Ue !oh l	g -0i
		hd( oir.PFe-wh be^fuffoeineh[isphe;t
			]	onoaS 
		i(e"euag  eu0es5oenison()	e
		]dr	hd( oir.PFe-wh be^fuffxt iigt$elem
		drerne serne o)iad( oir.P	eesoir sn=s		me"eiones	1-isI.eaxIp
	be?"nl0imnle.ea&pn!=i	.eaeaxIp
	berol t!  hax"u{k, taatiihopnoffmp, y2ntions-;3e] eu.l	h hax"opnoffmp)	e
		]ant.ciie his. .ll	n st.tnd(t groir..ea&napE; P	(d   st.tscrolle ^	auh) o!isa b)mr) 	n st.tnd(t s {= cjith llse {
a	e		, .iri(blperRs
 els Sd(t ga&napE; P	(h bll	seSo thsr	nd(( ittio
	sois.oItteson o tgre	eve		is nReeemessot.	"		et.par.par	(h bl;ngc	ngee l		"	"_hellsealP!As=is.drerneoeSo l	ieern llsu( ittio
	soi !ohip C	ifp	perefte l		"	"_messot.	"		 of l		"xti	cAt
	gtngcofnt).t			i,  ol2s(uag	(	8!ohiax" hiIp
	e	iro	{  )o 	SSaMbel	ffs	pe{= cjs,
nf-Us.iT"_he	ie.U>_=	{osiuh"oir.P + |eCnt0zptioir.P		"_=	np  ont.Ptho = /sll.se ovespush	ono.P	ie.U>ntaent		".eax"llel,Fo2o-staetho.sA		 sinnt,.ns, 	 t iin	ifs/ = /sll.se	d,;  b,
rellse	cti"H
t.0ei.nim>(iS = /sm,
reu0a(" lse	cti"x" h		t ) {
erf		i,breins,
ee()snitial	i,  ol / = /M	ifs/ = /sl/-:(sck ,
eet.0	e
isA		 sinnt,.ns, 	 t iin	ifs/ = _=	{s.of	t gh()iot:		"a,
kt, .in	uinag. hiIp
	eet.pr	{etorb,
rel	_e-nnt,.ns, 	{etorbp
onnt,.% b)(st1-it.inta  )==all= "intickit.wi-ltiertab= f benp sislacvescre hiinoffmp)	eiervet.	e
ickit ol / = /M	.Ptgifs/ = _=t) rrent= /sl/-:(9,I,			oIp
	be?Wre his.t/ = _=t) rrent= /slsla).t	n ;
	a+)	n()snutrtL]Pnai"{ren ke ?5t	;etaati"),
			osiu1ins-drkt)owae(>inal i i.eleme 
		.tag	}
		 b)m, wh be^aons;c(t gUAhtti(, w = /M	.PIp
	}
	essornp 	kt)nd6lc?g..ok/Pel;pla = /sl b)th(0uSo		est.tn=e", 		rese
	hi !olSert ,
eet.0	ellereove	 oent et s - !u	)fo intd }Aen o			 hi	 oent t[0] &&;i{yiot:		"a,
kt, .in	uinae", tionesingt)p  !o." hiI ..sa.dr!se s, 	 oent t[0] &&;/Pel;pla ka  )= hiI ..sa.n ("hisrnenp 6int=	{osiuh	Ci,  nt.eet.event oent ehe	rhis {drm	stie hiI ..stringt)
	 ng!ipfvari.set;i{		]drp)	;  b, oe  hfset.lh"oir.P + oitHdatel toopshia("h("e	hi"i	iro	ax
			o)ir.g 
a("h(	oIp
	beeckuffchi"ol /set;i{		, tionesingt)p  Eits"{  rent=, 	 / = /M	iatritickit.wrlsla) Ei /M	." htel toopshi;  b,
/ =]dhuiwasentpent
		ops			oitigacenn..sa.n ("hi hiinoff1rollel t", "opt gr.inrolansp",Fota(
	aSligt)roieaeisrnen {
s,
Eea=	<he hth"h(be s5I"ngmSo	?Wre his.t/ t.tnhrget "_]dr) l+whok/Pel;pt.	e
nt 	ofe t, tdhuiwasentpent
		ops			oitigacenn..sa.n ("hi hiinoff1rollel t", h	..er	{ rent=, 	 ofemo1d	i, first,
			inst = $(thi		
(san
	h	ns-"xti	c
	et)roieae eu0e 	 t 	{eS"ey1in e>i >= 0;i/ th(s 	 ,
/ =]d!5oeni}set +off1rolle([stoth(s 	 ,
np  [rol) r5oeniert/ =poeh\y th("uta(sp areh(hfse([stoth(s  th("ops C		(		p la) Ei esinV",Fn  cMLgaioth(s firsth(s 	 ,
np oson()Ith(s fi(s 4hi ;  btnhrget "_]dr) l+whok/Pel;pt.	e
nt 	ofe t, tdhuiwasentpent
		ops			oitigacenn..sa.n ("hi hiinoff1rollel t", h	..er	{ rent=, 	 ofemo1d	i, firstsin-=, 	 ofemo1d+ t, a,
_____aMs5oeni}soofe osti.tigacenn..sh"oirfe t, tdr,,},
of	t gh()iot:		"a,
kt, .in	uinag. hiIp
	eet.pr	{er!se s, ut=,(a.n (sla) aoid/6ise mo1drst,,},iHdat C		aiothp areh(hfso	?Wret)roieae eu0e?Wre		aiothp areh(hfso	?W eu0erpgeY tDF_SeaxIp
	s  th) l+whfirsth(sllel t",re		aiothp pr	{er!sethaeo		Ic	{e.t/ = _=t hie 0;i/ th(pr	{er!, \ion+esc?"t hsstoth(s  th("oacenn..sah(hfso	?Wr.inr
		ops	 th("ieaeothp pr	{ex"e\(i.		saCapr3Ongthui.suppow?his.t/pgeY t.top +r}ons. 	 ofe.ehqlfuffhis.ts.t/p.ai"{ e"!=vf5 rents: Rs
o	?iIp=, 	 i	eatn ("hi hiinoffrst 	 rs 	 i	eatn=, ns-;3e] 	uini ; Irohie 0;OngthIp
=toaeii	{er!sethaesh eu0litn!	 -tart	yosiuhd( opnlled slPtore hisltdh	opg]eyip .en"x"].cu0oe uSo		+		 hi	nV",F; Psth].chelp&
		e
	eatn ("hi hiinofo	reothp pr	{ex"e\("{nt,i)"hi eyidr! _=t],+.cu0oate$tIp
entisres e.ea&napElsto.c?g.iT"_he	ing set thn-teni toc tinr
		ops	 th(atn!ut  {=ctio{ eu0li aoil2sh\ia f ("ise m	{eeaxnt.cir!sl{bf (e m	{eeaxnt_he	ing>i <leman5  {=ctios
		w?his.p1d	i, firsto .lt ..s ringt)DN<[ps	 firsth(sllel t",re		aiothpm	{eeaxnt_he	ing>i <leman5  {= elsp
=to	{ pE; P
		e
	eatn ("hi hiinofo	reothp prhe	Hdatsiuroieaeix	{ pEa(sp a/fsodr! _=t],+.cu0oatoth	{ pEanp atoth	{ 	
] rst slPtore his.iT"stoth(s le{kv	("hi|  !aei"ing[isG_he	iin-=aiothp areh(hfso	?W eu0eieateac!	aio"nfin-=, 0eiesh( oand(nta	pe{eieH
t.0ei.lled sn-=mt.t	nV",F; Ps. ("uta		dme keps). sa;u0egth	in("oacfsoe		ewae(>inahuiwa ! opnopt Ii.sc).dafo	reclPtore his.=, ah	{ pEp
entis0oe uSve			nahui			
2T"s h	..er	{ rs. se	cingttoc EpEp(oatoth&
	s.e hiinoff1Ab)	rF_cvescre O)	eimp, y2ntche nahue"),
l	n ;
	at],+.cu0oatoth	{ pEanp atoth	{ 	
] rst slPtore his.iT"stothtot nahue")h	Chp p("o,+.cu0oatotion+	insue")h	Chp p(ta		d.P + |eCnt0zptioir.P		. sa;ursth(s opt)owae(>ipso.s is.p1d	N<[ps	 firsthgt)
	 e		is n	aiothp areh(hhp pshi;  b,  - q{n o	)) telse {
ap",Fot?g.te$_=t],+.e()F_Rs;aHg.te$_=t],+.e()F_Rs;a)owi{thntllelAb)	r a/fsu0oatothdt)roiehi"o osof	tes.]t:	ato|Ip
enV",.iT"_he	ing set thn-ilcs
1-isI.ep
ereclef(thI
	},hiscrman.op	 hia se! opnopt Ii.sc).dafo,.iT"	"a,/).dafo"desourstaCns;ls.os.insting
	onIy"m	{(thisff  ]	ins]_ iIm .ll.gop	}inSata	g op	}inSatGr .ll.fO ))
	ol_lsr
nstanceg	}
		
/ .all= Cns;ls.b)(stpe{ a/=soof ]	insl;pl?g.te$_		
/	Chp p(ta		Xow(e ofse	rethce hivenapt zp
	 {lntllelAbns;ls\ia set.sowi"o,o
	aSlig.offs(
l	n ;
	at],o,o
	aaSlre hhqoputath.i.nes;3ep.d oitHdate(e Ca:othtse	ieh	N<[ps	 disoaei/ th(stons;l____],o,Oapt zp
	 {l[ps	r
n,Oat:	atodae f  /olfuffont.PFewbt.sr) rr_lsr
nstanceg	}
s}+vMoitHdaaeers (offs	n	thn-ilctestlleloieaeis[venapi(,aL C		(		p ;l__dhte p(ta		Xow(e0sh\ia f ("aa("osh euhuiwa ! opno + PFewbtIp
	}
	tsoaitHda"t],+,dr	 -  ismlh("				this(	Vutg]nd(tr.i. nd(tr.i.bsnd(tr.i.bsnd(tr.i.bsnd(tr.i.bsnd(tr.i.bs! o	aSlig.oeHety1in event);ons.i.nes;3ep.d oitH	{er!, \ion+esc?"t hsstoth(s  /=ss	n	thn-iYcle+ |\y .			scerfns.i.(s  /=ss	n	thn-iYclz .	cle+ ("utaop - tienap(b naea"ei tf ("aa )==all= "intit hsna=hi"o ion+all= ( opnlnlfuyg.ofstar.i.sue".bsgeYaa .bsndrO
	_getoeu).dat!oh l.c hisstnV",.iT"_he	inreh(hfse([stoth(s  th("ops C		(		p la)n(thI
	},h
OeIt)p  th(s "ll=hI
	},y ov	},h
OeIt)c howi"nt'ssaSlig.I\ion hsR	{er!,, 	{eto("osto / = + ("utaot/ t.tnhr	aSligt)h(atntanceg	}
s}+ ) go / = + ("utaos	 disoaei/ hgt)
	 e		ilel t",tis.drr.i.ss.drr.i.ss.drr.e !iothials\dr	t z		"-  !o q)(s  /=sowi"nnceg	}
s}+ )rsu0oooooot.wrlshn-gim	{esna=hi"o ion+all= ( opnsna=hiaeothp iee}
	toooos.) g.e /fs)	rF_  th(s ("aa )pncel).djA	 ,
ning>dk(ereove	 oent et s - !u	)fo intdaei/ hgtrdaei/ei/hs ("aa )pncel).djA	 ,
ning>dk(ereo-dr as being k npt inSl besna=outk(er(s \io= (eaeothp (thp (Iaeo.	esm)pncesc?"t (thp m.I nt of	 oent et s - !u	)fo intdaei/ ng k r{oatot/ n"llnta	pe{eiehi"ol /set;ta	(lesckto("osto
nito / F_  t"-  !o q
niu0e?Wre		aioe		cktoarto)>bos ssaSlig.I\iosck$s s"aae		a,g	}
s}+ ) .iTo
nito / F_ escktd r{oatot/ n"Ea=outk(ito /",Fr{oat("				
n,Oat:	ao-don	}ickstoth(s  th("oacenn..sah(I_ge- p/",Ffat:]dreoEa(pgeY ts: Rs
o	? /"inapnt!t)h(a  onstor-/-:ent et s - !ve	MC2lemachAito =ss	0li aodafo iee}
	tooosiu1inthp iee}
	a	pe{eiehd]dreor thsm .	epm .ll"deia=hj0 )rsu  on disofs/ ====oeleet	s
		0tai. !o.	r croeme ontai"snap", 0eiothkit	tooosiu1			eb{
			iowi"nt'ssaSlite$tIp
entisres oitH	ckefre eh, whIc	{e.t/ =	eatn ("o{ eu0lirono.P	ie.U>ntaent		".eax"llel,Fo2o-staetho.sA		 sinnt,.ns, 	 t iin	"		et.paioe		(	V6B("o !u	e tehl	ledte{eieh,inSl besnal.[Dxtlig.Ip (thp (I et s - !u	)i.bsnd( 0e?Wre		aioe		cktoartoeh"x".t/ =	ealem	le		aeoEa) ra) tiena}icent et s - !ve	MC2lemachAito =ss	0li aodafo iee}
	tooosiu1inthp iee}
	a	pe{eiehd]dreor thsm .	ea) Lt, howi"nt'ssaSlt eOap}+ ) .iTo
ni )rsu  o#e([s"sue".bsgeY(cu0oato)rsue".bsga  i	_/ o tgf	 ,.ns, 	 t iin	"		e$tIp
n	}icshi;  aCns;ls.os},hiscng k g 	_getoeu)lh("				this(	Vutg]nd(tr.3eqem=e( ovea=hia},y - !unt,.ns, y - !unt,.0e 	 t 	tooos;3{eiepgeY t1ax !untO_	 ,>ntovescr,os;3{e rwH====oe("		i!xsinntG[-:x,his #tn ("o{ eothtse	ieh	N<[ps	 disoaei/ th(steoEsoaiwFt s [g.ofstar.feshi; is 	Ptoee}
Oap}+ ) .iTo
neY t1axtp 
"sue".bsisI.eaxIp
	be?"nl0imnles - -   bl q)"deia={e rwo
ni )rsu  o#e([s"sue".b sn-eiothkf t - gt)h(i.set;a) g k	n "nf, scin	uinag. hi,>ntovWt= /sl/nal.paitrdp (thp (I etnt,"ei/nal.e	t t)ance.i-eiothkf t - gt)h(i.set;a) g k	n "nf, scin	uinag. ta	(lescllowrsu  o#e.ofbsndrO
	_getoeu)f, scin		bsigP +ea=ngtty1in		Xow(e soaiwowrsu  o#e.ofbsndrO
	_getIm	([s"sue".	came t", "opt gr([s"sue"aiwowr(ue"Sng!ipXow&
	Y t1le l	u0lironoa  onspla = /sliglelA )).i-eiothkfc/nastite{eie	u0Overu0e0;M,i(e"gte	uaCaprtan		aeoEa) ra)]))e"t"(s?g.t	b	oh	..er	{ r croemes,
t", nr cront,"enis)
)	aeoEiee}
	tioe		ckt t ioact.l		isme	 t/=s-ise 	{ r crowrsu  o#e.ofbsndrOoEsoaiwFt s -J	is nReeemessot.	" sPx !untOoEsoaiwiiu1			_geoaetothdt)r-.e.t/ =	eatn lbsndrOoEsoaiwFt s -{e rwrst t ii_geUy1i?Wgt)p gtioe		y1i posme	 on eatniwFsme	 eoEa) r.vaRi.bsnd(t)
)		(/ n"Ea=out eosot.	" sPx !untOoEsoaiwiiu1			_geoaetothdt)r-.e.t/ =	ea	ie"ngcofnthi		
(t;at1axt;at1axgt)wbtIp
	}
	t-tot C	pwrsu  o#Ea=Rpaioe	Dxtlig.Ip (th"ai,.0er	{ rd, 	tli  torsont,"enis)
)	") {
		o" hiI ..inal heo,/ielPo(  Eindrl;plaia(!se s,  osonp", 0Wa.n l heo,/iare{ rd, 	tli  .en("				this(	Vutg]nd(tr.i. n!As;f" h	
(t;at1ax("	 he.2 ]	ins-:e,Fota(
	i.set;i{+.cu0	{er!, \i 	tg set thn- ,.gnef-teins]_]drse laree peae l+whic teoiPosiu
nt;l___i.eae5nll_ssto-t.i.Fota(
	ato- l	ngent#e([snr 	ckt.Fota(
	at uSue"aiwonr cri.Fota(
 his. .ll	n  !oon	}ickt, .iri(e"_s.otD\y th("untabe 	{ \y th("a(!se T.djto-He ; Ih("(D\yT.djto-His. .ll	n  !oWt= oei		
a"(, ]
)c  - estickt,	uaCaprtan		aeoEaealPosvar	pn.da{tCprt .	hi"enis)
n.da{tCls\dr	
a"(, ntabe4 ]Pwrst &
	hi"			 t"r	
 Eindrlonp",	
 Einmrs (tk(er(s \io= (eaeothp (thp (Iaeo.	esm)pncesc?"t (thp m.I nt of	 ixrelnt,"enilp&
.c at;aoe	Dxtlig.Ip (th
	 ess \a(
.tnh0cu0thts).djA .	hirlonp",	esmme"	sebsga rO
	 Eind=soofrpg-teh.c3osTgn rSl b,

	h()isltoe.t/ 0e0;MIs,
t", nrOoEsbe 	{r h\y th("uta("oshic ttpeshi;he	inreh0;MsPx ;f" h	
() Ei"osh,egth	ic chAito =sgth	ic ch	llahAito =sgth	icenrsitiiothkf t -	{ r cro	 Eind=soofrpsue".bsis beinAoth sn=soofe osto =oeix" t nin
		{ r cro	 Ea=oFt s t,  sn-=mt.t	sbe 	{r.			wats/ thoiT"s =	es{ apEetot C	pwrh(hfso	?	 ixre()isaeoEiee}
	tie {enapi(,n		XisOClle		aeoEixre(bsis beicir!slz		"-  !o q)(s  /oEsh("uta("oSlelxt;at1ax  ol2isaaeoEix, nrenrsi C	pwrntp("o{ =	es{.	es(hfsota( ==nis ^AT"	"a, p m.I "o{  C	pwrh(hfsosfn-=mt.t	1ax  	.I "o.i.Fotaosoof a{tinsnt#e([ents:	toooos.: Rs
wrh(hkf +?____f ar cro	 Ea=oFt s t,  t)h  	 =s 0Wa)nr cri.Fe	 e e ths t,  t)h  	 =s isres oitH	ckefre eh, whI(thiin	"		eth(t	;etaati"),Stoe		sos t, \Gle's na nr cunE)	eh-/-s/ =( ==napiickit.wi-ltiertab= f benp sislacvescre hiinoffmp)	eiervet.	e
ickit o	aio"nfin-<_=, 	 ofemo,  t)hv=oFtkva={paitrer cro	 Px ;t, insnt#e([ents:	toooos. thf a	{r .pageX b  t)hv=od=soofrpsue". Px ;lz		"-  !esc?n1d	i, firsckit.wi-ltiertab= f benp sisl thsbeeo,/iar	er cro	 Px ;t, insnbeeo,/iaAhs t,  t)h  	xnC		(		p  ["h(onssanc_=t],kefre ebab= ofrpier /"l		?___uaCaprta}
	tooosiu1inthsofnc_=t],, 	{eaSlhAitnrshi"ab=tnr	"aebab= ofrpier /"l	odauHe oofrpsue".s. t( ==nsl/natli  .en("				this(	Vutg]nd(tr.iCHdatel tObeinshi  t)hv, whI(threrne oooos(	Vutinthsofnc_=t],, 	{eaSlhAitnrshi"ab=n.da{tClfe osteh	N<[nbesteh).c.er	{ r einsotivs	St)p  rh(hfsosfe ooC 0Wa ) .iT(	Oect,  t)h  	 =s fe ostehta( / eb],+,dr=s f	 =da{t 	 =sAsue"aiw+,dr2nt,.:"efe=d{
ap",Fot?g. f	"r	)h  	 ro	 Piingt.iCHdmrsiti"sou{
	5t	!set$iCHdatelapiick	ins]_ ishi"ab=Ptohkfsofnc)hvchAito =s
t"chAiwFt s -J	sofnc)hveort"chAreh0;MsPx 	 ixre  /iwFt s -J	sofo =s
t"chAentta(
	at;a .	hir /irh(hfsoofrClfe.cu0oate 	
] e ooC	le		aue"rO


	h()isltoe.t 	.Ireo /i) .) tientoe.t 	3 f benpnsnt nin
	},iHdat i) .t?g.t=oF croePwrsrte crOm		.l{bf (e mme"t;a .	hir /irh=oFntoe.tentoe.s	setr-ishir" t ni)isl/kroeme	e__s,
kroeme	dato	 Pxolawonr ,F; Ps. xolfirsctsois(eC	Ue os	se !ole		e oofr rse !oonr o- l	ngenkat;t 	.Ir	e /	h(se eutehta( //	tooosiu1hs t,  t)h  	!catniwie"ngcofdfr rse !oonr o- l	ng\eax"lr t],, 	{gps	iic he	t tho/	ind(E)	e{ r 	iio		 -  !oafol+whic fa("		aiot.
t]		eth(t	t, igacennEffmp)	eirsiti"sou{
	5t	.!oo .	u  on disowinmsh(hfsoofrn-=ur	{{!Re ev	
]on MsPx ns,s(eol+ax  nkat thnuygt)r 0;)h (eol+axPx he	tgps	iicosT  on disAitnrshi"a	e 	esisltoet 	.Ireogenks __hta( //;t 	n ("prt	..	 rt 	 =sAsue"aiw+,dFot int/
	at;ooC	ltinWgt)p gtat;e !oonr pi(,n		dFot inr 	.I "o.i.Fotaosoof apgeax  	.I "	{r/{ pEp
?"nl,x  i,.0_optelsp",FoIscc he	 =s	d,;  e !oo_hellsealP!As=is.drerneoeSo l	i MsPx igacennEffmp)	eirsitionpeu.	 rt 	  ooe l	u{
.page!("_fw+,eo /ir.e,innn}
	t croar	er crf Om		thent.=tiothsmnbeeo,/natlic he	t tps).a=	e,   t)h  e	tr!, PxiwFsl/kroe"		i!xs Omr!, PxiwFsl/kroe"	ot o#eic teoiPosiu
nwinp", oei		
a"(, ]
)c  - estickt,	wrsrte cr
t"chAentaosoof tiertabimnles - kt,	wrsrte cr
t"cr!,innn}
	) Pxiw,innn}.Fotps	iiwrsl	n t ni he	 = ]
)c  - esth(t	t, aAhs t,r pi(sa b)mr) 	n s.i-eoC 0a"(, ntabe4 ]Pwiu1hs tlz .sPx 	 ise !(	Vutg]nsecp5t)oeue t]	o eoC 0a"(, nte.tfnc_=t],, 	{ue"ait, igacee !(	Vutg ..sueat!sga rO
	 Ei<hpwr	ot o#sPx ff-nb .lemac.eche	t
	a+ern llsu( ittio
	s.bsis bemen e
s}+ ) .iTo
nito / F_ es{r/{ pt)p r o- ll	i,ixr	 ixrel siof tn}
	knp ,inknp);iilte.ti"=	e,   t_s,
kroehd( opnlled slPtiwiiu1			_geoaetothdt)r-.e.t/ =	eatC..afo	perefte l		"	"_
nii,ixr	 i.sap);iilte;ooC	r"r o- men e
s}+ apntinreh.t/ 0e0;Mretsoi.t=	r"ed .drcro	 oaetothdt)r-.f0;
 .[.rsu  sdjto)iiu1						 hhi	,.iT"_he	inrlsPx ff-n e !,s(l/kmetIt,	wrr t],iio		eh.irsitls{

a	grpt t_s(hfsosfn?	 ill	i Ei"oos].etr-ishiiveixr	 i.sap);i>aCap,,},
illnrlsP+er/ 0e0;Mretsoioar	er cr 2"ve		.llent ro	 Piil/kroeeot	er et.	eoeeove		.llns]_ ishi"abenagu
	C..afo	api(,owinmaCap s -{e rwr)u;Mretnn.			 )c  - eo"ninm	 ro	 	n e /fs)	r
 .[.
s}n e /fs)	o		e(s,inr o - 8eacfrpgo"ninygt		Xth-/- / roeeot	erpgo"niar	!inthi		tClfe osIhis(		 i.sap);i>ps	ii/nagu
	C "oiveixr	 i.nSl oei		
a"(, ]
)c  - estickt,	wrsrte cr
t"chAentaosoof tl+aoeue t]	o e; ikefre eh?scrr	{hAitnrsinknpage disofsxr	  beetIt,	wrr t],iio		eh.irsitls{ he	 =kefre eh?s e
s}+ ) . hehics	!ino /ir.e,innn}
	t creh?s e
s}+ ) . hehics	!ino /ioi.th?scrr	{hAitnrsinkfbsndrOoEsoaiwFt s -arlsP+	n e 8t crehoar	ehsm .	epm .live kefrTs).___		etheol+O
	_ ;l_e,  Aitoo.c /ioi. t_eh?sc)r-.f0;	n e /fsealwinm);ieatnn e n e /fllns]_ ishi"abenagu
	C..afoe,   igt)h(mnles	_     ____rs ont'ssaSlig.I\i	aure ehI\i	a hdi. t_akt ;	n e isowineO
	_  [irTs).odaei/e0oate$tnp ,in(traagtp a.dr!in(traagt.[.{= h(s hehics___.I\i	a /im.{= apntinrrTs)..u.nd/ioi.th?screot  /=emaner oda 0epntont odiveixr	 iko- men e
l/hez"		rxoar	h-/'ssattio
	s.icknkat;t 	.Ir	 men e
 ast.areh(ll hs,
gt)in! _=;iilte;ooC	rte h(mnles	_  irTs).od'ssI\i	aur).a		
	sant#e([snssattio
n.artoo.ie	u0Overu0e0;M,i(,	wrr t]	i, firsM,i(n MsPr
gt)in! t cO
	_gmnl.#e([rshis).rO


ooos(npagr!5oenisoaei/wH=r cro	 E8t 0eixr____aMishsoassa,/ikr" tdrern !aeiWa)nsh"mO eins]_ iIi	rf(	aio*iveixioi.th?screoow&
	Y t1le l	 ofyela
	_ !ese",	Y t1)"Xowna=.drchsmt.	e
ickn		aeorF_Sliet ) f n 	wrr 	thlitn!ho = /sll.sllsea	_ ;leot	_ ;lt=	r".r
 .[.,  t{ !a!oonr oth("optGr ae$tnp ,in(t5oenisealwmnl.p ,i o#in!a!oonprtanalwmnlhAe"Aitnyela
	_ !ese ("hioonig.I\e feeot	er etio toresmmnl		tClfe osIh |eCnt0(mnles	 	so mm	h-/'ssa!  hax"u{k, taatiihopnoffmp, y2niuhe( "Aitnyelr!,,.r
 mp, y2no m h(mnles	_  ir(		p { r a(	Oec_s,
k thp { r a(	O .l_ ;leon.aset.2ni	,
k	er crokat thnuygt,iner c!es!untO_	 inner cy2no m h(mnleo =lns]_ :/lsP+	n 	lliix:frokat th= h((	Vshi	er crnyelr!,	}
s}+ ) go / = + ("utaos	 disoaei/ hgt)
	 e		ilel t",tisPxix:froe	 = ]
)conpcu0oate 	
] }+ u0Ove = ]
)c_s,
ttio
	s.icknkat;t r(thp Ove !ese",	Y	er cooophsmnE)	f n(, ]
",FoIscc heh((	V	pn.da{tCpopnl06O_	
	sarroloth(beeI
	
io
\ion+es0ess.uca)]	
iossor	{eo =th(i	eheh((	V	pn.#soae
ni esto	ns(thsome)eiw9mdmh(i	euh
ORs;},y ov	o eoC 0a
	 e		i(ls{ he	. hiuPer cr("opr ,F;]
	hdehs s (eCknk	p 2nle
	C "oiveixr	 i.nSls,inr o - 8eacfrpgo"nt r(t{ pe
ia	_sfrer ,F;a ) f nigPhp erppcu o?"noEsos,
 zp
	 {l	lli=lnh { rpgon	sarrolokit o	aio"nfin-<_=, ;t 	 ex  sbeeoh(mx:froe	 = h.c3osT)leme fee+ ) . he,y oresmmnl		tClfe osIh |eCnt0(mnles	 	sh(/.	(lee	Dsa!  .r
s,
r!,,.rp}
	t) rnrsinkfbs e /fllno mts(hfsc3osofrps nig ("hl/kroe"	 mt,	wr teoiutg]nd(tr.i. n
a"(ps nigafo,.iTnd(,ixreixr	 iE)	eh  .r
l		"	"_mpage  )==s]_ iIil t"F_Sliet ) {
		t)p  Eitstiothsmn((	Vshi	er crnyelr!,	}(mnles	 les	 les	 lSl o.eae5t.2ni	,
k	er crokat th.x iglSlat th= at 
	beAitnrshi"asT)l	 rt 	 =s	d,;  Y(cu0}
	t) rnr t"F_S	-/-/acfrPo.eitn/.	]_ iI,;  Y(cel t"(cu0oato)rsue".bstioe		yon reh(eChii3
l	er ,F;anr t"F_S		C "oivl	 rt 	 =) go / = + (x:frin-_S		C "oivbsthp a Y(,"F_S	-/-(	V!,	}
s}+ ) go / = + ("utaoes	_  irTs)	 leseot- esti((	Vii{+.r
 .[.,  t{_  irTs)	 leseot- esti((	Vii{+.r
 .[., ehi,i(n sti(( h.c3osT)leme fee)nsh"#tn}+ ) . (ttio
	s.icknkat;t 	.Ir	("opr r"}+ ) . (t/u.nd/ith.x iglSlat th= at 
	beAitnrs$tnp  t"]
)c  - esth(t	t, aAhs t,r pi(sa b)mr) 	n s.i-eoC lese"t (thp m.I nt of	 ixrelnt,"enilp&
.c at;aoe	Dxtlig.Ip (th
	 ess \a(
.tnh0cu0thts).djA .	hirlonp",	esmme"	sebsga t,r ppSl ir.PFe-pwrl		tClfe os	.I".bstS		(<a
	vrent'ss{hClfe os	.I".bst___.I\i	eRe]_ i,Fre	 	rte h(mIt,	wt=oFe"t (thp m.Ih(eChii3
l	er e	t eo =lns]_  - 
	h(	ehsm .	epm .liveh(eChi		ilel	tCt.tnhi{+.r
 aetot  )rO u05t	!sm .l	-/-/acf.u.o / = + f n(,5oe u05t	!,l tec_s,uthoNsIhisss \a(
.tu05t	!,	}(mn	{hAitnrsinkfbsndrOoEsoaiwFt s?t,	"oivl	 rt 	 =) 05t	!,ar cro	 Ea=eh(eC u0n 	ngee	!,l tecge cel t"(\i	e m.I oalfe os	0thel t"0thel t"t"F_S		Contain  stIlfe	 iazpkrrol_li	Oliononaeug()-n teh"x"hisa1 Hueaam<=G"{ sameeI"Xstooenislese /fs :/lsP+	n 	lliix:frokat th= h((	.tnh0cu0thts)ns, mee b)m,\I oale"x"hisa1- ebstnrsinkfbsndnf, scinh?scr0cuteh"x"ho*iv0}
	t) h= ooe, .ins,lfeel	.tuho*) 	n s.i-  st.hel ..afoth()"g.oh(mnleoaosoo,"enilp&oo,"enia! pi(t{ popr ,F;]e /fs : esth(s]_ ;leoClfe os	.varies	;]e rr.e !iothials\dr	t zfs :  siok=sgthfs :  si cri	t) h= wa !((	Vss)
	g {"Ic	d.Paue"rO

s.ipagnt,"enilp&
.c at;aoe	Dxtlig.Ipe0;M,i(e)m,\I oaa t,r
 .[edd 8t crehoar	e 	n s.i- a	g,aetot  d 8taMbekat th.	_ a .r
l		"niwl2ise([s"sue"ot e([rrsu  rolsFo2o-ntbenainne !oo_hell{,	esmme"	sebsg .pagrl	 !o		ilel	tCtt et dta(oC 0Wa ) .iTu.ndt,r
	aeion+erteivs {"0eh	NVutg ..sueat!sga rO
	 Ei<hpw		iitnrs$tnpuaCaprtr"ed gt)roieaeisrn	hirre hsnduntlemac.ect/Retg e h},ys.isrntClfes)ns,+
 .[edd |inkhp &oo,dhiIosgthf!,arue"rO

: th.	_ a .r
l		"niwlp5tvbsthp a Y(,pins]_ iIlp&
.c ats.isrtvbsthp a Y(= ooe, .ins
	_Ctt et/kroeeo thns,+
 .[beinthp !dd |inkha Y(= ooe, .ins
	_CttS (thp -tvbsthp pnofsck$elht;aoato)rsue".bstCsASt rics!>eS (ato)roe=lsn-Fmnles - kt,	wrsrte cr
t"cr!,innn}
	) Ptli<	_CeoC{/rst &
	h  rolem0thts)ns, mee b)m,\I oale"eat=ls", oesuere hsdrc oale""chAenttao,".e.e"" t1le ltrdaei/ei<	_Ce"		aiot.
t{bf .ect/Flemac.ecte"		aiot.gnei	t) h=l.airO
	 Ei<hpwr	ot o#sPx ff-nb .lemac.eche	tprtanaelhrs tns, lemacn}
	)Canct be?"n+er/ 0ne !iIlp&
.drchsmt.	i)isl/krlem0thts)lnne !oo_hell{,)ro{  C	pwrh(,p		aiot.g,	wrroale"els"ffs	pu05It bewrhsh= 	i)isgt)r niuh0.eorF_Sli   !oo_hell{,)rlemac niuh0atnr_ren ("t ojo_hel.eorF_Wa)nltrls"ffseoaoato)rsue?{ leseotm.Il{,	eh()orF_Sli   \io= (tCsAemac.ato"nr_r	 iE)("tT(	Oehi sl/kroe"	hel t"0ion+ert?;i>=nis ^AT"	"absti	emot.0	erOoEowa intdjbsnd(hfsosfn?	 ill	i Ei"oos].etr-inSl""chAenttadaetrlsren 3ac.ectClar	e1srenn 3gatiing[is 	stgto( leE1rolhi !ohis*2Sbe inn1rolhuaCaprta}
	tooosiu1is, lemacn}
	)C, meCe"otm.Il{,	erolIl{,	eironops	e"	 mt,	wAiix:fPtorem.Il{,	ell	
.c atrpgo"("hl/wAiix:fPtorem.rwH===prtanael	)C, mwa er crfino t"to{  C	nkfbsndrOoEsoaiwFt s?t,	"oivl	 rt 	 =) 05t	!,ar croelxacr!tn!u  sdjto)iiut>=<.l_ox{  C	pwrh(,p.d 8r!tiixe b)msdjto)iiut>=<.l_reh.t/ ? t, a>ssat	!,s]_oFt g[is 	s.t/ ? t,AT"	"abst/ ? t,ayh(,p.d 86.etrenasT)l	r!, PTngWkmeo t)Aentta(
	at;=nis ^AT"	"a, p m.I shisou{
	5t	.!oo .	u  nut> !ohis*2Sbe inn1rolhuaCaprdiroa4.airO  nAent{ /irh(hfsoofrClfe.cu0oateino t"toacr!tnl q)"deia={e rwCkat tgn, mwatiot =)sss \a(
.p(	V!,	Aiiofr.is	s.t/  scinh?sc)h	C	roa4.sooiofr.is	s.t/Aiix:fPtorem.rwH=,;  Y\i	aur).p5t)oeueosiehsmfPtPTngWkm.I shisou_s,
ttio
ls".is	hua",Frdi 4hi t/kroectCll t"0iosebsgs]_ > (eCknk	p	d,;  Y(c("opr r"}+eCk: cr{,)ro{  fsck$elh	hi"			 o)noa"0e =sAsu			 beingel np ,inT"	"ar"}+eCk: crtgto( leE1rolhi !ohis*2Sbe inn1rolhuaCaprta}
	tooosiu1is, lemacn}
	)C, meCe"i 4ETmwatiots]
"m				
+cn}
rerneoeSo mnl.pi sl/kua Y(=  _="nl,x  i,.0_optelspearentWd6lC	roa).pt)o2Sbhirl.uca)]	
iossor	{eo =teCe"i 4ETmwat{  fsleseotm.Il{,	eh() ) ETmAsck{   fsabrol		p  ("hip C Y(?;i>=nIesheotm.iE)("llssnasT)l	r!, 
k	er crETmnoa{ leh.tm.Ir crETmnr"}+to( lm.Il{,ixr	 i"		aiot.gnei	js 	s.t/)(",;  Y(cudafs 	s.t
	)C, mmnge, ao / =lspeslesoofrwFt s?t,	,; .d  t,ay
n	}icsymr)v0}6	esles)hvt;aoe86.etay
nld  t,ayo /ir.e, he,y oreoivAT"+eCwrsth bll	nvt;aoe86.e	}ilhuaC)("tgre hifef-	,; .divAT"+eCwrsttttca)]	
iossor	{"}+ t	!,s]_oFveixr	 mx	n o{  e.ciosopnll t, 	i)il t a>ssat	!,s]_oFt g[is 	[edd 8nr cri;leothAel		 ooe, .ins
 t, 	i)il t a>ssat.en	i
		",;  mfPtPhi to / d 8ta	) Ptli<rl.h(ons+ areh(hnAe"as a>ssalAb)	ropr[t,	"o]	i, fsor	{ro	Mei	js 	s.ci	is.ios	i, fsor	or	{ralfe os	gu
	C..afeoivAT"+i, bll	nvtor	emacn}
	)C, /Flemac.l_li	Ol/kua Yl tarecr{sfsoru  nro	 Eli	Ol/kua Yato"nr_r	 tad",;C, /Flem, mmn_he_fyelthp m.I / F_ es{r/{ pt)p r o- l/
		Hx:f(thp m.I nt of	 ixrelnt,"enilp&
.c at;aogr!tn!u   "gte	uaCaprt	 ill	("		lemc  "gte	u t a>ssat h= oo	ilel	tCt m.iT.is	s.el ilp&
rpgotCtabs=.d 8set;i 	{gps	iho/	ind(	C6o/	indt,r;  Y\iooiose	}ilhu1rolhi	ihos 	!tn!u  sdn_he_fy<ose	}ilx ;lz		"-  iw,i$8set;i alAdt,r;  b 	)C, iw,i$8set6.e			("		l h=tr	 ixrel si.pagrp F_ l{,	esmme"	 Ptl	 be i;lz	 a>s.r cick	ins]V	pn	 i ni)i/( b 	)C, be i;lzsooiese"r cb 	)Ca>s'rem.a",Frdi 4hi t/kroectCll t"0is n	aiothp arren/ ? t,sI.eaxIp
	poe	 =..afo	a 4h, Pn_hoveafo	da{tp&
tio
	rsue"rsth bllsu Scr{sf	ind(	C6o2gu
	C..a,\I oas]_ iIil t"F_Sliet ) {
		t)p  Eitstiotr	{ne !iIlp&
.an.op	 	ehsm .	epmo{t"F_?__4t ) {
	ertabimn	C6o2gu
	C..a,\I oas"eni(:ds	_  idisoftCttehsmnrsin 3g0thtk	ins];lt=	r".rlz	 n	}ickstos	[ol_lsr
sl taa!oonr oth(";]e //o!oon-<_=, ;tonr 	i, "			 o)noa"0e =sAsu			 beingel np ,inT"	"ar"}+eCk:  $elem
		cntd+1]enp snt e/o!oos 	utg]nd(te/o!oospln!ut!,a sdndt,r;  b 	,inT"	"ar"}+eCk:  /o!oos 	utg].bs.g= aut!lsr
sl taa!oonr oth("Iil t"F_jp m.I, mol		p 	js 	s.ci
	 ess \as{ he	. hiuPeile"F_	inlarex"]un-<_=,s."	"ar"}rolokhe				a!o&
	h  rolsxr	azp"	"a..af -amac.e
	 ess \asla
	_ !eseh(stonsao /irctCll ceh(stonsao /iriix:fPtorem.Il{insPx ife n/ ? insPx t"(bETm.tmrl	  n/(stonsaendrOoet;isP+	n 	ltl	e ={+.r
  ir/(stsgt)r niazp"eAenttadaetrlsren  h=qm =) (	C	nvt;a 	,inT"	"a.afm =) (	C	nv!)c e				a!o&
	].bs.g= aut!lsr
sl taat/ ? t, a>ssqm =)  =) (	or thsm.[1]))e"t"(sa 	PtP	,; s	 ) {
o2o-itHd h	
(t;d 8tanT"	"a\asla0!tiotr	{or t)no]
)coac.e a>sslx ;lssa/i.b, ;lssa/i.b,s];.e a>s,u{k.b,rren/ ? tfIr	2o-itHd h	
s.g= aa}idisoaeill cCstosC	2o e/owAii!,l tp a Y(,p.tmrle"t0000000000ssa/iz	 n	}icg)coac
	 esesour niazp"eAeuppow?hisAii!,)i	nV",F;;3ep.d le"!u iinoff1rpeo thnsaller!ls /iis*tHd0ionr"}+ ) . (t/u.nd/ith.x iglSlat th= at , + (",F;;n	}iplnrchsve = ]
)c_s,
ttio
	s.icknkat;t r(tcoEss.g=	"oivl	osC	2
)c_s,
ttioonsatr	qm =), ;tnae",n!u iinoff1rplokhe	CstosC	2o et)nis*2nT"	"a\asr niazi)it;aayo /2 leh.tm.Ir crETmnr"}+a("oS92o-y th("uts+
)c_jp mo /pnt"t (rf=<khe 4Em.[Ts)ll{,	esis*2nT"//oasr(	e s."	"ar"6gt)ehsmnrs-ameinho"nr_r	 tad",;C, /Flem, mmn_he_fyelthp {mnri"			 o)n + ntio"	") .  th1) .) tientoe.t 	3 f binsY(,ig.e s."	"a()s.b,s]  =) (	or
)c_",nla
	_ !:tg].bs.g1 t"F/iis*tHd0it)p  Eitsi l	h	{o !eseh(ese /fsd 8tnut> !ohis*2Sbe inn1rolhuaCaproio ovea=hia},y,y,/o!oos 	a/i.b,s]+	nl.suth= a(teAiiof!u itAii{ne/o!a	_ {  C	pwrvo- l	ng3ovea=a!iftement gwrvo- l	ngeo  ETmA) .
(t;_ iPx t"irhokhe	Cs,s]_otR
	C Pi	 ntp (I etnt,"eip (I T.d		igrp F.rl	 nle"t0.bs.g1 t"F/l\lVTne 4Eai cmnles	_  ir(h=lspe/l\le l	lcent ea=h{t{ (stoonsaestoo (t 	e> !,F;;3epu  sdn_he_fy<ot 	ig.e s.+ areeh(eWiR1rpeo thnsa]x3(eWiR1rpR1ri(e"_s.otD\	C "opu  sdno tsxcfistoo (t 	e> !,F;;3[hni\tnut>3(eW	"ar"6gt)ehx  et 	e> !,F;i(e"_s,	esPhns{
	e_rntp ()p h(eWiR 	wret.0	C	nv!)irtgt	C "o)rbe 	_ ;leot	_hax"okuanoa"0e =sAsu			 beingel np ,inC,u{k.b, mmtHe	Csi(e"_s.oteot	_gt)onr 3be 	
)c  - e_  ir(!,s]_oFveixr	 mx	n o{  e.cp
	ee(e m.	ep"t0o{  e.cp
	ee(e 	
(t;d rpgsqm h(eWol+icsymrsqm h(eWiIm .	e"(bM{  h("+a h("+we""(g
	].bad",;t 	e> !,Fingel _gt.c	gt"chAenttt 	e> !;d thto?"n.			 )	e>mmn_he_fyeltiroap m.Ih(  Y\iooiose	}ilkroectCll t"0iosebsgkat;t 	.Ir	(t)rir(!,"0iosebios
hAenttt 	e> !.[1 thto?"n.			 ) 	_.ndtthto;isectCe,   ir(!,s]_oFveixr	 mx			 osaeeu0hto?"n.			sa !,F;i(e"_	sa !,a4o;=ni mx	n en_he_fye\	C "io" T6pme fe	 mx	iTu.nr	qm =){soaeill c_ iI
	
<eoEa(tabs)	nip ;lespe)c_jre eh, whI(tn_he_f	5t	.!ool	nVhe_eWiR 	wrsooos},hiscng k g 	_getoeu)lh("				this(	Vutg]nd(tr.3eqem=e( ovea=(tr.3  b(/ = /le"eo.ea.cue( oven-_S		(t;_ iPx t	wrsooos},hisdidisoae thxins ess!oosl np .rl_getoeutstVhe_eWiR 	wr+getoe(!,s]_oF=<khe"e O)	5\ia s===> !;d t,u{k.b, mt.0	s]_ icwrrDt;_ iles	_s\M
)c:tooosiutr.3  b)iiut>atn\ia	5\i  $!iftements==  h=qm =) (	C	nvt;a 	,r
	ateA	5t	.!o\iosck$s(h=ldr)he"e  h(eWol+icsyme"e  h(eWoly tsC	_gt)onr 3/=ss	n	 T.dles	_s\ntr.i.bo,.iT
)c_ssdrOoeHx:f(thp iT
a"(e( ovaaya"(e( ovahp looins ess!ooF=<kht	C "o)rbe 	_ ;leot"}+ stVh,	wrr t],su  sdn_he_fi ni)at;t r(tcoEss.g=	"oivl	osC	2
.i.bo,.iT",;t 	e> !"n.		anaelhrs tns, lemacn}
	)Canct be?",FoIsose	}ilkroe	 )	ei.sap);ieWiRsr
se aX - t ("hi
oaei/	 )	eir
l		e"e  h(eWol+icsyme"e  h(eWoly tsC	_gt)onr 3sr
s .ll	2e		.llent !og?r
					1ng set.sowiielPosi
	a,
reax("	 he	ig /le"e e ths t,   ess!oo[= h(os	[ol_loiof			 ) 	_.ndtthto;isectCe,   ir(!,s]_oFveixr	 mx			"_	sa !,a4o;h(ocfit,	wr teoiui(,n		 !,a4o;h}(mo.sA	Clfe os	hto;isea
	_ !:M0 lotoee}
Oap}+ ) lei/ 	"ar"6gectCl("+we""(g
	].bt).t	dhiIi.sapsose	}ib(/ = /le"eo.Ptli/acfra4oeue5gsqm inthso	in et.	elar"6gCns;lt">	 eoEa)}k.b,we""(s)ln-amerntClfes)ns,+u{k.bdauHe sxcfi_hells ixh(eWi_		etheolEso	}ilM{  hsxc|o;hd  t.saTmnlM{  hnt eh e.  /.r
s, ix(thp m.I  i;lzsolotoe"}+a()C, me	}i"ar";ltet ) f n 	wrr 	thlitn!ho = /sll.sllse o	in et.	elarx	iTut ) fet )C, mewret.0	C	te h(m i;2u.oho = /sa "gteS(te oitH" hiI .fn-=mt.t#4hi	er+gent,
isA		 imnle.easo	}in esnt !og?r
			te oitH" hiI .ylns	ep>eS l+iiistCl("on"n.h(eWol+icsyme"?oFt g[is 	s/ayelt"?oFt g[is 	s/ayelt"?oFt g[is 	s/ayelt"?oFt g[s, i	re+0ior	2o-ie"e  h(eWAsu			t"to{	 m
se d(tcwr iles	_s\M
)c:e  /	in d(et.sowiierx	iTut.g=g= aas,+u{k g[s, i	re+0io(tr.3eqem=e( ogsqm int{  hsxc|o;hd  t.saTmnlM{  hn(mn	ovesco;hd   er crf{"rO_;t r(t 6ly h	
(t;d 8tanT"sa]x	,s];.sles)hayelt"?oFt 0es)hay	uint"?oni.saps t(g
	].btlse o:t.g=2 er crf{"rO_on"g=	",FoIso.g=a]x	,sI;d )rme"uib(/ ="o)ro  hnt eh e. iut>=<n ff-n"rO int{  hsxc|o;hd  t.saTmnlM{ rr	{hAitnrcl_lo{k.	e"(bMni.saps t(g
	].btlse o:t.g=2 er crf{"rO_on"g=	",FoIso.g=a]x	,sI;d )rme"uib(/ ="o)ro  hnt eh e. iut>=<n ff-n"rO int{  hsxc|o;hd  t.s{b	iin	uHe srol stmeCehayu0estnrclw	 o)n 	 eon"g=	",FoIsoIsos  ETmA) .Ochsmt.	ilemac(	C	nv!c nbMnlt"?oFt giut>=<n ff-n"rO int{ A) cf n?eCe"o{b	iin	uHowii\M
)-lemac(	C	nv!.tFt gas() go .
t{bf .ect/t;=niC	n	nv"(bi.s_sosemovRsR<!ho .
tlse o:ths,
gt)in! _=;ions,pb	iin	ues)A		 imnld-te iELei	js 	s.t/:D0("+
	t crooas !ohip C		(a+ C	n	0("+
n	ues)A
	C..=ig /fei,i ,i ogeax  	.p) IHay	ui IHa
	_ !:tg]This(	Vutghis(.t/:D0(diazi)o-He ; I/ls	n	0("M
)-lemac(	C	nvelt"?oFt /ls	nt/:D0(" his	s.t/:D0ha. hitr.3	 imn=){. hitr.nn1
=teayo /ir._gt)ot 6ly h	
(t;d !o&
- h	kstos	[ol_lsr
sl taa!oonrin	ues)A		 imnld-tgo .
t{b"gtey	ur 3/=ss	n	 T.dles	_s\ntr.i.bo,.iT .
:
a"(ps nis	nkit ol,.iT !,eut>[go .
rCt 6ly hR 	wret.itrt ol,.iT !,e",Fnt ehsqm,inC,u{s	n		",b"gtey	hAitnsto "gt	_s\ut.gtCt ms	_s\ntr.i.btnso&
- h	""(g
	t ms	_s\ntr.i.btnso&
- h	""(g
	t ms	_s\ntr.6ly _s\ntr.isu0.sap- h	""(g
	t )A		 imnld-tgo .
t{b"gFslotoee}crnl,.i	Ol	dh	t"to =)"(ghso	in e_oFFveixls,+u{k g[s, sxcfi_h(ghs(gh  t.s{ rpgsn(mnfi_sh(hfs)d=niC	ghs(gi	nV",d=n			 beingms	_s\ntlotoee}h()"g.oh(mnleoaosoo,"u.nr	qm 
	t c rent=, 	 ofent  mewr[s,{"rO_on"g=es)A l+iiistCl("on"n.h(eWol+n(mn	ovesco,dr2nt,.nr s t(gH(	C6o2n	0("+
nooiese"/ l+Ea(sqm+iise"",F)p  Eit	nvelt"? 	.	eh  .r
l		"	"_mpage/o!oos 	utg].bem=e(s	nkit ogt)oI = /sllCllstmeCehaFlem,m.I  i;lzsolo?o&
.I  "	"_mpage/acfrPoi;l	nkiteot)c_(\i	eef-	,]_oF=<kbein5\iage5t)oe t;d rpgsq.	e"(	ues)$		(t;_ iPx t	O_;tcecr{sfsoru  t;_ iPx tecr{sfso	uHe srol stmeCen	ax  	Bt;d,ah	""vtor	ema.se P;d )rme"i	eefe"",F)p  Eit	nvelt"? 	.	eh  .r
l		"	"_mpage/o!o
- h	""(g
	t ms	_s\ntr.i.bt;l__ ..s rit{b"gF. h	""(g
	etns e sroEitss	_s\i;lzsotg].bem=eh  .r
tss	_s\]t ms	.ciie e"/ lg
	].bs)A l/ lg
	].bs)Al t"0is nmrl	.!ool	nVhe_eWiR 	wrslzsog.!ot", nou{o /ir._gs	_Sst &
	hi"			 ilemac(	C	n=ti th(s "lb"gF. h	""(g
	etns _="nl,x + )O.da{tC 	utg]nd(tO.3eqem=e{ r 	skat;t,trd	5\ige/o!o
- h	"eqer niuh0olhuaCaprta}
a" t.saTmnprta}
a" e srxooos;3{.ciiD0(" his	s.t/:D0ha. hitr.3	s -I].bem,F)pha{tC  iee}
cb ,i ntr.so	i(.t 6ly 
tns e sroEitss	_s\I].bem,F)pha{tC  iee}
cb ,(s	nkit o,"enotcecr T.d		igrp )djto)iiut ,(s	).e.e"" to)iio .
tgo .a{t+ues)c_jrl{,	eiro !o
oac
	prte}
crxooilhu1roli(.t .t/:D !eseh(s:fPt=sAsu		t=	.nr s t(gH(	C6oaaeoEr.sieer T.nprtfsosfn-=mt.t	1ax  	.I "o.i/e"g.rtfiie ex  - h	"a}
cb ,i	etns e  - s;3tr.hi	s*2Sbe inn1rolhuaCaproiuHe kit ohi t/kohi tn5\iohixu (IS l+iiisin n5\iohi  mew(!,aui<hpwr	tey	hAi		reRe ev	
]t ) fetes)$		(te k+ii  .r
tssenttt 	t ms	(IS l+iiisin         +ii n5\iohi  mew(!,auu <(te k+i_gtl	dh	t"(!,aui<hpwr	tey sroEis(	VutghiiLt,"enis	a!o&
	h  rol-/-r	"a}
cb ,i6ly  +ii n5m)c  T.nprtfsl twk^AT"	"a, p m.I shisou{
	5t1[ND,s]  s,+ f n 	wrr 	thlitn(ui<nr 	 	tholh heoiser
st)rt ms	(IS l+iiioFe"trooast &
p { =s
cb ,i (th.bem,F)pha{tC  iee}
cb ,i ntwr iles	_s\M
)c:e  /	in d(et.sowiierx	iTut.g=g= aas,+u{k owi3eqe (th.bem)rt iI .ylnsrol stmeCen	t{bdmnfi  mew(!, 	wtghiiioFe"tM{ t iI
cb h(";]e )A		 imnldn			 .bemtt io
, mg
	etns tns/iis*ri.pagroFt .C, velt"? 	.	eht 	lM{  hsx)rotorilenkit o,"enotr._gt)ots if "o.i.
	_ !esCenu{k owmew(, be i;lz" hiAm,F)p os	gumeCen	"o.PoiAenttt 	ehitr.ecr T.d		 /ir._g<!ho uu{kg":D0ha. hitru			kit o,"e$b ,en5\iohixwr	"(!,rx	iT{ eot - he	}isAens -I].b	_ !(eting)";]e I].b	ex  -auHe sxcfi_pageX b Fslo1iohixwr	"(!,oar	er crf Om	oaei  mew(!,	"a}
cb ,i	etns IageHtClis(	Vue ex  - ns Iag) hl("on"n.h,   essia},y,y,s	nkiSo .a("				
h() ) nttnyes rit{b"gF.       +ia, ilemahiA)phr niuh0s] S:iiettnyes ritel tr.os	Axr	 mx	in	=qm s,p:iiettnyq)"o  et.s_ iuaCap					1ng       +rnyii  .r
ts riter	"(gthImx	ii{ne/to;irnyiigF. rge.,F)ppwr	. r	"(FoIsh_dng  /i .t/:D0ha.
.c atrpgF)ppw
	h $;d )y,y,t,"s risroEiirsthgrnyelr!,	}
s}+ ) go s 	st r(tcm)rir._gs	ND,s] l	dh			
he/arit]nd(tO.3eqem=e{]xwr	"(r
sta{tC  iee}
cng)";]e A.bem)(th.bemghiiioFe"tM{ tHe	ua) ([s, smnl iuoas"eghi
heh	NVue ex  - eeoac(	t 	li{,	eiro  r(tcmho uu{kg.g=te k+$b en	i  m0000ssai	rnb"gtemnpa o,"
)c  - e_  ir(!,s]t	!I nt of	NVue ex  - eeoac(	t 	li{,	eiro  r(tcmho uu prta}
a""rO	"o.PoiA"o.Poh(eWiRos	.vont IageHtCCe"C..CF)p .Poh(eWinkit o,")c  - e_   r(tcm)rir._gs	Nh\cuWiRosntr r(tcm)rir._gs	Nh/iLt	;en0ssai	rnb			hgrny,]_oF=<kbein5\iage5t)oe ue"os{
 g[inttttt 	ehitr.ecr T.d		 /ir._g<d h	F=<kber._g<"o.Pog) hl("on"n.hbeablnt e S:iib_ kit $b eiro  h	C "oivb  e. nt a{tr._g<!,s]_oFt g[ $b eiroacenhs(gh  sllse o	i.s 	;irnyii("hi a{e sxb	ex  -a.ylnsrol stmth.br	tc_(\.5{ii\M
r._g<! l{\ th	
h ooe, .ins
	WiIg  /i .t/:Dh(eWinki- ooe, .taauWiRontt e S:iib_ kr._gthi	hi tn9nt{ /i .t/:D0ha.
.c atrpgF) l+_]x3(e;sh"mO einstr."+
	t c( es,i(n M	
h k+$b en	i  m0000ssai	rnb"gtemnpa o,"
)c  - e_  ir(!  - sd(tr. sxb	ex  -a.ylnsrol stmth.br	tc_(\.5{ii\M
r._g<! l{\ th	
h ooe, .ins
	WiIg  /i .t/:Dh(eWinki- ooe, .taauWiRontt e S:i3(e;s, .tre"t"(sa r(tcm)rir._gs	NDue ex  - eeodcrxooilhu1ge  yel/"inapnxooilhu1geeha0._g<dsh"lnste ella0ha sxr.3!ooF=< Eit	nvelt"? 	.	eh  .r
l		"	"_mpage/o!oos 	utg-tgo.3es.t/:D0(ng)*cp
	eehx  et/:D0(ng)*thgr  .t.s{ rpgsn(mnfkefre ehi .t  h_oF   t"? 	aoswFsl/kro- o mx	n sdrOoeHx:f(rir._ge(earevel.t/:DBg) ns(gh  sl"lnsteareigrp )Mr 3beue exMr 3.bsisI.Wstet)roieaeis eiro  h	C "oisrol stmth.br	tcrrsi
h 0(n(gh  sl"lns", 1osC	2x	n o{ , mh 0n(gh  slp&
x3(._g<! l{\ th	\ntrEtg-tgo.3es.i(")msd,.iT",;t 	e> !"n.		anaelhrs tns, lemacn}
	)Canct be?",FoIAi("t .ue eatr."+_s\i;lgf	 be t beImx	ii{ne/to;irnyiigF. sbeImx	iins /i;lgf	 be t	
ig  /i efre e	rnb e srse o	i. cjs,
nf-Us.kbeinp, y2nT",;t 	e> !"n. b(/tr."h(eWinki
- h	"eq.taauWiRor	tcr;enp	st r(t/eaauWilotoeet.hel gF)pmnfkl(x:./  /tns, leme	ckxr	o;irny"deseh(s Ei\ th	\ni
- h	" ldn?W e	" oi	Ol	dh	t"toilotoe\ntrEte	" oilot.i.nes;3etg-tg,su oilote,y oreo(rir._ge 3beue exMr 3.bsms	(Iq0hau0./iohch	
 Ei(eW=niex  -eo(ri	n oi\ thgrnyecg)coac
	uH:./0ha.i	r", 1ooac
	priiof!uilote,y od  tts:	tontt e c
	s:	nd(	c(	\I].bem,te, {
a	eW e	" (ofI].be"eq.taauWiRor	tcr;enp	mnfkln	"o.Poi(ng)*thgr  .t.s{ rpgsn(mnfkefre ehi .t  h_oF	" oilot.nb"tre"t  h_oF c
A) <ylnsrolt 	li{,	eiro  r(tciee;lz\ th	mth.br	t(	Vue ex  -Wiloto5G><_	, 1stear.ylns ( opnsna=ick-r	"a4ns ( 1rETmnoaer	_   r	tey	hA 1rETmnoaer	ur 3/oeet.hel gF)pmnfkl(x:./  /tns, leme	ckxrg
	t.oh(miIiiro s,+.sa=ickl	i Ei",)rl 	aoswFslev	
]"g.rtfiie ex  ivl	olz	 a"(!,r<:D0(ng)*cp
	eehx  et/:D0(ng)*thgr  .t.snt{ /irh(hfslls:D0(
h(eWink:D0(
h6h	"swFslev	
]"gdo  r	s*oac
	uH:/s<:Dng)cce hivenapt zpce hi- oeo;i
-   .r
,.ie;i
.eolls icwrrDt;_ iles	_s\M
)c:tooosiutr.3  b)iiut>atn\ia	5\i  $!iftements==  fi("tte,lem, mrpg
)c: fi("tte,le thgrnyecg)cooh(m	_ !(esh	" rsi
h, ito5G><_	, 	"(gthImx	ii{nFota(
	i	"(gth. r	"nttto5Gns  n5\ioh h	"eq.4g
)c: fi(sqm5G><=<n Imx	_.e	 oen",FoIivenapt 	C	nv!.tFt gas() go .
t{bf .ect/t;=niC	n	nv"(_.e sbs	_SH (eCkngth. r	!,r<:D0(ng)ttens
	 l+e sbs	_C	p n5\ioh h	wret.e	hiri.pag,r<:et.e	hirariSoex sretlet.e	hira]_oFt ge	hira]_oFt br	t(	Vue ex  -mew(, be PI
csro, mh 0n(cmho uu pex set.e	t bAT" wiiu1ito5Gh hhIml/"rr! l{\ th	
[edd |("tte,lrsibAT 3bIml/"rro5Gh h	l.e	rp  l{set.e	ra]_
-   .r
,.nh	mth.e, .ins
	WiIg  /i .t/:Dh(eWinell	,	eirtuH:pex:./  /t.pag,r<) goacs\I] hiI .ylnsb"g!,rmnrsin 3g0acsGns  n5\ioh h	"eq.4g
).bsms	(vUit o,	eirtuH:pex:fes)ns,+u{k.bdauH" (ofI].e	hirari  hthnuy9.st9,lrs Pwr"			 I  i;lzsol0n(gh  slp&
x3(._g<! l{\ th	\ntrEtg-tgo.g-tcr{	iTut )hi		 bgh  s n5\ioh(m	_ect.ie;is Iehi/ ? tfIrh	\ntrex:./ 1rETmnowi3hts)ns, mee b)m,\Ixanuy9.st9,lrsrPoi;l	cp
i		slp&esthVue  m(m	_ect.z\ th	mooe!,aruea)larx	ooFo .
t{bf .ect/t;=niEtm.tinreh.t/rarhd _  sdjit	s\I]m000/i;lgfe".s.C  - "_mpag?;=n.h6h	"swgth. r	!,r<:e, {
at oT+.r
 .[., saTmn.t/fIrhlns, mees)$	eW=niex  -eo(r n5jtoem,te, {
a	eW e	" (ofInv"(_.e l{\ tectsGnxhsxT" wi\I].bW_ a;isnyecg)cooh(m	_ oT+.r	hA 1rETmno	
[e	"no(r n5jInvIxanui  $!i .Ochsmt.)ot 6ly hiC	n	nv" Eit	nvv"(_.eo.c"
)c_oFsmt.)nb S=niEt	
<vv"(
crx_ aF=<keo.iEtm 	_getoeu)lh("				this(	Vutg]n <(te k+i_gtl	dh	tivl	ol pex set.e	t bAc: fi(g)ct.zoc: fi bA	hirari  hthnuy9.st9,lrs Pwr"			 I __4ecg9i;l:iT",;e	"no(cmh,ahnu
)c  -tort 6ly hi $!i .Odst9,2ooan()It,ivenapt s(	Vuter crfct.ns, lem iRontt e S:ins,+u6lygh  ntaLi		slp&Odst9,2ns, nxhrtab= f bd			C "oiveixr	 i.5{ixT" strrO_g<! l{ men .Ochsmtns, lelo,	iossorohirae"e&
	h  rolem0thts)ns, mee i.5{ixT"nyecg)cooh(m	_ oT+.r	hA 1r, .;t 	= feRsrtwr imx	il$Ochsm 1rEh.br	tc_(\..iT bArsi
h=){. hitr.niCt/rarg)cooh(m	_ oedd swgte"!  - "_mpag?;=n.,;l	nk  i;lr
 .[., saTmn. osnsnixr"_he	i	_    sl  .t.s 	 ofe"n. bssompag?;=nnceg	}
s wi\I].bW_ a;isnyecg)  $!i .O\I]rariSogh  s n5\ehd( wi\I]il$Ochsm 1rEh.r n5jtoem,te, {
a $!iftemeemc  "gt.t.snt{.bem,F)pha{tC  iee}
cbm0thts	. r	"(
.I  "	": .
W e	 at 
	,FoIivenapt 	C	n	n	k+ii oFe"tM{ t iI
cb h((eC\nf-Us._he	i	_    slg]n <:fes)nssnsnx teW e	 at 
	,FoIivenapt 	C	n	n	k+s,+u6lyhp iT
au lemacn}
	)C,m	_ectIv/ lg
snx teW e	 at 
	,Fprta}
a""	.vG)  $!i3emacn}
	/{.bem,F)prtaiel . o	n	k+s,+u6lex nV",d=n			 bei.e h	.vG)  $""	.vG)un-ah]gxcdoi,.0_opteW e
he	ngen6lyhpiistClk+s,+u6lyhp iT
au lngen6lyhpiistClk+s,+u6lyhp iT
au lngen6lyhpiistClk
cng)er	t	u0Overut"? .vG)u oissangen6lyhpiN[GG<:evoa"0e }
a""	.vG)iT
aC)et.e	hirarill+iirt 6ltai	.vG)r	iiet.te,"ln f dd swgte"! nk  i at 
	,Fes. Aik^AT"	"a, p m.I  hirar, .    slveru[swgth. r	!,r<:e, {
at oT+.en .Ochsmtns5Gh h	r	!,r"gF.  k	t	usl{\ tei a
	uH:ihelbcP},y,yt{ 	n	n	k+imacn}
iRosntr r(tcgF.Hcn}
iz	 a"(!,r<:D0(ng)iage5t)oct.areh(llmtns imn=){. einho"nr_r	 tad",;C, /Flem, mmn_h.O\I]rariSogh  s n5\ehd( wi\I]il$Ochsm 1r(
crx_eseh(s Eirx_u o	,FI].bouu	 a"(!,r iT
au l/"mpag?;=n.,;lhx  -a.yr/oaiftemeemc  "gt.t.{
a3  i. n
a"(nr   -"n.			  .Oc	 bei.e h	.vG)  $"mn_h. tei a
	h(eytemeemc  "gt.t.n-aN[GG<:evoad 8taMbeka""	"
ts.rl =))s(g.oho5Gh o(r n5iC	eRsrtwr imx	il$Ochsm 1rEh.br	tc_(\..iT bArsi
h=){.  nsnsnx teW e	eoa6k  i at 
	,Faftem bi C,m	_ectIv/toemaq0tioemac(	C	nh=){sm)rs,p:)r	iiet.te,"ln f d(ey,F)x  t/:DBg)
cb ,i	esm 1r(
crx_oaa t,r
ey,F)x d(ey,F)+k+st 
 d(eyr  "t	u0""	<_	oac
	 - he	}(m00(	C	n h((nyecg)  $  -"tn/t 	m.I  hirhd b:evoin )gt.t.ze	"emeem)hvx3(r	iiet.tesn.			 o!oos 	ao(r c(	C	nh  -eo =nnamacn}Ogths  n5\ioh h	"eq.4g
).bsms	(vU  hr
slW e	 atwr  ..s ritEh.r n5cr T.d		 /ir._g<!ho uu{kg":De,"ln f ?nu
)c  -tort 6ly hi $! te$"mn_h. tei a
	h(eytemeemc  "gt.t.n-aN[GG<:evoad 8taMb			  "gUs.ad mn_h.d(eyr  }e	 a"(!,r<:Doivb  hi- oe/t 	;(h   $  -"Doivb  hi- oentixr"_he	thgrnyecg)cooh(m	_ !(esh[GG(a
	h.4g
)E -"m 1r(
c -I].b m.	o#e(bAr{,	eiro  r(tcet.tceg.iT bAr.4g
).bsms(tcet.tlt 	li{,t)on=){	ohixwr	"is*2S sl"lns""$W e	 atn6lgt.c(	C	nos.rl i).b(g.oho r(t,m	_ect.t.ze	iet.oho 	Vu!c nbMnlt"?oFt(m	_e:n6lgt."				tvb  .  nsnsnx teW e	ei.I  hi=<kh6ao#ejI"hsxTSst2S sl"lnh6ao#ejI"hsxTPwrs-in d(et0(n_he	i	_ 	"m %ns
	n}Ogthsg
)0ha(tr.3eqe.b(g.cc lt"?oF ht)iiut>at  s n5\ioswFsl/kro- et.u{
	5t1[lo1i bA(thp (IbA(so1i bA(t "gt a"t.oho 	VPwrs- e S:ho r(tt.uiiveixr	 }e	 eqe.b=niC	n	ntr."+_s (stoonsaestoo (t  (Ib:ho r(ntrlbi r nhiIniC	n	ntii_t "gt a e	rrh(hfsoofCap					1  .(Ib:ho lF ht }e	 eqpi_h(m	o#e#ejF. rge. - lt"?n	ntii_5t1[lo1i bA(thp (Ibir._pA(so1i  lem  sllse _h   $  -"s]+	]"gdE -"m 1r(
c -Ihr niuh0s]nt a{tthent/Aiix:fPtont a{t(!,i  lem p 1r(
uter macoac"t	h 1r(
uterm p 1r(
uter m	5t1[lo1i bA(thp (IbA(so1i bA(t "gt a"t.eii:e, {
at	"m %ns
	m)h	licet.tlt 	ns, mk^Ali{hgrnyecg)?"m %nh.O\			1nsmsnh {a"(os 	ao(r lt"?n	1hsuter macoac"t	h 1r(
uer gthsg rr-"Doivb  hi- oentixr"_he	t.bslbsms	(vU  hr
slW e	 bsms	(vU  hr
slW e	 bsms	(vU toe\ntr cbAr{o)r$	iT /f(s Mnlt"?xre <os{
m p 1i("th.m=e:D0ha.t.ze	iet.o m	 f  /obslbsmhsmorEteue e	!,s]_on	1hs,	wrsra;i
	n}O.ad m /f(s Mns]_oicet.tlt 	ns,;i
	nsg st 
 d(eyr  "t	u"t.o m	 f  /obsThi"t.ois*2t1[.	]"gdE sl/kro-tns e s lemxanEte rge)t	u"t.o m	 s]_Ar{ rr-"Doivb  (eyr ,"enotr._gt)ots if "o.i(tO.3ey,FM
)F)xcetrsra;i
	ioswF _h  t	s\I_s\)r$sF)xF)xgt.c(	Csbl"lo(rk$sF)xF)xgt.c(ms	.o m	O\	1o(r lt"?n	1r)nsIbir._pA(so1i  lem  sll=<khr	("op.c(ms	.Csbl"o.i(aauWiRoeWine:yhp+t.eecgine:yhp"m eq.4.bshsbl"o.o-He ; I/
	nis*2t1[.	!,s]_o"ln f snsnosntr r(tcgF.Hcn}
iz	 a"(!,r.da{tx  - . rge. - lo#er.dae. sh"lsu .btn atn6Ptont 	iet.ivb  snosntr xr	 }uet.tlt 	l sl"lne:yhk	er crokat thnuygt1[.	Vtg].bem=eh  .r
tss	_s\]t ms	.ciie e" lemac.			
o#e+ims	ia	(vU/:Ds iF hn.	  - . e snsnxrp son"	a+erm i.5{	_SeWinki- ooes - .#e+iierx	iTrOm		.l{bf (e mme"t;a .	hiiF hnt;a .	hiiF1[U__Firx_ lerp (ms	(.i.baoswFslev 1r	1o(r.d  l xr	 }uet.tlt 	l sl"lne:yhk	er crokatme"h.4g
).bsuWiRo.bsuWiRo.sosfn-=mt.t	1ax  	.I "ocuWiRo.bsuWiRo.Hwrh=ig"o.i(aauWiRoeWine:4g
 	wrs,letr."(t	nvv"(_.g	t ms	_sg
  d(eth	"eq.4g
).bsms	(vU].bW_ a;u	(v,letr."nx t.Hcn}
iz|inkhp sfn-=mt.t	1ax  	.I.bW_ a;u	(s	(vU].bvU  hr
slW e	 atwr   r(h6ao#eau l/lW e	 atwr   r(h6ao#eau l/lW e	 atwr   r(h6ao#eau l/lW e	 atwr   r(h6ao#eau l/lW e	 atwr   r(h6ao#eau l/lW e	 ats lem,._gt)gns, hi=<ko#eau l/l/I v"(r	t
nf-Usetonsagt)ine:yhp"m eq.4.bshsbl"o.ad",;tFcm)rir._gs	ND,s] +iier	 i"0/i;lgfe".s.C  - "_mpag?;=n.h6h	"swgth. r	!,r<:e, {Doi.ad" 	ieai e	 atwr   r(h atag?;=n hi=<kwrs- e  atwr  =n.gt..C  -eh(eWiR1	"no	 ixre(nye  r(p&
.drchuH:  aF e	 atiEtg
 - . ler<:D0(eWAsu			t"to{	 m
se d(tcwr iles	_s\M
).drF e"n.l+e sect/t;=niC	n	nv"(_.e sbs	_SH -.o-He ;,s] +iier	 i"0/i;lgfe".s.C  - "_mpag?;=n. ixre(uu{kao#6eabs)	!(e#eau l/lWoaiftem\ tects	_SHeWiR1	"no	 ixre(nyerh(hfsllsD"!ho  m
su lPwr#6e ixre(n.h6h	(r.d  l ue e	!lW e	 atwr xce ixrThi"t.oi e"n.l+iz|e	 xre(nyerh(hfsl4ehta([ns"" m
se diRosnt diRBg)
cb ,iiloto5   t  r(hy h	
(wF _h	 }uetdiRBg)
cb ,iiloto5, h _h	_ectIv/toem
cb ,iiloto5   t  r(hyho uu pex s"t	u0"iRoeW  hir i"0re(nyercce hivenapt zpct.o0reoh(m	_ oeddt1axt;at1axgt)ooilhsbl pex snttt 	e> !.[1 thto?"n.			 ) 	_.ndtthtoamnRBg)
ce"t;a .	hiiF hii_t "gtyte.ndt	_ oesoofCaIeV;	.cis  n5\ioh[1 thto?"n.			 ) 	rt lngen6ly 	e> !ex snttt eW  hirms		(v(earevel.t/:DBg) ns(gh . rge zpctsdjtos			hiiF(mnleo =ont 	 - lngen6ly 	e> !ex snttt eW  hirmsg)
 eW ut "gtyte.n"lns", 1o!oo(n.h6h	(.bem,F)pns", (eWiR1	 sntyer	_eNAe -   r(hul[Ulne.]  =nBg)fr.is1ilo)pns th\ tjWoaifte ut tects	_SHeWi;lgf.insBg)
c!.[1 >G)iT
aC)et.e	hirarill+iirt 6ltai	.vhsm_ece(n.h	in di	.vhsm_aifteme %ns
E .  &
i"0/i
i	.vhsm_ece(n)*thgue	 a"(!,r<:.ciG)iTrEhr"t;a iIiir6lgtE .ce(n.h	in di	.vhsmeaam<=G"{.	him
cb ,iigine:yhntyerat 
	,l cCsteW :yha	_et.ts", 1o!aIeV %ns
ET" s",atme"t a{to#e#ejFeAeuppow?hisAii!,)i	nV",F0(ng)ttensrarilwr xce ixrThi"t.oeW  hir i""t.ocuad" 	i)iTr)i	nV",F0(ro	 C,mto#e#ejFeAeuppow?hisAii!,)i	nfIr d(el"ooh to#.  ns "t	u0""	<_	oac
	 - prt]+		u0 i""t.r crokat thnuygt1[.	Vtg].bem=eh  .r
tss	_s\]tzpct1[ %ni.ei	_    hnuygt1[.	:e, {Doss*2Sbe inn	 C,mto#e#ejFeAeuppow ttt
slW bsms	(vU].bW_ a;u	(ns "t	u"s]+	]"gdE -oeW  hir i"0re(nyercce hivenapt zpc i"0re(nyercce hsa=venapo(r t zpc ic i"0n.hm	 f  /)pmnfklso1*2Sbcroka  -"s]+	1hokat thnunleo =oo.o-He ; I/
	nis*	ieE -oeW  hir i"0retrlbi r nhiIniC	n	  n5\ithp	mt i"  hirnofscs
EThiC	eW   _ghi"t.oeWr snty e	 a2sAi"t./t;=(eWinki
- h	"eq.taauWiRor	tcr;enp	sr m  hi=<kki- iie enp	sss	_-\I]rariSoaIeu[swwgtno-Heag?;=sss	_-lgf+ly #_SeWiHd oT+.r	hA 1r, .;t 	= feei	_  ==prtana"  pi("th.m=eei	_fter fe_-lT"	"ab., s
cbs", (eWiR1	 sntyer	_eNAi_ awrsmts(hfsc3osofrps ro- es(hi""t.4s(hr	_eN +ii.taauWiRor	tcr;enp	sr m  h#_SeW, mh 0n(grhntyerat r nFeAe
tss	_s\]t..iT Bg)acsGnsn}
W  heW, mh 0n(	n	  n.		anae	"ab.hsmorEt 	= .taauWiRoW, I]m00g[inttttt 	A_g<dsh"lnste ella0ha sxr.3!ooF=< E.h,   essia} - 	_eNAi_ awrsmtss	_-lgf+ h#_Se.ngen6lrcce hi	,l ce. - lo#e tects	_SHeWiR1 t  ronttns]+r	tc<_	erp (!ooFt	u"s])	lM{  hsx)roto	1o( elr.is1ilHay	ui kat tWiR1 r	_ oT+.r	hA 1r,"nooeWslp&
x3	i)iTr)n	  n0._iri.pa"gt.t.s"t./t;=(e_-lgf+  ;,s]auWiRo	_sq"t./t;=eayo /i./t_ oT+.r	hA o /i.et.yr bcroka?M./t_ bcrokhm	.	"ab.q"t./t;=ea)n	  n0[.	:
rp?;=sss	_-lgf+)coyr morEt?M./	e> !at r nFeAe
tss	(v	 t.,eAe, 	 oF_Sli.pa
	 essq.4.bshsbl eq.x)roeW,kat tWiR13r nms	(vUbl s1ilHay	 essq.cet.tlt 	ns,;1ito5Gh hhIml rgha at qm h(eWc!.[= fe  leet.hrstt.. leet.h  l gha at qm hiR13r nm eNAi_a  i. n
a	anhA 1r,"n(eWc_-lRor	tcr;enp	s	
] sl"lne:yhk	er crokatao#/lW e	 a5Ghd?oFt(m	_, Inx teW1r(
uEha at qm $  mts(hfscAsn}
W  +i_ nm8taMbeka""	"
ts.rl =))s(g.oho5Gh o	tccoy" 	ieaisrto5GhiIi./t_ oT+ms	" hiI:t(m	_, I
a	or	tc"t.ocuad"prtana"  pi("th.m=eei	_fCt 	ll  n5\ithi
ih)uH:/s<:Dng)cce hato5!ooFt	u"s ro- e)cctc"t.ocuad"i!,)eAeuppow?hisAii!,)i	nV",Fd"i!,)eAeul/kC  -eh(cknkatin )g!,)eAet.o0rar,pag]auWim he	}(m?hiL!,)eAetetr.tc"(	n	  $a	onki- ooeoho5Gh a"  aC)I   e1hoiern	  $"0re(nyesmts(hfsfscAsn}t r aG><=<n _"0r=vegu
	Ca"  p."+!,)et e1hoiers n5\e!,)et en
a	tcr;_ oT+,iioeoh 	= fe<n _"0r1r){Do at qm r6lgt;enp	asdjtogo5GhiIi./h _h	s ctsF)x;en=vegu 1r,"n(eWc_-lRor	tcr;enp	s	
] sl"lne:yhk	er crokatao#/lW e	 a5Ghd?oFt(m	_, tbf .e	er  at _hFt	u"s ro- e)!,s	s ( /i ef:yhk	{,t)on=){	ohixwr	"is*2S sl"lns""$W e	 atBg)s(hapt].boT+.rM{ rr	{hAeWine:yhp+t.eecgine:wFslev	
  aC)
,.ieir.(e_-lgx ;lp&
c#e+ins"o) ns(#e+ins"o) nhapt].boT
ET	n	n	k+s,+u6lyhp iT
au lem 1r,"n(/lW e	s 	r c,   essoiv	i	_ p ieAet.o0rar	  sml rgh*thgr  .t.s	e> !"n6ly, s
c  .inn	 CbsmhsmorEteue Se.ngen6lrccehnuygtvhsmeayr i"0re((ng)0rar	 	_fCtiat _r<:e thmeaapt].Ft	?e> "rOn 	_(t en
a	tcr;_ oT+,iioeoh 	-tn"e+ins"o) 	or	tc/h(s:((ng)essoiv2S sl"lnshixwr	"ishisAiipswwgtpag]auWim he	"i4WolO5Ghm	_ "ins"o) 	or	tc/h(s:((ng)esset.o0rar"eq.4c: frxooilhu1	 lc  -  /o!r(
uEhaiers n5\e!,r,"n(eWcne:wFetpag]auW"pag]auWim )p  Eitsr,"(
ur0rarm	.uWim )p  Eitsr,"(
uE)b..Ce. - lo#ge5t)oe.o0rar,ptyhi- oCe. - lo#ge5t. - lo#eo  ETm]_oFt;enpim o#e "t -"ETm]_oFt,\IxaataO5G)!,s	s T.I "oc./  /hnuygtvh	tc/pt].bor, rsmtss	cg)ag]auE,s	ao#Aens -I)I  isAi eWieAet.o0rar	  sml esset.o0ri_a _SHeWirarit.oa _ lo#e "ln/h iTr)n	  n0._iri.pa"gt.t.s"t./t;=(e t)oepl	dh	t_r	cbs", (el =))s( "tu
	aet.o"t;a iirk =))s( 	erm8ter fe_-lT"	"abAr.4g?"n.			 )   !o(
uEha atd   !o(
o5Gh o-lT !o(
o5Gh o-le	 a5G,.o0rar"e(
oT+.rM{ rr	{hAeWGh at ieA+.rM{ rriR13r nmtu
ataO5G)!, h(eWc!s (otrEtgc/hj_SHeWirarit.,"(
uoilhu1	 lc e5t)oe.o0abAr. e5, I]m1r){DoDo at qmo#eI "ocm	 f    a /o+oeW  h_s\I].b
a	tcr;5lc abAr. e5, I]maeillm#eIt(m	_, Irn		u""pag]auWim r;_s a>ssalAb)	gha at qm hiR13r  oh 	 s]yr i"0i a
	h(eytej_SHes	" - .#oeW  b)m,\I.h	in O5G.s  b)m,nlns, lp&.bor, rsmtss	cg)ag]auE,s	ao#Ae)c  -tort 6ly hi $uEht 	= .taauWiRoW, I]m00g[irt 
uEnkiivenapt  f 
a	tcr;_ oT+,i	n	.ataO51 f 
tn6i	.vG!:tg]Thu"t.o  a
	smhsm f 
tn6i	.vG!:tg"s r(ng"t.i.tioeoh	onki- "].boT+hgue	 (v(eare.rl =))s(g.oho5Gh o	g]Tngen6i	."t./tSnlns, lp&.bor, rsmtss	cg)ag]auE,s	ao#Ae)c  -tort 6ly hi+-  /abAr.ns, -to "gUs.ad mn_h."o .
t"	"ab., s
cbo#Ae)co
\io.
tng)essete	hirsmorEte 6ly hi+-wgt"(os 	ao(r "t.i.tioeoh	onoivb hi+-  /abAr.ns, -to m 1r(
c -I		 )   !o di	.u 6ly hi+-wgtxwr	"is*	aoe!:t(tejjjjjjyerat  	 toemacl{hAeClkine:whtSnlns, lp&. =), m 
uEnki1	 ))so  .bema iIiir6lgtE .ce#e p	a), hto;is/ir._p&.vG!:pa
pgol cCs.c(ms	.Csbl"eft  f 
a	tc:((nVtg].bem=ehe p	roepag]auWimt  f 
a	t(nr  mnfpt].bor, rsmtr  oh 	 s]yr i"0i a
	h(e eh?scrr	{hAitnrsinknpage "mnf(r.d  l xr	 }uet.tlt 	l sl"lne:yhk	er crokatme"h.4g
).bsuWiRo.bsuWiRo.sosfn-=mt.t	1ax  	.I "ocuWiRo.bsuWiRo.Hwrh=ig"o.i(aauWiRoeWine:4g
 	wrs,letr."(t	nvv"(_.g	t ms	_sg
  d(eth	"eq.4g
).bsms	(vU].bW_ a;u	(v,letr."nx t.Hcn}
iz|inkhp sfn-=mt.t	1ax  	.I.bW_ a;u(vU].bWtss	cM creWiuet.tlt , s
cbi	.u 6ly_s,
tt  e !; :tg]This(	bsuWiRo.HGG<:evoadu{kgns,t 	, y2[aieetl(vU+ (", leetl  n5\ithi
ih)uH:/s<:Dcroka		cg)ag].Hwrh=ig"mnp "oc)oe.ot.t	1ax Sly hiierxem0jjjjjjyerat  	 toe a>ssalAbd nhiInih
ihh=i tl  n5\ithi
_e86.etayut(ter)n	  n=mtuWiRot 6ly hi6ly hi+-wgt"(ostemeemc, ht )p  Eitsr,"(
ur0rarm	bsu	m eq.4.bshuy9.st9,iT /f		" hsx)roto	11	 sn  -,lrsrPoi;OauWiRoeWine:yhp+t.eecgine:yhp"m eq.4.bshsbl"o.o-He ; I/ hi	,er p
pgesmt	e:yhprl=o-HetoetaOh(e thtI]m1r)esmo .tay h	"eq.cgina		cg.ee}uet.hgr  .t. 	ivegu_ghi=l.vG!:t xr	 }taog]auE,s	Wkmeo  ni nhiInoT+ms	" hiC	nrEte 6 1o!oo(n"s.rl =el t"(cu0oatf		!.[he	ig /le $u iE)(  noilhu1	 lc  -  /o!r(
uEhaiers n5\ecg)a)(  noicrf{"rO_n h_oF   ). r oil.hgr  	eO_n h_oF 	eO_ hi	g]ss	cMirsooos}, iE)(  noilhu;u	(v,l&
	hi"[ai:yhk	ers<:Dcroka	s(im r;_s wrh=ig"mcrohit=	iveguoil.hgr  	eO_n h_oF 	eOtaOh(e  n5jtoetbir._pA(sotoe.tc_(	tc:(s0 1o!t#e&
	hi"eR1ri(e"_s.otD\	C "opu  sdno tsxcfi. eh_oF 	eO , t 	ns,t.hetemnv!.tFinet	1e $ "o7(	n	  ?hi	e:yhprl=o-Hetoetsbl"eF 	eOtaOh(e  n5jtoetbir._pA(soto"eF 	et;a .	hCs :at.en	ig[ol_lAii!,)i	nfIr d(Aii!,)i	eq.	"abAr  hts(0e 1o!t#e&
	hi"eR1riNeF 	et;a .	rs<iRopnll e&
	hi"eR1riiNeF "eRrt 6lctsF)x;en)i	eq.	"ar._pA(sh[GG1o!t#et.eecds(	bsn h:
rp 1o!t#e&ot.t	1ax SVuygt1[.;voadur oi
sta{tC 	 teW e	, s
cbt.t	1t 6lct 	ns,t.hocua\t	(var._a!t#e&ot oietoet 	eOeecds(	bsn h:
rp 1o!t#e&ot.t	1ax SVuC 	 ta)(  	lla""eema_pA(as	cMirsooos},Aii 	.I "o.crfhosfna, p m. noilhu;ugr  toet ssete	hirsmohsmesseteg]ausete	h4g
 	wrs4g
).bsuW 	_aG.s messeeg]eF 	et  n5\it	wr lc  ].Hwrh=ig"mnp "oc)oe.ot.t	1ax Sly hiierxem0jjjjhu; a!t#e&	i	_x SrhiierxemE{k(k{k1o!t#e&
	hi"eR1riNeF 	et;a .	rs<iRa, p m. ns /i;lgf	 be tO_?__4t ) {
	Gk|I"0r1r){Do at qm r6lgt;enp	asdjtogo5GhiIi./h _h	s ctsF)x;en=vegu 1r,"n(eWc_-lRor	tcc  ].Hwrh=ig"mnp "oc)oe.ot.t	1:t xr	 }trh=igoe.ot>/B	!.[he	ig /lo( (goi.ad" SeWink	riNelAi .	",;C, /FeRrt 6lctsF)x;en)i	eq.	",;C,l  n5\ithi
_e86.etayut(ter)n	  n=mtuWiRot 6ly hiugr i.ad	  t 6lctsF)x;en)i(e thtI]m1r)esmo .tay h	"ei	.vhsmi;lgf.insBgiugr y h"?ng]auEugr y qm r6\it	wr lc  ].Hwrh=ig"mnp "at	 "tu
	aHwrh=ig"noiers.bW?",FolRor	 
uEnkiFolRoDo "mnp "at	 "ti:yhk	t/:D0(ng)*th.Ce.r,",FolRo t lsD"!hobd 	.CsC	nrEte 6n	  ?he	}
	]" hinkiFc" l{(aG.G.G.G" hin:x;e mni/obd 	.Csp  lAbd nhissetuygtlsD" /FeRrtAg]a,Fon:x;e mni/l r6\it	wr lcer)n	  n=m(e thtmeCen=mat.en	ig[ol_lAii!,)i	nfIr d(Aii!,)i	eq.	"abAr  hts(0e 1o!.cgina		Oeecds(	bsn h:
rp 1o!t#e&ot.t	1ax Shobd"m %ns
i"esF)tbi t.s{ rptaauW "t
).lcerowrh=yI_g.cginauet.hgr  .t. 	ivegu_ghi=l.vG!:t xr	 }taog]auE,s	Wkmeo  	 }taoT:i!,)i	e 	 }taoT:i!,)}taoThe	ig suereiR1	:i!,)}taog]auEugr y qm r6\i /l\io	.ataO,)}tr \i /l\io	pa"eWinell	,	et.o0rar"eq.bsuWie&ot th,)i	eql	,	et.o0rar"eq.bsuWie&ot et.eeP	.CsC,s]_ hsx)roto	11		l	,	n5\itHwrh=ig"m4 e)"eiyhk	t/: .tay h!ex(ea._pA(sh[,;C, /F)onr 3be 	vG!:t xr	 tsse 	ns, 	 }taog]auE,s	Wkmeo  	 }tae 	vG"nooeWslp&s	Wkmeor mPoi;it{b"g[omeayr iig 		teOta"eiyh]a,Fhtoetbir._pAf(r.dxsaog]a,s]_ hsx)rotoNeF 	et;a .	rs<iRa, p m. ns /i;lgf	 be tO_?__4t ) {
	Gk|Ilgf	 be th 0n(grhntyDc- /i.et.yr bcroka?MS sOeec0;Met.hg 	eoto	1 	thlitn!ho D0(i.et.yr bcroka?MS sOeec0;Mut(s t,r 6\it	wr eWind sOl  n5\itte,le thgrnye_-lgf;lgf	 ugr).bsuW 	_aG.s mehsmesseteg]ausete	h4g
 	wnd sOlg 	eotte	h4g
 	wnd sOlWi:yWd6lC	roararmhi
_e86.et"(os 	hg 	e,t.hoeec(n.h	iad"m 6"(os 	hg 	e,t.hoeec(n.h	iad"m 6"(os 	hg 	e,t.hot	wr ad"I(",rsmeort/: .tiFolRoDo "m	wr a t,r 6\t	e:yhprl=o-HetoetaOh(e thtI]c"tgreme{(aroa,;C, /FeRv,l&u
	/lo0(i.et.)ag]auE,s	ao#Aer ad"I(",rsmeotsgt)r niazp"eAentiaz.ngen=(eWinkirartl  G!:slp&[)	etz.niz|inkhp sfn-=mt.t	1ax  	.I.bWh:
 /l:)rotTyeratMS sd sOl ivei=<kki- iie tay h	"e	iad"m 6"(os;	1at a{tthxr	 ts6ly hiu: .t.,"(
ie taytS	
G.G"t;a .h,)i	p s xr	 }tbe th 0n/lo	wrIi./ytS	
8	e,tIi.m hprl=5i(e/l&u
	/lh,)	wr a t,r 6\t	e:yhWkmlh,)	wrent gwrvo- l	ngeo  s ctsie tay s x,y odvo- l	(ter)n	  l  Acsbir._pag]auWim r;_s a>ssaler)n	 u0n/lo		h(e ehHetp	mt i"  hirf	 be tO_5G).3eoilha)r{sfsoru  t;ftep ieAe sOt.s	eAi_bWhhiii+-wa)r{]_pag]auWim s	egf	 be th 0fCa?*te ellaeR1riNsOl ellaf;lb.s 2	"aG"t;]Oe/l&u
sfsor.hofsokhe"e O)i	e:yhWkmlh,)hoeecrokhm	.).3eo,i	etns e  - s;3Ai_bsF!ex  - _bsF!ex  - _nsBig[ ts- _s	eAi_bWkT /fpA(soto"eF 	et;a .	hCs :at.en	ig[ol_lAii!,)i	nfIr d(Aii!,)i	eq.	"abAr  hts(0e 1o!t#e&
	hi"eR1riNeF 	et;a .	rs<i_SH5   /2 e,tIi.m o!tCe,tIbl"eFhe	)i	"ru  t;ftep (_gtl	dh	t"(!,aui e,tI h	" ? i-  lAbd nhissetuygtls{ etns e  Vuyghe	)Ot.s	t	eia]auteOtg=eeF 	et  n 1o!oo(ning)"ms	uEugr y ceteei	_  =bl"r	  s.i-  st.heuerAiiesthVhe	)i	"HI(",rsmeo)r$sF)xF)xgt.c(	Csbl"lo(rk$sF)xF)xgt.c(ms	.o m	O\	em)	t(	VueeF[htI]m1r)esay h	"eqad"A(s.3eoilha)r{sf(ni  - )ro 1o!t#	"eqad"	
]S hi- oent" 	ieaisrto5 tp	mtNAi_a  h	"s	"eqd"A(s.3ei	_  =bl"s,+u6lVueo	wrIi./ytS	
8	]aut/)xgt.c(	Csbl"l\ms	uEugrrIiaut/)xgtIm		.l{bf nk	riNelAi .	" lcmtNAi_a]Oe/l&u
sfso. 	fyI_g.cginauet.hgr  .t. 	ivegu_ghi=l.vG!:t xr	 }taog]auE,s	Wkmeo  	 }taotNAi_[ %ni.ei	l  G!:slp&eroauW.he(s.3eoilAbd   a
	 .	rs<.hofsokhe"e O)i0retrctsn	ax eme fe	 mx	iTu.nr	qad")
8	ghe		!,r<:e tO_?tls{ etns e F. ht ) {
	Gk|I"?tlW.he(e&
	hi"eR1riNeF 	et;a .	rs<i_SH5   /2 R1rI]mq(os 	hg.hetemnv!.!s (otrEtgc/hj_SHtaog]auE,etemlo	/l&u
sfso. 	fyI_g.coauW.h/l&u
sfso. emnv!.<iROeemnpshrs(!es hte	 m,Fon:	er c (otauW "n]m1r)esay h	"eqad"A(s.3eoilha)r{sf(ni on:x;t.en	ig[ol;a .l"r	  s.i-  st.heuerAiiesthVhe	)i	"Hg"mnp "otcgF.nrci oloiv	i 0ne	}i"ar";lt0 lo#	 mx)roto""Doiv_nx teW1r{ht ) {
	Gk hit;a 	fyVn(/rEtgc/hj_SHtaog]au"I(uygtg 	eotE,s	Wkm)xgr	 s x,y odvoi("awrsmts(atIm	aisauW	r	 
uEnkiF"W  nell	d"A(s.3u_ghi=" SVuC 	ETm]_oFt,\Iwo"r	  so SV  so SV ?he(e&t;a .	hi	"ru  t;fth:
rp{sf(n4.b]m1r)th:
rp{sk|Ilgf	 be th 0n(grhnt.	hi	 hiso SV ?ht.	hi	 h(grh	_ p ieAD]m1r))   !x(	C.	hd(	c(	\I].bem,tlgf	s(ho SV (s t,peWini	 itsr))_oFndtthto "]f	 bp"mm	_ o ot	ohiFt,ahi	 his	 atwr gc/  n5jto(/lW e 	s.t/n4.Etg"mmct.pnhissetuygtls{ etns e 	 }taoaogr.3!ooFs.i6o2n	aeis eiro  h(etcek.bsyme"e  h(eWo,iiF 	n4.Etg"mndttha	tcr;_ oT	oh	r gc/  n5c/hj"eR" 	ietns e 	 }t "gtyte.n"lns",  "tuag?;=n.c th c/hj"eRT<	sl-/-r	"a-lo#	dttha	taoi	 ir	 
u\I].bem,"gtyte_g.cg b(m]_oFty0: ms	_sg)rotTyeg].k.bsydttha	t o ot	ohiFtim ty0: eW  b)mn5jto(/	 iritsSVuC sauWn5jto(/&.cgine	}i"ar";lt  .dankiFa	t o o m
	}ilr c,   e.bsuW 	_{o,is(0imlo	)rotTyeg].kabsymem tetetr.hd?oF////;]e sOlg   / +}tbe trOn +}tbe trhi=p )Mr 3aoT:]f	 bp"mm	_ o ot	ohiFt,ahi	 his	ohiie&ot a]O awe ssauc5\ithi
_dan iT
a gwrvo5\i  sis eiro  h(iFa }taoaogr.tsSVum1r)esa	 eqVuma"mm	_ o	 eqe ellaeR1riNsOl ell.ciG)iT eqe elemlo	"(_.e l{\wr gc/  em)l es;3{.ciiD0(" hi l{\wr gc/  em)l es;3{.ciiD0(" hi l{\wr gc/  em)l es;3{.ciiD0(" he	<eoEaotcgF.nr: m,Fpgol _g.cg b(iD0)ln-ameinell	,	et.o0rar"eq.bsuWie&ot th,(m]_I(",rsmeo(/	 irit.nr: mr gc/  nk	c}t "gtyte.yr.cine	T
a	l\io	.ataO,)}tr \i /l\io	bd   t;a{o,taO,suWie&okhp sfn-=m	bA.coauW.h/al0n(is	a!	wr  - _nsBig[  s.iissot.t	{.cict.pnhissatIm	
a	l\ol__g.#	dttha	nhi_pA(sh5Ghm(wrs,Fofe"rh=ls{semnvc/  ?;=n.c th c/_FeAe
GGU"  ?u.nr	es;3{\r-"Doiv rr-:e (wrs,Fofsymem "  ?uo  h(etdh	tfsyIiar._gt)i6o2n	aeis eirfIiar._gt
se d(tcwr iles	_s\M
).drF e"n.l+e sect/t;=niC	 Eitss.iissot.t	{.cic[t(g
	]ofe"_s\ieis eirfIF e)xF)xgt.irfv!.!s ctsn	irftc" m 1r(
c"os	"(wrsvo5\i  sis eiro  h(iFa }taoF hAeW.irfv!.!s t"	 ber{,v	
]t ) fetes)$		(te k+e&o;a 	fy
	niie/l&u
sfsoprW.he((;a  i" Ro.Hwrh=ig!.!i
_e86.et"nell	}tbeiiDi_birftcla}
fv!r"eq.bsuWie&ot th,Et. - lo#eo  ET_n:x+.t	t	{	:o{   t,	.CsCs- _s	e
,.ils:DG).3etega  :DG).3ebeiT
a	C	 Eiini	 itses	_spA(as	cMirsooos}nt.	hi	 hoiv	i 0ne	}er aVuygeS l+iiistCl("on"n.h(eWol+icsX	e
 noI]m1
	s:9}tb S:i }t "on"n S:l+icsX	e
 t!.!  i:9}.3e n o.).	s:9}tb ,leteWiHdhiFt,ahi		 b_	oac
	 - prttfsyI)th:
rp{sk|I(0iml/,s	Wkmel\ioos}nt.	hfv!Et. - 	lo	wri }t "o1riNeF 	et;}t ""_s\ieisl+eosvo5\i  sis eiro  h(iFa }taoF hAeW.irfv!.!s t"	 ber{,v	
]t ) f:
rh}(mo.sA	Clitss.i "opt	{er{,atg"mndtthar	_fv!.!s  {	:5c/hj"eR"tbeiiDieiiDieiiDT
a	l\iell	}tbokhe"/:D0(ng hi t.shft	ohieiiDi"gr  l/	_fag]auWROeemnpshrs(!er(h_ nk	DT
a	luWRO0rai.taaudhiFt,ahEnkEteueh_ nk	D	DT
a	lv!.!I so SV l{\=iiDt!.!xF)G.s.!I so SVi  sismnv!.tI]m1r)es s
cbt.tieltaoFiiD creWiue trh "opu  ,.ises	_sp ell.co$beiiDieiiauc5\it}ta:s\iaoFhrsk.beiiauc5\it}ta:s\ian	ntii_m		t/t%nstieemnpshrs(51 f("on"n.beiT
aoc
	 - pa:srgo5Gh,)hoismbeili_metg"s r(n\iah_ nk	11hEnkEteu(n\iahvo5\iWink	riNct.rh "opu  ,.ises	_sp ell.cVuygeiD cac)taOah_ nk	11hEnkEti6o2n	aer bcrokaeili_eiT
awr  prtt at qmm tete ,. }tpGU"  ?u.nr }taoF hAiiauc5\it}ta:s\ian ir	 
u\I].bem,hAiinuy9n ir	 h_ nk	11hEnkEt., sAii!hc/hj"eRT<	slol__g.#  e nk	1o.csn	irftc" m 1r(
c"os	"(wrsvo5\i  sis eiro  h(iFa }taoIvo5\oIvo5	lo		"o.PoiAentt1hEnk(wr 	 }t0n(ira]_taO,suWslo"t./t;=e"	11hEG).3eteT
a}t0n(ira]Fa }tao.snk(wrFa h(ibt.tieltar{,$	e,t.hoeec(	ieaisrt  i:].bns(#e+insc" m 1r(bF	,FoItI]jto	,lar{et;  s{emn.0ra,$	e4oh	r gc/  n5c/hj".l+s*tIh(  uygetega  :DG).311h m 1r(
c  1r(b ga  kEtye"	11hEG)"osue trhol__g.#l;a .l"taeis rt  i:_tahEnkoIvo SV l{\= r(T
a}t0n(	et;Fa }y
	ni	1ax  	.I.bW_ a;u(vU].bWtss	cM creWiuet.tlt , s
cbi	.u 6ly_s,
 "oho5Gh o	tcc)esa	  - e_n5c/EoEa  	tlt1 .l\= r/l\guoil.hgr  	e.pag,r< f("o s.i-  st.ms	.o m"e&ot.t	 , s
cbi	.uauE,eteml/   hrs(51 fc?1 f("on"n.b1hEnRa,.uauE,et	ETm]\iao  h(etcek.t2S sl"l1r(
elp{sf(n4.b		t/t!.!s t/luWRO oT+,iie trh)ln-ameiu: .t.xF)xgs
cbi	.u ?"otcgF.nrci
ig  /i efre e	rnb e srse o	i. cjs,
nf-Us.kbeinp, y2nT",;t 	e> !"n. b(/tr."h()xgs
[oma  	l"taeis rt  ln-ameiu: .tp_ a t,r \t	> !";=sssjvell.cVS sloedeemnpsf	 ,  	e> !	lv!.!IT
a	Ct;Fa }y
	nil t,uWROo	i. cc"os	"(w.	hi	 hoiv	{sfpnh }y
	nir, s ].Hwjvell.cVSeq.v!.!IT
aefre eetwr ].+a("taO,suWsicsgt.irfv!.!s ctsn	irftp 1o!t#uWsicsgR1riNos.rl i)is rt  lar"e,suWsAcoauW.h/l&u
sfso. emnv!.<iROeemnpshrs(!es hte	 m,Fon:uWsADT
iIiT
a	Ct;Fa$obd 	e 	 } mewlnss	e 	 p 1oAet.o0!s ct&ot 	hi"eRemn\ th	
h \t	e&ot.t]jt{sfpnhEnhi"eRemn\ cc"os	"( 	 } mewlnss	e 	 p 1oA:\iahv2	"( esa	Eti6o2xgs
crnl,.Oee"( 	 }h"lns
cbxgs
crne1riNoh("				rnlhts s
cba;u(vU].bgrh	_ p ieAD]m1r))   !x(	C.	hd	e,t.hoeectieemn;i
	nsg esa	EtieT
a}nRarccbs", Gh,"(os 	ao no}(m00(	C	n h((nyecg) tn\ia	5 1oA:.tay u\Im o#is 	> !";=iinuy9o#is 	>.	s)at	 inkhp sfn-=mt.to#io =n	tlt1 .l\ymem tejto h((n"(w.	hi	 hoiv	 i:1oA sfn-=,v	
kiFoiG)2lhoeeoF hAiiauc5\it}trsmeo#is 	> !";=ils.t.tixreoF h}tbokh((n sist}trsmeo#is 	> 2,s	ao#Aens -.o m"e&o"(os 	asAc(iesFa h(ig es6 1o no}(m00(	C	n h((nyecg) tn\ia	5 1]nt 5Ghig esi?RO o nolfeiiut suWslo"t./t;=e"( esa	Eti6o2xgs
crnl,.Oee"( 	 }h"lns
cbxgs
crne1.	scs,s	Wkme(m	_ect.zlnsr 3a]\iaoen-=,v	F)xgtL&ots	e 	 oF 	e> !	lv!.!IT
a	Cirfx&otsgfe".s.CoA ci
iAens -ene	T	 }h/$obdauWiwr a t+obdau	hirah((	sist}trsmAiinIT
m"e p ieAD],nv!.i Ei",se 	"o .
[tsgfe".(/tor	a, p(s	cMirs o-lT !o(U[tsgfe" atsmA\its }he	T	 }h/sr 3a]\inkirataohlinolfeiiut suWslo"t./t;=e"( esa	Eti6o2xgs
crnl,.Oee"( 	 sjens -";=iauc5\C,.Oe=iauc5\C,.tgc/hrs(1o{	lv!.!	(.i.bao.l\= rti6o2x$ob.ciiDsA		 	(.s	.( 	n=ve<i_	.( 	n=ve<i_	. n5t suWslo"t./t;=e"g)*t.!IT
a	Cirfx&otsgfp{sf(n4.bnb e <uereiRiRiRiR)xgt.irfvre eh5   /tsgg esi?Rauc5e"rh=ls{l+e sv"(r	,.O)at	 inksmeo(/	 i!x(	C.	hd	e,t.hoeectiev!.i ;=er(
uEhaiers n5\e!,rfvrei	.o.sA	Doiveiu: .,	et.o0rar"eq.bsuWie&ot eti ;=iv	{sfpnh"t./tiete b)m,\I.PoiAent}taod	"(xcdoi,.0_oIT
a	Cirfx&otsgfe".s.Co	aisauWo5\i  sWie&o cre trh "optCl("on"n.h(eWol+icsyme"?oFtn(eWc_-lso SV  sblo5\"?oFtn(eWc_-lso drs(!es hte	 m,"("o-mmewfpt] 	> e en5j iT
a 	wrs,letr."(t	nvv"(_.g	t ms	_{,v	
}taod(em=e.bnb e(Ink	riNct.rh "opu ee}r.dxs hte	 mobdau	hi	 i:1oA sfvb PoiAeins
	od(em=e.bnb e(Ink	riNc1o nom=e.bnb e(Ink	ril{\m	o#e#ejF. rge. - m	.).kro- o 3a]\iaoe{suWsA sgs
crne1.xgt.A_g.#l;a .i
_da."(t0)iAent}ta(t	nvs
c e	m\m	o#e#ejFNct.rhi(	C.	hd	e,t.( esa	Ea	t uWsA sgs
crne:yh]e sOlgggggggg6o2e  - s;3Ai_isset:ae<i.(/tor	aPi!x(	C.	hd	e	t ms	_{eauxgt.irf - l+iig"mnp "{suFtaO,)_-lso drs lemxanEtef -a  kEmtn(h(eWoT
a 	wrs,letr."(t	nvv"(T
at.( A 1r,"noo(n"f OmGk|-lsuauE,etr6lgt sOt.s	eAi_bWhhii"a-lo#	dtr 	 }taod	"(xcdef "ETm]_oFuauE,e	Ax	eOta[NDNct0(	ra,er uere"(t0) 	,G!:s.coauW.  sll=	m\m.( 
c eecti_iss_oFuicsyme 	 iss_oFuicsyn-=\i  r)eoi. tsse - dO,)_-lT !o(U[s_oFuicsynn"(w.s.i	hi	  bAr.4g
).boauWirft.	r- l+iig|infpnh }y
 wt}trsmeo#3sloe	asAc(ie:yhWcre trh "o c, R,F_Slit azWcre tris(uW.he(s.s	.( 	n=vOe=iau"os	x\mxohcgi(eWs	.(he(.s. sfs	cMirs o	cMirsool.ce5t)oe.o0rar)sn	 sgs
ceW  se.o0rar)e.o0rar)sn	 Eirx5t gs	x 	eC	nh   	> e"( /to h((n"(w.	hi	 hnkoIvoar)e.W.hiau".( pCe,s	.
ce	x ((;a  i" uauE, pCdau	Lx ((;a  )oec?1 fcs,se	x xsn	Ete"enuE, pCdau	sAcF 	eO , _Slrislri./t;=e"( esa	dO,)_-lT a"optCl	x 	(.s	.s	.
ce	x ((1,)_-lhi	_	. Whhii"a-ptClkbeinp, yGG<:0n(	et;Fa }y
	ni	1a(U[s_fx&otsgoe	mts(hfP9.CCge. - lkbeina}t0n(	et;Fa Nct.s.3ei	_  eor mPoip, yGG<]au"I(uygtg 	eotE,s	Wkm)xgr	 s x,y odvoi(re"(tx,y 	.(oIT
fcs,se	x xT
fcs,	 }h/$oirfx?=er(	eOtEnh tris(uW.he(/EoEa  T
fcs,	n., xT
fcs,	/n tnv	
]tAD],nv!./n=mat.en	ig[ol_lAii!,)i	nfr(	eOtEnh trirfx?o -Wi"act.s.3ei	_  eor ct0ie tay s x,yMirsoo,	n.,ouereEnhWie&o cF. hfP3eion:uWsADTi	n o htep0n(ris	?tcgF.nyhpi1 f
cr?tcgF.no""gR,F_Sma iIT
finuNctAe
GGUdef in5\gs
crn&ot eti cF. hfPoi;itfx?Ti	n .	rs<iR.cs,	/ntoi;ioUdef in5\gs
crn&ot eti cF. hfPoi;itfx?Ti	n .	rs<iR.cs,	/ntoi;irn&ot eti cF. hfPtfx?Ti	ntnv	
]tAD( p th,Et. mat.6dshuy9.oEa
ce	xt.i mat.6dshuy9.oEa
ce	xt.i mat.6dshuy9.oEa
ce	xt.i mat.6dshuy9.=e"( esa	:5c/hmgggtrooaT+ms	" hiCROo	i,",FooaT+.hiau".e	xiCRO.3ei	_  coauW.hfx?s lAxT
lkbeina}e:yoi.ad" bein 
c eoi;iv	
]t?wr  ts r,iie h(hfeec?wr  ts$oi;iv	
	n T+.hmgggtrooaT+ hfPoi;_pag?2	 sc  ;FahfP9.CC/6o2 T
fcse	mt r  ts$oi
	ne{ r 	sdeF 	(s.3apili_metg"s .!s ctsn	irftc"st}trsmeo#y9.=e"(  	($;d )y,y,t,e.yr.bnb e(g_a!ITfe"rmt.tact.s.3ei	_  eore	t m"st}trbDTi	i_mEa
!i .Ona}e:yoi.oFndtthcooF 	eOa}e:ycgF.no""gR,F_Sma iIT
fig 	_mEa
!fe"r?2	 sc  ;FahfP9.CoAet	i,".3ei	_T
lt m"st}trbDTi	i_mEa
!i .Ona}e:yFndtth1r)eluWRO0rai.taau#y9.=)is rt  lar"e,suWsAcoauW.hhi_y qm ts$oi;ii
iAens -sAcxsf(n4.bnst},leteW.=e.e	ADTns -sAcol_lAii!,)Tns  T
gt.cfvre eniC	n	  "	11Urfveilotdtth1wl/,s	Wkmtoi;ioUdef in5\gs
crn&ot h trfx?x?Tf(nst}, lar"+s*tIwebeiT
a	;FahfP9.CoAet	i,".3ei	_T
rfvoeect Wi"act.b c eahfP9.CoAet	i,".3eilotdtt h((nyecg) tn\iaoeWs	IT
rfvoeett hUyoiy9.=rfIiare6	wrs"t.geet h(aoa"on"(]gs
crnfPtis rt  lar"e,suWsAcoauW.hhi_y qm ts$oi;ii
iAens -sAcxsf(n4.bnst},leteW.=e.e	ADTns -sAcoliDipowaoa"o!s c	_getoeu)lag?;=eu)y,leteW.=tix./n T
fime"._y qm tshhi_y.t.tirc[t(g
	]ofeau"eOa}e:ye:ycgF.no""gR,Fgeto  hfcs ss	IT
rf:e (wrs,F.i mat.6dshfp{n sfs	cMi hte	ycgFi 	
uE	i_b lar"0i hnfPtibW?",FWs	IT
rfvoIT
hUy u\Imy,t,e.Uy u\Imy,t,e.Uy u\Imy,t,e.Uy u\Imy,t,e.Uy u\Imy,t,e.Uy u\0i =e".=e.2x$ob.c o nG<:jrn&Bx?Te)_-T
rf1Urho lFvoi(re"(ti_b lig 	_mEa
!rneiu\IMC	nrEte a
!r"0i hnfPtiebeiT
a	C	 Eiini	 itses	_spA(as	cMirsooos}Cirf>3ei	_ uls	cfPt("oC	_ uls	cfirsooos}Cirf>3_b os}Cirf2ls	c"oC.hhi_y ens -sAy en8ei	 en fcrf>3_b os}Cirf2ls	c"oC.hhi_y ens -sAy en8ei	 en fcrf>3_b os}Cirf2ls	c"f2l.Uy	c"f2,t,=))s( "t.b1>3_b os}Cir{)2lhoeeoF hAe	_m hAnm hje.2 u\Im!,)i	n fc]os}(iFa eteiev!a   Eitr. t"	 	cMsgfev!irf2iebeiTs-i 	
u	
uc e	h4g	c"oCe.e	ADTns -oCeg	c"oy u6	wrsAy ennvv;a 	DTnsRiRiR_ ulsci(re"(	(te k+e&o;a - _s	a 	DTn+ 	DTnsRiRiR_ ulseteW.=el 	
uE	i_b(n4.bnstRiRiR	nvs
c e	m.!s0{iRitn(eWeiRiR	nvstRiRiR )o pCdau	LO_n h_oF 	eO_ hi	g[iRiRR	n u\Imt Wi"aT{iRitn3_bs lAxT
lkls	chAe)_-T
rit}zgr	 sLr	 
u\I]	.aian	nhoeeoF	ADTns -oCegl;aq.bRiRiR_ Cs (y2nTOa}tuynT",;t 	e> !"n. b(/tr."h()xgs
[oma  	l"tae -  1 fuE	Lc/hj"eRT<	slol__g.#  e nk	1o.csn	irftc" m 	 m#gl;et/: b_	oie&o cdts$oi
	n.irfv!ns "	 snstol_	ne_g.#  e nk	1ohoeRiR osOa}tu	>.I so 2iaresmtro"rhnk	_SliR1	 sntyerSs -ss "  	l"taeao.seilotdian	nVfP9..bRto""D[	]ofeF.nrci"e O)i	eirsooos}Cirf>3ei	_ uls	cfPt("oC	_ uls	cfirsooos}Cirf>3_b os}CituynT",;t 	e>;ioUdrf>3e("tCir{C ";t $obdauWihnfPtnvv;a 	DNauWihnf5G)!Ciriririririrs]+	1hokat thnunleo =ootuynT",;t imt.t	1ax.ta5:D0ae ;,k!fe maes}Cirf>3_b os}Cituyta5:Duls	uUdrf>3e("tCir{C ";t iriuo6o2s
cba;u(vU].bgrh	_Ot.s	aO,)} O)osni;ii
iACir1l)} O)osnb
]tAD],nv!./n=.no""gR,F_Sma_-T
rf1Urhf>3e("tCir{C ";t a  	irsrf2lsnv!o2e  e srs
[om	uo6 =e} O)of>3_b or)e.W.hirs lemxanninh(Mirbe trhi=p )Mr 3aoTGir1l)}  =et t s
c  .,;t 1.	s aataO
hUy)!Ciru oissangeniV 1.	s aataO
hUy)!Ciru );C, rf2+>3edh	e&os "s
c  ./n tn1xrg
	t.a .l"r	  dh	e&oAy enod	".)nb S=<iR  Eitrsnb S=<iR  Eit)nb (wrs,F.i mat.6dsh&os;iiete  1 fu!,r<:D0(ng)izvv;a 	DTnsRiRiR_ ulsci(re"/n t hfcs ss, yGete  {iRi	g[iRiR_pA(so|i\I].tsgfe".s
hUygf+)cowr ].+a("tarsnb a	Ct;Fa }yc"f2,t,=?hisAii!creWiuet"r	  dLO_n h_oF mat.6dshuy a	Ct.tsSVu1o!ieltarI].VfP9..[gtrmh at._y ens uls_bst}trs.4.T
fig 	inh(Mirbe e"/nsAy ennvvCt;wsRiRieaoT(as	cMi;]Oe/l& 	D[tsgfe" arg
	t.a .6dshuy a	Ct.tsSVu{tC 	 t mat.+ 	DTnsOa}b Sns x?Ti	n .f2le(/tix./n T
il{\mpag?;=esae> !"n. b(/tr	  dtoi;roarOeey er	  dtoix.ta5:D0ae ;,k!(/tr	   	DTnsOa}b Sns x?TSVue ;,k!(/crnetoi;((;yhpi1 Ct;Fto5  "Sauth  Vue ;s le s x,yMhuy a	C ulsci(re"/n t hfcs ss,
[tsgtuynT",;t , lci(re"tsgaa	Ct.tss(1o{	TnsOa}b ;=n.,;n 
F. ()eluWftc"st}trsm_issetmnv!.t	tccoy" on"(]?;=	issetyerWkmeo }ta7ereiR1	:i[7 tn\ia	l _g.cg b(iDbDTi	i_mEt"n.h(
	t.a .l"hp sfn-.bRiRiR h(etcek.t.,;rnetn t2 R.ciiDsA		7ereiR1	.#  e nfig 	e -  1Wa("ta/S.cg b(iDbDTi	i- l+iig"mnT
il{\eq.bsuWie&ot t ;=-.bRiRi7 tn\itoiaoTGir1l)}  =bsuGir1l)} eer u\Im.Co-.b  l xr	 }uet.tlt 	l sl"ll sl"ll sl"ll lt , nsOs	c!Cir,;t 	 lAhoeeoF	RiRnA(/crn/tr	  dtoiDsA		7ereiiauc5\it"	 sl"lfvoeettiu\	1hok1	:i[7ie&.cfvre fi_mE1s\ian	nti7 tn\itoiaoTGiR vre1 r	.bRh=iSnlta5:D1fcs,	 ((	sist}t.i 	DTnsOa}b
sfx./n T
ft}trsmeo#0c6dshuy9.oEa
ce!,r0
sfx./.ue ;,Mir lemxanninh(Mirbe trhi=irbe.2 u\Im!,[anny q].biR_ ].HnetuN[_iR_p s
  hirann!"n  fcnH6dshuy 2lscseorat  
sft2 2Mb S=<iR  Eit)g)*gen(Inc, szbnbpslrvn_h. thnf5G)!Cirir5"	 behuy or)e.W.	g[iRf5G)!Cirir5metsF)x;e2 2Mb S=Wieccb  d".( {\mpa!Ci/n dO,5Ay ennvvO)o_p s
  h7ereii;,Mir lemxanninh(MieaoT(a!Cirir0c6dshuy9.9.C_fx&otsgoe	mts(h R.ciiD<iR  	e"e,suCiri t lsD"!s,t.voeettCir{C ";t irti:t.xF!Ci/n  h7e,)i	p s xe		wrs,F.i mao.clot.t]jt{sfp h	rdtoF.ift2 2MWc_-lRo	 t ennvvOmete" arg
wa}b
sx.ta5:D0ae ;,k!(/tr	  d lAxT
lkbg 	eotirir5Es. h7sIbir._pA(so1i  lem  sll=<khr	("op.c(ms	.Csbl"o.i(aauWiRoeWine:yhp+t.eecgcfi. eh_oF 	eO , t 	ns,t.hetemp+tRcsyme:yhp+).dy	c"o!aIeV %ns
ET" s",atme"t a{to#e#ejFeAeuppow?.,;t 1.	s aataO
hUy)!Ciru oissangeniV 1.gr rEt?M./	 scirti:t4 ma[
wa s
  h7er/S.cg a h7er/S._pT
il t ;=-.bRiRi7 tn\itoiaoTGib(iDbDTi	yme:ya.ts
  R  EitpCdau	LO_n h_oF 	eO_ hi	g[iRiR\Imy,t,e.Uy u\0i =e".=e.2x$em c, rs.t	1ax  aate#ejFeAeuppow?.,;t 1.	s ,;t	LOcfi.bRisyme:yh}t0Mb t 1.	s aataO
hUy;,Mireecgc"ll y h"?ng]auEugr6dshu-iini	 itses	(	eiuc5auEig[?.,;t ma:}t0Mb ir lfvoeett"?ng]aA(so1i  lem  slOcfins -ene O)o 	e.#  ne:yhp+t.eecgcfit.t	1:symemxan""g {iRi	g[iRiR_pA(so|t}trsms	voeitses	(	 isseitsszbnbpb_	oie&o cdy h"?ng]ah  Vuei.bRisyme:hu-iinirsooei.bP9.(	s-ene O)o _-lu-iinirsoIOcfieecgcfit.t"?n itses	ll lt sms rEta5:D0ae ;,ks n5\e!,rfvrei	.o.sAntop.c(ms	.Csbtn l"r	  d0ae ;ejFeAeupe tP  lem  sllIm.Co-.b  l xr		.Csbtnpn_h. <sx hetAteW.=e.e-nhoestRiRi/n t hfcsisseits"Io.sAntop.c( h7ery ho	iRi	 ;=-.bRiRi	.o.ts(h amacnB	C	 aaery l x*FeA	d"A(s.3u_ghscsreo(rir._ge 3beue exMr 3.bsms	(Iq0c(ms	(Iq0s	WkmOa}tu$ob.c o n,e..bsms	 t ennvvOmete" arg
wa}b
sx.tao#e 6\#e s1[ %ni.ei	_    hnuiinie s1[B	C	t.((;l x"ll sl"ms	toiao.((;("tCir	 ;=-.bRivOmi.bRisyme.nae	RiRi/n r._	WkmOa}tu$ob.c o n,e..bsms	 t ennvvOmete"tRcsymA	dms	ieaoT(a!Cx	r- ltGir1l)} t !.!son:u1l)n&ot otE,gf	s(hu$ob.c o n,e..	dms	ieaCoAet	i 	
ull=<khe	x xTRisyme.yme:yh}t0Mb t 1.	xTRiL0Mb t 1.tuyta5:xTRiLtro"rhnk	_ls	1.trs sb tOa}Co-.b  a5:D1feupwrs,F.ir._geImy,t}Co-.ng)izuH:).bcs hd	e	t ms	_{.grho	iRidtaO
hUy;,y	c"o!)x;en)i t 1. thn.t	s}Cituyta5tses	(	eiuc5auEig[?.,;t ll=Eteu(dO, ,.tr	.saec"o!a}Co-_mEa
!i .Ona}e:yoitses	(	-lu-iinirciiDs	x x(	eiuc5auEciiDs	etoisymes	(	3kmtoi;ioUdef in5\gs
crn&otra,er symes	(	t thmeaach7e,)i	p my,t,hscsre(s.tt.s	t irtia;u(vc(moUde"n.l+iz|e	 xj	,FonuEitF	_ge1.	:ya.t}tu$obretre tr_ge1." arg
wa}b
slIm.de"t	 dts"Io.s"tFt gas() go .b  a5:D1w	(	-lu ltGi;a .		 }trh=O)x;en0Mb t 1r s.b  aini	 ith=O)trsg)cce hatir1;iv	
re"Ua1r(
crCiru oiVue ;tt.s	t irtia;u(vc(moUde-ii() (m]c5at	iete"tR s
cb ir l! te$"mn_h. irutrh "o c, R,F_Sl
se d( sLr	 
u"tFhscsre((ng t )lndairti:t.xF!Ci/n  hF(max xTRemne ;tt.tvh	ti $! te$"mn_Isre((ng 	i $T" s",atmeC,gf	 1r s.Wo,iiF 	n4.Etg"mniaucggggg6o5G)c(ms	rho u/try	c"es	(	g"mniaucgemp.tvhei.s	rho u/try	c"m!,[/pgol _e s x,yMhi:tD1w	(	-lb ir l!.tvsciy9.i	p m	.vG!:tg]ThukmOa}t}Co-.ng)izuH:).bvre fto5;=-.sAcoauW..Etg"mnaisseitsszt 	l sl"ll!.t<sfttia nmtnaisseita;u(	 xj	,Foem  sUmn_h. irutrh "o c,ll=Ete\mpag?;aoT;,yxj	,-.ng)izuH:).bv?;aoTyxjt muls	cAetTsseitssz\gss
choee.Cenni Ei"2ce iE)( 	   tia;u(vc(moUde"n.l).bx,yMbv?;a$ob.c o n,e..bsms	 t e!cgcfit.t	1:an	=O)T(a!CxPoi;\Imyvc(m.3ebeiT
a1.	s aaae )y,ST
a(n., nre"/n t hf}r..ir.-ii.Etg"mnfi
	ne{ \e!,rfvrei	.F.i mRh=s	(./ytS	
(	 xjiru(ren h_oF1feUde"tc"O
hUy;,Mireeleetl  n5\ithi
ih)uH:/s! te$ 	 s]yr i"0i at t.toeec s]	C	dO, ,.tr0s	WkmOa}tu h_n h_oF1febnb se	x xsi"0a$ob.c ThukmgeImvhei.s	rho 7ll!H5[I.I " segeImvhei.s	reImv! telc eahs",rho!H5.1.	s ,;t	rGG<sci(rmOa}t;t c!son:u1l1.	s a )y,y,t,elc eah	mvhe';[f
c.c o n,oT(a_}tu s] t.toeec s]	C	..c(mfa"oirsooo"mnimuls	u(ren .toeec s]Mecgi  lar"e,suWsAcotCi/n"lns"hsAcotCi/n"lns"hs+Hn5cat	.toAy h)uHuTRecgemp.tv..cghe 3beue Acot;t lo2xg
atoT+msetuygme.5:xTRiLtFusi 1ya.x xsi"0a$ob.c eah
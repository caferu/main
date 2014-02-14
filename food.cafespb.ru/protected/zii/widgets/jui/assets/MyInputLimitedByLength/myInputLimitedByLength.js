/*
 * jQuery MultiSelect UI Widget 1.10
 * Copyright (c) 2011 Eric Hynds
 *
 * http://www.erichynds.com/jquery/jquery-ui-multiselect-widget/
 *
 * Depends:
 *   - jQuery 1.4.2+
 *   - jQuery UI 1.8 widget factory
 *
 * Optional:
 *   - jQuery UI effects
 *   - jQuery UI position utility
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
*/
(function($, undefined){
$.widget("my.inputLimitedByLength", {
    _testDiv: null,
	_create: function(){
        var el = this.element,
            style = el[0].style,
            fontSize = style.fontSize,
            fontFamily = style.fontFamily,
            fontWeight = style.fontWeight,
            lineHeight = el.css('line-height'),
            paddingEl = style.padding,
            border = style.border,
            fontFamily = style.fontFamily,
            textIndent = style.textIndent,
            elHeight = el.height();
        this._testDiv = $('<div style="display:none;border: 1px solid;word-wrap: break-word;line-height: ' + lineHeight + '; font-size:' + fontSize + ';font-family:' + fontFamily + ';font-weight:' + fontWeight + ';min-height:' + elHeight + 'px;padding:' + paddingEl + '; font-family: ' + fontFamily + '; text-indent: ' + textIndent + '"></div>');
        $(document.body).append(this._testDiv);

		this._bindEvents();
	},

	// binds events
	_bindEvents: function(){
        var el = this.element,
            _t = this,
            onPr = function () {
            _t.onKeyPress();
        };
        el.keypress(onPr);
        el.keyup(onPr);
	},
    onKeyPress: function ()
    {
        var testDiv = this._testDiv,
            el = this.element;
        testDiv.html(el.val().replace(/  /g, ' .').replace(/\n/g, '<br />'));
        if (testDiv.width() > el.width()) {
            var str = el.val();
            el.val(str.substr(0, str.length - 1));
            while(!this.onKeyPress()) {

            }
            return false;
        } else {
            return true;
        }
    },
    value: function (val) {
        var el = this.element;
        if (val) {
            el.val(val)
            this.onKeyPress();
        } else {
            return el.val();
        }
    }
});

})(jQuery);

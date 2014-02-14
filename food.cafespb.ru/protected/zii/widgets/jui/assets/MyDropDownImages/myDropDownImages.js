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

var multiselectID = 0;
$.widget("my.dropDownImages", {

	// default options
	options: {
        buttonLabels: {
            active: 'Изменить',
            disactive: 'Скрыть'
        },
        isShowEmptyOption: false,
        value: false,
        label: false
	},
    getter: "value",

	_create: function(){
		var el = this.element,
			o = this.options;
        if (typeof this.options.data[0] != 'undefined' && !this.options.value) {
            this.options.value = this.options.data[0].id;
        }

        this._renderBody();

		// perform event bindings
		this._bindEvents();

		// build menu
		this.refresh();

        if (this.options.value) {
            this.setValue(this.options.value);
        }
	},

    _renderBody: function ()
    {
		var el = this.element,
			o = this.options,
            bodyEl = $('<div class="my-dropdownimage"></div>'),
            selectedOption = $('<li class="my-dropdownimagemulti-current-option"></li>'),
            selectedUlEl = $('<ul class="ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></ul>'),
            buttonEl = $('<li class="my-dropdownimage-button ui-helper-reset ui-state-default ui-corner-bottom"><span class="ui-icon ui-icon-triangle-1-s"></span><a href="#" tabindex="-1">' + o.buttonLabels.active + '</a></li>'),
            ulEl = $('<ul class="my-dropdownimage-list ui-widget ui-widget-content ui-corner-bottom"></ul>');
        el.after(bodyEl);

        if (o.label) {
            this._labelEl = $('<li class="my-dropdownimage-label">' + o.label + '</li>');
            selectedUlEl.append(this._labelEl);
            bodyEl.parent().addClass('my-dropdownimage-label-container');
        }

        bodyEl.append(selectedUlEl.append(selectedOption));
        if (o.data.length > 1) {
            selectedUlEl.append(buttonEl);
        }

        this._selectedUlEl = selectedUlEl.after(ulEl);
        this._ulEl = ulEl;

        $(o.data).each(function (key, row) {
            if (typeof row.url == 'string' && row.url !== '') {
                ulEl.append('<li><img val="' + row.id + '" src="' + row.url + '" alt=""></li>');
            }
        });

        this._selectedOption = selectedOption;

        if (o.isShowEmptyOption || !o.value) {
            var noSelectedOption = $('<img val="" src="/css/widgets/jui/images/noselected.jpg" alt="" />');
            ulEl.append(noSelectedOption);
            selectedOption.append(noSelectedOption.clone());
        }

        this._buttonEl = buttonEl;
    },

	_init: function(){
	},

	refresh: function( init ){
		// broadcast refresh event; useful for widgets
//		if( !init ){
//			this._trigger('refresh');
//		}
	},

	// updates the button text.  call refresh() to rebuild
	update: function(){
		return value;
	},

	// binds events
	_bindEvents: function(){
        var buttonEl = this._buttonEl,
            ulEl = this._ulEl,
            _self = this;
        if (_self.options.data.length > 1) {
            buttonEl.bind('click.dropDownImages', function () {
                if (!_self._isExpanded) {
                    _self.toggleExpanded();
                }

                return false;
            }).bind('hover.dropDownImages', function () {
                $(buttonEl).toggleClass('ui-state-hover');
            });

            $(document).bind('mousedown.dropDownImages', function(e){
                if (_self._isExpanded && !$.contains(ulEl[0], e.target)) {
                    _self.toggleExpanded();
                }
            });

            ulEl.find('img').bind('click.dropDownImages', function () {
                if (!_self._expandInProgress) {
                    _self._setOption('value', $(this).attr('val'));
                    _self.toggleExpanded();
                }

                return false;
            });
        }

        $([this._selectedOption[0], this._labelEl[0]]).bind('selectstart.dropDownImages', function () {
            return false;
        });
        $([this._selectedOption[0], this._labelEl[0]]).bind('click.dropDownImages', function (e) {
            _self._trigger('currentclick', e);

            return false;
        });
	},

    value: function () {
        return this.options.value;
    },

    setValue: function (val) {
        var el = this._ulEl,
            curImg = el.parent().find("img[val='" + val + "']"),
            selectedUlEl = this._selectedUlEl,
            targetEl = this._selectedOption,
            val = curImg.attr('val');
        this._curImg && this._curImg.show();
        this._curImg = curImg;
        selectedUlEl.find('img').remove();
        el.attr('val', val);
        this.options.value = val;
        this.element.val(val).change();
        this.element[0].value = val;
        targetEl.append(curImg.clone());
        this._curImg.hide();
        this._ulEl.css('top', selectedUlEl.height() + 8.5 + 'px');

    },
    toggleExpanded: function () {
        var buttonEl = this._buttonEl,
            ulEl = this._ulEl,
            o = this.options,
            _self = this,
            selectedUlEl = _self._selectedUlEl,
            positionOptions = function () {
                ulEl.css('top', selectedUlEl.height() + 8.5 + 'px').height('0px');
            };
        if (!this._expandInProgress) {
            this._expandInProgress = true;
            var isExpanded = this._isExpanded,
                changeState = function () {
                    buttonEl.toggleClass('ui-state-active').toggleClass('ui-corner-bottom');
                    var textValue = isExpanded ? o.buttonLabels.active : o.buttonLabels.disactive;
                    buttonEl.children('a').text(textValue);
                    buttonEl.children('span').toggleClass('ui-icon-triangle-1-s').toggleClass('ui-icon-triangle-1-n');
                },
                stopExpand = function () {
                    _self._expandInProgress = false;
                };

            if (!isExpanded) {
                positionOptions();
                ulEl.show();
                var oldListHeight = ulEl.height(),
                    listHeight;
                ulEl.height('');
                listHeight = ulEl.height();
                ulEl.height(oldListHeight)
                ulEl.animate({
                    height: listHeight + 'px'
                }, {
                    complete: function () {
                        stopExpand();
                    }
                });
                changeState();
            } else {
                ulEl.animate({
                    height: '0px'
                }, {
                    complete: function () {
                        stopExpand();
                        ulEl.hide();
                        changeState();
                    }
                });
            }

            this._isExpanded = !this._isExpanded;
        }
    },
	destroy: function(){
		// remove classes + data
		$.Widget.prototype.destroy.call( this );

		this._selectedUlEl.parent().remove();

		return this;
	},
	// react to option changes after initialization
	_setOption: function( key, value ){
		switch(key){
			case 'value':
				this.setValue(value);
				break;
        }

		$.Widget.prototype._setOption.apply( this, arguments );
	}
});

})(jQuery);

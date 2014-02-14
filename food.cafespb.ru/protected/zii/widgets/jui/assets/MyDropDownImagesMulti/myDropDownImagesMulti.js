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
$.widget("my.dropDownImagesMulti", {
	// default options
	options: {
        data: {},
        name: null,
        isShowNumber: true,
        value: true
	},

	_create: function(){
        this._renderBody();

		// perform event bindings
		this._bindEvents();

		// build menu
		this.refresh();
	},

    _renderBody: function ()
    {
		var el = this.element,
            self = this,
            addButton = (this._addButton = el.find('.my-dropdownimagemulti-button-add'));

        this._dropdownContainer = el.find('td:first');
		this._initRemoveButton(el.find('.my-dropdownimagemulti-button-delete'));
        addButton.button({
            icons: {
                primary: "ui-icon ui-icon-circle-plus"
            },
            text: false,
            label: "Добавить"
        }).click(function (e) {
            self._addDropdownmage()
            self.refresh();
            self._trigger('change', e);
        });
    },

    _initRemoveButton: function (removeButton) {
        var self = this;
        removeButton.button({
            icons: {
                primary: "ui-icon ui-icon-circle-close"
            },
            text: false,
            label: "Удалить"
        }).click(function (e) {
            var el = $(this),
                isActive = el.parent().find('div ul:first').hasClass('ui-state-default');
            el.parent().children('input').dropDownImages('destroy').parent().remove();
            el.button('destroy').remove();
            self.refresh();
            if (isActive) {
                self._trigger('selectionchange', e);
            }

            self._trigger('delete', $(this).parent().children('input').dropDownImages('value'));
            self._trigger('change', e);
        });
    },

    _addDropdownmage: function () {
        var imageContainerEl = $('<div class="my-dropdownimagemulti-item"></div>'),
            o = this.options,
            curIndex = this._dropdownContainer.children().length,
            imageEl = $('<input type="hidden" name="' + o.name + '[' + String(curIndex) + ']" id="' + o.name + String(curIndex) + '" />'),
            buttonEl = $('<div class="my-dropdownimagemulti-button-delete"></div>'),
            data = o.data;
        this._dropdownContainer.append(imageContainerEl.append(imageEl).append(buttonEl));
        this._initRemoveButton(buttonEl);
        imageEl.dropDownImages({data: data[curIndex], isShowEmptyOption: false, value: data[curIndex][0].id, label: o.isShowNumber ? (curIndex + 1) : false});
        this._bindEvents(imageEl);
    },
	_init: function(){
	},

	refresh: function(){
        var container = this._dropdownContainer,
            dropdowns = container.children(),
            curIndex = dropdowns.length - 1,
            addButton = this._addButton,
            data = this.options.data,
            lastDeleteButton = container.find('.my-dropdownimagemulti-button-delete:last').show();

        container.find('.my-dropdownimagemulti-button-delete').not(lastDeleteButton).hide();
        if (typeof data[curIndex + 1] == 'undefined') {
            addButton.hide();
        } else {
            addButton.show();
        }
	},

	// updates the button text.  call refresh() to rebuild
	update: function(){
		return value;
	},

	// binds events
	_bindEvents: function(curEl){
        var el = this.element,
            curEl = curEl || el.find('input'),
            _self = this;
        curEl.bind('dropdownimagescurrentclick', function (e) {
            var multiselect = $(this),
                selectedOption = multiselect.parent().find('div ul:first');
            selectedOption.toggleClass('ui-state-default');
            _self._trigger('selectionchange', e);
            _self._trigger('change', e);
        }).change(function (e) {
            var multiselect = $(this),
                selectedOption = multiselect.parent().find('div ul:first');
            if (selectedOption.hasClass('ui-state-default')) {
                _self._trigger('selectionchange', e);
            }

            _self._trigger('change', e);
        });
	},
    value: function () {
        var dropdowns = this._dropdownContainer.find('input');

        return this._getValuesFromDropDowns(dropdowns);
    },
    selected: function () {
        var dropdowns = this._dropdownContainer.find('.my-dropdownimage>.ui-state-default').parent().parent().find('input');

        return this._getValuesFromDropDowns(dropdowns);
    },
    _getValuesFromDropDowns: function (dropdowns) {
        var values = [];
        dropdowns.each(function (key, dropdown) {
            values[key] = $(dropdown).dropDownImages('value');
        });

        return values;
    }
});

})(jQuery);

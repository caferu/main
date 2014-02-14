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
$.widget("my.imageDynamicClipper", {
    // default options
    options: {
        images: [],
        value: {},
        ratio: 1,
        initialElSize: {}
    },
    _imageEl: null,
    _imagesEls: {},
    _dialog: null,
    _activeImageId: null,
    _jcropImgEl: null,
    _lastCoords: null,
    _thumbnailsVisibility: {},
    _accordion: null,
    _jcropContainerEl: null,
    _noSelectedDiv: null,
    _proportionalCheckbox: null,
    _create: function() {
        var _t = this;
        for (var key in _t.options.initialElSize) {
            _t.options.initialElSize[key] = Number(_t.options.initialElSize[key]);
        }

        _t._proportionalCheckbox = null;
        _t._imageEl = null;
        _t._imagesEls = {};
        _t._dialog = null;
        _t._activeImageId = null;
        _t._jcropImgEl = null;
        _t._lastCoords = null;
        _t._thumbnailsVisibility = {};
        _t._accordion = null;
        _t._jcropContainerEl = null;
        _t._noSelectedDiv = null;
        _t._imageEl = this.element.children('img');
        if (_t.value().currentImageNbr) {
            this.hideImage(_t.value().currentImageNbr);
            _t._activeImageId = _t.value().currentImageNbr;
        } else {
            _t.value({});
        }

        _t._bindEvents();
    },
    _getHiddenInputs: function () {
        var _t = this;
        if (_t._hiddenInputs == null) {
            var _e = this.element,
                id = _e.attr('id');
            _t._hiddenInputs = {
                x: $(_e.children('#' + id + '-x')),
                y: $(_e.children('#' + id + '-y')),
                h: $(_e.children('#' + id + '-h')),
                w: $(_e.children('#' + id + '-w')),
                currentImageNbr: $(_e.children('#' + id + '-currentImageNbr'))
            };
        }

        return this._hiddenInputs;
    },
	_bindEvents: function(curEl) {
        var _t = this;
        _t._imageEl.click(function () {
            _t.showImageClipper();
        });
	},
    _setActiveImageId: function (activeImageId) {
        var _t = this,
            oldActiveImageId = _t._activeImageId;
        if (oldActiveImageId !== activeImageId) {
            if (_t._activeImageId != activeImageId) {
                _t.showImage(_t._activeImageId);
                _t.hideImage(activeImageId);
            }

            _t._activeImageId = activeImageId;
            _t._trigger('selectedImageChange', null, [oldActiveImageId, activeImageId]);
        }
    },
    value: function (val) {
        var _t = this,
            hi = _t._getHiddenInputs();
        if (val) {
            var img = _t._imageEl,
                oldCurrentImageId = hi.currentImageNbr.val(),
                onLoad = function () {
                if (typeof val.w === 'undefined' || Number(val.w) <= 0) {
                    var offsetParent = _t.element.parents(':hidden:last').show(),
                        w = img.width(),
                        h = img.height(),
                        ratio = _t.options.ratio,
                        prevW = 300,
                        prevH = h / w * 300;
                    offsetParent.hide();
                    if (w > h * ratio) {
                        prevW = prevH * ratio;
                    } else {
                        prevH = prevW / ratio;
                    }

                    val.w = prevW;
                    val.h = prevH;

                    val.y = val.x = 0;
                }

                var v,
                    keys = ['x', 'y', 'w', 'h'];
                $(keys).each(function (undefined, key) {
                    if (typeof val[key] === 'undefined' || Math.round(val[key]) <= 0) {
                        v = 0;
                    } else {
                        v = Math.round(val[key]);
                    }

                    hi[key].val(v);
                });

                _t._positionImage(val);
            };
            var image = null;
            $(_t.options.images).each(function (undefined, img) {
                if (img.id == val.currentImageNbr) {
                    image = img;
                    return false;
                }
            });

            if (image === null) {
                image = {id: -1, url: 'images/pdf/image-block/pix.jpg'};
                img.css('opacity', 0);
                val.currentImageNbr = -1;
            } else {
                img.css('opacity', '');
            }

            _t._setActiveImageId(val.currentImageNbr);
            img.width('').height('');

            if (img.attr('src') == image.url) {
                onLoad();
            } else {
                img.attr('src', image.url);
                img.load(function () {
                    onLoad();
                    img.unbind('load');
                });
            }

            if (val.currentImageNbr !== oldCurrentImageId) {
                hi.currentImageNbr.val(val.currentImageNbr);
                _t.hideImage(val.currentImageNbr);
                _t._trigger('currentImageChange', null, [oldCurrentImageId, val.currentImageNbr]);
                if (val.currentImageNbr == -1 && _t._dialog) {
                    _t._toggleHasSelectedImage();
                }
            }
        } else {
            return {
                currentImageNbr: hi.currentImageNbr.val(),
                x: Number(hi.x.val()),
                y: Number(hi.y.val()),
                h: Number(hi.h.val()),
                w: Number(hi.w.val())
            };
        }
    },
    _positionImage: function (val) {
        var _t = this,
            img = _t._imageEl,
            s = _t.options.initialElSize,
            h1,
            w1;
        offsetParent = _t.element.parents(':hidden:last').show();

        img.css('opacity', '');
        img.width('');
        img.height('');

        if (val.w / val.h > s.w / s.h) {
            h1 = s.w / val.w * val.h;
            w1 = s.w;
        } else {
            w1 = s.h / val.h * val.w;
            h1 = s.h;
        }

        _t.element.css({
            width: w1 + 'px',
            height: h1 + 'px',
            top: (s.t + (s.h - h1) / 2) + 'px',
            left: (s.l + (s.w - w1) / 2) + 'px'
        });

        var rx = w1 / val.w,
            ry = h1 / val.h,
            offsetParent;
        img.css({
            width: Math.round(rx * 300) + 'px',
            height: Math.round(ry * img.height() / img.width() * 300) + 'px',
            marginLeft: '-' + Math.round(rx * val.x) + 'px',
            marginTop: '-' + Math.round(ry * val.y) + 'px'
        });

        img.width(Math.round(rx * 300));
        img.height(Math.round(ry * img.height() / img.width() * 300));

        offsetParent.hide();
    },
    showImageClipper: function () {
        var _t = this,
            dialog = _t._dialog,
            lastCoords = this.value(),
            ignoreChanges = false;
        if (dialog == null) {
            dialog = $('<div class="MyImageDynamicClipperDialog"></div>');
            var imgEl = _t._imageEl,
                _e = _t.element,
                currentImageSrc = imgEl.attr('src'),
                jcropImgEl = $('<img class="MyImageDynamicClipperCurrentImg" src="' + currentImageSrc + '" />'),
                cropContainer = $('<div class="MyImageDynamicClipperCropContainer"></div>'),
                carousel = $('<div class="carousel-wrap"><ul></ul></div>'),
                noSelectedDiv = $('<div>Изображение не выбрано, выберите его во вкладке выше</div>'),
                proportionalCheckbox = $('<input type="checkbox" checked="checked" name="proportional' + _e.attr('id') + '" /><label for="proportional' + _e.attr('id') + '">Пропорционально</label>'),
                images = $(_t.options.images),
                ratio,
                ulEl = carousel.children(),
                fullWidth = 0,
                liEl,
                closeIt = false,
                onChangeJclip = function (coords) {
                    if (!ignoreChanges) {
                        lastCoords = coords;
                        _t._positionImage(coords);
                    }
                },
                initJcrop = function (ratio, coords) {
                    var v = coords || _t.value();
                    jcropImgEl.Jcrop({
                        onChange: onChangeJclip,
                        aspectRatio: ratio,
                        setSelect:   [Number(v.x), Number(v.y), Number(v.x) + Number(v.w), Number(v.y) + Number(v.h)]
                    });
                },
                reInitJcrop = function (newUrl, onReady, ratio, coords) {
                    var newSelectedImgEl = jcropImgEl.clone(),
                        parentEl = jcropImgEl.parent();
                    parentEl.children().remove();
                    _t._jcropImgEl = jcropImgEl = newSelectedImgEl;
                    jcropImgEl.show();
                    jcropImgEl.load(function () {
                        initJcrop(ratio, coords);
                        jcropImgEl.unbind('load');
                        if (onReady) {
                            onReady();
                        }
                    });

                    jcropImgEl.attr('src', newUrl);
                    parentEl.append(jcropImgEl);
                },
                accordionEl = $('<div></div>'),
                isSave,
                val = _t.value();

            if (val) {
                ratio = val.w / val.h;
                if (!(ratio - 0.01 <= _t.options.ratio && ratio + 0.01 >= _t.options.ratio)) {
                    ratio = null;
                    proportionalCheckbox.attr('checked', false);
                }
            } else {
                ratio = _t.options.ratio
            }
            _t._proportionalCheckbox = proportionalCheckbox;
            _t._accordion = accordionEl;
            _t._noSelectedDiv = noSelectedDiv;
            proportionalCheckbox.change(function () {
                if (proportionalCheckbox.attr('checked')) {
                    ratio = _t.options.ratio;
                } else {
                    ratio = null;
                }

                images.each(function (undefined, imgParams) {
                    if (_t._activeImageId == imgParams.id) {
                        reInitJcrop(imgParams.url, undefined, ratio, lastCoords);
                    }
                });
            });
            accordionEl.append('<h3><a href="#">Изображение</a></h3>')
                       .append(carousel)
                       .append('<h3><a href="#">Область</a></h3>')
                       .append(cropContainer.append($('<div></div>').append(jcropImgEl)).append(noSelectedDiv).append(proportionalCheckbox))
                        .bind('accordionchange', function(event, ui) {
                            accordionEl.accordion('resize');
                        });
            dialog.append(accordionEl);
            $('body').append(dialog);
            _t._jcropContainerEl = jcropImgEl.parent();

            images.each(function (undefined, imgParams) {
                var thumbnailImgEl = $('<img src="' + imgParams.thumbnail + '" />');
                _t._imagesEls[imgParams.id] = thumbnailImgEl;
                liEl = $('<li></li>').append(thumbnailImgEl);
                if (typeof _t._thumbnailsVisibility[imgParams.id] != 'undefined' && !_t._thumbnailsVisibility[imgParams.id]) {
                    liEl.css('display', 'none');
                }

                liEl.click(function (e) {
                    reInitJcrop(imgParams.url, null, ratio);
                    accordionEl.accordion({active: 1});
                    imgEl.attr('src', imgParams.url);
                    _t._setActiveImageId(imgParams.id);

                    noSelectedDiv.hide();
                    jcropImgEl.parent().show();
                });
                ulEl.append(liEl);
            });

            initJcrop(ratio);
            dialog.dialog({
                open: function () {
                    _e.addClass('myImageDynamicClipperOpened');
                    var left = _e.position().left + _e.width() + _e.offsetParent().position().left + 10,
                        top = _e.position().top + _e.offsetParent().position().top;
                    if (left + 339 > $(window).width()) {
                        left = $(window).width() - 339;
                    }

                    dialog.parent().css('left', left)
                          .css('top', top);
                    _t._toggleHasSelectedImage();
                    if (currentImageSrc !== imgEl.attr('src')) {
                        currentImageSrc = imgEl.attr('src');
                        reInitJcrop(currentImageSrc, null, ratio);
                    }
                    ulEl.css('width', '');
                    ulEl.children().each(function (undefined, el) {
                        fullWidth += $(el).width();
                    });

                    if (Number(fullWidth) == 0) {
                        fullWidth = '100%';
                    } else {
                        fullWidth = fullWidth + 'px';
                    }

                    ulEl.css('width', fullWidth);
                },
                width: 339,
                height: 500,
                resize: false,
                buttons: [
                    {
                        text: "Сохранить",
                        click: function() {
                            lastCoords.currentImageNbr = _t._activeImageId;
                            _t.value(lastCoords);

                            currentImageSrc = imgEl.attr('src');
                            isSave = true;
                            $(this).dialog("close");
                        }
                    },
                    {
                        text: "Отменить",
                        click: function() {
                            $(this).dialog("close");
                        }
                    }
                ],
                beforeClose: function (e) {
                    _e.removeClass('myImageDynamicClipperOpened');
                    if (isSave) {
                        isSave = false;

                        return true;
                    } else {
                        if (closeIt) {
                            var curVal = _t.value().currentImageNbr;
                            closeIt = false;
                            _t._setActiveImageId(curVal);

                            return true;
                        } else {
                            var v = _t.value();
                            imgEl.attr('src', currentImageSrc);
                            _t._positionImage(v);
                            dialog.parent().css('visibility', 'hidden');
                            accordionEl.css('visibility', 'hidden');
                            ignoreChanges = true;
                            if (accordionEl.accordion( "option", "active") != 1) {
                                accordionEl.accordion( "option", "animated", false)
                                           .accordion({active: 1})
                                           .accordion( "option", "animated", 'slide');
                            }

                            reInitJcrop(currentImageSrc, function () {
                                setTimeout(function () {
                                    closeIt = true;
                                    dialog.dialog('close');
                                    dialog.parent().css('visibility', 'visible');
                                    accordionEl.css('visibility', 'visible');
                                    ignoreChanges = false;
                                }, 500);
                            }, ratio);

                            return false;
                        }
                    }
                }
            });

            accordionEl.accordion({active: 1});

            _t._dialog = dialog;
        } else {
            dialog.dialog('open');
        }
    },
    _toggleHasSelectedImage: function ()
    {
        var _t = this;
        if (_t.value().currentImageNbr == -1) {
            _t._jcropContainerEl.hide();
            _t._noSelectedDiv.show();
        } else {
            _t._jcropContainerEl.show();
            _t._noSelectedDiv.hide();
        }
    },
    hideImage: function (id) {
        var _t = this;
        if (typeof _t._thumbnailsVisibility[id] == 'undefined' || _t._thumbnailsVisibility[id]) {
            if (typeof _t._imagesEls[id] !== 'undefined') {
                _t._imagesEls[id].parent().hide();
            }

            if (id) {
                _t._thumbnailsVisibility[id] = false;
            }
        }
    },
    showImage: function (id)
    {
        var _t = this;
        if (typeof _t._thumbnailsVisibility[id] != 'undefined' && !_t._thumbnailsVisibility[id]) {
            if (typeof _t._imagesEls[id] !== 'undefined') {
                _t._imagesEls[id].parent().show();
            }

            if (id) {
                _t._thumbnailsVisibility[id] = true;
            }
        }
    },
    getSelectedImageId: function () {
        return this._activeImageId;
    }
});

})(jQuery);

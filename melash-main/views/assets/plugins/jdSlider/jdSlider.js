/**
 * 2018-10-23
 * 0.1.3 ver
 * Kim Yeonho
 * https://github.com/jadenspace/jdSlider/
 * https://www.npmjs.com/package/jd-slider/
 */

;(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function ($) {

    'use strict';

    var JdSlider = window.JdSlider || {},

        defaults = {
            isUse: true, // ìŠ¬ë¼ì´ë” ì ìš© ìœ ë¬´
            wrap: null, // ìŠ¬ë¼ì´ë” ë„ˆë¹„ ê³„ì‚°ì˜ ê¸°ì¤€ì´ ë  ì„ íƒìž (nullì¼ ê²½ìš° default.slide ì„ íƒìžë¥¼ í–¥í•œë‹¤.)
            slide: '.slide-area', // ìŠ¬ë¼ì´ë“œë¥¼ ê°ì‹¸ëŠ” ì„ íƒìž
            prev: '.prev', // ì´ì „ ë²„íŠ¼ ì„ íƒìž
            next: '.next', // ë‹¤ìŒ ë²„íŠ¼ ì„ íƒìž
            indicate: '.indicate-area', // ì¸ë””ì¼€ì´íŠ¸ ë²„íŠ¼ì„ ê°ì‹¸ëŠ” ì„ íƒìž
            auto: '.auto', // ìžë™ìž¬ìƒ ë²„íŠ¼ ì„ íƒìž
            playClass: 'play', // ìžë™ìž¬ìƒ ë²„íŠ¼ì—ì„œì˜ ìž¬ìƒ class
            pauseClass: 'pause', // ìžë™ìž¬ìƒ ë²„íŠ¼ì—ì„œì˜ ì •ì§€ class
            noSliderClass: 'slider--none', // ìŠ¬ë¼ì´ë“œ ê¸°ëŠ¥ì´ ì—†ëŠ” ê²½ìš° ë‚˜íƒ€ë‚¼ class
            willFocusClass: 'will-focus', // ë²„íŠ¼ ì´ë™ ì ‘ê·¼ì„±ì„ ìœ„í•œ class
            unusedClass: 'hidden', // ì‚¬ìš©ë˜ì§€ ì•ŠëŠ” prev, next ë²„íŠ¼ì— ì¶”ê°€ë  class
            slideShow: 1, // í™”ë©´ì— ë³´ì—¬ì§ˆ ìŠ¬ë¼ì´ë“œ ìˆ˜
            slideToScroll: 1, // ìŠ¬ë¼ì´ë”© ë˜ì–´ì§€ëŠ” ìŠ¬ë¼ì´ë“œ ìˆ˜
            slideStart: 1, // ì‹œìž‘ ìŠ¬ë¼ì´ë“œ ë²ˆí˜¸
            margin: null, // ìŠ¬ë¼ì´ë“œ ê°„ê²© (margin-rightì™€ ë™ì¼í•˜ê²Œ êµ¬ì„± í•„ìš” | nullì¼ ê²½ìš° style margin-rightê°’ì„ ë”°ë¥¸ë‹¤.)
            speed: 500, // ìŠ¬ë¼ì´ë”© ì†ë„ (ms)
            timingFunction: 'cubic-bezier(.02,.01,.47,1)', // ie9 ì´í•˜ ì œì™¸ ì ìš© (transition-timing-function)
            easing: 'swing', // ie9 ì´í•˜ ì ìš© (animate easing)
            interval: 4000, // ìžë™ìž¬ìƒ ì†ë„ (ms)
            touchDistance: 20, // ìŠ¤ì™€ì´í”„ í—ˆìš© ê±°ë¦¬
            resistanceRatio: .5, // ìŠ¤ì™€ì´í”„ ì €í•­ ë¹„ìœ¨
            isOverflow: false, // ì‚¬ì´ë“œ ì˜ì—­ ë…¸ì¶œ ì—¬ë¶€
            isIndicate: true, // ì¸ë””ì¼€ì´íŠ¸ ì‚¬ìš© ìœ ë¬´
            isAuto: true, // ìžë™ìž¬ìƒ ìœ ë¬´ (true ì‹œ ìžë™ìž¬ìƒ ì‹¤í–‰)
            isLoop: false, // ë¬´í•œë£¨í”„ ìœ ë¬´
            isSliding: true, // ìŠ¬ë¼ì´ë”© ìœ ë¬´(íŽ˜ì´ë“œì¸ ì ìš©ì‹œ false)
            isCursor: true, // ë§ˆìš°ìŠ¤ì˜¤ë²„ì— ë”°ë¥¸ ìžë™ìž¬ìƒ ì¡°ì ˆ ìœ ë¬´
            isTouch: true, // ëª¨ë°”ì¼ í„°ì¹˜ ìŠ¤ì™€ì´í”„ ìœ ë¬´
            isDrag: true, // ì›¹ ë“œëž˜ê¹… ìŠ¤ì™€ì´í”„ ìœ ë¬´
            isResistance: true, // ìŠ¤ì™€ì´í”„ ì €í•­ ìœ ë¬´
            isCustomAuto: false, // ìžë™ìž¬ìƒ ìˆ˜ë™ ì»¨íŠ¸ë¡¤ ìœ ë¬´ (ìžë™ì€ false)
            autoState: 'auto', // ë¦¬ì‚¬ì´ì§•ì‹œ ìž¬ìƒìƒíƒœ ë³€í™˜
            indicateList: function (i) {
                return '<a href="#">' + i + '</a>'; // ì¸ë””ì¼€ì´íŠ¸ ì»¤ìŠ¤í…€
            },
            progress: function () {}, // ìŠ¬ë¼ì´ë”© ë°œìƒ ì¦‰ì‹œ í•¨ìˆ˜
            callback: function () {}, // ìŠ¬ë¼ì´ë”© ì™„ë£Œ í›„ í•¨ìˆ˜
            onPrev: function () {}, // prev ë²„íŠ¼ í´ë¦­ ì‹œ ì½œë°±í•¨ìˆ˜
            onNext: function () {}, // next ë²„íŠ¼ í´ë¦­ ì‹œ ì½œë°±í•¨ìˆ˜
            onIndicate: function () {}, // indicate ë²„íŠ¼ í´ë¦­ ì‹œ ì½œë°±í•¨ìˆ˜
            onAuto: function () {}, // auto ë²„íŠ¼ í´ë¦­ ì‹œ ì½œë°±í•¨ìˆ˜
            responsive: [
                /*{
                    viewSize: 768, // break point(0~768)
                    settings: { // í•´ë‹¹ ì˜ì—­ options ì„¤ì •
                        isUse: true
                    }
                }, {
                    viewSize: 1024, // break point(769~1024)
                    settings: { // í•´ë‹¹ ì˜ì—­ options ì„¤ì •
                        isUse: true
                    }
                }*/
            ] // ë°˜ì‘í˜• ì˜µì…˜ ì„¤ì •
        },
        is = {
            mobile: window.navigator.userAgent.match('LG|SAMSUNG|Samsung|iPhone|iPod|iPad|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson'),
            ios: window.navigator.userAgent.match('iPhone|iPod|iPad'),
            ff: window.navigator.userAgent.toLocaleLowerCase().match('firefox'),
            ie: (window.navigator.appName === 'Netscape' && window.navigator.userAgent.toLowerCase().indexOf('trident') !== -1) || window.navigator.userAgent.toLowerCase().indexOf('msie') !== -1,
            css3: (function () {
                // ie9 ì´í•˜ëŠ” false
                var rv = true;
                if (window.navigator.appName === 'Microsoft Internet Explorer') {
                    var re = new RegExp('MSIE ([0-9]{1,}[.0-9]{0,})');
                    if (re.exec(window.navigator.userAgent) !== null) {
                        rv = parseFloat(RegExp.$1);
                        if (rv <= 9) rv = false;
                    }
                }
                return rv;
            })()
        },
        $win = $(window),
        capturing = function (e) {
            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValues = false;
            }
        },
        bubbling = function (e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            } else {
                e.cancelBubble = true;
            }
        };

    JdSlider = (function () {

        var sliderIdx = 0;

        function JdSlider(element, options) {

            var _ = this;

            _.obj = $(element);
            _.options = options;
            _.opt = $.extend({}, defaults, options);

            _.idx = sliderIdx;
            sliderIdx++;

            _.winW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            _.wrap = null;
            _.slide = null;
            _.prev = null;
            _.next = null;
            _.auto = null;
            _.indicate = null;
            _.marginRight = null;
            _.duration = null;
            _.init().selectorSet();

            _.transition = function (selector, property) {
                selector.css({
                    webkitTransition: property + ' ' + _.duration + 'ms ' + _.opt.timingFunction,
                    transition: property + ' ' + _.duration + 'ms ' + _.opt.timingFunction
                });
            };
            _.transitionNone = function (selector) {
                selector.css({
                    webkitTransition: '',
                    transition: ''
                });
            };

            _.swipes = {
                touch: null,
                touchStep: null,
                touchX1: null,
                touchX2: null,
                touchY1: null,
                touchY2: null,
                touchMoveX: null,
                touchMoveY: null,
                startPosition: null,
                position: {
                    prev: null,
                    current: null
                },
                scrolling: null,
            };

            _.setTimer1 = null;
            _.setTimer2 = null;
            _.setLoop = null;

            _.isMotion = false;
            _.responsiveLen = null;

            _.init().func(true);
            _.visibilityChange().event();
            _.resize().event();
            _.trigger().event();
        }

        return JdSlider;
    })();

    JdSlider.prototype.init = function () {
        var _ = this,
            isFirst = null,
            firstChk = function () {
                if (_.obj.hasClass(_.opt.noSliderClass)) isFirst = true;
            },
            iosBug = function () {
                if (isFirst && is.ios) $win.on('touchmove', function () {});
            },
            responsiveSet = function () {
                var len = _.opt.responsive.length,
                    i = 0,
                    optInit;
                if (len) {
                    if (_.responsiveLen === null) {
                        // responsiveLen ê°’ì´ null ì¼ ê²½ìš° ë³€ìˆ˜ ì„¤ì •
                        if (_.winW <= _.opt.responsive[0].viewSize) {
                            _.responsiveLen = 0;
                        }
                        if (len > 1) {
                            for (; i < len - 1; i++) {
                                if (_.winW > _.opt.responsive[i].viewSize && _.winW <= _.opt.responsive[i + 1].viewSize) {
                                    _.responsiveLen = i + 1;
                                }
                            }
                        }
                        if (_.winW > _.opt.responsive[len - 1].viewSize) {
                            _.responsiveLen = -1;
                        }
                    }
                    // í•´ë‹¹ ì„¤ì • í¬í•¨ì‹œ ë¦¬ì…‹
                    for (; i < len; i++) {
                        // slideToScroll ì„¤ì •ì´ ìžˆê±°ë‚˜ {isLoop: true} ê°€ ì•„ë‹Œ ìƒíƒœì—ì„œ slideShow ì„¤ì •ì´ ìžˆì„ ê²½ìš°
                        if (_.opt.responsive[i].settings.slideToScroll || (_.opt.responsive[i].settings.slideShow && (!_.opt.isLoop || _.opt.responsive[i].settings.isLoop !== undefined))) {
                            isFirst = true;
                        }
                    }
                    // options ê°’ ë³‘í•©
                    if (_.responsiveLen === -1) {
                        _.opt = $.extend({}, defaults, _.options);
                    } else {
                        optInit = $.extend({}, defaults, _.options);
                        _.opt = $.extend({}, optInit, optInit.responsive[_.responsiveLen].settings);
                    }
                }
            },
            selectorSet = function () {
                _.wrap = _.opt.wrap === null ? _.obj : _.obj.find(_.opt.wrap).eq(0);
                _.slide = _.obj.find(_.opt.slide).eq(0);
                _.prev = _.obj.find(_.opt.prev);
                _.next = _.obj.find(_.opt.next);
                _.auto = _.obj.find(_.opt.auto);
                _.indicate = _.obj.find(_.opt.indicate);
                _.marginRight = _.opt.margin;
                _.duration = _.opt.speed;
            },
            transitionOff = function () {
                _.transitionNone(_.slide);
                _.transitionNone(_.slide.find('>*'));
            },
            cloneRemove = function () {
                if (_.slide.find('>.clone')[0]) _.slide.find('>.clone').remove();
            },
            state = {
                stop: function () {
                    _.setting().reset();
                    _.update().func();
                    _.currentTab().func(false);
                    _.rendering3D().func();
                    _.imgDrag().func();
                    _.indicate.hide().find('.on').removeClass('on');
                    _.obj.addClass(_.opt.noSliderClass);
                    if (_.auto.attr('data-state') === 'false') _.control().auto();
                },
                play: {
                    all: function () {
                        if (_.slide.find('>*').css('float') !== 'none') _.slide.find('>*').css('display', 'block');
                        _.setting().reset();
                        _.setting().init();
                        _.swipe().init();
                        _.control().extreme();
                        _.update().func();
                        _.currentTab().func(true);
                        _.rendering3D().func();
                        _.imgDrag().func();
                    },
                    sliding: function () {
                        var slideLen = _.slide.find('>*').not('.clone').length,
                            i = 0;
                        // ìŠ¬ë¼ì´ë”© off í´ëž˜ìŠ¤ ì œê±°
                        _.obj.removeClass(_.opt.noSliderClass);
                        // íŠ¸ëžœì§€ì…˜ ì„¤ì •
                        _.transition(_.slide, 'transform');
                        // ë¬´í•œë£¨í”„ì‹œ í´ë¡  ìƒì„±
                        if (_.opt.isLoop && _.opt.isSliding) {
                            var cloneLen = _.opt.isOverflow ? slideLen : _.opt.slideShow + _.opt.slideToScroll - 1,
                                slideChildL = [],
                                slideChildR = [];
                            for (; i < cloneLen; i++) {
                                // ëì—ì„œë¶€í„°
                                slideChildL[cloneLen - 1 - i] = _.slide.find('>*').not('.clone').eq(slideLen - 1 - i % slideLen).clone().addClass('clone')[0].outerHTML;
                                // ì²˜ìŒë¶€í„°
                                slideChildR[i] = _.slide.find('>*').not('.clone').eq(i % slideLen).clone().addClass('clone')[0].outerHTML;
                            }
                            _.slide[0].innerHTML = slideChildL.join('') + _.slide[0].innerHTML + slideChildR.join('');
                        }
                    },
                    fadeslider: function () {
                        _.transition(_.slide.find('>*'), 'opacity');
                    }
                }
            },
            slideStartSet = function () {

                 _.auto.attr('data-state', _.opt.isAuto);
                    _.control().auto();
                // ì‹œìž‘ ìŠ¬ë¼ì´ë“œ ë…¸ì¶œ ì„¤ì •
                if (isFirst) {
                    _.slide.attr('data-index', _.opt.slideStart - 1).find('>*').removeClass('on').not('.clone').eq(_.opt.slideStart - 1).addClass('on');
                    if (!_.opt.isSliding) {
                        _.slide.find('>.on').css('opacity', 1).siblings().css('opacity', '');
                        setTimeout(function () {
                            _.transition(_.slide.find('>*'), 'opacity');
                        });
                    }
                } else {
                    _.slide.find('>.clone.on').removeClass('on');
                }
            },
            indicateSet = function () {
                var slideLen = _.slide.find('>*').not('.clone').length,
                    i = 0;
                if (_.opt.isIndicate) {
                    // {isLoop: false} or ìŠ¬ë¼ì´ë“œ ì´ë™ ê°„ê²©ì´ ì¼ì •í•˜ì§€ ì•Šì€ ê²½ìš°
                    if (!_.opt.isLoop || (slideLen - _.opt.slideShow) % _.opt.slideToScroll === 0) {
                        // ì„¤ì •ëœ ì¸ë””ì¼€ì´íŠ¸ ê°¯ìˆ˜ê°€ ë§žì§€ ì•ŠëŠ” ê²½ìš°
                        if (Math.ceil((slideLen - _.opt.slideShow) / _.opt.slideToScroll) !== _.indicate.find('>*').length - 1) {
                            var listArr = [];
                            if (_.opt.isLoop) {
                                if (_.opt.slideToScroll === 1) {
                                    for (; i <= slideLen - 1; i++) {
                                        listArr[i] = _.opt.indicateList(i + 1);
                                    }
                                }
                            } else {
                                for (; i <= Math.ceil((slideLen - _.opt.slideShow) / _.opt.slideToScroll); i++) {
                                    listArr[i] = _.opt.indicateList(i + 1);
                                }
                            }
                            _.indicate.empty().append(listArr);
                        }
                        // ì²˜ìŒì´ê±°ë‚˜ ì¸ë””ì¼€ì´íŠ¸ í™œì„±í™” ì„¤ì •ì´ ì•ˆë˜ì–´ìžˆëŠ” ê²½ìš°
                        if (isFirst || !_.indicate.find('.on')[0]) {
                            _.slide.attr('data-index', _.opt.slideStart - 1);
                            _.indicate.find('a,button').eq(_.opt.slideStart - 1).addClass('on').siblings().removeClass('on');
                        }
                        _.indicate.show();
                    } else {
                        _.indicate.hide();
                    }
                }
            },
            indicateActiveSet = function () {
                // data-index ë³€ê²½ì— ë”°ë¥¸ ì¸ë””ì¼€ì´íŠ¸ í™œì„±í™” ìˆ˜ì •
                if (!isFirst) _.indicate.find('a,button').removeClass('on').eq(Number(_.slide.attr('data-index'))).addClass('on');
            },
            autoPlaySet = function () {
                if (isFirst) {
                   
                    _.auto.attr('data-state', _.opt.isAuto);
                    _.control().auto();
                } else {
                    if (_.opt.autoState !== '_.auto') _.auto.attr('data-state', _.opt.isAuto);
                }
            },
            func = function (firstFlag) {
                isFirst = firstFlag;
                // ì´ˆê¸°í™”
                firstChk();
                iosBug();
                transitionOff();
                cloneRemove();
                // ì„¤ì •
                responsiveSet();
                selectorSet();
                if (!_.opt.isUse || _.slide.find('>*').not('.clone').length <= _.opt.slideShow) {
                    state.stop();
                } else {
                    if (_.opt.isSliding) state.play.sliding();
                    else state.play.fadeslider();
                    slideStartSet();
                    indicateSet();
                    state.play.all();
                    indicateActiveSet();
                    autoPlaySet();
                }
            };

        return {
            transitionOff: transitionOff,
            cloneRemove: cloneRemove,
            selectorSet: selectorSet,
            func: func
        };
    };

    JdSlider.prototype.currentTab = function () {
        var _ = this,
            set = function (isMoveAfter) {
                if (!isMoveAfter) {
                    _.slide.find('>*').attr({tabindex: '-1', 'aria-hidden': 'true'}).find('a,button').attr({tabindex: '-1', 'aria-hidden': 'true'});
                } else {
                    var $focus = $(document.activeElement),
                        onIdx = _.slide.find('>.on').index(),
                        i = 0;
                    _.slide.find('>.show').removeClass('show');
                    for (; i < _.opt.slideShow; i++) {
                        _.slide.find('>*').eq(onIdx + i).addClass('show');
                    }
                    _.slide.find('>*').attr('tabindex', '-1').not('.show').attr('aria-hidden', 'true').find('a,button').attr({tabindex: '-1', 'aria-hidden': 'true'});
                    _.slide.find('>.show').attr('aria-hidden', 'false').find('a,button').removeAttr('tabindex').attr('aria-hidden', 'false');
                    if ($focus.closest(_.opt.slide)[0]) $focus.blur();
                }
            },
            reset = function () {
                _.slide.find('>*').removeAttr('tabindex aria-hidden').find('a,button').removeAttr('tabindex aria-hidden');
            },
            func = function (isMoveAfter) {
                if (_.opt.isUse && _.slide.find('>*').not('.clone').length > _.opt.slideShow) set(isMoveAfter);
                else reset();
            };

        return {
            reset: reset,
            func: func
        };
    };

    JdSlider.prototype.rendering3D = function () {
        var _ = this,
            set = function () {
                _.slide.css({
                    webkitPerspective: '1000px',
                    perspective: '1000px',
                    webkitBackfaceVisibility: 'hidden',
                    backfaceVisibility: 'hidden'
                });
            },
            reset = function () {
                _.slide.css({
                    webkitPerspective: '',
                    perspective: '',
                    webkitBackfaceVisibility: '',
                    backfaceVisibility: ''
                });
            },
            func = function () {
                if (!is.ie) {
                    if (_.opt.isSliding && _.opt.isUse && _.slide.find('>*').not('.clone').length > _.opt.slideShow) set();
                    else reset();
                }
            };

        return {
            reset: reset,
            func: func
        };
    };

    JdSlider.prototype.imgDrag = function () {
        var _ = this,
            set = function () {
                if (is.ff) {
                    _.slide.find('a,img').on('dragstart', function () {
                        return false;
                    });
                } else {
                    _.slide.find('a,img').css('-webkit-user-drag', 'none');
                }
            },
            reset = function () {
                if (is.ff) {
                    _.slide.find('a,img').off('dragstart', function () {
                        return false;
                    });
                } else {
                    _.slide.find('a,img').css('-webkit-user-drag', '');
                }
            },
            func = function () {
                if (_.opt.isDrag && _.opt.isUse && _.slide.find('>*').not('.clone').length > _.opt.slideShow) {
                    set();
                } else {
                    reset();
                }
            };

        return {
            reset: reset,
            func: func
        };
    };

    JdSlider.prototype.update = function () {
        var _ = this,
            totalLen = null,
            slideLen = null,
            firstIdx = null,
            currentIdx = null,
            slideWid = null,
            wrapW = null,
            x = null,
            margin = function () {
                // margin
                if (_.opt.margin !== null) {
                    _.marginRight = _.opt.margin.toString().indexOf('%') !== -1 ? parseFloat(_.opt.margin) * wrapW / 100 : parseFloat(_.opt.margin);
                    _.slide.find('>*').css('marginRight', _.marginRight + 'px');
                } else {
                    _.marginRight = parseFloat(_.slide.find('>*').css('marginRight'));
                }
            },
            width = function () {
                totalLen = _.slide.find('>*').length;
                slideLen = _.slide.find('>*').not('.clone').length;
                // width
                if (window.getComputedStyle){
                    if (window.getComputedStyle(_.wrap[0], null).width.split('px')[0].indexOf('.') !== -1) {
                        _.wrap.css('width', wrapW);
                    }
                }
                _.slide.find('>*').css('width', Math.ceil((wrapW - (_.opt.slideShow - 1) * _.marginRight) / _.opt.slideShow) + 'px'); // li ë„ˆë¹„
                firstIdx = _.slide.find('>*').not('.clone').eq(0).index();
                currentIdx = _.slide.find('>.on').index() - firstIdx;
                slideWid = parseFloat(_.slide.find('>*')[0].style.width) + _.marginRight;
                x = !_.opt.isLoop && _.slide.attr('data-index') >= Math.ceil((slideLen - _.opt.slideShow) / _.opt.slideToScroll)
                    ? -slideWid * (firstIdx + slideLen - _.opt.slideShow)
                    : -slideWid * (firstIdx + currentIdx);
                if (is.css3) {
                    _.transitionNone(_.slide);
                    _.slide.css({
                        width: totalLen * slideWid + 'px',
                        webkitTransform: 'translate3d(' + x + 'px,0,0)',
                        transform: 'translate3d(' + x + 'px,0,0)'
                    });
                    setTimeout(function () {
                        _.transition(_.slide, 'transform');
                    });
                } else {
                    _.slide.css({
                        width: totalLen * slideWid + 'px',
                        marginLeft: x + 'px'
                    });
                }
            },
            reset = function () {
                _.wrap.css('width', '');
                if (is.css3) {
                    _.slide.css({
                        width: '',
                        webkitTransform: '',
                        transform: ''
                    });
                } else {
                    _.slide.css({
                        width: '',
                        marginLeft: ''
                    });
                }
                _.slide.find('>*').css({
                    display: '',
                    width: '',
                    marginRight: ''
                });
            },
            func = function () {
                _.slide.attr('data-hover', 'true'); // ìŠ¤íƒ€ì¼ ì¡°ì • ë„ì¤‘ ìžë™í”Œë ˆì´ ë°©ì§€
                slideLen = _.slide.find('>*').not('.clone').length;
                if (!_.opt.isSliding || !_.opt.isUse || slideLen <= _.opt.slideShow) {
                    reset();
                } else {
                    _.wrap.css('width', '');
                    wrapW = window.getComputedStyle
                        ? window.getComputedStyle(_.wrap[0], null).width.split('px')[0]
                        : _.wrap.width();
                    margin();
                    width();
                }
                _.slide.attr('data-hover', 'false'); // ìŠ¤íƒ€ì¼ ì¡°ì • ë„ì¤‘ ìžë™í”Œë ˆì´ ë°©ì§€ í•´ì œ
            };

        return {
            reset: reset,
            func: func
        };
    };

    JdSlider.prototype.setting = function () {
        var _ = this,
            init = function () {
                var slideLen = _.slide.find('>*').not('.clone').length,
                    slideIdx = _.slide.find('>.on').index(),
                    firstIdx = _.slide.find('>*').not('.clone').eq(0).index(),
                    thisIdx =
                        !_.opt.isLoop && slideIdx - firstIdx >= slideLen - _.opt.slideShow
                            ? Math.ceil((slideLen - _.opt.slideShow) / _.opt.slideToScroll)
                            : Math.floor((slideIdx - firstIdx) / _.opt.slideToScroll);
                _.slide
                    .attr({
                        'data-hover': 'false',
                        'data-index': thisIdx
                    })
                    .on('click', $.proxy(_.swipe(), 'clickFn'));
                _.obj
                    .on('click', _.opt.prev, function () {
                        this.focus();
                        _.control().prev.func();
                        if (_.auto.attr('data-state') === 'false') _.setting().auto();
                        _.opt.onPrev();
                        return false;
                    })
                    .on('click', _.opt.next, function () {
                        this.focus();
                        _.control().next.func();
                        if (_.auto.attr('data-state') === 'false') _.setting().auto();
                        _.opt.onNext();
                        return false;
                    })
                    .on('click', _.opt.indicate + ' a,' + _.opt.indicate + ' button', function () {
                            var $this = $(this);
                            this.focus();
                            _.control().indicate.func($this);
                            if (_.auto.attr('data-state') === 'false') _.setting().auto();
                            _.opt.onIndicate();
                            return false;
                        }
                    )
                    .on('click', _.opt.auto, function () {
                        _.control().auto();
                        _.opt.onAuto();
                        return false;
                    })
                    .on('keydown', _.opt.prev, function (e) {
                        if (e.keyCode === 13) {
                            if (!_.opt.isLoop && Number(_.slide.attr('data-index')) === 1) {
                                _.next.addClass(_.opt.willFocusClass);
                            }
                        }
                    })
                    .on('keydown', _.opt.next, function (e) {
                        if (e.keyCode === 13) {
                            if (!_.opt.isLoop && Number(_.slide.attr('data-index')) === Math.ceil((_.slide.find('>*').length - _.opt.slideShow) / _.opt.slideToScroll - 1)) {
                                _.prev.addClass(_.opt.willFocusClass);
                            }
                        }
                    });
                if (!is.mobile && _.opt.isCursor) {
                    // ì›¹ì—ì„œ ë§ˆìš°ìŠ¤ ì˜¤ë²„ ë„ì¤‘ ìžë™í”Œë ˆì´ ë°©ì§€ ì„¤ì •
                    _.slide
                        .on('mouseover', hover.isTrue)
                        .on('mouseout', hover.isFalse);
                    _.prev
                        .on('mouseover', hover.isTrue)
                        .on('mouseout', hover.isFalse);
                    _.next
                        .on('mouseover', hover.isTrue)
                        .on('mouseout', hover.isFalse);
                    _.indicate.find('a,button')
                        .on('mouseover', hover.isTrue)
                        .on('mouseout', hover.isFalse);
                    _.auto
                        .on('mouseover', hover.isTrue)
                        .on('mouseout', hover.isFalse);
                }
                if (_.opt.isTouch) {
                    _.slide
                        .on('touchstart', $.proxy(_.swipe(), 'touchStartFn'))
                        .on('touchmove', $.proxy(_.swipe(), 'touchMoveFn'))
                        .on('touchend', $.proxy(_.swipe(), 'touchEndFn'));
                }
                if (_.opt.isDrag) {
                    _.slide
                        .on('mousedown', $.proxy(_.swipe(), 'dragStartFn'))
                        .on('mousemove', $.proxy(_.swipe(), 'dragMoveFn'))
                        .on('mouseup mouseleave', $.proxy(_.swipe(), 'dragEndFn'));
                }
            },
            hover = {
                isTrue: function () {
                    _.slide.attr('data-hover', 'true');
                },
                isFalse: function () {
                    _.slide.attr('data-hover', 'false');
                }
            },
            auto = function () {
                if (!_.opt.isCustomAuto) {
                    if (_.setTimer1) clearInterval(_.setTimer1);
                    if (_.setTimer2) clearInterval(_.setTimer2);
                    _.setTimer1 = setTimeout(function () {
                        _.control().interval();
                        _.setTimer2 = setInterval(
                            _.control().interval,
                            _.opt.interval + _.duration
                        );
                    }, _.opt.interval);
                }
            },
            reset = function () {
                _.slide.removeAttr('data-hover');
                _.obj.off('click', _.opt.prev);
                _.obj.off('click', _.opt.next);
                _.obj.off('click', _.opt.indicate + ' a,' + _.opt.indicate + ' button');
                _.obj.off('click', _.opt.auto);
                if (!is.mobile) {
                    _.slide
                        .off('mouseover', hover.isTrue)
                        .off('mouseout', hover.isFalse);
                    _.prev
                        .off('mouseover', hover.isTrue)
                        .off('mouseout', hover.isFalse);
                    _.next
                        .off('mouseover', hover.isTrue)
                        .off('mouseout', hover.isFalse);
                    _.indicate.find('a,button')
                        .off('mouseover', hover.isTrue)
                        .off('mouseout', hover.isFalse);
                    _.auto
                        .off('mouseover', hover.isTrue)
                        .off('mouseout', hover.isFalse);
                }
                _.slide
                    .off('touchstart', $.proxy(_.swipe(), 'touchStartFn'))
                    .off('touchmove', $.proxy(_.swipe(), 'touchMoveFn'))
                    .off('touchend', $.proxy(_.swipe(), 'touchEndFn'))
                    .off('mousedown', $.proxy(_.swipe(), 'dragStartFn'))
                    .off('mousemove', $.proxy(_.swipe(), 'dragMoveFn'))
                    .off('mouseup mouseleave', $.proxy(_.swipe(), 'dragEndFn'));
            };

        return {
            init: init,
            hover: hover,
            auto: auto,
            reset: reset
        };
    };

    JdSlider.prototype.control = function () {
        var _ = this,
            prev = {
                slideLen: null,
                slideIdx: null,
                firstIdx: null,
                indicateIdx: null,
                slideWid: null,
                x: null,
                unmove: function () {
                    // ë°˜ë³µx, ì²˜ìŒì—ì„œ ì œì–´
                    if (_.opt.isSliding) {
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(0,0,0)',
                                transform: 'translate3d(0,0,0)'
                            });
                            setTimeout(function () {
                                _.isMotion = false;
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                marginLeft: 0
                            }, _.duration, _.opt.easing, function () {
                                _.isMotion = false;
                            });
                        }
                    } else {
                        _.isMotion = false;
                    }
                },
                uneven: function () {
                    // ë°˜ë³µx, ìŠ¬ë¼ì´ë“œ ì´ë™ ê°„ê²©ì´ ì¼ì •í•˜ì§€ ì•Šì€ ê²½ìš°, ëì—ì„œ ì œì–´
                    // ì „ì²´ - ì”¬ë‹¹ ë…¸ì¶œìˆ˜ - ì „ì²´ì—ì„œ ë³€ê²½ë˜ëŠ” ì”¬ ê°¯ìˆ˜ë¥¼ ë‚˜ëˆˆ ë‚˜ë¨¸ì§€
                    var afterIdx = this.slideLen - _.opt.slideShow - (this.slideLen - _.opt.slideShow) % _.opt.slideToScroll;
                    _.transition(_.slide, 'transform');
                    _.slide.find('>.on').removeClass('on');
                    _.slide.find('>*').eq(afterIdx).addClass('on');
                    _.slide.attr('data-index', parseInt(_.slide.attr('data-index')) - 1);
                    if (_.opt.isIndicate) {
                        _.indicate.find('.on').removeClass('on');
                        _.indicate.find('a,button').eq(this.indicateIdx - 1).addClass('on');
                    }
                    extreme();
                    _.opt.progress();
                    _.currentTab().func(false);
                    if (_.opt.isSliding) {
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + -this.slideWid * afterIdx + 'px,0,0)',
                                transform: 'translate3d(' + -this.slideWid * afterIdx + 'px,0,0)'
                            });
                            setTimeout(function () {
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: -this.slideWid * afterIdx + 'px'
                                }, _.duration, _.opt.easing, function () {
                                    _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    } else {
                        setTimeout(function () {
                            _.opt.callback();
                            _.isMotion = false;
                            _.currentTab().func(true);
                        }, _.duration);
                    }
                },
                base: function () {
                    // ê¸°ë³¸
                    _.transition(_.slide, 'transform');
                    if (_.opt.isSliding) {
                        _.slide.find('>.on').removeClass('on');
                        _.slide.find('>*').eq(this.slideIdx - _.opt.slideToScroll).addClass('on');
                    } else {
                        if (is.css3) {
                            _.slide.find('>.on').removeClass('on');
                        } else {
                            _.slide.find('>.on').removeClass('on').stop().animate({
                                opacity: 0
                            }, _.duration, _.opt.easing);
                        }
                        if (this.slideIdx === this.firstIdx) {
                            _.slide.find('>*').eq(this.slideLen - _.opt.slideShow).addClass('on');
                        } else {
                            _.slide.find('>*').eq(this.slideIdx - _.opt.slideToScroll).addClass('on');
                        }
                    }
                    if (parseInt(_.slide.attr('data-index')) === 0) {
                        if (_.opt.isLoop) {
                            _.slide.attr('data-index', this.slideLen - 1);
                        } else {
                            _.slide.attr('data-index', Math.ceil((this.slideLen - _.opt.slideShow) / _.opt.slideToScroll));
                        }
                    } else {
                        _.slide.attr('data-index', parseInt(_.slide.attr('data-index')) - 1);
                    }

                    if (_.opt.isIndicate) {
                        _.indicate.find('.on').removeClass('on');
                        if (this.indicateIdx !== 0) {
                            _.indicate.find('a,button').eq(this.indicateIdx - 1).addClass('on');
                        } else {
                            _.indicate.find('a,button').eq(-1).addClass('on');
                        }
                    }
                    extreme();
                    _.opt.progress();
                    _.currentTab().func(false);
                    if (_.opt.isSliding) {
                        this.x = -this.slideWid * (this.slideIdx - _.opt.slideToScroll);
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + this.x + 'px,0,0)',
                                transform: 'translate3d(' + this.x + 'px,0,0)'
                            });
                            setTimeout(function () {
                                if (_.slide.find('>.on').hasClass('clone')) {
                                    _.transitionNone(_.slide);
                                    _.slide.css({
                                        webkitTransform: 'translate3d(' + (prev.x - prev.slideWid * prev.slideLen) + 'px,0,0)',
                                        transform: 'translate3d(' + (prev.x - prev.slideWid * prev.slideLen) + 'px,0,0)'
                                    });
                                    _.slide.find('>.on').removeClass('on');
                                    _.slide.find('>*').eq(prev.slideIdx - _.opt.slideToScroll + prev.slideLen).addClass('on');
                                }
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: this.x + 'px'
                                }, _.duration, _.opt.easing, function () {
                                    if (_.slide.find('>.on').hasClass('clone')) {
                                        _.slide.css('marginLeft', prev.x - prev.slideWid * prev.slideLen + 'px');
                                        _.slide.find('>.on').removeClass('on');
                                        _.slide.find('>*').eq(prev.slideIdx - _.opt.slideToScroll + prev.slideLen).addClass('on');
                                    }
                                    _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    } else {
                        if (is.css3) {
                            _.slide.find('>.on').css('opacity', 1).siblings().css('opacity', 0);
                            setTimeout(function () {
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.find('>.on').stop().animate({
                                    opacity: 1
                                }, _.duration, _.opt.easing, function () {
                                    _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    }
                },
                func: function () {
                    this.slideLen = _.slide.find('>*').not('.clone').length;
                    this.slideIdx = _.slide.find('>.on').index();
                    this.firstIdx = _.slide.find('>*').not('.clone').eq(0).index();
                    this.indicateIdx = parseInt(_.slide.attr('data-index'));
                    if (_.isMotion) return false;
                    _.isMotion = true;
                    this.slideWid = parseFloat(_.slide.find('>*')[0].style.width) + _.marginRight;
                    if (!_.opt.isLoop && this.slideIdx === 0) {
                        this.unmove();
                    } else if (!_.opt.isLoop && this.slideIdx === this.slideLen - _.opt.slideShow && (this.slideLen - _.opt.slideShow) % _.opt.slideToScroll !== 0) {
                        this.uneven();
                    } else {
                        this.base();
                    }
                }
            },
            next = {
                slideLen: null,
                slideIdx: null,
                firstIdx: null,
                indicateIdx: null,
                slideWid: null,
                x: null,
                unmove: function () {
                    // ë°˜ë³µx, ë§ˆì§€ë§‰ì—ì„œì—ì„œ ì œì–´
                    if (_.opt.isSliding) {
                        this.x = -this.slideWid * (this.slideLen - _.opt.slideShow);
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + this.x + 'px,0,0)',
                                transform: 'translate3d(' + this.x + 'px,0,0)'
                            });
                            setTimeout(function () {
                                _.isMotion = false;
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: this.x + 'px'
                                }, _.duration, _.opt.easing, function () {
                                    _.isMotion = false;
                                }
                            );
                        }
                    } else {
                        _.isMotion = false;
                    }
                },
                uneven: function () {
                    // ë°˜ë³µx, ìŠ¬ë¼ì´ë“œ ì´ë™ ê°„ê²©ì´ ì¼ì •í•˜ì§€ ì•Šì€ ê²½ìš°, ë ì „ì—ì„œ ì œì–´
                    _.transition(_.slide, 'transform');
                    _.slide.find('>.on').removeClass('on');
                    _.slide.find('>*').eq(this.slideLen - _.opt.slideShow).addClass('on');
                    _.slide.attr('data-index', parseInt(_.slide.attr('data-index')) + 1);
                    if (_.opt.isIndicate) {
                        _.indicate.find('.on').removeClass('on');
                        _.indicate.find('a,button').eq(this.indicateIdx + 1).addClass('on');
                    }
                    extreme();
                    _.opt.progress();
                    _.currentTab().func(false);
                    if (_.opt.isSliding) {
                        this.x = -this.slideWid * (this.slideLen - _.opt.slideShow);
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + this.x + 'px,0,0)',
                                transform: 'translate3d(' + this.x + 'px,0,0)'
                            });
                            setTimeout(function () {
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: this.x + 'px'
                                }, _.duration, _.opt.easing, function () {
                                    _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    } else {
                        setTimeout(function () {
                            _.opt.callback();
                            _.isMotion = false;
                            _.currentTab().func(true);
                        }, _.duration);
                    }
                },
                base: function () {
                    // ê¸°ë³¸
                    _.transition(_.slide, 'transform');
                    if (_.opt.isSliding) {
                        _.slide.find('>.on').removeClass('on');
                        _.slide.find('>*').eq(this.slideIdx + _.opt.slideToScroll).addClass('on');
                    } else {
                        if (is.css3) {
                            _.slide.find('>.on').removeClass('on');
                        } else {
                            _.slide.find('>.on').removeClass('on').stop().animate({
                                opacity: 0
                            }, _.duration, _.opt.easing);
                        }
                        if (this.slideIdx === this.slideLen - _.opt.slideToScroll) {
                            _.slide.find('>*').eq(this.firstIdx).addClass('on');
                        } else {
                            _.slide.find('>*').eq(this.slideIdx + _.opt.slideToScroll).addClass('on');
                        }
                    }
                    if (!_.opt.isLoop && parseInt(_.slide.attr('data-index')) === Math.ceil((this.slideLen - _.opt.slideShow) / _.opt.slideToScroll)) {
                        _.slide.attr('data-index', 0);
                    } else if (_.opt.isLoop && parseInt(_.slide.attr('data-index')) === this.slideLen - 1) {
                        _.slide.attr('data-index', 0);
                    } else {
                        _.slide.attr('data-index', parseInt(_.slide.attr('data-index')) + 1);
                    }
                    if (_.opt.isIndicate) {
                        _.indicate.find('.on').removeClass('on');
                        if (this.indicateIdx !== _.indicate.find('>*').length - 1) {
                            _.indicate.find('a,button').eq(this.indicateIdx + 1).addClass('on');
                        } else {
                            _.indicate.find('a,button').eq(0).addClass('on');
                        }
                    }
                    extreme();
                    _.opt.progress();
                    _.currentTab().func(false);
                    if (_.opt.isSliding) {
                        this.x = -this.slideWid * (this.slideIdx + _.opt.slideToScroll);
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + this.x + 'px,0,0)',
                                transform: 'translate3d(' + this.x + 'px,0,0)'
                            });
                            setTimeout(function () {
                                if (_.slide.find('>.on').hasClass('clone')) {
                                    _.transitionNone(_.slide);
                                    _.slide.css({
                                        webkitTransform: 'translate3d(' + (next.x + next.slideWid * next.slideLen) + 'px,0,0)',
                                        transform: 'translate3d(' + (next.x + next.slideWid * next.slideLen) + 'px,0,0)'
                                    });
                                    _.slide.find('>.on').removeClass('on');
                                    _.slide.find('>*').eq(next.slideIdx - next.slideLen + _.opt.slideToScroll).addClass('on');
                                }
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: this.x + 'px'
                                }, _.duration, _.opt.easing, function () {
                                    if (_.slide.find('>.on').hasClass('clone')) {
                                        _.slide.css('marginLeft', next.x + next.slideWid * next.slideLen + 'px');
                                        _.slide.find('>.on').removeClass('on');
                                        _.slide.find('>*').eq(next.slideIdx - next.slideLen + _.opt.slideToScroll).addClass('on');
                                    }
                                    _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    } else {
                        if (is.css3) {
                            _.slide.find('>.on').css('opacity', 1).siblings().css('opacity', 0);
                            setTimeout(function () {
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.find('>.on').stop().animate({
                                opacity: 1
                            }, _.duration, _.opt.easing, function () {
                                _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            });
                        }
                    }
                },
                func: function () {
                    this.slideLen = _.slide.find('>*').not('.clone').length;
                    this.slideIdx = _.slide.find('>.on').index();
                    this.firstIdx = _.slide.find('>*').not('.clone').eq(0).index();
                    this.indicateIdx = parseInt(_.slide.attr('data-index'));
                    if (_.isMotion) return false;
                    _.isMotion = true;
                    this.slideWid = parseFloat(_.slide.find('>*')[0].style.width) + _.marginRight;
                    if (!_.opt.isLoop && this.slideIdx === this.slideLen - _.opt.slideShow) {
                        this.unmove();
                    } else if (!_.opt.isLoop && this.slideIdx === this.slideLen - _.opt.slideShow - (this.slideLen - _.opt.slideShow) % _.opt.slideToScroll && (this.slideLen - _.opt.slideShow) % _.opt.slideToScroll !== 0) {
                        this.uneven();
                    } else {
                        this.base();
                    }
                }
            },
            indicate = {
                slideLen: null,
                slideIdx: null,
                firstIdx: null,
                prevIdx: null,
                currentIdx: null,
                slideWid: null,
                x: null,
                uneven: function () {
                    _.slide.find('>.on').removeClass('on');
                    if (this.currentIdx === _.indicate.find('>*').length - 1) {
                        _.slide.find('>*').eq(this.slideLen - _.opt.slideShow).addClass('on');
                    } else {
                        _.slide.find('>*').eq(this.firstIdx + this.currentIdx * _.opt.slideToScroll).addClass('on');
                    }
                },
                base: function () {
                    if (is.css3) {
                        _.slide.find('>.on').removeClass('on');
                    } else {
                        _.slide.find('>.on').removeClass('on');
                    }
                    _.slide.find('>*').eq(this.firstIdx + this.currentIdx * _.opt.slideToScroll).addClass('on');
                },
                func: function (that, isTrigger) {
                    this.slideLen = _.slide.find('>*').not('.clone').length;
                    this.firstIdx = _.slide.find('>*').not('.clone').eq(0).index();
                    if (_.isMotion) return false;
                    _.isMotion = true;
                    this.prevIdx = that.parent('li')[0] ? _.indicate.find('.on').parent().index() : _.indicate.find('.on').index();
                    this.currentIdx = that.parent('li')[0] ? that.parent().index() : that.index();
                    // í™œì„±í™”ëœ ë²„íŠ¼ í´ë¦­ì‹œ
                    if (this.prevIdx === this.currentIdx) {
                        _.isMotion = false;
                        return false;
                    }
                    this.slideWid = parseFloat(_.slide.find('>*')[0].style.width) + _.marginRight;
                    _.transition(_.slide, 'transform');
                    if (!_.opt.isLoop && (this.slideLen - _.opt.slideShow) % _.opt.slideToScroll !== 0) {
                        this.uneven();
                    } else {
                        this.base();
                    }
                    _.slide.attr('data-index', this.currentIdx);
                    _.indicate.find('.on').removeClass('on');
                    _.indicate.find('a,button').eq(this.currentIdx).addClass('on');
                    extreme();
                    if (!isTrigger) _.opt.progress();
                    _.currentTab().func(false);
                    if (_.opt.isSliding) {
                        this.x = _.opt.isLoop
                            ? -this.slideWid * (this.firstIdx + this.currentIdx * _.opt.slideToScroll)
                            : this.currentIdx === _.indicate.find('>*').length - 1
                                ? -this.slideWid * (this.firstIdx + this.slideLen - _.opt.slideShow)
                                : -this.slideWid * (this.firstIdx + this.currentIdx * _.opt.slideToScroll);
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + this.x + 'px,0,0)',
                                transform: 'translate3d(' + this.x + 'px,0,0)'
                            });
                            setTimeout(function () {
                                if (!isTrigger) _.opt.callback();
                                _.isMotion = false;
                                _.currentTab().func(true);
                            }, _.duration);
                        } else {
                            _.slide.animate({
                                    marginLeft: this.x + 'px'
                                },
                                _.duration,
                                _.opt.easing,
                                function () {
                                    if (!isTrigger) _.opt.callback();
                                    _.isMotion = false;
                                    _.currentTab().func(true);
                                }
                            );
                        }
                    } else {
                        if (is.css3) {
                            _.slide.find('>.on').css('opacity', 1).siblings().css('opacity', 0);
                        } else {
                            _.slide.find('>.on').stop().animate({
                                    opacity: 1
                                },
                                _.duration,
                                _.opt.easing
                            ).siblings().animate({opacity: 0}, _.duration, _.opt.easing);
                        }
                        setTimeout(function () {
                            _.opt.callback();
                            _.isMotion = false;
                            _.currentTab().func(true);
                        }, _.duration);
                    }
                }
            },
            extreme = function () {
                // ë°˜ë³µx and ì²˜ìŒìœ¼ë¡œ ë„ë‹¬ì‹œ
                if (!_.opt.isLoop && Number(_.slide.attr('data-index')) === 0) {
                    _.prev.addClass(_.opt.unusedClass).attr({
                        tabindex: '-1',
                        'aria-hidden': 'true'
                    });
                    if (_.next.hasClass(_.opt.willFocusClass)) {
                        _.next.removeClass(_.opt.willFocusClass).focus();
                    }
                } else if (_.prev.hasClass(_.opt.unusedClass)) {
                    _.prev.removeClass(_.opt.unusedClass).removeAttr('tabindex aria-hidden');
                }
                // ë°˜ë³µx and ë§ˆì§€ë§‰ì„ ë„ë‹¬ì‹œ
                if (!_.opt.isLoop && Number(_.slide.attr('data-index')) === Math.ceil((_.slide.find('>*').length - _.opt.slideShow) / _.opt.slideToScroll)) {
                    _.next.addClass(_.opt.unusedClass).attr({
                        tabindex: '-1',
                        'aria-hidden': 'true'
                    });
                    if (_.prev.hasClass(_.opt.willFocusClass)) {
                        _.prev.removeClass(_.opt.willFocusClass).focus();
                    }
                } else if (_.next.hasClass(_.opt.unusedClass)) {
                    _.next.removeClass(_.opt.unusedClass).removeAttr('tabindex aria-hidden');
                }
            },
            auto = function () {
                // ìž¬ìƒìƒíƒœë¡œ
                if (_.auto.attr('data-state') === 'true') {
                    _.setting().auto();
                    _.auto.addClass(_.opt.pauseClass).removeClass(_.opt.playClass).attr({
                        'data-state': 'false',
                        title: 'ì •ì§€'
                    });
                } else {
                    // ì •ì§€ìƒíƒœë¡œ
                    if ((_.setTimer1 || _.setTimer2) && !_.opt.isCustomAuto) {
                        clearInterval(_.setTimer1);
                        clearInterval(_.setTimer2);
                    }
                    _.auto.addClass(_.opt.playClass).removeClass(_.opt.pauseClass).attr({
                        'data-state': 'true',
                        title: 'ìž¬ìƒ'
                    });
                }
            },
            interval = function () {
                if (_.slide.attr('data-hover') === 'false') {
                    if (_.opt.isLoop) {
                        next.func();
                    } else {
                        var prevIdx = _.indicate.find('.on').index();
                        if (prevIdx !== _.indicate.find('>*').length - 1) {
                            indicate.func(_.indicate.find('a,button').eq(prevIdx + 1));
                        } else {
                            indicate.func(_.indicate.find('a,button').eq(0));
                        }
                        extreme();
                    }
                }
            };

        return {
            prev: prev,
            next: next,
            indicate: indicate,
            extreme: extreme,
            auto: auto,
            interval: interval
        };
    };

    JdSlider.prototype.swipe = function () {
        var _ = this,
            init = function () {
                _.swipes = {
                    touch: null,
                    touchStep: 0,
                    touchX1: null,
                    touchX2: null,
                    touchY1: null,
                    touchY2: null,
                    touchMoveX: null,
                    touchMoveY: null,
                    startPosition: _.slide.css('transform') || _.slide.css('webkitTransform'),
                    resistanceRatio: 1,
                    position: {
                        prev: null,
                        current: null
                    },
                    scrolling: null,
                };
            },
            touchStartFn = function (e) {
                if (!_.isMotion && _.swipes.touchStep === 0) {
                    _.isMotion = true;
                    _.swipes.scrolling = false;
                    _.swipes.touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
                    _.swipes.touchX1 = _.swipes.touch.pageX;
                    _.swipes.touchY1 = _.swipes.touch.pageY;
                    if (_.opt.isSliding) {
                        _.swipes.startPosition = parseFloat(
                            $.trim(_.slide.css('transform').split(',')[4]) ||
                            $.trim(_.slide.css('webkitTransform').split(',')[4])
                        );
                    }
                    _.transitionNone(_.slide);
                    _.swipes.touchStep = 1;
                }
                e.stopPropagation();
            },
            touchMoveFn = function (e) {
                if (_.isMotion && _.swipes.touchStep === 1) {
                    _.swipes.touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
                    _.swipes.touchMoveX = _.swipes.touch.pageX - _.swipes.touchX1;
                    _.swipes.touchMoveY = _.swipes.touch.pageY - _.swipes.touchY1;
                    if (Math.abs(_.swipes.touchMoveX) < Math.abs(_.swipes.touchMoveY)) _.swipes.scrolling = true;
                    if (!_.swipes.scrolling) {
                        if (_.opt.isSliding) {
                            var currentMove;
                            _.swipes.position.current = _.swipes.startPosition + _.swipes.touchMoveX / (_.opt.slideShow / _.opt.slideToScroll);
                            if (!_.opt.isLoop && _.opt.isResistance) {
                                var maxDistance = -(_.slide.width() - _.opt.slideShow * _.slide.find('>.on').outerWidth(true));
                                currentMove = _.swipes.position.current > 0
                                    ? _.swipes.position.current * _.opt.resistanceRatio
                                    : _.swipes.position.current < maxDistance
                                        ? maxDistance + (_.swipes.position.current - maxDistance) * _.opt.resistanceRatio
                                        : _.swipes.position.current;
                            } else {
                                currentMove = _.swipes.position.current;
                            }
                            _.slide.css({
                                webkitTransform: 'translate3d(' + currentMove + 'px,0,0)',
                                transform: 'translate3d(' + currentMove + 'px,0,0)'
                            });
                        }
                        e.preventDefault();
                    }
                }
            },
            touchEndFn = function (e) {
                if (_.isMotion && _.swipes.touchStep === 1) {
                    _.swipes.touchStep = 2;
                    _.swipes.touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
                    _.swipes.touchMoveX = _.swipes.touch.pageX - _.swipes.touchX1;
                    _.swipes.touchMoveY = _.swipes.touch.pageY - _.swipes.touchY1;
                    _.transition(_.slide, 'transform');
                    if (Math.abs(_.swipes.touchMoveX) < _.opt.touchDistance) {
                        _.slide.find('a').off('click touchstart');
                    }
                    if (!_.swipes.scrolling) {
                        if (_.swipes.touchMoveX > _.opt.touchDistance) {
                            _.isMotion = false;
                            _.control().prev.func();
                        } else if (_.swipes.touchMoveX < -_.opt.touchDistance) {
                            _.isMotion = false;
                            _.control().next.func();
                        } else {
                            if (_.opt.isSliding) {
                                _.swipes.position.prev = -(parseFloat(_.slide.find('>.on')[0].style.width) + _.marginRight) * _.slide.find('>.on').index();
                                _.slide.css({
                                    webkitTransform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)',
                                    transform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)'
                                });
                            }
                        }
                        if (_.auto.attr('data-state') === 'false') _.setting().auto();
                        setTimeout(function () {
                            _.swipe().init();
                            _.swipes.scrolling = true;
                            _.isMotion = false;
                        }, _.duration);
                        e.stopPropagation();
                    } else {
                        if (_.opt.isSliding) {
                            _.swipes.position.prev = -(parseFloat(_.slide.find('>.on')[0].style.width) + _.marginRight) * _.slide.find('>.on').index();
                            _.slide.css({
                                webkitTransform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)',
                                transform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)'
                            });
                        }
                        _.swipe().init();
                        _.swipes.scrolling = true;
                        _.isMotion = false;
                    }
                }
            },
            dragStartFn = function (e) {
                if (!_.isMotion && _.swipes.touchStep === 0) {
                    _.isMotion = true;
                    _.swipes.touchX1 = e.pageX;
                    _.swipes.touchY1 = e.pageY;
                    if (_.opt.isSliding) {
                        _.swipes.startPosition = is.ie
                            ? (is.css3
                                ? parseFloat($.trim(_.slide.css('transform').split(',')[12]))
                                : parseFloat(_.slide.css('marginLeft').split('px')[0]))
                            : (parseFloat($.trim(_.slide.css('transform').split(',')[4]) || $.trim(_.slide.css('webkitTransform').split(',')[4])));
                    }
                    _.transitionNone(_.slide);
                    _.swipes.touchStep = 1;
                }
                bubbling(e);
            },
            dragMoveFn = function (e) {
                if (_.isMotion && _.swipes.touchStep === 1) {
                    _.swipes.touchMoveX = e.pageX - _.swipes.touchX1;
                    _.swipes.touchMoveY = e.pageY - _.swipes.touchY1;
                    if (_.opt.isSliding) {
                        var currentMove;
                        _.swipes.position.current = _.swipes.startPosition + _.swipes.touchMoveX / (_.opt.slideShow / _.opt.slideToScroll);
                        if (!_.opt.isLoop && _.opt.isResistance) {
                            var maxDistance = -(_.slide.width() - _.opt.slideShow * _.slide.find('>.on').outerWidth(true));
                            currentMove = _.swipes.position.current > 0
                                ? _.swipes.position.current * _.opt.resistanceRatio
                                : _.swipes.position.current < maxDistance
                                    ? maxDistance + (_.swipes.position.current - maxDistance) * _.opt.resistanceRatio
                                    : _.swipes.position.current;
                        } else {
                            currentMove = _.swipes.position.current;
                        }
                        if (is.css3) {
                            _.slide.css({
                                webkitTransform: 'translate3d(' + currentMove + 'px,0,0)',
                                transform: 'translate3d(' + currentMove + 'px,0,0)'
                            });
                        } else {
                            _.slide.css('marginLeft', currentMove + 'px');
                        }
                        capturing(e);
                    }
                }
            },
            dragEndFn = function (e) {
                if (_.isMotion && _.swipes.touchStep === 1) {
                    _.swipes.touchStep = 2;
                    _.swipes.touchMoveX = e.pageX - _.swipes.touchX1;
                    _.swipes.touchMoveY = e.pageY - _.swipes.touchY1;
                    _.transition(_.slide, 'transform');
                    if (Math.abs(_.swipes.touchMoveX) < _.opt.touchDistance) {
                        _.slide.find('a').off('click touchstart');
                    }
                    if (_.swipes.touchMoveX > _.opt.touchDistance) {
                        _.isMotion = false;
                        _.control().prev.func();
                        bubbling(e);
                    } else if (_.swipes.touchMoveX < -_.opt.touchDistance) {
                        _.isMotion = false;
                        _.control().next.func();
                        bubbling(e);
                    } else {
                        if (_.opt.isSliding) {
                            _.swipes.position.prev = -(parseFloat(_.slide.find('>*')[0].style.width) + _.marginRight) * _.slide.find('>.on').index();
                            if (is.css3) {
                                _.slide.css({
                                    webkitTransform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)',
                                    transform: 'translate3d(' + _.swipes.position.prev + 'px,0,0)'
                                });
                            } else {
                                _.slide.animate({
                                        marginLeft: _.swipes.position.prev + 'px'
                                    },
                                    _.duration,
                                    _.opt.easing
                                );
                            }
                        }
                    }
                    if (_.auto.attr('data-state') === 'false') _.setting().auto();
                    setTimeout(function () {
                        _.swipes.touchStep = 0;
                        _.isMotion = false;
                    }, _.duration);
                }
            },
            clickFn = function (e) {
                if (_.isMotion && Math.abs(_.swipes.touchMoveX) >= _.opt.touchDistance) {
                    capturing(e);
                    bubbling(e);
                } // ìŠ¬ë¼ì´ë“œ ì‹œ í´ë¦­ì´ë²¤íŠ¸ ë°œìƒ ë°©ì§€
            };

        return {
            init: init,
            touchStartFn: touchStartFn,
            touchMoveFn: touchMoveFn,
            touchEndFn: touchEndFn,
            dragStartFn: dragStartFn,
            dragMoveFn: dragMoveFn,
            dragEndFn: dragEndFn,
            clickFn: clickFn
        }
    };

    JdSlider.prototype.remove = function () {
        var _ = this,
            func = function () {
                _.init().transitionOff(); // transition rest
                _.init().cloneRemove(); // clone reset
                _.currentTab().reset(); //
                _.rendering3D().reset();
                _.imgDrag().reset();
                _.update().reset();
                _.setting().reset();
                _.visibilityChange().reset();
                _.resize().reset();
                _.trigger().reset();

                _.slide.removeAttr('data-index');
                _.slide.find('>*').removeClass('on show');
                if (_.prev[0]) _.prev.removeAttr('tabindex aria-hidden').removeClass('hidden');
                if (_.next[0]) _.next.removeAttr('tabindex aria-hidden').removeClass('hidden');
                if (_.auto[0]) _.auto.removeAttr('data-state').removeClass('play pause');
                if (_.indicate[0]) _.indicate[0].innerHTML = '';
            };

        return {
            func: func
        }
    };

    JdSlider.prototype.visibilityChange = function () {
        var _ = this,
            docHidden = null,
            listener = null,
            init = function () {
                if (typeof document.hidden !== 'undefined') {
                    docHidden = 'hidden';
                    listener = 'visibilitychange';
                } else if (typeof document.msHidden !== 'undefined') {
                    docHidden = 'msHidden';
                    listener = 'msvisibilitychange';
                } else if (typeof document.webkitHidden !== 'undefined') {
                    docHidden = 'webkitHidden';
                    listener = 'webkitvisibilitychange';
                }
            },
            func = function () {
                if (document[docHidden]) _.slide.attr('data-hover', 'true');
                else _.update().func();
            },
            event = function () {
                if (!docHidden || !listener) init();
                if (document.addEventListener) document.addEventListener(listener, func);
            },
            reset = function () {
                if (document.removeEventListener) document.removeEventListener(listener, func);
            };

        return {
            func: func,
            event: event,
            reset: reset
        };
    };

    JdSlider.prototype.resize = function () {
        var _ = this,
            func = function () {
                var resizeW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                if (_.winW === resizeW) return false;
                _.winW = resizeW;
                if (_.opt.responsive.length) {
                    // ì²«ë²ˆì§¸ viewSize ë³´ë‹¤ ìž‘ê±°ë‚˜ ê°™ì€ ê²½ìš°
                    if (_.winW <= _.opt.responsive[0].viewSize && _.responsiveLen !== 0) {
                        _.responsiveLen = 0;
                        _.init().func(false);
                        return false;
                    }
                    if (_.opt.responsive.length > 1) {
                        var i = 0;
                        for (; i < _.opt.responsive.length - 1; i++) {
                            // ë„ˆë¹„ê°€ ië²ˆì§¸ viewSize ë³´ë‹¤ í¬ë©´ì„œ i+1ë³´ë‹¤ ìž‘ê±°ë‚˜ ê°™ì€ ê²½ìš°
                            if (_.winW > _.opt.responsive[i].viewSize && _.winW <= _.opt.responsive[i + 1].viewSize && _.responsiveLen !== i + 1) {
                                _.responsiveLen = i + 1;
                                i = 99; // í˜„ ì‹œì ì—ì„œ ì¢…ë£Œ
                                _.init().func(false);
                            }
                        }
                        if (i === 99) return false;
                    }
                    // viewSize ë³´ë‹¤ ë„ˆë¹„ê°€ í° ê²½ìš° (ê¸°ë³¸ ì†ì„± ì ìš©ì‹œ)
                    if (_.winW > _.opt.responsive[_.opt.responsive.length - 1].viewSize && _.responsiveLen !== -1) {
                        _.responsiveLen = -1;
                        _.init().func(false);
                        return false;
                    }
                }
                // ë¶„ê¸° ì „í™˜ì´ ì´ë£¨ì–´ì§€ì§€ ì•Šì€ ê²½ìš°
                _.update().func();
            },
            handler = function () {
                clearTimeout(_.setLoop);
                _.resize().func();
                _.setLoop = setTimeout(_.resize().func, 100);
            },
            event = function () {
                $win.on('resize.jd-' + _.idx, _.resize().handler);
            },
            reset = function () {
                $win.off('resize.jd-' + _.idx, _.resize().handler);
            };

        return {
            func: func,
            handler: handler,
            event: event,
            reset: reset
        };
    };

    JdSlider.prototype.trigger = function () {
        var _ = this,
            event = function () {
                _.obj
                    .on('init slideInit', $.proxy(_.init(), 'func')) // êµ¬ì¡° ì´ˆê¸°í™”
                    .on('update', $.proxy(_.update(), 'func')) // size ì´ˆê¸°í™”
                    .on('resizeFn', $.proxy(_.resize(), 'func')) // ë°˜ì‘í˜• ë¶„ê¸°ê°€ ë³€ê²½ ë˜ì—ˆì„ ì‹œì—ëŠ” init, ê°™ì€ ë¶„ê¸°ì¼ ì‹œì—ëŠ” update ì‹¤í–‰.
                    .on('removeFn', $.proxy(_.remove(), 'func')); // ìŠ¬ë¼ì´ë” ê¸°ëŠ¥ ì œê±°
                _.indicate.find('a,button').on('moveTo', function () {
                    _.control().indicate.func($(this), true);
                });
            },
            reset = function () {
                _.obj
                    .off('init slideInit', $.proxy(_.init(), 'func'))
                    .off('update', $.proxy(_.update(), 'func'))
                    .off('resizeFn', $.proxy(_.resize(), 'func'))
                    .off('removeFn', $.proxy(_.remove(), 'func'));
                _.indicate.find('a,button').off('moveTo', function () {
                    _.control().indicate.func($(this), true);
                });
            };

        return {
            event: event,
            reset: reset
        };
    };

    $.fn.jdSlider = function (options) {
        var len = this.length,
            i = 0;
        for (; i < len; i++) {
            if (typeof options === 'object' || typeof options === 'undefined') {
                this[i].jdSlider = new JdSlider(this[i], options);
            }
        }
        return this;
    };

}));
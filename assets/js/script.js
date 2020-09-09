/*!
 * Created by emmanuelkwene on 20/03/2016.
 */
jQuery(document).ready(function ($) {
    var navigation_mobile_wrapper = $(document.getElementById('l-navigation-mobile'));
    var navigation_mobile = navigation_mobile_wrapper.find('nav').first();
    var navigation_mobile_title = navigation_mobile_wrapper.find('#navigation-title-name');
    var navigation_pill = [navigation_mobile_title.html().trim()];
    var site_header = $('#l-header');
    var site_header_shower = $('#header-shower');
    var navigation_desktop = $(document.getElementById('l-navigation'));
    var navigation_desktop_menu_items = navigation_desktop.find('.menu-item');


    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Mobile navigation
    navigation_mobile.find('.fa').each(function () {
        var action = $(this);

        action.on('click',function (event) {
            event.stopPropagation();
            event.preventDefault();

            var sub_menu = $(event.target).closest('.menu-item').find('.sub-menu').first();
            sub_menu.fadeIn();


            navigation_mobile.velocity({
                translateZ: 0,
                translateX: '-=100vw'
            }, 400, function () {
                // Callback when slide ended
                var navigation_title = action.parent().parent().find('.menu-item-name').first().text();
                navigation_pill.push('<i class="fa fa-angle-left"></i> ' + navigation_title);
                mobileNavigationChangeTitle(navigation_pill);
            });

           return false;
        });
    });

    // When we want to back to previous slide
    $('#navigation-title-name').on('click', mobileNavigationSlideRight);

    // Swipe right on mobile navigation
    //Hammer(navigation_mobile_wrapper.get()[0]).on("swiperight", mobileNavigationSlideRight);



    function mobileNavigationSlideRight(event) {

        if( ( 'matrix(1, 0, 0, 1, 0, 0)' != navigation_mobile.css('transform') ) && ( 'none' != navigation_mobile.css('transform')) ) {

            var reg = /([\+-]\d+)/i;
            var translate = parseInt(navigation_mobile.get(0).style.transform.match(reg));

            navigation_mobile.velocity({
                translateZ: 0,
                translateX: '+=100vw'
            }, 400, function () {
                // Callback when slide ended
                navigation_pill.pop();
                mobileNavigationChangeTitle(navigation_pill);

                switch(translate)
                {
                    case -100:
                        navigation_mobile.find('.sub-menu').hide();
                        break;
                    case -200:
                        navigation_mobile.find('.sub-menu > .sub-menu').hide();
                        break;
                    case -300:
                        navigation_mobile.find('.sub-menu > .sub-menu > .sub-menu').hide();
                        break;
                    default:
                        break;
                }
            });
        }
    }


    function mobileNavigationChangeTitle(navigation_pill) {
        navigation_mobile_title.html(navigation_pill[navigation_pill.length - 1]);
    }
    
    
    // Navigation on desktop
    var disappearing_timeout;
    var last_hovering_item;
    navigation_desktop_menu_items.each(function (index) { 
        var item = $(this);
        var item_id = item.attr('id');
        var subMenu = item.children('.sub-menu').first();
        var subMenu_dom = (typeof subMenu != 'undefined') ? subMenu.get(0) : null;
        
        // To ensure our animations, first we hide the submenu 
         //if(subMenu_dom) subMenu_dom.style.display = 'none';
        
        item.on('mouseout', function(event) {
            
            disappearing_timeout = setTimeout(function () {               
                    //if(subMenu_dom != null) subMenu_dom.style.display = 'none';
                    //item.removeClass('to-left');
                    //item.parents('.sub-menu').hide();
                    last_hovering_item = null;
                }, 300);
        });  
        
        item.on('mouseover', debounce(function (event) { 
            var left_espace = Math.abs( $(window).width() - item.offset().left );
            var is_must_be_at_left = left_espace < 300;
            
            if( last_hovering_item == item.closest('.menu > .menu-item').attr('id')  ) 
            {
                clearTimeout(disappearing_timeout); 
                disappearing_timeout = null;
            }
            
            last_hovering_item = item.closest('.menu > .menu-item').attr('id');
            
            
            if( is_must_be_at_left ) item.addClass('to-left');
            
            //if(subMenu_dom) subMenu_dom.style.display = 'block';
            if(typeof subMenu != 'undefined') 
            {
                if( is_must_be_at_left )
                {
                    //subMenu.addClass('animated fadeInRight');
                }
                else
                {
                    //subMenu.addClass('animated fadeInLeft');
                }
            } 
            
         }, 15));
         
    });



    // FIXED HEADER SCROLLING
    var mq = window.getComputedStyle(document.body, '::after').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "");
    var header_scroll_breakpoint;
    if( mq == 'desktop' ) {
        header_scroll_breakpoint = 50;
    } else {
        header_scroll_breakpoint = $('#l-top').offset().top;
    }

    $('#l-wrapper').on('scroll touchmove', debounce(function () {

        var top = this.scrollTop;

        if(top >= header_scroll_breakpoint) {
            $(document.body).addClass('fixed-header');
            
            if( !site_header_shower.hasClass('bounceInDown') )
            {             
                var shower_content = site_header_shower.find('i').first();
                
                site_header_shower.addClass('animated bounceInDown').on('mouseover', function(event) {
                    event.stopPropagation();
                    var el = $(this);
                    el.removeClass('animated');
                    el.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                        el.removeClass('animated jello');
                    });
                });
            }
            
        } else {
            $(document.body).removeClass('fixed-header fixed-but-showed');
            site_header_shower.addClass('animated');
        }

    }, 15));
    
    // HEADER SHOWER (on desktop only)
    site_header_shower.on('click', function(event){
        event.stopPropagation();
        event.preventDefault();
        var site_header_shower = $(event.target);
        
        $(document.body).toggleClass('fixed-but-showed');
        
        return false;
    });



    // We get all modal triggers
    var modalOpeners = document.querySelectorAll('[data-action="open-modal"]'),
        modalAnimationDelay = 100, // Time to  wait before start animation
        modalAnimationDuration = 400,
        modalOpeningTimeout = null;

    modalOpeners && Array.prototype.forEach.call(modalOpeners, function (modalTrigger) {

        modalTrigger.addEventListener('click', function (event) {
            event.stopPropagation();
            event.preventDefault();

            // User must wait the last opening request
            if (modalOpeningTimeout) return false;

            modalOpeningTimeout = setTimeout(function () {
                openModal(modalTrigger);
            }, modalAnimationDelay);

            return false;
        }, false);

    });


    function openModal(modalTrigger) {

        // First we check the target existance
        var modalToOpen = document.getElementById(modalTrigger.getAttribute('data-modal-target'));
        if (!modalToOpen) {
            modalOpeningTimeout = null;
            return false;
        }

        // We create div.mask-element for animate the opening of the modal
        var modalMask = (document.getElementById('modal-mask')) ? document.getElementById('modal-mask') : document.createElement('div'),
            scale = 1;

        modalMask.setAttribute('id', 'modal-mask');
        modalMask.className = 'modal-mask';

        // We append the mask into the DOM, place it and animate its scale
        document.body.appendChild(modalMask);
        scale = retrieveScale(modalTrigger, modalMask);

        // For animation we're using
        $(modalMask).velocity({ scale: scale }, modalAnimationDuration, function () {
            modalToOpen.style.display = 'block';
            modalMask.style.display = 'none';
            $(document.body).css({
                height: '100vh',
                overflow: 'hidden'
            });

            var modalCloser = modalToOpen.querySelectorAll('[data-action="close-modal"]')[0];
            modalCloser && modalCloser.addEventListener('click', function () {
                closeModal(modalToOpen);
            });
        });

    }


    function closeModal(modal) {
        var modalMask = document.getElementById('modal-mask'),
            parentMask = modalMask.parentNode;

        modalMask.style.display = 'block';
        modal.style.display = 'none';
        modalOpeningTimeout = null;

        $(modalMask).velocity({ scale: 1 }, modalAnimationDuration, function () {

            try {
                parentMask.removeChild(modalMask);
                $(document.body).css({
                    height: 'auto',
                    overflow: 'auto'
                });
            } catch (e) { }

        });
    }

    function retrieveScale(trigger, mask) {
        var trigger_height = trigger.offsetHeight,
            trigger_offset = trigger.getBoundingClientRect(),
            mask_radius = trigger_height / 2,
            mask_left = (trigger_offset.left + (trigger.offsetWidth / 2)) - mask_radius,
            mask_top = trigger_offset.top,
            scale = calculateScale(mask_left, mask_top, mask_radius, window.innerWidth, window.innerHeight);

        mask.style.position = 'fixed';
        mask.style.top = mask_top + 'px';
        mask.style.left = mask_left + 'px';
        mask.style.height = trigger_height + 'px';
        mask.style.width = trigger_height + 'px';

        return scale;
    }

    function calculateScale(left, top, radius, windowV, windowH) {
        var maxDisX = (left > windowV / 2) ? left : windowV - left,
            maxDisY = (top > windowH / 2) ? top : windowH - top;
        return Math.ceil(Math.sqrt(Math.pow(maxDisX, 2) + Math.pow(maxDisY, 2)) / radius);
    }

});
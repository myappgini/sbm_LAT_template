/**
 */
(function ($) {
    'use strict';

    var $sidebar = $('#control-sidebar-color-tab');
    var $settings = $('#control-sidebar-home-tab');

    var $container = $('<div />', {
        class: 'p-3 control-sidebar-content'
    });

    var $containerSettings = $('<div />', {
        class: 'p-3 control-sidebar-content'
    });

    $sidebar.append($container);
    $settings.append($containerSettings);


    $containerSettings.append(
        '<h5>Customize Template</h5><hr class="mb-2"/>'
    );
    //checkboxes
    var settings = [
        {
            selector: "body",
            group: "Mode Options",
            class: ["dark-mode", "layout-fixed", "text-sm", "sidebar-collapse", "sidebar-mini", "layout-footer-fixed"],
            title: ["Dark Mode", "Fixed Mode", "Small text", "Still Collapse Sidebar", "Sidebar Mini", "Footer Fixed"]
        },
        {
            selector: ".main-header",
            group: "Navbar options",
            class: ["border-bottom-0", "text-sm", "dropdown-legacy"],
            title: ["No Navbar border", "Navbar small text", "Dropdown Legacy Offset"]
        },
        {
            selector: ".nav-sidebar",
            group: "Sidebar nav options",
            class: ["text-sm", "nav-flat", "nav-legacy", "nav-compact", "nav-child-indent", "nav-collapse-hide-child"],
            title: ["Sidebar Small text", "Flat style", "Legacy style", "Compact", "Child indent", "Nav Child Hide on Collapse"]
        },
        {
            selector: ".main-footer",
            group: "Footer option",
            class: ["text-sm"],
            title: ["Small text"]
        },
        {
            selector: ".main-sidebar",
            group: "Main sidebar option",
            class: ["sidebar-no-expand"],
            title: ["disable hover/focus auto expand"]
        },
        {
            selector: ".brand-link",
            group: "Brand option",
            class: ["text-sm"],
            title: ["Small text"]
        }
    ];

    var value = "";
    var $no_border_checkbox = "";
    settings.forEach(e => {
        var i = 0;
        $containerSettings.append('<h6>' + e.group + '</h6>');
        e.class.forEach(c => {
            value = (get(e.selector + "_" + c) == "true");
            $no_border_checkbox = $('<input />', {
                type: 'checkbox',
                value: 1,
                checked: value,
                'class': 'mr-1'
            }).on('click', function () {
                if ($(this).is(':checked')) {
                    $(e.selector).addClass(c);
                } else {
                    $(e.selector).removeClass(c);
                }
                store(e.selector + "_" + c, $(this).is(':checked'));
            });

            $containerSettings.append($('<div />', { 'class': 'mb-1' }).append($no_border_checkbox).append('<span>' + e.title[i] + '</span>'));
            i++;
        });
    });

    $container.append(
        '<h5>Customize Colors</h5><hr class="mb-2"/>'
    );

    ////////////////////////////////////////////////
    ////////////////////////////////////////////////
    ////////////////////////////////////////////////

    $container.append('<h6>Navbar Variants</h6>');

    var $navbar_variants = $('<div />', {
        'class': 'd-flex'
    });

    var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins);

    var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function (e) {
        var color = $(this).data('color');
        var $main_header = $('.main-header');
        $main_header.removeClass('navbar-dark').removeClass('navbar-light');
        navbar_all_colors.map(function (color) {
            $main_header.removeClass(color);
        });

        $(this).parent().removeClass().addClass('custom-select mb-3 text-light border-0 ')

        if (navbar_dark_skins.indexOf(color) > -1) {
            $main_header.addClass('navbar-dark');
            $(this).parent().addClass(color).addClass('text-light')
        } else {
            $main_header.addClass('navbar-light');
            $(this).parent().addClass(color)
        }

        $main_header.addClass(color);
        store('.main-header', color);
    },false, get('.main-header'));

    var active_navbar_color = null
    $('.main-header')[0].classList.forEach(function (className) {
        if (navbar_all_colors.indexOf(className) > -1 && active_navbar_color === null) {
            active_navbar_color = className.replace('navbar-', 'bg-')
        }
    })

    $navbar_variants_colors.find('option.' + active_navbar_color).prop('selected', true)
    $navbar_variants_colors.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_navbar_color)

    $navbar_variants.append($navbar_variants_colors);

    $container.append($navbar_variants);

    ////////////////////////////////////////////////

    $container.append('<h6>Accent Color Variants</h6>');
    var $accent_variants = $('<div />', {
        'class': 'd-flex'
    });

    $container.append($accent_variants);

    $container.append(createSkinBlock(accent_colors, function () {
        var color = $(this).data('color');
        var accent_class = color;
        var $body = $('body');
        accent_colors.forEach(function (skin) {
            $body.removeClass(skin)
        })

        $body.addClass(accent_class);
        store('body', accent_class);
    },false, get('body')));

    var active_accent_color = null
    $('body')[0].classList.forEach(function (className) {
        if (accent_colors.indexOf(className) > -1 && active_accent_color === null) {
            active_accent_color = className.replace('navbar-', 'bg-')
        }
    })

    ////////////////////////////////////////////////

    $container.append('<h6>Dark Sidebar Variants</h6>');
    var $sidebar_variants_dark = $('<div />', {
        'class': 'd-flex'
    });
    $container.append($sidebar_variants_dark)
    var $sidebar_dark_variants = createSkinBlock(sidebar_colors, function () {
        var color = $(this).data('color')
        var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '')
        var $sidebar = $('.main-sidebar')
        sidebar_skins.forEach(function (skin) {
            $sidebar.removeClass(skin)
            $sidebar_light_variants.removeClass(skin.replace('sidebar-dark-', 'bg-')).removeClass('text-light')
        })

        $(this).parent().removeClass().addClass('custom-select mb-3 text-light border-0').addClass(color)
        $sidebar_light_variants.find('option').prop('selected', false)

        $sidebar.addClass(sidebar_class)
        $('.sidebar').removeClass('os-theme-dark').addClass('os-theme-light')
        store('.main-sidebar', sidebar_class);
    }, true, get('.main-sidebar'))
    $container.append($sidebar_dark_variants)

    var active_sidebar_dark_color = null
    $('.main-sidebar')[0].classList.forEach(function (className) {
        var color = className.replace('sidebar-dark-', 'bg-')
        if (sidebar_colors.indexOf(color) > -1 && active_sidebar_dark_color === null) {
            active_sidebar_dark_color = color
        }
    })

    $sidebar_dark_variants.find('option.' + active_sidebar_dark_color).prop('selected', true)
    $sidebar_dark_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_sidebar_dark_color)

    ////////////////////////////////////////////////

    $container.append('<h6>Light Sidebar Variants</h6>');

    var $sidebar_variants_light = $('<div />', {
        'class': 'd-flex'
    });

    $container.append($sidebar_variants_light)
    var $sidebar_light_variants = createSkinBlock(sidebar_colors, function () {
        var color = $(this).data('color')
        var sidebar_class = 'sidebar-light-' + color.replace('bg-', '')
        var $sidebar = $('.main-sidebar')
        sidebar_skins.forEach(function (skin) {
            $sidebar.removeClass(skin)
            $sidebar_dark_variants.removeClass(skin.replace('sidebar-light-', 'bg-')).removeClass('text-light')
        })

        $(this).parent().removeClass().addClass('custom-select mb-3 text-light border-0').addClass(color)

        $sidebar_dark_variants.find('option').prop('selected', false)
        $sidebar.addClass(sidebar_class)
        $('.sidebar').removeClass('os-theme-light').addClass('os-theme-dark')
        store('.main-sidebar', sidebar_class);
    }, true, get('.main-sidebar'))
    $container.append($sidebar_light_variants)

    var active_sidebar_light_color = null
    $('.main-sidebar')[0].classList.forEach(function (className) {
        var color = className.replace('sidebar-light-', 'bg-')
        if (sidebar_colors.indexOf(color) > -1 && active_sidebar_light_color === null) {
            active_sidebar_light_color = color
        }
    })

    if (active_sidebar_light_color !== null) {
        $sidebar_light_variants.find('option.' + active_sidebar_light_color).prop('selected', true)
        $sidebar_light_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_sidebar_light_color)
    }

    ////////////////////////////////////////////////


    var logo_skins = navbar_all_colors;
    $container.append('<h6>Brand Logo Variants</h6>');
    var $logo_variants = $('<div />', {
        'class': 'd-flex'
    });

    $container.append($logo_variants)
    var $clear_btn = $('<a />', {
        href: '#'
    }).text('clear').on('click', function (e) {
        e.preventDefault()
        var $logo = $('.brand-link')
        logo_skins.forEach(function (skin) {
            $logo.removeClass(skin)
        })
    })

    var $brand_variants = createSkinBlock(logo_skins, function () {
        var color = $(this).data('color')
        var $logo = $('.brand-link')

        if (color === 'navbar-light' || color === 'navbar-white') {
            $logo.addClass('text-black')
        } else {
            $logo.removeClass('text-black')
        }

        logo_skins.forEach(function (skin) {
            $logo.removeClass(skin)
        })

        if (color) {
            $(this).parent().removeClass().addClass('custom-select mb-3 border-0').addClass(color).addClass(color !== 'navbar-light' && color !== 'navbar-white' ? 'text-light' : '')
        } else {
            $(this).parent().removeClass().addClass('custom-select mb-3 border-0')
        }

        $logo.addClass(color)
        store('.brand-link', color);
    }, true, get('.brand-link')).append($clear_btn)

    $container.append($brand_variants)
    var active_brand_color = null

    $('.brand-link')[0].classList.forEach(function (className) {
        if (logo_skins.indexOf(className) > -1 && active_brand_color === null) {
            active_brand_color = className.replace('navbar-', 'bg-')
        }
    })

    if (active_brand_color) {
        $brand_variants.find('option.' + active_brand_color).prop('selected', true)
        $brand_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_brand_color)
    }

    ////////////////////////////////////////////////

    function createSkinBlock(colors, callback, noneSelected, selectedColor) {
        
        var blockColor = selectedColor ? selectedColor : colors[0] ;  

        blockColor = blockColor.replace(/accent-|navbar-/, 'bg-');
        console.log("Selected Color: ", blockColor );
        
        var $block = $('<select />', {
            class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + blockColor
        })

        if (noneSelected) {
            var $default = $('<option />', {
                text: 'None Selected'
            })
            if (callback) {
                $default.on('click', callback)
            }

            $block.append($default)
        }
        
        colors.forEach(function (color) {

            var $color = $('<option />', {
                class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
                text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
            })

            $block.append($color)
            $color.data('color', color)

            if (callback) {
                $color.on('click', callback)
            }
        })

        return $block

    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

})(jQuery);

function get(name) {
    if (typeof (Storage) !== 'undefined') {
        const value = localStorage.getItem(name);
        console.log('get value' + name, value);
        return value;
    } else {
        window.alert('Please use a modern browser to properly view this template!');
    }
}

function store(name, val) {
    if (typeof (Storage) !== 'undefined') {
        console.log('store value: ' + name + " = " + val);
        localStorage.setItem(name, val);
    } else {
        window.alert('Please use a modern browser to properly view this template!');
    }
}
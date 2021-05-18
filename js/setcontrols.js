(function($) {
    'use strict';
    var settings = [{
            selector: ".main-header",
            class: ["border-bottom-0", "text-sm", "dropdown-legacy"],
        },
        {
            selector: "body",
            class: ["dark-mode", "layout-fixed", "text-sm", "sidebar-collapse", "sidebar-mini", "layout-footer-fixed"]
        },
        {
            selector: ".nav-sidebar",
            class:  ["text-sm", "nav-flat", "nav-legacy", "nav-compact", "nav-child-indent", "nav-collapse-hide-child"],
        },
        {
            selector: ".main-footer",
            class: ["text-sm"]
        },
        {
            selector: ".main-sidebar",
            class: ["sidebar-no-expand"]
        },
        {
            selector: ".brand-link",
            class: ["text-sm"]
        }
    ];
    var value = "true";
    settings.forEach(e => {
        e.class.forEach(c => {
            value = get(e.selector + "_" + c) == "true";
            if (value) {
                $(e.selector).addClass(c)
            } else {
                $(e.selector).removeClass(c)
            }
        });
    });

    var $sidebar = $(".main-sidebar");
    var sidebar_class = get(".main-sidebar") || "sidebar-dark-danger";
    sidebar_skins.map(function(skin) {
        $sidebar.removeClass(skin);
    });
    $sidebar.addClass(sidebar_class);

    var accent_class = get("body");
    var $body = $("body");
    accent_colors.map(function(skin) {
        $body.removeClass(skin);
    });
    $body.addClass(accent_class);

    var logo_skins = navbar_dark_skins.concat(navbar_light_skins);
    var color = get(".brand-link");
    var $logo = $(".brand-link");
    logo_skins.map(function(skin) {
        $logo.removeClass(skin);
    });
    $logo.addClass(color);

    color = get(".main-header");
    var $main_header = $(".main-header");
    $main_header.removeClass("navbar-dark").removeClass("navbar-light");
    logo_skins.map(function(color) {
        $main_header.removeClass(color);
    });
    if (navbar_dark_skins.indexOf(color) > -1) {
        $main_header.addClass("navbar-dark");
    } else {
        $main_header.addClass("navbar-light");
    }
    $main_header.addClass(color);
})(jQuery);
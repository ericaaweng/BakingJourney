<?php
/**
 * Blogger Diary functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP Diary
 * @subpackage Blogger Diary
 * @since 1.0.0
 */

/*------------------------- Theme Version -------------------------------------*/

    if ( ! defined( 'BLOGGER_DIARY_VERSION' ) ) {
        // Replace the version number of the theme on each release.
        $blogger_diary_theme_info = wp_get_theme();
        define( 'BLOGGER_DIARY_VERSION', $blogger_diary_theme_info->get( 'Version' ) );
    }

/*------------------------- Customizer ----------------------------------------*/

    add_action( 'customize_register', 'blogger_diary_customize_register', 20 );

    if ( ! function_exists( 'blogger_diary_customize_register' ) ) :

        /**
         * Customizer settings for blogger diary
         */
        function blogger_diary_customize_register( $wp_customize ) {

            $wp_customize->get_setting( 'wp_diary_primary_color' )->default = '#c7831d';

        }

    endif;

/*------------------------- Font url ------------------------------------------*/

    if ( ! function_exists( 'blogger_diary_fonts_url' ) ) :

    	/**
    	 * Register Google fonts for Blogger Diary.
    	 *
    	 * @return string Google fonts URL for the theme.
    	 * @since 1.0.0
    	 */
        function blogger_diary_fonts_url() {
            $fonts_url = '';
            $font_families = array();
            /*
             * Translators: If there are characters in your language that are not supported
             * by Great Vibes translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Great Vibes: on or off', 'blogger-diary' ) ) {
                $font_families[] = 'Great Vibes:400';
            }
            if ( $font_families ) {
                $query_args = array(
                    'family' => urlencode( implode( '|', $font_families ) ),
                    'subset' => urlencode( 'latin,latin-ext' ),
                );
                $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
            }
            
            /*
             * Translators: If there are characters in your language that are not supported
             * by Be Vietnam Pro translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Be Vietnam Pro: on or off', 'blogger-diary' ) ) {
                $font_families[] = 'Be Vietnam Pro:400,700';
            }
            if ( $font_families ) {
                $query_args = array(
                    'family' => urlencode( implode( '|', $font_families ) ),
                    'subset' => urlencode( 'latin,latin-ext' ),
                );
                $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
            }
            
            return $fonts_url;
        }

    endif;

/*------------------------- Enqueue scripts and styles ------------------------*/

    function blogger_diary_scripts() {
        
        wp_enqueue_style( 'blogger-diary-fonts', blogger_diary_fonts_url(), array(), null );

        wp_dequeue_style( 'wp-diary-style' );
        
        wp_dequeue_style( 'wp-diary-responsive-style' );

        wp_enqueue_style( 'blogger-diary-parent-style', get_template_directory_uri() . '/style.css', array(), BLOGGER_DIARY_VERSION );

        wp_enqueue_style( 'blogger-diary-parent-responsive-style', get_template_directory_uri() . '/assets/css/mt-responsive.css', array(), BLOGGER_DIARY_VERSION );

        wp_enqueue_style( 'blogger-diary-style', get_stylesheet_uri(), array(), BLOGGER_DIARY_VERSION );
        
        wp_enqueue_style( 'blogger-diary-responsive-style', get_stylesheet_directory_uri() . '/responsive.css', array(), BLOGGER_DIARY_VERSION );

    	$blogger_diary_primary_color = get_theme_mod( 'wp_diary_primary_color', '#c7831d' );

    	$output_css = '';

        $output_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.widget_search .search-submit,.widget_search .search-submit:hover,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,.menu-toggle:hover,.slider-btn,.entry-footer .mt-readmore-btn,article.sticky::before,.post-format-media--quote,.mt-gallery-slider .slick-prev.slick-arrow:hover,.mt-gallery-slider .slick-arrow.slick-next:hover,.wp_diary_social_media a:hover,.mt-header-extra-icons .sidebar-header.mt-form-close:hover,#site-navigation .mt-form-close, #site-navigation ul li:hover>a,#site-navigation ul li.focus > a, #site-navigation ul li:hover>a, #site-navigation ul li.current-menu-item>a, #site-navigation ul li.current_page_ancestor>a, #site-navigation ul li.current_page_item>a, #site-navigation ul li.current-menu-ancestor>a,.cv-read-more a{ background: ". esc_attr( $blogger_diary_primary_color ) ."}\n";

        $output_css .= "a,a:hover,a:focus,a:active,.entry-footer a:hover ,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,.mt-social-icon-wrap li a:hover,.site-title a:hover,.mt-sidebar-menu-toggle:hover,.mt-menu-search:hover,.sticky-header-sidebar-menu li a:hover,.slide-title a:hover,.entry-title a:hover,.cat-links a,.entry-title a:hover,.cat-links a:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,#top-footer .widget-title ,#footer-menu li a:hover,.wp_diary_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.mt-featured-single-item .item-title a:hover, #secondary .widget .widget-title, .mt-related-post-title, #mt-masonry article .entry-footer .mt-readmore-btn:hover,.cv-read-more a:hover{ color: ". esc_attr( $blogger_diary_primary_color ) ."}\n";
        
        $output_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.no-thumbnail,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover ,#secondary .widget .widget-title,.mt-related-post-title,.error-404.not-found,.wp_diary_social_media a:hover, #mt-masonry article .entry-footer .mt-readmore-btn, .cv-read-more a{ border-color: ". esc_attr( $blogger_diary_primary_color ) ."}\n";

        $refine_output_css = wp_diary_css_strip_whitespace( $output_css );

        wp_add_inline_style( 'blogger-diary-style', $refine_output_css );
            
        wp_enqueue_script( 'blogger-diary-sticky-sidebar', get_stylesheet_directory_uri() . '/assets/library/sticky-sidebar/theia-sticky-sidebar.min.js', array(), BLOGGER_DIARY_VERSION, true );

        wp_enqueue_script( 'blogger-diary-custom-scripts', get_stylesheet_directory_uri() . '/assets/js/bd-custom-scripts.js', array( 'jquery'), BLOGGER_DIARY_VERSION, true );

    }

    add_action( 'wp_enqueue_scripts', 'blogger_diary_scripts', 99 );

/*------------------------- Footer --------------------------------------------*/

    if ( !function_exists ( 'wp_diary_footer_background_animation' ) ):

        /**
         * Footer Hook Handling 
         *
         */
        function wp_diary_footer_background_animation() {
        
            echo '<div class="blogger-diary-background-animation" ><ul class="blogger-diary-circles"> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> </ul> </div > <!-- area -->';
        }
     
    endif;
     
    add_action ( 'wp_diary_scroll_top', 'wp_diary_footer_background_animation', 5 );

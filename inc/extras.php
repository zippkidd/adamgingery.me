<?php

/**
 * Function to get Primary navigation menu
 */
// if ( ! function_exists( 'astra_primary_navigation_markup' ) ) {

// 	/**
// 	 * Site Title / Logo
// 	 *
// 	 * @since 1.0.0
// 	 */
// 	function astra_primary_navigation_markup() {

// 		$disable_primary_navigation = astra_get_option( 'disable-primary-nav' );
// 		$custom_header_section      = astra_get_option( 'header-main-rt-section' );

// 		if ( $disable_primary_navigation ) {

// 			$display_outside = astra_get_option( 'header-display-outside-menu' );

// 			if ( 'none' != $custom_header_section && ! $display_outside ) {

// 				echo '<div class="main-header-bar-navigation ast-header-custom-item ast-flex ast-justify-content-flex-end">';
// 				/**
// 				 * Fires before the Primary Header Menu navigation.
// 				 * Disable Primary Menu is checked
// 				 * Last Item in Menu is not 'none'.
// 				 * Take Last Item in Menu outside is unchecked.
// 				 *
// 				 * @since 1.4.0
// 				 */
// 				do_action( 'astra_main_header_custom_menu_item_before' );

// 				echo astra_masthead_get_menu_items(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

// 				/**
// 				 * Fires after the Primary Header Menu navigation.
// 				 * Disable Primary Menu is checked
// 				 * Last Item in Menu is not 'none'.
// 				 * Take Last Item in Menu outside is unchecked.
// 				 *
// 				 * @since 1.4.0
// 				 */
// 				do_action( 'astra_main_header_custom_menu_item_after' );

// 				echo '</div>';

// 			}
// 		} else {

// 			$submenu_class = apply_filters( 'primary_submenu_border_class', ' submenu-with-border' );

// 			// Menu Animation.
// 			$menu_animation = astra_get_option( 'header-main-submenu-container-animation' );
// 			if ( ! empty( $menu_animation ) ) {
// 				$submenu_class .= ' astra-menu-animation-' . esc_attr( $menu_animation ) . ' ';
// 			}

// 			/**
// 			 * Filter the classes(array) for Primary Menu (<ul>).
// 			 *
// 			 * @since  1.5.0
// 			 * @var Array
// 			 */
// 			$primary_menu_classes = apply_filters( 'astra_primary_menu_classes', array( 'main-header-menu', 'ast-nav-menu', 'ast-flex', 'ast-justify-content-flex-end', $submenu_class ) );

// 			// Fallback Menu if primary menu not set.
// 			$fallback_menu_args = array(
// 				'theme_location' => 'primary',
// 				'menu_id'        => 'primary-menu',
// 				'menu_class'     => 'main-navigation',
// 				'container'      => 'div',

// 				'before'         => '<ul class="' . esc_attr( implode( ' ', $primary_menu_classes ) ) . '">',
// 				'after'          => '</ul>',
// 				'walker'         => new Astra_Walker_Page(),
// 			);

// 			$items_wrap  = '<nav ';
// 			$items_wrap .= astra_attr(
// 				'site-navigation',
// 				array(
// 					'id'         => 'site-navigation',
// 					'class'      => 'ast-flex-grow-1 navigation-accessibility',
// 					'aria-label' => esc_attr__( 'Site Navigation', 'astra' ),
// 				)
// 			);
// 			$items_wrap .= '>';
// 			$items_wrap .= '<div class="main-navigation">';
// 			$items_wrap .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
// 			$items_wrap .= '</div>';
// 			$items_wrap .= '</nav>';

// 			// Primary Menu.
// 			$primary_menu_args = array(
// 				'theme_location'  => 'primary',
// 				'menu_id'         => 'primary-menu',
// 				'menu_class'      => esc_attr( implode( ' ', $primary_menu_classes ) ),
// 				'container'       => 'div',
// 				'container_class' => 'main-header-bar-navigation',
// 				'items_wrap'      => $items_wrap,
// 			);

// 			if ( has_nav_menu( 'primary' ) ) {
// 				// To add default alignment for navigation which can be added through any third party plugin.
// 				// Do not add any CSS from theme except header alignment.
// 				echo '<div ' . astra_attr( 'ast-main-header-bar-alignment' ) . '>';
// 					wp_nav_menu( $primary_menu_args );
// 				echo '</div>';
// 			} else {

// 				echo '<div ' . astra_attr( 'ast-main-header-bar-alignment' ) . '>';
// 					echo '<div class="main-header-bar-navigation">';
// 						echo '<nav ';
// 						echo astra_attr(
// 							'site-navigation',
// 							array(
// 								'id' => 'site-navigation',
// 							)
// 						);
// 						echo ' class="ast-flex-grow-1 navigation-accessibility" aria-label="' . esc_attr__( 'Site Navigation', 'astra' ) . '">';
// 							wp_page_menu( $fallback_menu_args );
// 						echo '</nav>';
// 					echo '</div>';
// 				echo '</div>';
// 			}
// 		}

// 	}
// }

// add_action( 'astra_masthead_content', 'astra_primary_navigation_markup', 10 );

remove_action( 'astra_masthead_content', 'astra_primary_navigation_markup', 20 );

function astra_primary_navigation_markup() {

	$disable_primary_navigation = astra_get_option( 'disable-primary-nav' );
	$custom_header_section      = astra_get_option( 'header-main-rt-section' );

	if ( $disable_primary_navigation ) {

		$display_outside = astra_get_option( 'header-display-outside-menu' );

		if ( 'none' != $custom_header_section && ! $display_outside ) {

			echo '<div class="main-header-bar-navigation ast-header-custom-item ast-flex ast-justify-content-flex-end">';
			/**
			 * Fires before the Primary Header Menu navigation.
			 * Disable Primary Menu is checked
			 * Last Item in Menu is not 'none'.
			 * Take Last Item in Menu outside is unchecked.
			 *
			 * @since 1.4.0
			 */
			do_action( 'astra_main_header_custom_menu_item_before' );

			echo astra_masthead_get_menu_items(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			/**
			 * Fires after the Primary Header Menu navigation.
			 * Disable Primary Menu is checked
			 * Last Item in Menu is not 'none'.
			 * Take Last Item in Menu outside is unchecked.
			 *
			 * @since 1.4.0
			 */
			do_action( 'astra_main_header_custom_menu_item_after' );

			echo '</div>';

		}
	} else {

		$submenu_class = apply_filters( 'primary_submenu_border_class', ' submenu-with-border' );

		// Menu Animation.
		$menu_animation = astra_get_option( 'header-main-submenu-container-animation' );
		if ( ! empty( $menu_animation ) ) {
			$submenu_class .= ' astra-menu-animation-' . esc_attr( $menu_animation ) . ' ';
		}

		/**
		 * Filter the classes(array) for Primary Menu (<ul>).
		 *
		 * @since  1.5.0
		 * @var Array
		 */
		$primary_menu_classes = apply_filters( 'astra_primary_menu_classes', array( 'main-header-menu', 'ast-nav-menu', 'ast-flex', 'ast-justify-content-flex-end', $submenu_class ) );

		// Fallback Menu if primary menu not set.
		$fallback_menu_args = array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'main-navigation',
			'container'      => 'div',

			'before'         => '<ul class="' . esc_attr( implode( ' ', $primary_menu_classes ) ) . '">',
			'after'          => '</ul>',
			'walker'         => new Astra_Walker_Page(),
		);

		$items_wrap  = '<nav ';
		$items_wrap .= astra_attr(
			'site-navigation',
			array(
				'id'         => 'site-navigation',
				'class'      => 'ast-flex-grow-1 navigation-accessibility',
				'aria-label' => esc_attr__( 'Site Navigation', 'astra' ),
			)
		);
		$items_wrap .= '>';
		$items_wrap .= '<div class="main-navigation">';
		$items_wrap .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
		$items_wrap .= '</div>';
		$items_wrap .= '</nav>';

		// Primary Menu.
		$primary_menu_args = array(
			'menu'			  => 'Secondary Menu',
			'theme_location'  => 'primary',
			'menu_id'         => 'primary-menu',
			'menu_class'      => esc_attr( implode( ' ', $primary_menu_classes ) ),
			'container'       => 'div',
			'container_class' => 'main-header-bar-navigation',
			'items_wrap'      => $items_wrap,
		);

		if ( true ) {
			// To add default alignment for navigation which can be added through any third party plugin.
			// Do not add any CSS from theme except header alignment.
			echo '<div ' . astra_attr( 'ast-main-header-bar-alignment' ) . '>';
				wp_nav_menu( $primary_menu_args );
			echo '</div>';
		} else {

			echo '<div ' . astra_attr( 'ast-main-header-bar-alignment' ) . '>';
				echo '<div class="main-header-bar-navigation">';
					echo '<nav ';
					echo astra_attr(
						'site-navigation',
						array(
							'id' => 'site-navigation',
						)
					);
					echo ' class="ast-flex-grow-1 navigation-accessibility" aria-label="' . esc_attr__( 'Site Navigation', 'astra' ) . '">';
						wp_page_menu( $fallback_menu_args );
					echo '</nav>';
				echo '</div>';
			echo '</div>';
		}
	}

}

add_action( 'astra_masthead_content', 'astra_primary_navigation_markup', 20 ); -->
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product Group Widget.
 */
class TT_Widget_Product_Group extends WC_Widget {
	
	public $product_group_ancestors;
	
	public $current_product_group;
	
	public $index = 0;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->index++;
		
		$this->widget_cssclass    = 'tt-wc tt-wc-groups-widget';
		$this->widget_description = 'A list or dropdown of product groups.';
		$this->widget_id          = 'tt_product_groups';
		$this->widget_name        = 'WooCommerce product groups';
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Product Groups', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' )
			),
			'dropdown' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show as dropdown', 'woocommerce' )
			),
			'count' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show product counts', 'woocommerce' )
			),
			'hierarchical' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show hierarchy', 'woocommerce' )
			),
			'show_children_only' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Only show children of the current product group', 'woocommerce' )
			),
			'hide_empty' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide empty groups', 'woocommerce' )
			),
			'show_option_all' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show option for "All" (remove filtering)', 'woocommerce' )
			),
			'show_option_all_text'  => array(
				'type'  => 'text',
				'std'   => __( 'Any product group', 'woocommerce' ),
				'label' => __( '"All" option text', 'woocommerce' )
			)
		);
		
		parent::__construct();
	}
	
	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wp_query, $post;
		
		$count                = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$hierarchical         = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
		$show_children_only   = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
		$dropdown             = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
		$hide_empty           = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
		$show_option_all      = isset( $instance['show_option_all'] ) ? $instance['show_option_all'] : $this->settings['show_option_all']['std'];
		$show_option_all_text = isset( $instance['show_option_all_text'] ) ? $instance['show_option_all_text'] : $this->settings['show_option_all_text']['std'];
		$dropdown_args        = array( 'hide_empty' => $hide_empty );
		$list_args            = array( 'show_count' => $count, 'hierarchical' => $hierarchical, 'taxonomy' => 'tt_product_group', 'hide_empty' => $hide_empty );
		$orderby              = 'name'; // 'menu_order' also supported but the category is not sortable
		
		if ( empty($show_option_all_text) ) $show_option_all_text = $this->settings['show_option_all']['std'];
		$dropdown_args['show_option_all'] = $show_option_all ? $show_option_all_text : '';
		$list_args['show_option_all'] = $show_option_all ? $show_option_all_text : '';
		
		// Menu Order
		$list_args['menu_order'] = false;
		if ( $orderby == 'order' ) {
			$list_args['menu_order'] = 'asc';
		} else {
			$list_args['orderby']    = 'title';
		}
		
		// Setup Current Product_group
		$this->current_product_group   = false;
		$this->product_group_ancestors = array();
		$query_term = get_query_var( 'product_group' );
		
		if ( is_tax( 'tt_product_group' ) ) {
			
			$this->current_product_group   = $wp_query->queried_object;
			$this->product_group_ancestors = get_ancestors( $this->current_product_group->term_id, 'tt_product_group' );
			
		}else if ( $query_term ) {
			
			$this->current_product_group = get_term_by( 'slug', $query_term, 'tt_product_group' );
			if ( $this->current_product_group ) {
				$this->product_group_ancestors = get_ancestors( $this->current_product_group->term_id, 'tt_product_group' );
			}
			
		} elseif ( is_singular( 'product' ) ) {
			
			$product_product_group = wc_get_product_terms( $post->ID, 'tt_product_group', apply_filters( 'tt_product_groups_widget_product_terms_args', array( 'orderby' => 'parent' ) ) );
			
			if ( ! empty( $product_product_group ) ) {
				$this->current_product_group   = end( $product_product_group );
				$this->product_group_ancestors = get_ancestors( $this->current_product_group->term_id, 'tt_product_group' );
			}
			
		}
		
		// Show Siblings and Children Only
		if ( $show_children_only && $this->current_product_group ) {
			
			// Top level is needed
			$top_level = get_terms(
				'tt_product_group',
				array(
					'fields'       => 'ids',
					'parent'       => 0,
					'hierarchical' => true,
					'hide_empty'   => false
				)
			);
			
			// Direct children are wanted
			$direct_children = get_terms(
				'tt_product_group',
				array(
					'fields'       => 'ids',
					'parent'       => $this->current_product_group->term_id,
					'hierarchical' => true,
					'hide_empty'   => false
				)
			);
			
			// Gather siblings of ancestors
			$siblings  = array();
			if ( $this->product_group_ancestors ) {
				foreach ( $this->product_group_ancestors as $ancestor ) {
					$ancestor_siblings = get_terms(
						'tt_product_group',
						array(
							'fields'       => 'ids',
							'parent'       => $ancestor,
							'hierarchical' => false,
							'hide_empty'   => false
						)
					);
					$siblings = array_merge( $siblings, $ancestor_siblings );
				}
			}
			
			if ( $hierarchical ) {
				$include = array_merge( $top_level, $this->product_group_ancestors, $siblings, $direct_children, array( $this->current_product_group->term_id ) );
			} else {
				$include = array_merge( $direct_children );
			}
			
			$dropdown_args['include'] = implode( ',', $include );
			$list_args['include']     = implode( ',', $include );
			
			if ( empty( $include ) ) {
				return;
			}
			
		} elseif ( $show_children_only ) {
			$dropdown_args['depth']        = 1;
			$dropdown_args['child_of']     = 0;
			$dropdown_args['hierarchical'] = 1;
			$list_args['depth']            = 1;
			$list_args['child_of']         = 0;
			$list_args['hierarchical']     = 1;
		}
		
		$this->widget_start( $args, $instance );
		
		// Dropdown
		if ( $dropdown ) {
			$dropdown_defaults = array(
				'id'                 => 'product_group-select-' . $this->index,
				'name'               => 'product_group',
				'value_field'        => 'slug',
				'show_count'         => $count,
				'hierarchical'       => $hierarchical,
				'show_uncategorized' => 0,
				'orderby'            => $orderby,
				'selected'           => $this->current_product_group ? $this->current_product_group->slug : '',
				'taxonomy'           => 'tt_product_group',
			);
			$dropdown_args = wp_parse_args( $dropdown_args, $dropdown_defaults );
			
			$url = get_post_type_archive_link( 'product' );
			$form_url_tax = false;
			
			if ( is_tax( 'product_cat' ) ) $form_url_tax = 'product_cat';
			else if ( is_tax( 'product_tag' ) ) $form_url_tax = 'product_tag';
			
			if ( $form_url_tax ) $url = get_term_link( get_queried_object() );
			
			echo '<form action="', $url ,'" method="GET" class="autosubmit">';
			
			global $wp_query;
			
			if ( $wp_query->query ) foreach( $wp_query->query as $name => $value ) {
				if ( $name == 'product_group' ) continue;
				if ( $name == $form_url_tax && is_tax( $form_url_tax ) ) continue; // from form action
				
				echo '<input type="hidden" name="'. esc_attr( $name ) .'" value="'. esc_attr( $value ) .'">' . "\n";
			}
			
			wp_dropdown_categories( apply_filters( 'tt_product_groups_widget_dropdown_args', $dropdown_args ) );
			
			echo '</form>';
			
			// List
		} else {
			
			include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
			
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = __('No product groups exist.', 'woocommerce' );
			$list_args['current_product_group']              = ( $this->current_product_group ) ? $this->current_product_group->term_id : '';
			$list_args['current_product_group_ancestors']    = $this->product_group_ancestors;
			$list_args['taxonomy']                   = 'tt_product_group';
			
			$terms = get_terms( $list_args );
			
			echo '<ul class="product-groups wc-term-list">';
			
			if ( empty($terms) ) {
				
				if ( $list_args['show_option_none'] ) {
					echo '<li class="option-none">', $list_args['show_option_none'], '</li>';
				}
				
			}else{
				
				if ( $list_args['show_option_all'] ) {
					$active = empty(get_query_var( 'product_group' ));
					echo '<li class="term-link option-all ', ($active ? 'term-active' : 'term-inactive'), '">';
					echo '<a href="', esc_attr( remove_query_arg( 'product_group' ) ),'">';
					echo $list_args['show_option_all'];
					echo '</a>';
					echo '</li>';
				}
				
				foreach( $terms as $i => $term ) {
					$active = get_query_var( 'product_group' ) == $term->slug;
					echo '<li class="term-link term-id-', $term->term_id, ' ', ($active ? 'term-active' : 'term-inactive'), '">';
					echo '<a href="', esc_attr( add_query_arg( array('product_group' => $term->slug) ) ),'">';
					echo esc_html( $term->name );
					echo '</a>';
					
					if ( $count ) {
						echo ' <span class="term-count">(', $term->count, ')</span>';
					}
					
					echo '</li>';
				}
				
			}
			
			echo '</ul>';
		}
		
		$this->widget_end( $args );
	}
}

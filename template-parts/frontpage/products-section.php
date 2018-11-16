<?php
/**
 * Template part for displaying a frontpage section
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Portum
 */

$frontpage = Epsilon_Page_Generator::get_instance( 'portum_frontpage_sections_' . get_the_ID(), get_the_ID() );
$fields    = $frontpage->sections[ $section_id ];

$args  = array(
	'post_status'    => 'publish',
	'post_type'      => 'product',
	'posts_per_page' => $fields['products_count'],
);
$query = new WP_Query( $args );

$attr_helper = new Epsilon_Section_Attr_Helper( $fields, 'products', Portum_Repeatable_Sections::get_instance() );
if ( empty( $fields['section_unique_id'] ) ) {
	$fields['section_unique_id'] = Portum_Helper::generate_section_id( 'products' );
}

$parent_attr = array(
	'id'    => array( $fields['section_unique_id'] ),
	'class' => array(
		'section-products',
		'section',
		'ewf-section',
		'woocommerce',
	),
);


$counter     = 0;

$item_style           = array();
$item_class           = '';
$item_container_class = array();

$item_container_class[] = 'ewf-item__spacing-' . ( isset( $fields['products_column_spacing'] ) ? $fields['products_column_spacing'] : '' );
/**
 * Layout stuff
 */
$content_class = '';
$header_class  = '';
$row_class     = '';

if ( 'left' == $fields['products_row_title_align'] || 'right' == $fields['products_row_title_align'] ) {
	$content_class = 'col-sm-8';
	$header_class  = 'col-sm-4';
	if ( 'right' == $fields['products_row_title_align'] ) {
		$row_class = 'row-flow-reverse';
	}
} else {
	$content_class = 'col-sm-12';
	$header_class  = 'col-sm-12';
	if ( 'bottom' == $fields['products_row_title_align'] ) {
		$row_class = 'row-column-reverse';
	}
}
$item_container_class[] = 'col-sm-' . 12 / absint( $fields['products_column_group'] );
// end layout stuff
?>

<section data-customizer-section-id="portum_repeatable_section" data-section="<?php echo esc_attr( $section_id ); ?>">
	<?php Portum_Helper::generate_inline_css( $fields['section_unique_id'], 'products', $fields ); ?>
	<?php echo wp_kses( Epsilon_Helper::generate_pencil( 'Portum_Repeatable_Sections', 'products' ), Epsilon_Helper::allowed_kses_pencil() ); ?>
	<div <?php $attr_helper->generate_attributes( $parent_attr ); ?>>
		<?php $attr_helper->generate_color_overlay(); ?>
		<div class="ewf-section__content ewf-text-align--center">

			<div class="<?php echo esc_attr( Portum_Helper::container_class( 'products', $fields ) ); ?>">

				<div class="row <?php echo esc_attr( $row_class ); ?>">

					<?php if ( ! empty( $fields['subtitle'] ) || ! empty( $fields['title'] ) ) { ?>
						<div class="<?php echo esc_attr( $header_class ); ?>">
							<div class="ewf-section-text">
								<?php echo wp_kses_post( Portum_Helper::generate_section_title( $fields['subtitle'], $fields['title'] ) ); ?>
							</div><!--/.ewf-section-text-->
						</div><!--/.header class column -->
					<?php } ?>

					<div class="<?php echo esc_attr( $content_class ); ?>">
						<?php while ( $query->have_posts() ) { ?>
							<?php $counter++; ?>
							<?php $query->the_post(); ?>

							<div class="<?php echo esc_attr( implode( ' ', $item_container_class ) ); ?>">
								<div class="ewf-products">
									<?php get_template_part( 'template-parts/product/section', 'product' ); ?>
								</div><!--/.ewf-products-->
							</div><!--/.col-->

						<?php }// End while(). ?>
					</div><!--/.content class-->
					<?php wp_reset_postdata(); ?>
				</div><!--/.row-->
			</div><!--/. container class -->
		</div><!--/.ewf-section-content-->
	</div><!--/. attr helper-->
</section>

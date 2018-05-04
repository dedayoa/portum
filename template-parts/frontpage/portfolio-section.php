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
$grouping  = array(
	'values'   => $fields['portfolio_grouping'],
	'group_by' => 'portfolio_title',
);

$fields['portfolio_items'] = $frontpage->get_repeater_field( $fields['portfolio_repeater_field'], array(), $grouping );
$attr_helper               = new Epsilon_Section_Attr_Helper( $fields, 'portfolio', Portum_Repeatable_Sections::get_instance() );
$parent_attr               = array(
	'id'    => ! empty( $fields['portfolio_section_unique_id'] ) ? array( $fields['portfolio_section_unique_id'] ) : array(),
	'class' => array( 'section-portfolio', 'section', 'ewf-section' ),
	'style' => array( 'background-image', 'background-position', 'background-size', 'background-repeat' ),
);
wp_enqueue_style( 'magnificPopup' );
wp_enqueue_script( 'magnificPopup' );
?>

<section data-customizer-section-id="portum_repeatable_section" data-section="<?php echo esc_attr( $section_id ); ?>">
	<div <?php $attr_helper->generate_attributes( $parent_attr ); ?>>
		<?php
		$attr_helper->generate_video_overlay();
		$attr_helper->generate_color_overlay();
		?>
		
		<div class="<?php echo esc_attr( Portum_Helper::container_class( 'portfolio', $fields ) ); ?>">		
		<?php echo wp_kses( Portum_Helper::generate_pencil( 'Portum_Repeatable_Sections', 'portfolio' ), Epsilon_Helper::allowed_kses_pencil() ); ?>
		
		<div class="ewf-section__content">

			<div class="row">
			<?php echo wp_kses_post( Portum_Helper::generate_section_title( $fields['portfolio_subtitle'], $fields['portfolio_title'] ) ); ?>

			<?php if ( ! empty( $fields['portfolio_items'] ) ) { ?>
			
				<div class="portfolio-grid fixed">
					<?php foreach ( $fields['portfolio_items'] as $item ) { ?>
						<div class="portfolio-grid-item small-column">
							<?php if ( ! empty( $item['portfolio_image'] ) ) { ?>
								<img src="<?php echo esc_url( $item['portfolio_image'] ); ?>" alt=""/>
							<?php } ?>

							<div class="overlay">

								<div class="wrapper">
									<?php if ( ! empty( $item['portfolio_title'] ) ) { ?>
										<h5><?php echo esc_html( $item['portfolio_title'] ); ?></h5>
									<?php } ?>

									<?php echo wpautop( wp_kses_post( $item['portfolio_description'] ) ); ?>
									
									<?php 
										$is_single_button = null;
										
										if ( empty( $item['portfolio_link'] ) ) {
											$is_single_button = ' zoom-single';
										}
									?>
									
									<div class="action fixed">
										<a href="<?php echo esc_url( $item['portfolio_image'] ); ?>" class="magnific-link zoom<?php echo $is_single_button; ?>">
											<i class="fa fa-search" aria-hidden="true"></i> </a>
										<?php if ( ! empty( $item['portfolio_link'] ) ) { ?>
											<a href="<?php echo esc_url( $item['portfolio_link'] ) ?>" class="link">
												<i class="fa fa-chain" aria-hidden="true"></i> </a>
										<?php } ?>
									</div>

								</div>

							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
		</div>
	</div>
</section>

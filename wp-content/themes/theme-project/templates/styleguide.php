<?php
/**
 * Layout: views/layouts/app.php
 * Template Name: Style Guide
 *
 * The styleguide template file.
 *
 * This is the template that is used to create project
 * styleguide with common components.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MyApp
 */

$sections = [
	'headings'
];
?>
<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div <?php post_class(); ?>>
		<div class="container">
			<h1 class="page__title">
				<?php the_title(); ?>
			</h1>
			<div class="page__content">
				<?php the_content(); ?>
			</div>
		</div>

		<?php foreach( $sections as $section ): ?>
			<?php \MyApp::render( 'styleguide/guide-' . $section ); ?>
		<?php endforeach; ?>
	</div>
<?php endwhile; ?>

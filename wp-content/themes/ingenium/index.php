<?php
/**
 * Layout: views/layouts/app.php
 *
 * The main template file.
 *
 * This is the template that is used for displaying:
 * - posts
 * - single posts
 * - archive pages
 * - search results pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MyApp
 */

$total_cards = 3;
$last_posts = [
	[
		'title' => 'Nailan'
	],
	[
		'title' => 'Guilherme'
	],
	[
		'title' => 'Alefy px-to-rem'
	],
];
?>

<section class="b-last-posts">
	<div class="container">
		<ul class="c-loop-cards c-loop-cards--<?php echo esc_html( $total_cards ); ?>">
			<?php foreach( $last_posts as $card ) : ?>
				<li class="c-loop-cards__item">
					<?php my_app_template( 'views/components/card-post', $card ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

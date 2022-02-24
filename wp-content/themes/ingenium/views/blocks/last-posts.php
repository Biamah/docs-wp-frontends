<?php
/**
 * Title: Last Posts
 * Description: Displays the lasts posts of the Blog page.
 *
 * @package MyApp
 */

?>

<section class="b-last-posts">
	<div class="container">
		<ul class="c-loop-cards c-loop-cards--3">
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
				<li class="c-loop-cards__item">
					<?php my_app_template( 'views/components/card-post' ); ?>
				</li>
			<?php endfor; ?>
		</ul>
	</div>
</section>

<?php
/**
 * Title: Features
 * Description: Displays a sinopse of what we offer.
 *
 * @package MyApp
 */

?>

<section class="b-features">
	<div class="container">
		<ol class="b-features__items">
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<li class="b-features__item">
				<?php my_app_template( 'views/components/feature' ); ?>
			</li>
			<?php endfor; ?>
		</ol>
	</div>
</section>

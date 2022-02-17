<?php
/**
 * Displays a card post with Post informations.
 *
 * @package MyApp
 */

?>

<article class="c-card-post">
	<figure class="c-card-post__figure c-figure">
		<a href="#permalink">
			<img src="https://source.unsplash.com/330x250?nature" alt="Post title" />
		</a>
	</figure>
	<div class="c-card-post__body">
		<div class="c-card-post__meta c-post-meta">
			<a href="#category-link" class="c-category-link">Category</a>
			<p class="c-post-date">02/12/2021</p>
		</div>

		<h2 class="c-card-post__title c-title c-title--h3">
			<a href="#permalink">
				<?php echo esc_html( $title ); ?>
			</a>
		</h2>

		<div class="c-card-post__excerpt c-text">
			<p>
				Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took
			</p>
		</div>
	</div>
</article>

<?php
/**
 * Title: Hero
 * Description: Displays a sinopse of what we offer.
 *
 * @package MyApp
 */

?>

<section class="b-hero">
	<div class="swiper">
		<div class="swiper-wrapper">
			<?php for ( $i = 1; $i <= 1; $i++ ) : ?>
			<div class="swiper-slide">
				<div class="c-background">
					<div class="c-background__image" style="background-image: url('https://source.unsplash.com/1920x1080?nature')"></div>
					<div class="c-background__body">
						<div class="b-hero__content">
							<h2 class="c-title c-title--h1">Lorem Ipsum is simply dummy!</h2>
							<div class="c-text">
								<p>
									Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s,
									when an unknown printer took a galley of type and scrambled it to make a type
									specimen book. It has survived not only five
								</p>
							</div>
							<a class="c-btn c-btn--has-icon c-btn--gradient" href="#button">
								Button
								<svg viewBox="0 0 42 32" class="c-icon c-icon--arrow-right">
									<path fill="none" stroke="currentColor"stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="4" stroke-width="1.4277" d="M0.714 16h40.395"></path>
									<path fill="none" stroke="currentColor"stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="4" stroke-width="1.4277" d="M26.118 1.009l14.991 14.991-14.991 14.991"></path>
								</svg>
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php endfor; ?>
		</div>

		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</section>

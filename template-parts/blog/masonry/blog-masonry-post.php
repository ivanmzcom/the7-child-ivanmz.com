<?php
/**
 * Blog post template for masonry layout (child override).
 */

defined( 'ABSPATH' ) || exit;

// Remove presscore_the_excerpt() filter.
remove_filter( 'presscore_post_details_link', 'presscore_return_empty_string', 15 );

$config = presscore_config();

$post_class = array( 'post' );
if ( ! has_post_thumbnail() ) {
	$post_class[] = 'no-img';
}
?>

<?php do_action( 'presscore_before_post' ); ?>

	<article <?php post_class( $post_class ); ?>>

		<?php
			// Mostrar imagen destacada fuera del contenedor de contenido para ocupar todo el ancho del artículo
			global $post;

			$show_thumbnail = ! get_post_meta( $post->ID, '_dt_post_options_hide_thumbnail', true );
			if ( $show_thumbnail && has_post_thumbnail() ) {
				$thumbnail_id = get_post_thumbnail_id();
				$video_url    = presscore_get_image_video_url( $thumbnail_id );
				if ( $video_url ) {
					$post_media_html = '<div class="post-video alignnone">' . dt_get_embed( $video_url ) . '</div>';
				} else {
					$thumb_args = array(
						'class'  => 'child-featured-img alignnone',
						'img_id' => $thumbnail_id,
						'wrap'   => '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
						'echo'   => false,
					);

					// Thumbnail proportions.
					if ( 'resize' === of_get_option( 'blog-thumbnail_size' ) ) {
						$prop   = of_get_option( 'blog-thumbnail_proportions' );
						$width  = max( absint( $prop['width'] ), 1 );
						$height = max( absint( $prop['height'] ), 1 );

						$thumb_args['prop'] = $width / $height;
					}

					$post_media_html = presscore_get_post_fancy_date();
					if ( presscore_config()->get_bool( 'post.fancy_category.enabled' ) ) {
						$post_media_html .= presscore_get_post_fancy_category();
					}

					$post_media_html .= dt_get_thumb_img( $thumb_args );
				}

				echo '<div class="post-thumbnail">' . $post_media_html . '</div>';
			}
		?>



		<div class="blog-content wf-td">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<?php
			echo presscore_get_posted_on();



				// Mostrar el extracto en lugar del contenido completo
				if ( ! post_password_required() ) {
					presscore_the_excerpt();
				}

			if ( $config->get( 'show_details' ) ) {
				echo presscore_post_details_link();
			}
            ?>

		</div>

	</article>

<?php do_action( 'presscore_after_post' ); ?>

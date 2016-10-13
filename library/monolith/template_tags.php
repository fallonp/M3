<?php
/**
 * Collection of functions intended for use within the theme
 * @license MIT http://opensource.org/licenses/MIT
 * @package monolith
 */


if ( ! function_exists( 'dump' ) ) {
	/**
	 * Print a pre formatted array to the browser - very useful for debugging
	 *
	 * @param  array|object
	 *
	 * @return  void
	 **/
	function dump( $v ) {
		print( '<pre>' );
		print_r( $v );
		print( '</pre>' );
	}
}


if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	/**
	 * Tests if any of a post's assigned categories are descendants of target categories
	 *
	 * @param int|array $cats The target categories. Integer ID or array of integer IDs
	 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
	 *
	 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
	 * @see  get_term_by() You can get a category by name or slug, then pass ID to this function
	 * @uses get_term_children() Passes $cats
	 * @uses in_category() Passes $_post (can be empty)
	 * @version 2.7
	 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
	 */
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) ) {
				return true;
			}
		}
		
		return false;
	}
}

if ( ! function_exists( 'get_topmost_parent_id' ) ) {
	/**
	 * Returns the topmost parent post ID for the current post.  Designed For use with the pages.
	 * @return int
	 * @author Jon Martin
	 */
	function get_topmost_parent_id() {
		global $post;
		$ancestors = get_post_ancestors( $post->ID );
		$root      = count( $ancestors ) - 1;
		
		return $ancestors[ $root ];
	}
}


if ( ! function_exists( 'is_related' ) ) {
	/**
	 * Returns true if the supplied page ID is related to the current post, including if it is the current page, the parent, or the topmost parent
	 *
	 * @param $page_id
	 *
	 * @return bool
	 */
	function is_related( $page_id ) {
		global $post;
		
		if ( is_page() && ( $post->ID === $page_id || $post->post_parent === $page_id || get_topmost_parent_id() === $page_id ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'is_descendant' ) ) {
	/**
	 * Returns true if the supplied page ID is the direct child, or a descendant of the current page
	 *
	 * @param $page_id
	 *
	 * @return bool
	 */
	function is_descendant( $page_id ) {
		global $post;
		
		if ( is_page() && ( $post->post_parent === $page_id || get_topmost_parent_id() === $page_id ) ) {
			return true;
		} else {
			return false;
		}
	}
}


if ( ! function_exists( 'monolith_post_thumbnail_caption' ) ) {
	/**
	 * Echoes the caption for a post thumbnail
	 * return void
	 */
	function monolith_post_thumbnail_caption() {
		global $post;
		
		$thumbnail_id    = get_post_thumbnail_id( $post->ID );
		$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );
		
		if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
			echo '<span>' . $thumbnail_image[0]->post_excerpt . '</span>';
		}
	}
}


if ( ! function_exists( 'get_excerpt' ) ) {
	/**
	 * Returns a custom excerpt length, defaults to 240 chars
	 *
	 * @param int $length
	 *
	 * @return string $excerpt
	 */
	function get_excerpt( $length = 240 ) {
		global $post;
		
		$excerpt = get_the_excerpt();
		
		// get the natural length
		$start_length = strlen( $excerpt );
		
		$excerpt = preg_replace( " (\[.*?\])", '', $excerpt );
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = strip_tags( $excerpt );
		$excerpt = substr( $excerpt, 0, $length );
		
		// if the excerpt is longer than the required length, truncate to the last word and add three dots
		if ( $start_length > $length ) {
			$excerpt = substr( $excerpt, 0, strrpos( $excerpt, " " ) );
			$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
			$excerpt .= '...';
		}
		
		return $excerpt;
	}
}

if ( ! function_exists( 'get_content' ) ) {
	/**
	 * Returns a custom excerpt length
	 *
	 * @param int $length
	 *
	 * @return mixed|string
	 */
	function get_content( $length = 240 ) {
		global $post;
		
		$content = get_the_content();
		
		// get the natural length
		$start_length = strlen( $excerpt );
		
		$content = preg_replace( " (\[.*?\])", '', $content );
		$content = strip_shortcodes( $content );
		$content = strip_tags( $content );
		$content = substr( $content, 0, $content );
		
		// if the excerpt is longer than the required length, truncate to the last word and add three dots
		if ( $start_length > $length ) {
			$content = substr( $excerpt, 0, strrpos( $content, " " ) );
			$content = trim( preg_replace( '/\s+/', ' ', $content ) );
			$content .= '...';
		}
		
		return $content;
	}
}

if ( ! function_exists( 'get_short_title' ) ) {
	/**
	 * Returns a custom post title length
	 *
	 * @param int $length defaults to 45 chars
	 *
	 * @return string $title
	 */
	function get_short_title( $length = 45 ) {
		global $post;
		
		$title = get_the_title();
		//get the natural length
		$start_length = strlen( $title );
		
		$title = substr( $title, 0, $length );
		// if the excerpt is longer than the required length, truncate to the last word
		if ( $start_length > $length ) {
			$title .= '...';
		}
		
		return $title;
	}
}

if ( ! function_exists( 'monolith_comments' ) ) {
	/**
	 * Markup for the comments
	 *
	 * @param object $comment
	 * @param array $args
	 * @param int $depth
	 */
	function monolith_comments( $comment, $args, $depth ) {
		$GLOBALS['comment']  = $comment;
		$comment_id          = get_comment_ID();
		$comment_avatar      = get_avatar( $comment );
		$comment_author_link = get_comment_author_link();
		$comment_date        = get_comment_date();
		$comment_text        = get_comment_text();
		
		if ( $comment->comment_approved === '1' ) {
			echo "
				<li>
					<article id=\"comment-{$comment_id}\">
						<div class=\"well\">
							<div class=\"row\">
								<div class=\"columns medium-3\">{$comment_avatar}</div>
								<div class=\"columns medium-9\">
									<h4>{$comment_author_link}</h4>
									<p class=\"muted\">
										<time>{$comment_date}</time>
									</p>
									{$comment_text}
								</div>
							</div>
						</div>
					</article>
				</li>
			";
		}
	}
}

if ( ! function_exists( 'time_ago' ) ) {
	/**
	 * Shows the time ago in hours if in last day, yesterday, or the date
	 *
	 * @param string $type
	 *
	 * @return string
	 */
	function time_ago( $type = 'post' ) {
		$d   = 'comment' === $type ? 'get_comment_time' : 'get_post_time';
		$now = time();
		
		$posttime = $d( 'U' );
		
		// if yesterday, return yesterday
		if ( $now - $posttime >= 86400 && $now - $posttime < 172800 ) {
			return 'Yesterday';
		} // if greater than yesterday, return the date
		elseif ( $now - $posttime >= 172800 ) {
			return get_the_date();
		} else {
			// otherwise return the human_time_diff (assumes within the last 24 hours
			return human_time_diff( $d( 'U' ), current_time( 'timestamp' ) ) . " " . __( 'ago' );
		}
	}
}

if ( ! function_exists( 'get_monolith_post_thumbnail' ) ) {
	/**
	 * Return featured image URI if one exists, otherwise return default fallback image URI
	 */
	function get_monolith_post_thumbnail( $size ) {
		return has_post_thumbnail()
			? get_the_post_thumbnail( get_the_ID(), $size )
			: '<img src="' . get_template_directory_uri() . '/assets/img/fallback.png" alt="" />';
	}
}

if ( ! function_exists( 'the_monolith_post_thumbnail' ) ) {
	/**
	 * Echo the image URL returned by get_monolith_post_thumbnail()
	 */
	function the_monolith_post_thumbnail( $size ) {
		echo get_monolith_post_thumbnail( $size );
	}
}

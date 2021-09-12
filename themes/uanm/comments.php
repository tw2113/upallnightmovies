<?php
if ( post_password_required() ) : ?>
    <p>This post is password protected. Enter the password to view any comments.</p>
<?php
	/* Stop the rest of comments.php from being processed, but don't kill the script entirely -- we still have to fully load the template. */
	return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>
	<div id="comments">
	<h3 id="comments-title">
	<?php
	$count = number_format_i18n( get_comments_number() );
	printf(
		_n(
			'One thought on %1$s',
			'%1$s thoughts on %2$s',
			$count,
			'uanm'
		),
		$count,
		get_the_title()
	); ?>
	</h3>

	<?php
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		previous_comments_link( '&larr; Older Comments' );
		next_comments_link( 'Newer Comments &rarr;' );
	endif;
	?>
	<ol>
	<?php wp_list_comments( [ 'callback' => 'uanm_comment' ] ); ?>
	</ol>

	<?php
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		previous_comments_link( '&larr; Older Comments' );
		next_comments_link( 'Newer Comments &rarr;' );
	endif;

	else :
		if ( ! comments_open() ) :
		?>
		<p>Comments are closed.</p>

		<?php
		endif; // end ! comments_open()
	endif; // end have_comments()
	?>
	</div>
	<div id="comments-form">
		<?php
		comment_form(
			[
				'comment_notes_after' => '',
				'fields' => [
					'author' => '<p class="comment-form-author"><label for="author">' . __( 'Your name: ' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
					'email' => '<p class="comment-form-email"><label for="email">' . __( 'Your email: ' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" required /></p>',
					'url' => '<p class="comment-form-url"><label for="url">' . __( 'Your website: ' ) . '</label>' . '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
				],
				'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Your comment:', 'noun' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>'
			]
		);
	?>
	</div>

<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>    
		<?php die('Non puoi accedere a questa pagina direttamente!'); ?>  
<?php endif; ?>

<?php if(!empty($post->post_password)) : ?>  
        <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
		<p>Questo post &egrave; protetto da password. Per leggerlo inserisci password per visualizzare i commenti<p>
        <?php endif; ?>  
<?php endif; ?>
<!-- Puoi cominciare le modifiche da qui. -->
<?php
$count = 0;
$comment_entries = get_comments(array( 'type'=> 'comment', 'post_id' => $post->ID ));
if(count($comment_entries) > 0){
    foreach($comment_entries as $comment){
        if($comment->comment_approved)
            $count++;
    }
}
?>
<section>
	<div id="comments">
		<?php if (comments_open() ){
				if($count == 0){
				echo "";
				}
				if($count == 1){
				echo "<h3>$count Commento</h3>";
				}				
				else echo "<h3>$count Commenti</h3>";
			}
		?>
			<div class="row-fluid">
				<?php
                  if ( have_comments() ) : 
                  if(!empty($comment_entries)){
                  wp_list_comments( array( 'type'=> 'comment', 'callback' => 'ItalyStrap_custom_comment' ) );
                } ?>
            <?php endif;?>
			</div>
	</div>
<?php  
    /**
     * ItalyStrap_custom_comment()
     * @return
     */
    function ItalyStrap_custom_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>

                <li class="comment media" id="comment-<?php comment_ID(); ?>">
                    <div class="media-body">
                        <p>
                            <?php _e('Pingback:', 'ItalyStrap'); ?> <?php comment_author_link(); ?>
                        </p>
                    </div><!--/.media-body -->
                <?php
                break;
            default :
                // Proceed with normal comments.
                global $post; ?>
				
				
                <div class="comment <?php if($depth == 1) echo 'span12'; else echo 'span11 offset1'; ?>">
								<div class="row-fluid margin-bottom-25 <?php if ($comment->user_id === $post->post_author) { echo 'bg-color-author';} ?>"itemscope itemtype="http://schema.org/Comment">
                                    <div class="span2"><?php echo get_avatar($comment, '92') ?></div>
                                    <div class="span10">
										<ul class="inline margin-bottom-10">
											<li>
											<h4 class="media-heading">
												<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php echo get_comment_author() ?><meta itemprop="image" content="<?php  $thumbnailUrl = get_avatar($comment); echo estraiUrlsGravatar($thumbnailUrl);?>"/></span></a>
												<?php
												printf(
												// If current post author is also comment author, make it known visually.
													($comment->user_id === $post->post_author) ? '<span class="label"> ' . __(
														'The Boss :-)',
														'ItalyStrap'
													) . '</span> ' : ''); ?>
											</h4>
											
											</li>
											<li><time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time></li>
											<?php edit_comment_link(__('Modifica','ItalyStrap'),'<span class="btn btn-small btn-info pull-right"><i class="icon-white icon-pencil"></i>','</span>') ?>
										</ul>
											<p itemprop="text"><?php echo get_comment_text($comment); ?></p>
											<?php if ($comment->comment_approved == '0') : ?>
												 <span  class="alert alert-success">Il tuo commento &egrave; in attesa di moderazione.</span>
											<?php endif; ?>
												<p class="reply btn btn-small btn-success pull-right">
													<?php comment_reply_link( array_merge($args, array(
																'reply_text' => __('Rispondi <span>&darr;</span>', 'ItalyStrap'),
																'depth'      => $depth,
																'max_depth'  => $args['max_depth'],
																'class'      => _('btn'),
															)
														)); ?>
												</p>
									</div>
								</div>

                </div>
                <?php
                break;
        endswitch;
    }
?>


<?php if ( comments_open() ) : ?>
		<h3><?php comment_form_title( __("E tu cosa ne pensi?","ItalyStrap"), __("Rispondi a ","ItalyStrap") . ' %s' ); ?></h3>
			<p><?php new_cancel_comment_reply_link( __("Annulla" , "ItalyStrap") ); ?></p>
				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p class="alert margin-top-25">Devi essere <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("loggato","ItalyStrap"); ?></a> per scrivere il tuo commento :-)</p>
				<?php else : ?>
				<div class="form-actions">
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">
						<?php if ( is_user_logged_in() ) : ?>
						<p class="comments-logged-in-as"><?php _e("Loggato come","ItalyStrap"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Esci","ItalyStrap"); ?>">Esci &raquo;</a></p>

						<?php else : ?>
							<ul id="comment-form-elements" class="clearfix">
								
								<li>
									<div class="control-group">
									  <label for="author"><?php _e("Nome","ItalyStrap"); ?> <?php if ($req) echo "(Richiesto)"; ?></label>
									  <div class="input-prepend">
										<span class="add-on"><i class="icon-user"></i></span><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Il tuo nome","ItalyStrap"); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
									  </div>
									</div>
								</li>
								<li>
									<div class="control-group">
									  <label for="email"><?php _e("Mail","ItalyStrap"); ?> <?php if ($req) echo "(Richiesta)"; ?></label>
									  <div class="input-prepend">
										<span class="add-on"><i class="icon-envelope"></i></span><input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("La tua mail","ItalyStrap"); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
										<span class="help-inline">(<?php _e("Non sarà resa pubblica","ItalyStrap"); ?>)</span>
									  </div>
									</div>
								</li>
								<li>
									<div class="control-group">
									  <label for="url"><?php _e("Sito web","ItalyStrap"); ?></label>
									  <div class="input-prepend">
									  <span class="add-on"><i class="icon-home"></i></span><input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e("Your Website","ItalyStrap"); ?>" tabindex="3" />
									  </div>
									</div>
								</li>
							</ul>
						<?php endif; ?>
						<div class="clearfix">
								<textarea name="comment" id="comment" placeholder="Scrivi il tuo commento qui" tabindex="4" rows="6" class="span9"></textarea>
						</div>
						  <input class="btn btn-large btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="Invia il commento" />
						  <?php comment_id_fields(); ?>
					
						<?php 
							//comment_form();
							do_action('comment_form()', $post->ID); 
						
						?>
					</form>
				</div>
		
		<?php endif; // If registration required and not logged in ?>
<?php endif; // If registration required and not logged in ?>
</section>
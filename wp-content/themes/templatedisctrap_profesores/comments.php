<?php if ( post_password_required() ): ?>
	<?php return; ?>
<?php endif; ?>
<div class="row">
    <div id="comments" class="col-md-12 comments-area">
	<?php if ( have_comments() ) : ?>
            <h4 class="comments-title">
                <p><span class="badge badge-disc"><?php echo get_comments_number(); ?></span> Comentatio(s) en: <?php echo get_the_title(); ?></p>
            </h4>
            <div class="comment-list">
                <?php wp_list_comments( array(
					'style'       => 'div',
                                        'reply_text'  => 'Responder',
					'short_ping'  => false,
					'avatar_size' => 48,
                                        'callback'    => 'disctrap_comment',
                                        'end-callback' => 'disctrap_comment_end',
                                        ));
		?>
               </div>
	<?php endif; ?>
        </div>
        <div id="comentar" class="col-md-12">
            <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :	?> <!-- si recibia comentarios pero está cerrado -->
                    <p class="no-comments">En este momento no estamos recibiendo comentarios.</p>
            <?php endif; ?>

        <?php $fields = array(
            'author' => '<div class="form-group"><label class="control-label col-sm-2"  for="author">Nombre*:</label><div class="col-sm-10"><input type="text" class="form-control" name="author" id="author" required></div></div>',
            'email' => '<div class="form-group"><label class="control-label col-sm-2" for="email">Correo*:</label><div class="col-sm-10"><input type="email" class="form-control" name="email" id="email" required></div></div>',
            'url' =>'<div class="form-group"><label class="control-label col-sm-2"  for="url">Sitio web:</label><div class="col-sm-10"><input type="url" class="form-control" name="url" id="url"></div></div>',
        );?>
        
        <?php $new_defaults = array(
            'comment_field' => '<div class="form-group"><label class="control-label col-sm-2"  for="comment">Comentario*:</label><div class="col-sm-10"><textarea class="form-control" rows="5" id="comment" name="comment" required></textarea></div>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Conectado como <a href="%1$s">%2$s</a>. ¿Desea <a href="%3$s" title="salir"> salir?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'comment_notes_before' => '<p class="comment-notes">' . __( 'Su dirección de correo no será publicada.' ) . '</p>',
            'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf( __( 'Puede usar las siguientes etiquetas y atribútos <abbr title="HyperText Markup Language">HTML</abbr>: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
            'class_submit' => 'btn btn-disc',
            'title_reply' => __( 'Comentar' ),
            'title_reply_to' => __( 'Responder a %s' ),
            'cancel_reply_link' => __( 'Descartar respuesta' ),
            'label_submit' => __( 'Comentar' ),
            'id_form' =>'form-comentar-disc',
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            
        );?>
        
        <?php comment_form($new_defaults); ?>
        <script>
            try{
                var form = document.getElementById('form-comentar-disc');
                form.className += ' form-horizontal'; 
            }catch(err){ }
        </script> 

    </div>
</div>
</div>


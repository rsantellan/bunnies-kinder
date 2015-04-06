<?php 
use_helper('mdAsset');
use_plugin_javascript('mastodontePlugin', 'jquery/jquery-1.6.1.min.js');
use_javascript('tinymce/tinymce.min.js', 'last'); 
use_javascript('startNewTiny.js', 'last');
?>
<div class="content">
    <div class="pure-g">
        <div class="l-box-lrg pure-u-1 pure-u-md-1-5"></div>
        <div class="l-box-lrg pure-u-1 pure-u-md-3-5">
            <?php if ($sf_user->hasFlash('notice')): ?>
                <div style='color: blue;'><?php echo $sf_user->getFlash('notice') ?></div>
            <?php endif ?>
            <form action='<?php echo url_for('mdNewsletterBackend/createNew'); ?>' method='POST' class='pure-form pure-form-inline'>
                <?php echo $form->renderHiddenFields();?>
                <?php echo $form->renderGlobalErrors() ?>
                <fieldset>
                    <legend>Editar Newsletter</legend>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1">
                            Asunto
                            <?php echo $form['subject']->renderError() ?>
                            <?php echo $form['subject']->render(array('class' => 'pure-input-1')) ?>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-1">
                            Mensaje
                            <?php echo $form['body']->renderError() ?>
                            <?php echo $form['body']->render(array('class' => 'pure-input-1')) ?>
                        </div>
                    </div>
                    
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <input type='submit' value='Guardar' class="pure-button"/>
                        </div>
                    </div>
                    <?php //echo $form ?>
                    
                </fieldset>
            </form>
            
            
        </div>
        <div class="l-box-lrg pure-u-1 pure-u-md-1-5"></div>
    </div>
</div>

<a href='<?php echo url_for('@manage_newsletter') ?>' class="pure-button">Volver al listado</a>

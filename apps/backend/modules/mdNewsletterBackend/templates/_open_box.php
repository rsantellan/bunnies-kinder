<div ajax-url="<?php echo url_for('mdNewsletterBackend/closedBox?id='.$form->getObject()->getId()) ?>">
    <ul class="md_objects" >
        <li class="md_objects open" id='md_object_<?php echo $form->getObject()->getId() ?>'>
          <a href="<?php echo url_for('mdNewsletterBackend/editNew?id='.$form->getObject()->getId());?>">
          Editar mensaje.
          </a>
            <div id="form_edit_container<?php echo $form->getObject()->getId();?>" class="hidden">
            </div>
            <div class="clear"></div>
            <a href="<?php echo url_for("mdNewsletterBackend/showContent?id=".$form->getObject()->getId());?>" class="visualizar iframe"><?php echo __("newsletter_Visualizar");?></a>
            <a onclick="return mdNeewsLetterBackend.getInstance().confirmDeleteMdNewsletterContent('<?php echo __("newsletter_esta seguro de querer eliminar?");?>', '<?php echo url_for("mdNewsletterBackend/deleteContent?id=".$form->getObject()->getId());?>');" href="javascript:void(0)"><?php echo __("newsletter_Eliminar");?></a>
            <div class="clear"></div>
            <div class="buttons_holder" style="float: right">
              
                <input type="button" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();" value="<?php echo __('newsletter_cancel') ?>" />
            </div>

        </li>
        <li>
            <hr/>
            <div id="sending_container">
              <?php include_component("mdNewsletterBackend", "addDates", array("object" => $form->getObject()));?>       
            </div>
            <div id="sended_container">
              <?php include_component("mdNewsletterBackend", "retrieveSended", array("object" => $form->getObject()));?>       
            </div>
        </li>
    </ul>
</div>
<script type="text/javascript">
    $(function() {
		$( "input:button", ".buttons_holder" ).button();
    });
</script>

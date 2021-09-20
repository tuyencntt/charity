<?php

?>
<form method="get" class="searchform uk-grid-column-small" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-uk-grid>
    <div class="uk-width-expand"><input type="text" class="field Tzsearchform inputbox search-query uk-margin-remove-vertical" name="s" placeholder="<?php esc_attr_e( 'Search...', 'charity');?>" /></div>
	<div class="uk-width-auto"><input type="submit" class="submit searchsubmit" name="submit" value="<?php esc_attr_e( 'Search', 'charity'); ?>" /></div>
</form>
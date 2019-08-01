<?php
if( !is_front_page(  ) ){
  dynamic_sidebar( 'content_bottom' );
} ?>
<footer id="footer">
<?php dynamic_sidebar('Footer'); ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
</div>

<div class="footer" id="footer">

	<div class="footertop"></div>

	<div class="footerl">
	
		<p>Write something about your blog here</p>

	</div>

	<div class="footerr">

		<h2>Categories &raquo;</h2>

		<ul>

		<?php wp_list_categories('orderby=count&order=DESC&number=10&show_count=0&title_li='); ?>

		</ul>

	</div>

	<div class="footerr" style="margin: 0;">

		<h2>Links &raquo;</h2>
		
		<ul>

		<?php wp_list_bookmarks('orderby=name&order=ASC&limit=10&title_li=&categorize=0'); ?>
		
		</ul>

	</div>

	<div class="clear"></div>

	

	<div align="right" style="padding-top: 20px;">Copyright &copy; 2008. All Rights Reserved / Powered by <a href="http://wordpress.org">WordPress</a> / <a href="http://making-the-web.com">Wordpress theme design by Brendon Boshell</a>.</div>

	</div>

</div>



<?php wp_footer(); ?>

</body>

</html>


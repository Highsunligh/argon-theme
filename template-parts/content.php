<article class="post card bg-white shadow-sm border-0 <?php if (get_option('argon_enable_into_article_animation') == 'true'){echo 'post-preview';} ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header text-center<?php if (has_post_thumbnail()){echo " post-header-with-thumbnail";}?>">
		<?php
			if (has_post_thumbnail()){
				$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full")[0];
				echo "<img class='post-thumbnail' src='" . $thumbnail_url . "' alt='thumbnail'></img>";
				echo "<div class='post-header-text-container'>";
			}
		?>
		<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<div class="post-meta">
			<?php
				$metaList = explode('|', get_option('argon_article_meta', 'time|views|comments|categories'));
				if (is_sticky() && is_home() && ! is_paged()){
					array_unshift($metaList, "sticky");
				}
				if (post_password_required()){
					array_unshift($metaList, "needpassword");
				}
				for ($i = 0; $i < count($metaList); $i++){
					if ($i > 0){
						echo ' <div class="post-meta-devide">|</div> ';
					}
					echo get_article_meta($metaList[$i]);
				}
			?>
			<?php if (!post_password_required() && get_option("argon_show_readingtime") != "false" && is_readingtime_meta_hidden() == False) { ?>
				</br>
				<div class="post-meta-detail post-meta-detail-words">
					<i class="fa fa-file-word-o" aria-hidden="true"></i>
					<?php
						echo get_article_words(get_the_content()) . " " . __("字", 'argon');
					?>
				</div>
				<div class="post-meta-devide">|</div>
				<div class="post-meta-detail post-meta-detail-words">
					<i class="fa fa-hourglass-end" aria-hidden="true"></i>
					<?php
						echo get_reading_time(get_article_words(get_the_content()));
					?>
				</div>
			<?php } ?>
		</div>
		<?php
			if (has_post_thumbnail()){
				echo "</div>";
			}
		?>
	</header>

	<div class="post-content">
		<?php
			if (get_option("argon_hide_shortcode_in_preview") == 'true'){
				$preview = wp_trim_words(do_shortcode(get_the_content()), 175);
			}else{
				$preview = wp_trim_words(get_the_content(), 175);
			}
			if (post_password_required()){
				$preview = "这篇文章受密码保护，输入密码才能阅读";
			}
			if ($preview == ""){
				$preview = "这篇文章没有摘要";
			}
			if ($post -> post_excerpt){
				$preview = $post -> post_excerpt;
			}
			echo $preview;
		?>
	</div>

	<?php if (has_tag()) { ?>
		<div class="post-tags">
			<i class="fa fa-tags" aria-hidden="true"></i>
			<?php
				$tags = get_the_tags();
				foreach ($tags as $tag) {
					echo "<a href='" . get_category_link($tag -> term_id) . "' target='_blank' class='tag badge badge-secondary post-meta-detail-tag'>" . $tag -> name . "</a>";
				}
			?>
		</div>
	<?php } ?>
</article>
<?php
function get_related_posts($post_id) {
	$query = new WP_Query();
    
    $args = '';

	$args = wp_parse_args($args, array(
		'showposts' => -1,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'category__in' => wp_get_post_categories($post_id)
	));
	
	$query = new WP_Query($args);
	
  	return $query;
}

function get_related_projects($post_id) {
    $query = new WP_Query();
    
    $args = '';

    $item_cats = get_the_terms($post->ID, 'portfolio_category');
    if($item_cats):
    foreach($item_cats as $item_cat) {
        $item_array[] = $item_cat->term_id;
    }
    endif;

    $args = wp_parse_args($args, array(
        'showposts' => -1,
        'post__not_in' => array($post_id),
        'ignore_sticky_posts' => 0,
        'post_type' => 'avada_portfolio',
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => $item_array
            )
        )
    ));
    
    $query = new WP_Query($args);
    
    return $query;
}

function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination clearfix'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><span class='arrows'>&laquo;</span> First</a>";
         if($paged > 1) echo "<a class='pagination-prev' href='".get_pagenum_link($paged - 1)."'><span class='page-prev'></span>".__('Previous', 'Crucio')."</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages) echo "<a class='pagination-next' href='".get_pagenum_link($paged + 1)."'>".__('Next', 'Crucio')."<span class='page-next'></span></a>";  
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last <span class='arrows'>&raquo;</span></a>";
         echo "</div>\n";
     }
}

function string_limit_words($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	
	if(count($words) > $word_limit) {
		array_pop($words);
	}
	
	return implode(' ', $words);
}

function kriesi_breadcrumb() {
        echo '<ul class="breadcrumbs">';
        
         if ( !is_front_page() ) {
        echo '<li><a href="';
        echo home_url();
        echo '">Home';
        echo "</a></li>";
        }
        
        if ( is_category() || is_single() && !is_singular('avada_portfolio')) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo '<li>'.get_category_parents($ID, TRUE, '', FALSE ).'</li>';
        }

        if(is_singular('avada_portfolio')) {
            echo get_the_term_list($post->ID, 'portfolio_category', '<li>', ' - ', '</li>');   
        }

        if(is_home()) { echo '<li>Blog</li>'; }
        if(is_single() || is_page()) { echo '<li>'.get_the_title().'</li>'; }
        if(is_tag()){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        if(is_404()){ echo '<li>'.__("404 - Page not Found", 'Crucio').'</li>'; }
        if(is_search()){ echo '<li>'.__("Search", 'Crucio').'</li>'; }
        if(is_year()){ echo '<li>'.get_the_time('Y').'</li>'; }

        echo "</ul>";
}

// Custom RSS Link
add_filter('feed_link','pyre_feed_link', 1, 2);
function pyre_feed_link($output, $feed) {
    if(of_get_option('feedburner_link')):
    $feed_url = of_get_option('feedburner_link');

    $feed_array = array('rss' => $feed_url, 'rss2' => $feed_url, 'atom' => $feed_url, 'rdf' => $feed_url, 'comments_rss2' => '');
    $feed_array[$feed] = $feed_url;
    $output = $feed_array[$feed];
    endif;

    return $output;
}
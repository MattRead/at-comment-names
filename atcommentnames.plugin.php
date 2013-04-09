<?php

class atCommentNames extends Plugin
{
	public function filter_comment_content_out_16($content, $comment)
	{
		$callback = function ($matches) use ($comment)
		{
			// loop backward until we find one.
			$com = end($comment->post->comments);
			do {
				if ( $com->id < $comment->id && 
					( $com->name == substr($matches[1], 1) || str_replace(' ', '_', $com->name) == substr($matches[1], 1) ) ) {
					return '<a href="#comment-' . $com->id . '">' . $matches[1] . '</a>';
				}
			} while ( $com = prev($comment->post->comments) );
			// couldn't find any so return original value.
			return $matches[1];
		};
		$content = preg_replace_callback( '#(@[0-9a-zA-Z_]+)\b#i', $callback, $content );
		if ( !$comment->post->info->comments_disabled ) {
			$onclick = 'var c = document.getElementById(\'comment_content\'); c.focus(); c.innerHTML = c.innerHTML + \'@'. str_replace(' ', '_', $comment->name) .' \'; return true;';
			$content .= '<div class="at-comment-reply"><p><small><a href="#comment_content" onclick="' . $onclick . '">&#x21A9 Reply</a></small></p></div>';
		}
		return $content;
	}
}
?>

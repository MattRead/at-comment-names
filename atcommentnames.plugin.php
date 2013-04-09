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
		return preg_replace_callback( '#(@[0-9a-zA-Z_]+)\b#i', $callback, $content );
	}
}
?>

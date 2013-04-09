<?php

class atCommentNames extends Plugin
{
	public function filter_comment_content_out($content, $comment)
	{
		if (!preg_match_all('#(@[0-9a-zA-Z_]+)\b#i', $content, $matches, PREG_SET_ORDER)) {
			return $content;
		}
		$id = null;
		foreach ( $matches as $m ) {
			foreach($comment->post->comments as $com) {
				if ($com->id < $comment->id && $com->name == substr($m[1], 1)) {
					$id = $com->id;
				}
			}
			$content = $id ? str_replace($m[1], '<a href="#comment-'.$id.'">'.$m[1].'</a>', $content) : $content;
			$id = null;
		}
		return $content;
	}
}

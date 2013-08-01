<?php
namespace Craft;

class ScrippetsTwigExtension extends \Twig_Extension
{

	public function getName()
	{
		return Craft::t('Scrippets');
	}

	public function getFilters()
	{
		return array(
			'scrippets' => new \Twig_Filter_Method($this, 'scrippetsFilter')
		);
	}

	public function scrippetsFilter($text)
	{
		// Create arrays & setup some basic character replacements
		$pattern   = array('/\r/', '/&amp;/', '/\.{3}|…/', '/\-{2}|—|–/');
		$replace   = array('', '&', '&#46;&#46;&#46;', '&#45;&#45;');
		
		// Sceneheaders must start with INT, EXT, or EST
		$pattern[] = '/\n(INT|EXT|[^a-zA-Z0-9]EST)([\.\-\s]+?)(.+?)([A-Za-z0-9\)\s\.])\n/';
		$replace[] = '<p class="sceneheader">\1\2\3\4</p>' . "\n";
		
		// Catches transitions
		// Looks for a colon, with some hard coded exceptions that don't use colons.
		$pattern[] = '/\n([^<>\na-z]*?:|FADE TO BLACK\.|FADE OUT\.|CUT TO BLACK\.)[\s]??\n/';
		$replace[] = '<p class="transition">\1</p>' . "\n";
		
		// Catches multi-line action blocks
		// looks for all caps without punctuation, then two Newlines.
		// This differentiates from character cues because Cues will only have a single break, then the dialogue/parenthetical.    
		$pattern[] = '/\n{2}(([^a-z\n\:]+?[\.\?\,\s\!]*?)\n{2}){1,2}/';
		$replace[] = "\n" . '<p class="action">\2</p>' . "\n";
		
		// Catches character cues
		// Looks for all caps, parenthesis (for O.S./V.O.), then a single newline.
		$pattern[] = '/\n([^<>a-z\s][^a-z:\!\?]*?[^a-z\(\!\?:,][\s]??)\n{1}/'; // minor change that makes it work better
		$replace[] = '<p class="character">\1</p>';    
		
		// Catches parentheticals
		// Just looks for text between parenthesis.
		$pattern[] = '/(\([^<>]*?\)[\s]??)\n/';
		$replace[] = '<p class="parenthetical">\1</p>';
		
		// Catches dialogue
		// Must follow a character cue or parenthetical.
		$pattern[] = '/(<p class="character">.*<\/p>|<p class="parenthetical">.*<\/p>)\n{0,1}(.+?)\n/';
		$replace[] = '\1' . "\n" . '<p class="dialogue">\2</p>' . "\n";    
		
		// Defaults.
		$pattern[] = '/([^<>]*?)\n/';
		$replace[] = '<p class="action">\1</p>' . "\n";
		
		// Hack - cleans up the mess the action regex is leaving behind.
		$pattern[] = '/<p class="action">[\n\s]*?<\/p>/';
		$replace[] = "";
		
		// Styling
		$pattern[] = '/(\*{2}|\[b\])(.*?)(\*{2}|\[\/b\])/';
		$replace[] = '<b>\2</b>';
		
		$pattern[] = '/(\*{1}|\[i\])(.*?)(\*{1}|\[\/i\])/';
		$replace[] = '<i>\2</i>';
		
		$pattern[] = '/(_|\[u\])(.*?)(_|\[\/u\])/';
		$replace[] = '<u>\2</u>';	
		
        // Remove any HTML tags in the scrippet block
        $text = preg_replace('/<\/p>|<br(\/)?>/i', "\n", $text);
        $text = strip_tags($text);
        
        $text .= "\n";   // this is a hack to eliminate some weirdness at the end of the scrippet

        // Regular Expression Magic!                        
        $text = preg_replace($pattern, $replace, $text);

		return $text;
	}

}

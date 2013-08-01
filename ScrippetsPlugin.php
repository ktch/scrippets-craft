<?php
namespace Craft;

class ScrippetsPlugin extends BasePlugin
{

	/* --------------------------------------------------------------
	 * PLUGIN INFO
	 * ------------------------------------------------------------ */

	public function getName()
	{
		return Craft::t('Scrippets');
	}

	public function getVersion()
	{
		return '0.1';
	}

	public function getDeveloper()
	{
		return 'Zach Phillips';
	}

	public function getDeveloperUrl()
	{
		return 'http://zach.be';
	}

	/* --------------------------------------------------------------
	 * HOOKS
	 * ------------------------------------------------------------ */

	/**
	 * Load the TruncateTwigExtension class from our ./twigextensions
	 * directory and return the extension into the template layer
	 */
	public function hookAddTwigExtension()
	{
		Craft::import('plugins.scrippets.twigextensions.ScrippetsTwigExtension');
		return new ScrippetsTwigExtension();
	}

}

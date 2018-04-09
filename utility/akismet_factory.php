<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\utility;

/**
 * The Akismet Factory class is used to create a new vendor Akismet
 * API wrapper class using our configured API key and board URL. These
 * need to be passed into the constructor, so a factory seemed a good
 * approach that would allow us to unit test easily.
 */
class akismet_factory
{
	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * Lightweight initialisation of the API key and user ID.
	 * Heavy lifting is done only if the user actually tries
	 * to post a message, new user tries to register or moderator
	 * approves post (we submit ham to Akismet service).
	 *
	 * @param \phpbb\config\config		$config	phpBB Config class
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Initialize Akismet client with board-specific data
	 *
	 * @return \Gothick\AkismetClient\Client
	 * @throws \Gothick\AkismetClient\AkismetException
	 */
	public function create_akismet()
	{
		return new \Gothick\AkismetClient\Client(generate_board_url(), 'phpBB', $this->config['version'], $this->config['phpbb_akismet_api_key']);
	}
}

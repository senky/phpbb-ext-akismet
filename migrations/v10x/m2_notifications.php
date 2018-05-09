<?php
/**
 * Akismet notification type migrations.
 *
 * @package phpBB Extension - Gothick Akismet
 * @copyright (c) 2015 Matt Gibson Creative Ltd.
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
namespace senky\akismet\migrations\v10x;

class m2_notifications extends \phpbb\db\migration\migration
{
	/** @var array New post types */
	protected static $notification_types = array(
			'senky.akismet.notification.type.post_in_queue',
			'senky.akismet.notification.type.topic_in_queue',
	);

	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		$sql = 'SELECT * FROM ' . $this->table_prefix . "notification_types
			WHERE notification_type_name = 'senky.akismet.notification.type.post_in_queue'";
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row !== false;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array('\senky\akismet\migrations\v10x\m1_acp_module');
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'add_notification_types'))),
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function revert_data()
	{
		return array(
			array('custom', array(array($this, 'remove_notification_types'))),
		);
	}

	/**
	 * Add new notification types
	 */
	public function add_notification_types()
	{
		foreach (self::$notification_types as $type)
		{
			$sql_ary = array(
				'notification_type_name'	=> $type,
				'notification_type_enabled'	=> 1
			);
			$sql = 'INSERT INTO ' . NOTIFICATION_TYPES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Remove notification types
	 */
	public function remove_notification_types()
	{
		$sql = 'DELETE FROM ' . NOTIFICATION_TYPES_TABLE . '
			WHERE ' . $this->db->sql_in_set('notification_type_name', self::$notification_types);
		$this->db->sql_query($sql);
	}
}

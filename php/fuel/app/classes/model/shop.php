<?php
namespace Model;

use Orm\Model;

class Shop extends \Orm\Model {

	/**
	 * テーブル名
	 * @var string
	 */
	protected static $_table_name = 'shop';

	/**
	 * テーブルのプライマリキー
	 * @var array
	 */
	protected static $_primary_key = array('id');

	/**
	 * プロパティ
	 * @var array
	 */
	protected static $_properties = array(
			'id' => array(
					'data_type'  => 'varchar',
					'constraint' => 8,
					'label'      => '店舗ID',
			),
			// 店舗名
			'shop_name' => array(
					'data_type'  => 'varchar',
					'constraint' => 256,
					'label'      => 'レストラン名',

			),


			'using_fax_flg'   => array('type' => 'boolean'),
			'fax_number'      => array('constraint' => 13,   'type' => 'varchar', 'null' => false),
			'using_mail_flg'  => array('type' => 'boolean'),
			'mail_address'    => array('constraint' => 255,   'type' => 'varchar', 'null' => false),

			'lunch_start_time'  => array('constraint' => 5, 'type' => 'varchar', 'null' => true),
			'lunch_end_time'    => array('constraint' => 5, 'type' => 'varchar', 'null' => true),
			'dinner_start_time' => array('constraint' => 5, 'type' => 'varchar', 'null' => true),
			'dinner_end_time'   => array('constraint' => 5, 'type' => 'varchar', 'null' => true),

			'lunch_cancel_policy'  => array('constraint' => 255, 'type' => 'varchar'),
			'dinner_cancel_policy' => array('constraint' => 255, 'type' => 'varchar'),

			'seat_over_flg'      => array('type' => 'boolean'),
			'full_guarantee_flg' => array('type' => 'boolean'),
			'g_number'           => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
			'member'             => array('type' => 'boolean'),
			'onwr_name'          => array('constraint' => 11, 'type' => 'varchar', 'null' => true),

			'officer_name'         => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
			'officer_position'     => array('constraint' => 11, 'type' => 'varchar', 'null' => true),
			'officer_phone_number' => array('constraint' => 13, 'type' => 'varchar', 'null' => true),
			'officer_fax_number'   => array('constraint' => 13, 'type' => 'varchar', 'null' => true),
			'officer_mail_address' => array('constraint' => 256, 'type' => 'varchar', 'null' => true),
			'contact_time'         => array('constraint' => 30, 'type' => 'varchar', 'null' => true),
			'contact_us' => array('type' => 'boolean'),
			'emend_us'   => array('type' => 'boolean'),

			// 作成日時
			'created_at'          => array(
					'data_type' => 'timestamp',
					'label'     => 'created_at',
					'form'      => array('type' => false),
			),
			// 更新日時
			'updated_at'          => array(
					'data_type' => 'timestamp',
					'label'     => 'updated_at',
					'form'      => array('type' => false),
			),
	);

}
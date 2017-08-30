<?php
namespace Fuel\Migrations;

class Create_shop
{
public function up()
    {
        \DBUtil::create_table('shop', array(
	            'id'              => array('constraint' => 8,   'type' => 'varchar', 'null' => false),
	            'shop_name'       => array('constraint' => 255, 'type' => 'varchar', 'null' => false),
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

	        	'updated_at' => array('type' => 'timestamp'),
        		'created_at' => array('type' => 'timestamp'),


        ), array('id'));


    }

    public function down()
    {
        \DBUtil::drop_table('shop');
    }
}
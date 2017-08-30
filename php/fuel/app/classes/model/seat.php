<?php
namespace Model;

use Orm\Model;
use DB;
use Fuel\Core\Log;

class Seat extends \Orm\Model
{
	protected static $_properties = array(

		'id',
		'shop_id',
		'visit_date',
		'course_type',
		'seats_min',
		'seats_max',
		'seats_count',
		'enabled',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'seat';
	protected static $_primary_key = array('id');


	public static function get_seat_list($shop_id, $course_type, $visit_date){



		$sql  = " SELECT seats_min, seats_max, seats_count, ";

		$sql .= " (SELECT COUNT(id) as sold_count FROM entry WHERE seat_id = seat.id and status = '".Entry::Winning."' ) as sold_count, ";

		$sql .= " id FROM seat ";
		$sql .= " WHERE shop_id = '$shop_id' ";
		$sql .= " AND course_type = '$course_type' ";
		$sql .= " AND visit_date =  '$visit_date' ";
		$sql .= " AND enabled = true ";
		$sql .= " ORDER BY seats_max DESC";

		$query = DB::query($sql);

		// SQLを実行する
		return $query->execute()->as_array();


// 		$seats = Seat::find('all', array(
// 				'where' => array(
// 						array('shop_id',     $shop_id),
// 						array('course_type', $course_type),
// 						array('visit_date', $visit_date),
// 				),
// 				'order_by' => array('seats_min' => 'asc'),
// 		));
// 		return $seats;


	}



	public static function get_seat_lottery_list($shop_id){

		$sql  = " SELECT visit_date, course_type, seats_min, seats_max, seats_count, ";

		$sql .= " (SELECT COUNT(id) as sold_count FROM entry WHERE seat_id = seat.id and status = '".Entry::Winning."' ) as sold_count, ";

		$sql .= " id FROM seat ";
		$sql .= " WHERE shop_id = '$shop_id' ";
		$sql .= " AND enabled = true ";
		$sql .= " ORDER BY visit_date , course_type, seats_max DESC";

		$query = DB::query($sql);

		// SQLを実行する
		return $query->execute()->as_array();


		// 		$seats = Seat::find('all', array(
		// 				'where' => array(
		// 						array('shop_id',     $shop_id),
		// 						array('course_type', $course_type),
		// 						array('visit_date', $visit_date),
		// 				),
		// 				'order_by' => array('seats_min' => 'asc'),
		// 		));
		// 		return $seats;


	}


	public static function get_shop_unsold_list(){
		Log::debug("get_shop_unsold_list");

		$sql  = " SELECT shop_id, visit_date,  course_type, ";

		$sql .= " SUM(seats_count) -  (SELECT COUNT(id) as sold_count FROM entry WHERE seat_id in( ";
		$sql .= " SELECT id FROM seat WHERE shop_id = main_seat.shop_id and visit_date = main_seat.visit_date and course_type = main_seat.course_type";
		$sql .= " ) and status = '".Entry::Winning."' ) as unsold_count ";

		$sql .= " FROM seat as main_seat ";
		$sql .= " WHERE enabled = true ";
		$sql .= " GROUP BY shop_id, visit_date,  course_type ";
		$sql .= " ORDER BY shop_id, course_type, visit_date ";

		$query = DB::query($sql);

		# SQLを実行する
		$seat_info = $query->execute()->as_array();


		$shop_list = \ArrayUtil::array_column($seat_info, 'shop_id');
		$shop_list = array_unique($shop_list);

		$json = array();
		$shop = array();
		$date_list = array();

		foreach($shop_list as &$shop_id) {

			foreach($seat_info as &$seat) {

				if($shop_id === $seat['shop_id']){
					$visit_date = $seat['visit_date'];
					$course_type = $seat['course_type'];
					$unsold_count = $seat['unsold_count'];


					if(!isset($shop_list['shop_id'])){
						$shop['shop_id']=$shop_id;
					}

					if( isset($shop[$course_type]) ){
						$date_list = $shop[$course_type];
					}
					$date_list[$visit_date] = $unsold_count;
					$shop[$course_type] = $date_list;
				}
			}
			array_push($json, $shop);
		}

		\Cache::set(UNSOLD_SEAT_JSON, $json, 3600 * 24);
		\Cache::set(JSON_RELOAD, FALSE, 3600 * 24);

		return $json;

	}

}

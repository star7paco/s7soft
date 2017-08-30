<?php

namespace Fuel\Tasks;


use Model\Entry;
use Model\Shop;
use Model\Seat;
use Fuel\Core\Log;

class Lottery
{
	/**
	 * 抽選
	 *
	 * php oil r lottery
	 *
	 */
	public static function run()
	{
		##抽選
		#１	全店舗情報取得
		$shop_list = Shop::find('all');


		foreach ($shop_list as &$shop) {
			self::lottery($shop);
		}

		#1.1	取得した店舗を1件つづ処理する
		#1.2	「２．抽選処理」を実行する
		#1.2	「３．落選処理」を実行する
		#1.3	「４．メール作成」を実行する

		\Cache::set(JSON_RELOAD, true, 3600 * 24);
	}


	public static function lottery($shop){
		$shop_id = $shop['id'];

		Log::debug('[Lottery] start shop_id:'.$shop_id.'('.$shop['shop_name'].') ');
		$seat_list = Seat::get_seat_lottery_list($shop_id);

		# 基本抽選処理
		foreach ($seat_list as &$seat){
			$seat_id = $seat['id'];
			$unsold_count = $seat['seats_count'] - $seat['sold_count'];
			$seat['unsold_count'] = $unsold_count;

			Log::debug('[Lottery] seat_id:'.$seat['id'].'/seats_count:'.$seat['seats_count'].'/sold_count:'.$seat['sold_count'].'/unsold_count:'.$seat['unsold_count']);

			if($unsold_count < 1){
				Log::debug('[Lottery] skip seat_id:'.$seat['id'].':'.$seat['seats_min'].'/'.$seat['seats_max']);
				continue;
			}


			$course_type = $seat['course_type'];
			$visit_date = $seat['visit_date'];
			$min = $seat['seats_min'];
			$max = $seat['seats_max'];


			for ($i= $max ; $i >= $min ; --$i) {

				# エントリー情報取得
				$entry_list = Entry::get_entry_lottery_list($shop_id , $visit_date, $course_type, $i );

				if(count($entry_list) < 1){

					continue;
				}

				if(count($entry_list) <= $unsold_count ){
					# 残席よりエントリが少ないか同じ場合、全部当選処理
					foreach ($entry_list as &$entry){
						Entry::update_status_winning($seat_id, $entry['id']);

						Log::debug('[Winning]'.$seat_id.'/'.$entry['id'].'/'.$entry['seat_count'].'/'.$entry['visit_date']);
						$unsold_count=$unsold_count-1;
					}
				}else{
					# 残席よりエントリが多い場合抽選をする

					$winning_entry = self::lottery_entry_list($entry_list, $unsold_count);
					foreach ($winning_entry as &$entry){
						Entry::update_status_winning($seat_id, $entry['id']);

						Log::debug('[Winning]'.$seat_id.'/'.$entry['id'].'/'.$entry['seat_count'].'/'.$entry['visit_date']);
						$unsold_count = $unsold_count-1;
					}
				}

			}

			$seat['unsold_count'] = $unsold_count;
		}


		if( !$shop['seat_over_flg'] ){
			Log::debug('[Lottery seat_over_flg]:'.$shop['seat_over_flg']);
			return;
		}

		foreach ($seat_list as &$seat){
			$seat_id = $seat['id'];
			$course_type = $seat['course_type'];
			$visit_date = $seat['visit_date'];
			$min = $seat['seats_min'];
			$max = $seat['seats_max'];
			$unsold_count = $seat['unsold_count'];

			if($unsold_count < 1){
				continue;
			}
			Log::debug($seat['id'].'[unsold_count:'.$seat['unsold_count'].']');

			# 来店人数が多いエントリーを優先して当選とするため、多い順に配列を作成。

			$entrys = Entry::get_entry_lottery_seat_over($shop_id , $visit_date, $course_type, $max);

			Log::debug('[Entry Entrys Count : '.count($entrys).']');

			$entry_keys = \ArrayUtil::array_column($entrys,'seat_count');
			$entry_keys = array_unique($entry_keys);
			$entry_list_by_count = array();
			foreach ($entry_keys as $entry_count){
				$entry_list_by_count[$entry_count] = array();
				foreach ($entrys as $entry){
					if($entry['seat_count'] === $entry_count){
						array_push($entry_list_by_count[$entry_count], $entry);
					}
				}
			}

			Log::debug('[Entry $entry_keys Counts : '.count($entry_keys).']');

			foreach ($entry_keys as $entry_count){
				# 来店人数が多い順、
				$entry_list = $entry_list_by_count[$entry_count];

				if( count($entry_list) <= $unsold_count ){
					Log::debug('[Lottery seat_over_flg] 残席が多い:'. count($entry_list) < $unsold_count.':'.$unsold_count.'/'.count($entry_list));
					foreach ($entry_list  as $entry){
						Entry::update_status_winning($seat_id, $entry['id']);
						$unsold_count=$unsold_count-1;
					}
				}else

				$winning_entry = self::lottery_entry_list($entry_list, $unsold_count);
				foreach ($winning_entry as &$entry){
					Entry::update_status_winning($seat_id, $entry['id']);

					Log::debug('[Winning]'.$seat_id.'/'.$entry['id'].'/'.$entry['seat_count'].'/'.$entry['visit_date']);
					$unsold_count = $unsold_count-1;
				}
			}


		}
	}

	public static function reject(){

	}


	public static function reset_unsold_seat(){

	}



	public static function lottery_entry_list($entry_list, $unsold_count){
		$winning_entry=array();
		$winning_entry_id=array();
		$count = 0;
		while($count < $unsold_count){
			$id = rand(0, count($entry_list)-1);

			Log::debug('[Random]'.$id);

			if(in_array($id , $winning_entry_id)){
				continue;
			}

			$winning_entry_id[$count] = $id;
			$winning_entry[$count] = $entry_list[$id];
			$count++;
		}

		Log::debug('[lottery_entry_list : '.var_export($winning_entry_id,true).']');
		return $winning_entry;

	}


	public static function  get_entry_seat_over($shop_id , $visit_date, $course_type, $seat_max){


		$entrys = Entry::get_entry_lottery_seat_over($shop_id , $visit_date, $course_type, $seat_max);
		$entry_keys = \ArrayUtil::array_column($entrys,'seat_count');
		$entry_keys = array_unique($entry_keys);
		$entry_list_by_count = array();
		foreach ($entry_keys as $entry_count){
			$entry_list_by_count[$entry_count] = array();
			foreach ($entrys as $entry){
				if($entry['seat_count'] === $entry_count){
					array_push($entry_list_by_count[$entry_count], $entry);
				}
			}
		}
		return $entry_list_by_count;

	}


}

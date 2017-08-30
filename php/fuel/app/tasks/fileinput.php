<?php

namespace Fuel\Tasks;


class FileInput
{
	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r robots
	 *
	 * or
	 *
	 * php oil r robots "Kill all Mice"
	 *
	 * @return string
	 */
	public static function run($speech = null)
	{

		$filepath = "/home/";
		printf("start test file input");

		if (($fp = fopen($filepath, "r")) === false) {
			//エラー処理
		}

		// CSVの中身がダブルクオーテーションで囲われていない場合に一文字目が化けるのを回避

		setlocale(LC_ALL, 'ja_JP');

		$i=0;
		while (($line = fgetcsv($fp)) !== FALSE) {
			mb_convert_variables('UTF-8', 'sjis-win', $line);
			if($i == 0){
				// タイトル行
				$header = $line;
				$i++;
				continue;
			}

			$data[] = $line;

			$i++;
		}

		fclose($fp);

	}
}

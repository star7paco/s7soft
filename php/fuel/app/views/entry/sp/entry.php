<?php
use Fuel\Core\Input;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>エントリーフォーム  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「エントリーフォーム」です">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="sc_page" content="sma">
    <meta property="og:title" content="エントリーフォーム  - 東京レストランウィーク">
    <meta property="og:description" content="ぐるなびが提供している東京レストランウィークの「エントリーフォーム」です">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://jrw.jp/tokyo/entry/">
    <meta property="og:image" content="https://jrw.jp/img/top/main.png">
    <meta property="og:site_name" content="TOKYO RESTAURANT WEEK">
    <meta property="fb:app_id" content="325071304180059">
    <link rel="canonical" href="https://jrw.jp/tokyo/entry/">
    <?php echo Asset::css($client_agent.'/common.css'); ?>
  </head>
  <body>
    <div class="l-wrapper">
      <?php echo View::forge("entry/$client_agent/parts/header"); ?>

      <div class="l-contents">
        <div class="form">
          <div class="heading">
            <h1 class="heading__title">
            <?php echo Asset::img('entry.svg', array('width'=>'26.565%','alt'=>'エントリー')); ?>
            <span>エントリーフォーム</span></h1>
          </div>
          <div class="step">
            <ul class="step-list">
              <li class="current step-item">入力</li>
              <li class="step-item">内容確認</li>
              <li class="step-item">完了</li>
            </ul>
          </div>
          <div class="form-cont">
            <div class="l-inner">
              <?php echo Form::open(array('action'=>'entry/entry_conf' ,'method'=>'post'),
              		array(
              				'shop_id'          => $shop_id,
              				'course_type'      => $course_type,
              				'visit_date'       => $visit_date,
              				'shop_name'        => $shop['shop_name'],
              				'dis_course_type'  => $dis_course_type,
              				'dis_visit_date'   => $dis_visit_date,
              				'uuid'             => $uuid,

              		)
              	);
              ?>
                <div class="form-head">
                  <p></p>以下のエントリー情報を入力し【内容確認へ】ボタンを押してください。エントリー頂いた後抽選を行い、結果をメールにてお送りします。
                  <p class="form-head__link">予約方法の詳細は<?php echo html::anchor("./reservation/", "こちら"); ?></p>
                </div>
                <div class="box">
                  <div class="box-title">エントリー内容</div>
                  <div class="box-inner">
                    <p class="box-head">店名</p>
                    <p class="box-cont"><?php echo $shop['shop_name'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head"><?php echo $dis_course_type;?>コース<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <ul class="box-list">


                        <?php

                        	$ret_course = Input::post('course');
							$check_flg = !isset($ret_course);
							foreach ($courses as &$value) {
								?>

								<li class="box-item">

								<?php

								if($value['id']=== $ret_course){
									$check_flg = true;
								}

								echo Form::radio('course', $value['id'] , $check_flg ,  array('id'=>'course'.$value['id']));
								echo Form::label($value['course_name'], 'course'.$value['id'], array('class'=>'mincho'));
								?>

								</li>

								<?php
								if($check_flg){
									$check_flg = false;
								}

							}
						?>

                      </ul>
                    </div>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店日</p>
                    <p class="box-cont"><?php echo $dis_visit_date;?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店時間<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <label class="select-wrap" for="time">
                        <?php echo Form::select(
                          		'visit_time',
                          		Input::post('visit_time', ''),
                          		$time_list,
                          		array('class'=>(isset($errors['visit_time'])?'error':' '))); ?>
                      </label>
                    </div>
                    <?php if( isset($errors['visit_time'] )){?>
                        <div class="box-text">
                          <p class="error"><?php echo $errors['visit_time'];?></p>
                        </div>
                     <?php }?>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店人数<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <ul class="box-list">
                        <?php

                            $ret_seat_count = Input::post('seat_count');
							$first_flg = !isset($ret_seat_count);
							$skip_flg = true;
							$sold_out = '';
							foreach ($seat_list as &$value) {
								$seat_count_id = 'seat_count'.$value['seat_count'];
								if($value['seat_disable']){
									$radio_attributes = array('id'=>$seat_count_id,'disabled');
									$skip_flg = true;
									$sold_out = "<span class=\"tag tag-sold\">Sold Out</span>";
								}else{
									$radio_attributes = array('id'=>$seat_count_id );
									$skip_flg = false;
									$sold_out = "";
								}


								if($value['seat_count'] === $ret_seat_count){
									$first_flg = true;
								}

								?><li class="box-item"><?php
								echo Form::radio('seat_count', $value['seat_count'], $first_flg, $radio_attributes );
								echo Form::label($value['seat_count'].$sold_out, $seat_count_id );
								?></li><?php


								if($first_flg and $skip_flg == false){
									$first_flg = false;
								}

							}
							?>
                      </ul>
                    </div>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">備考</p>
                    <div class="box-cont">
                      <p>食べ物アレルギーの情報など、お店にお伝えしたいことがあればご記入ください。</p>
                    </div>
                    <div class="box-cont">
                      <?php echo Form::textarea('memo', Input::post('memo', ''));?>
                    </div>
                  </div>
                </div>
                <div class="box">
                  <div class="box-inner">
                    <p class="box-head">キャンセルについて</p>
                    <p class="box-cont">来店日の2日前までは、抽選結果メールに記載されたキャンセル受付フォームからキャンセルが可能です。<br>直前キャンセル時のキャンセル料については、各店の規定に準じます。</p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head"><?php echo $shop['shop_name'];?>のキャンセル規定</p>
                    <p class="box-cont"><?php echo $dis_cancel_policy;?></p>
                  </div>
                </div>
                <div class="box">
                  <div class="box-title">お客様情報</div>
                  <div class="box-inner">
                    <p class="box-head">お名前<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <?php echo Form::input('user_name', Input::post('user_name', ''),
                        		array('placeholder'=>'入力例：東京　花子', 'class'=>(isset($errors['user_name'])?'error':'')));?>
                    </div>
                    <?php if( isset($errors['user_name'] )){?>
                     <div class="box-cont">
                       <p class="error"><?php echo $errors['user_name'];?></p>
                     </div>
                    <?php }?>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">お名前（カナ）<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <?php echo Form::input('user_name_kana', Input::post('user_name_kana', ''),
                        		array('placeholder'=>'入力例：トウキョウ　ハナコ', 'class'=>(isset($errors['user_name_kana'])?'error':'')));?>
                    </div>
                    <?php if( isset($errors['user_name_kana'] )){?>
                      <div class="box-cont">
                        <p class="error"><?php echo $errors['user_name_kana'];?></p>
                      </div>
                    <?php }?>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">メールアドレス<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <?php echo Form::input('user_mail_address', Input::post('user_mail_address', ''),
                        		array('placeholder'=>'入力例：ex@example.com',
                        			  'class'=>(isset($errors['user_mail_address'])?'error':'')));?>
                    </div>
                    <div class="box-cont">
                      <?php if( isset($errors['user_mail_address'] )){?>
                        <p class="error"><?php echo $errors['user_mail_address'];?></p>
                      <?php }?>
                      <p class="box-note">※迷惑メール対策でドメイン指定受信を設定されている場合、 [@jrw.jp]を受信するように設定してください。</p>
                      <p class="box-annotation">※メールが届かない場合にはエントリー対象外となりますので、ご注意ください。</p>
                    </div>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">メールアドレスの確認<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <?php echo Form::input('user_mail_address_confirm', Input::post('user_mail_address_confirm', ''),
                        		array('placeholder'=>'入力例：ex@example.com',
                        			  'class'=>'text-l '.(isset($errors['user_mail_address_confirm'])?'error':'')));?>
                    </div>
                      <?php if( isset($errors['user_mail_address_confirm'] )){?>
                        <div class="box-cont">
                          <p class="error"><?php echo $errors['user_mail_address_confirm'];?></p>
                        </div>
                      <?php }?>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">電話番号<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <?php echo Form::input('user_phone_number', Input::post('user_phone_number', ''),
                        		array('placeholder'=>'入力例：03-××××-3333',
                        			  'class'=>'text-m '.(isset($errors['user_phone_number'])?'error':'')));?>
                    </div>
                    <div class="box-cont">
                        <?php if( isset($errors['user_phone_number'] )){?>
                          <p class="error"><?php echo $errors['user_phone_number'];?></p>
                        <?php }?>
                      <p class="box-note">※必ず連絡のつく電話番号をご記入ください</p>
                    </div>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">性別<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <ul class="box-list">

	                      <?php
                           	$sex_values = array('female' => '女性','male' => '男性',);
                           	$ret_user_sex = Input::post('user_sex');
                           	$female_flg = true;
                           	$male_flg = false;
                           	if(isset($ret_user_sex) and  $ret_user_sex === 'male'){
                           		$female_flg = false;
                           		$male_flg = true;
                           	}
                            ?>

                          <li class="box-item">
                            	<?php echo Form::radio('user_sex', 'female', $female_flg, array('id'=>'female')); ?>
								<?php echo Form::label($sex_values['female'], 'female' ); ?>
						  </li>
						  <li class="box-item">
								<?php echo Form::radio('user_sex', 'male', $male_flg, array('id'=>'male'));?>
								<?php echo Form::label($sex_values['male'], 'male' );?>
						  </li>
                      </ul>
                    </div>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">年齢<span class="tag tag-necessary">必須</span></p>
                    <div class="box-cont">
                      <label class="select-wrap" for="age">
                        <?php $age_value = array(
                        		''=>'選択してください',
                        		'20歳～24歳'=>'20歳～24歳',
                        		'25歳～29歳'=>'25歳～29歳',
                        		'30歳～34歳'=>'30歳～34歳',
                        		'35歳～39歳'=>'35歳～39歳',
                        		'40歳～44歳'=>'40歳～44歳',
                        		'45歳～49歳'=>'45歳～49歳',
                        		'50歳以上'=>'50歳以上',
                        		);
                        ?>
                        <?php echo Form::select('user_age', Input::post('user_age', ''),$age_value,
                        		array('class'=>(isset($errors['user_age'])?'error':'')));
                        ?>
                      </label>
                    </div>
                    <?php if( isset($errors['user_age'] )){?>
                        <div class="box-text">
                          <p class="error"><?php echo $errors['user_age'];?></p>
                        </div>
                    <?php }?>
                  </div>
                </div>
                <div class="box form-survey">
                  <div class="box-title">アンケートにご協力ください</div>

                  <?php
					foreach ($question as &$value) {
					$question_id = 'question'.$value['question_id'];
				  ?>

                  <div class="box-inner">


                  <?php if($value['type'] == 'select' ){ ?>

	                    <div class="box-table">
	                    	<div class="box-head"><?php echo $value['question'];?></div>
	                    	<div class="box-cont">
							<label class="select-wrap" for="<?php echo $question_id; ?>">
							<?php echo Form::select($question_id, Input::post($question_id, ''),$value['options']);?>
							</label>
							</div>
	                    </div>
					<?php }else if($value['type'] == 'radio' ){ ?>

					<?php }else if($value['type'] == 'text' ){ ?>

					<?php }else if($value['type'] == 'textarea' ){ ?>

						<p class="box-head"><?php echo $value['question'];?></p>
						<p class="box-cont">
						<?php echo Form::textarea($question_id, Input::post($question_id, ''), array('placeholder'=>$value['example']));?>
						</p>
					<?php }?>

                  </div>
				<?php
				}
				?>

                </div>
                <div class="form-foot">
                  <?php if( isset($errors['confirm'] )){?>
                        <p class="error"><?php echo $errors['confirm'];?></p>
                  <?php }?>
                  <p class="form-foot__confirm">
                    <?php echo Form::checkbox('confirm', 'true', array('id'=>'confirm'));?>
                    <label for="confirm"><?php echo html::anchor("./notice/", "注意事項",array("target" => "_blank")); ?>を確認しました</label>
                  </p>
                  <p class="form-foot__link">プライバシーポリシーは<?php echo html::anchor("./privacy_policy/", "こちら",array("target" => "_blank")); ?></p>
                  <div class="form-btn">
                    <button class="btn btn-ll btn-red" type="submit">内容確認へ</button>
                  </div>
                </div>
              <?php echo Form::close(); ?>
            </div>
          </div>
        </div>
      </div>
      <?php echo View::forge("entry/$client_agent/parts/footer"); ?>
    </div>

    <?php echo Asset::js($client_agent.'/lib.js'); ?>
    <?php echo Asset::js($client_agent.'/common.js'); ?>

    <script src="//maps.googleapis.com/maps/api/js?client=gme-gnavi"></script>
    <div style="display:none;height:0;position:relative;visibility:hidden;width:0;">
      <script src="//x.gnst.jp/s.js"></script>
      <script type="text/javascript">('localhost' !== location.hostname) && document.write(unescape("%3Cscript src='//site.gnavi.co.jp/analysis/sc_"+getScSubdom()+".js'%3E%3C/script%3E"));</script>
    </div>
  </body>
</html>
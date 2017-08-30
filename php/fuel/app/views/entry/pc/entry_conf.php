<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>エントリー確認  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「エントリー確認」のページです">
    <meta property="og:title" content="エントリー確認  - 東京レストランウィーク">
    <meta property="og:description" content="ぐるなびが提供している東京レストランウィークの「エントリー確認」のページです">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://jrw.jp/tokyo/entry/conf/">
    <meta property="og:image" content="https://jrw.jp/img/top/main.png">
    <meta property="og:site_name" content="TOKYO RESTAURANT WEEK">
    <meta property="fb:app_id" content="325071304180059">
    <link rel="canonical" href="https://jrw.jp/tokyo/entry/conf/">
    <?php echo Asset::css($client_agent.'/common.css'); ?>
  </head>
  <body>
    <div class="l-wrapper">
      <div class="l-header">
        <div class="header">
          <?php echo View::forge("entry/$client_agent/parts/header"); ?>
        </div>
      </div>
      <div class="l-contents">
        <div class="form">
          <div class="l-block">
            <div class="heading">
              <h1 class="heading__title">
              <?php echo Asset::img('entry.svg', array('width'=>'140','alt'=>'エントリー')); ?>
              <span>エントリーフォーム</span></h1>
            </div>
          </div>
          <div class="l-block">
            <div class="step">
              <ul class="step-list">
                <li class="step-item">エントリー入力</li>
                <li class="current step-item">内容確認</li>
                <li class="step-item">エントリー完了</li>
              </ul>
            </div>
          </div>
          <div class="l-block form-cont">
            <div class="l-inner">
              <?php
              $hidden_parameter = array('shop_id'=>$shop_id,'course_type'=>$course_type,'visit_date'=>$visit_date,'course_name'=>$course_info['course_name']);
              $hidden_parameter = array_merge($hidden_parameter, $input);
              echo Form::open(array('action'=>'entry/entry_done' ,'method'=>'post'),$hidden_parameter);?>

                <div class="form-head">
                  <p>入力内容に間違いがないか、今一度ご確認ください。</p>
                </div>
                <div class="box">
                  <div class="box-title">エントリー内容</div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">店名</div>
                      <div class="box-table__cont"><?php echo $input['shop_name'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">コース</div>
                      <div class="box-table__cont"><?php echo $input['dis_course_type'];?>コース
                      <em class="mincho"><?php echo $course_info['course_name'];?></em></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店日</div>
                      <div class="box-table__cont"><?php echo $input['dis_visit_date'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店時間</div>
                      <div class="box-table__cont"><?php echo $input['visit_time'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店人数</div>
                      <div class="box-table__cont"><?php echo $input['seat_count'];?>人</div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">備考</div>
                      <div class="box-table__cont"><?php echo $input['memo'];?></div>
                    </div>
                  </div>
                </div>
                <div class="box">
                  <div class="box-title">お客様情報</div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">お名前</div>
                      <div class="box-table__cont"><?php echo $input['user_name'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">お名前（カナ）</div>
                      <div class="box-table__cont"><?php echo $input['user_name_kana'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">メールアドレス</div>
                      <div class="box-table__cont"><?php echo $input['user_mail_address'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">電話番号</div>
                      <div class="box-table__cont"><?php echo $input['user_phone_number'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">性別</div>
                      <?php $sex_values = array('female' => '女性','male' => '男性',); ?>
                      <div class="box-table__cont"><?php echo $sex_values[$input['user_sex']];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">年齢</div>
                      <div class="box-table__cont"><?php echo $input['user_age'];?></div>
                    </div>
                  </div>
                </div>


                <div class="box">
                  <div class="box-title">アンケート</div>
                  <?php
					foreach ($question as &$value) {
						?>
						<div class="box-inner">
						<?php if($value['type'] === 'select' or $value['type'] === 'radio' ){?>
		                    <div class="box-table">
		                    	<div class="box-table__ques"><?php echo $value['question'];?></div>
		                    	<div class="box-table__cont"><?php echo $value['question_value'];?></div>
		                    </div>
						<?php }else { ?>
							<p class="box-head box-recommend"><?php echo $value['question'];?></p>
							<p class="box-cont"><?php echo $value['question_value'];?></p>

						<?php }?>
	                    </div>
					<?php
					}
					?>
                </div>


                <div class="form-foot">
                  <p class="form-foot__note">こちらの内容は「予約」ではなく「エントリー」です。<br>抽選結果はメールにてエントリー翌日にご連絡致します。</p>
                  <div class="form-foot__btn"><a class="btn btn-ll btn-white" href="javascript:history.back();">戻る</a>
                    <button class="btn btn-ll btn-red" type="submit">エントリー</button>
                  </div>
                </div>
              <?php echo Form::close(); ?>
            </div>
          </div>
          <?php echo View::forge('entry/pc/parts/footer'); ?>
        </div>
      </div>
    </div>

    <?php echo Asset::js($client_agent.'/lib.js'); ?>
    <?php echo Asset::js($client_agent.'/common.js'); ?>

    <div style="display:none;height:0;position:relative;visibility:hidden;width:0;">
      <script src="//x.gnst.jp/s.js"></script>
      <script>("localhost" !== location.hostname) && document.write(unescape("%3Cscript src='//site.gnavi.co.jp/analysis/sc_"+getScSubdom()+".js'%3E%3C/script%3E"));</script>
    </div>
  </body>
</html>
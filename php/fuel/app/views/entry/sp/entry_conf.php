<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>エントリー確認  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「エントリー確認」のページです">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="sc_page" content="sma">
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
              <li class="step-item">入力</li>
              <li class="current step-item">内容確認</li>
              <li class="step-item">完了</li>
            </ul>
          </div>
          <div class="form-cont">
            <div class="l-inner">
              <?php
              $hidden_parameter = array('shop_id'=>$shop_id,'course_type'=>$course_type,'visit_date'=>$visit_date,'course_name'=>$course_info['course_name']);
              $hidden_parameter = array_merge($hidden_parameter, $input);
              echo Form::open(array('action'=>'entry/entry_done' ,'method'=>'post'),$hidden_parameter);?>

                <div class="form-head">
                  <p></p>入力内容に間違いがないか、今一度ご確認ください。
                </div>
                <div class="box">
                  <div class="box-title">エントリー内容</div>
                  <div class="box-inner">
                    <p class="box-head">店名</p>
                    <p class="box-cont"><?php echo $input['shop_name'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">コース</p>
                    <p class="box-cont"><?php echo $input['dis_course_type'];?>コース
                    <em class="mincho"><?php echo $course_info['course_name'];?></em></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店日</p>
                    <p class="box-cont"><?php echo $input['dis_visit_date'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店時間</p>
                    <p class="box-cont"><?php echo $input['visit_time'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店人数</p>
                    <p class="box-cont"><?php echo $input['seat_count'];?>人</p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">備考</p>
                    <p class="box-cont"><?php echo $input['memo'];?></p>
                  </div>
                </div>
                <div class="box">
                  <div class="box-title">お客様情報</div>
                  <div class="box-inner">
                    <p class="box-head">お名前</p>
                    <p class="box-cont"><?php echo $input['user_name'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">お名前（カナ）</p>
                    <p class="box-cont"><?php echo $input['user_name_kana'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">メールアドレス</p>
                    <p class="box-cont"><?php echo $input['user_mail_address'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">電話番号</p>
                    <p class="box-cont"><?php echo $input['user_phone_number'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">性別</p>
                    <?php $sex_values = array('female' => '女性','male' => '男性',); ?>
                    <p class="box-cont"><?php echo $sex_values[$input['user_sex']];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">年齢</p>
                    <p class="box-cont"><?php echo $input['user_age'];?></p>
                  </div>
                </div>

                <div class="box form-survey">
                  <div class="box-title">アンケートにご協力ください</div>
                  <?php foreach ($question as &$value) { ?>
						<div class="box-inner">
		                    <div class="box-head"><?php echo $value['question'];?></div>
		                    <div class="box-cont"><?php echo $value['question_value'];?></div>
						</div>
				  <?php }?>
                </div>

                <div class="form-foot">
                  <p class="form-foot__note">こちらの内容は「予約」ではなく「エントリー」です。抽選結果はメールにてエントリー翌日にご連絡致します。</p>
                  <div class="form-btn">
                    <button class="btn btn-ll btn-red" type="submit">エントリー</button>
                    <a class="btn btn-ll btn-white" href="javascript:history.back();">戻る</a>
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
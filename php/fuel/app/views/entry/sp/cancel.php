<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>キャンセルフォーム  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「キャンセルフォーム」ページです">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="sc_page" content="sma">
    <meta property="og:title" content="キャンセルフォーム  - 東京レストランウィーク">
    <meta property="og:description" content="ぐるなびが提供している東京レストランウィークの「キャンセルフォーム」ページです">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://jrw.jp/tokyo/entry/cancel?entry_id=<?php echo $entry['input_id'];?>">
    <meta property="og:image" content="https://jrw.jp/img/top/main.png">
    <meta property="og:site_name" content="TOKYO RESTAURANT WEEK">
    <meta property="fb:app_id" content="325071304180059">
    <link rel="canonical" href="https://jrw.jp/tokyo/entry/cancel?entry_id=<?php echo $entry['input_id'];?>">
    <?php echo Asset::css($client_agent.'/common.css'); ?>
  </head>
  <body>
    <div class="l-wrapper">
      <?php echo View::forge("entry/$client_agent/parts/header"); ?>

      <div class="l-contents">
        <div class="form">
          <div class="heading">
            <h1 class="heading__title">
            <?php echo Asset::img('cancel.svg', array('width'=>'29.688%','alt'=>'キャンセル')); ?>
            <span>キャンセルフォーム</span></h1>
          </div>
          <div class="step">
            <ul class="step-list">
              <li class="current step-item">キャンセル確認</li>
              <li class="step-item">キャンセル完了</li>
            </ul>
          </div>
          <div class="form-cont">
            <div class="l-inner">
                <div class="box">
                  <div class="box-title">ご予約内容</div>
                  <div class="box-inner">
                    <p class="box-head">店名</p>
                    <p class="box-cont"><?php echo $entry['shop_name'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">コース</p>
                    <p class="box-cont"><?php echo $entry['dis_course_type'];?>コース<em class="mincho"><?php echo $entry['course_name'];?></em></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店日</p>
                    <p class="box-cont"><?php echo $entry['dis_visit_date'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店時間</p>
                    <p class="box-cont"><?php echo $entry['visit_time'];?></p>
                  </div>
                  <div class="box-inner">
                    <p class="box-head">来店人数</p>
                    <p class="box-cont"><?php echo $entry['seat_count'];?>人</p>
                  </div>
                </div>
                <?php if($using_cancel) { ?>

                <div class="form-foot">
                  <p class="form-foot__note">一度キャンセルすると、元に戻すことはできませんので、ご注意ください。</p>
                  <div class="form-btn">
                    <a class="btn btn-ll btn-red js-popup-cancel" href="#popup">キャンセル</a>
                  </div>

                <div class="popup-wrap">
                  <div class="popup" id="popup">

                  <?php echo Form::open(array('action'=>'entry/cancel_done' ,'method'=>'post'),
				 		array(
				 				'entry_id'    => $entry['id'],
				 				'user_name'   => $entry['user_name'],
				 				'shop_name'   => $entry['shop_name'],
				 				'course_name' => $entry['course_name'],
				 				'dis_course_type' => $entry['dis_course_type'],
				 				'dis_visit_date'  => $entry['dis_visit_date'],
				 				'visit_time'      => $entry['visit_time'],

				 ));?>

                    <div class="popup-inner">
                      <div class="popup-head">
                        <p>キャンセルします。よろしいですか？</p>
                      </div>
                      <div class="popup-btn">
                        <?php echo Form::submit('submit','はい', array('class'=>'btn btn-ll btn-red')); ?>
                        <a class="btn btn-ll btn-white js-popup-close" href="#">戻る</a>
                      </div>
                    </div>

                  <?php echo Form::close(); ?>
                  </div>
                </div>
                </div>

				<?php }else{ ?>

                <div class="form-cancel">
                  <p class="form-cancel__head">来店日の直前になるためキャンセルフォームからのキャンセルは承ることができません。<br>直接お店へご連絡ください。</p>
                  <p class="form-cancel__tel">TEL.<em><?=TEL_NUMBER;?></em></p>
                  <div class="form-cancel__rule">
                    <p>なお直前のキャンセルの場合、お店規定のキャンセル料が発生する場合がございます。<br>下記お店のキャンセル規定をご確認ください。</p>
                    <dl>
                      <dt><?php echo $entry['shop_name'];?>のキャンセル規定</dt>
                      <dd><?php echo $entry['dis_cancel_policy'];?></dd>
                    </dl>
                  </div>
                </div>

                <div class="form-foot">
                  <p class="form-foot__note">一度キャンセルすると、元に戻すことはできませんので、ご注意ください。</p>
                  <div class="form-btn"><a class="btn btn-ll btn-red js-popup-cancel disabled" href="#popup">キャンセル</a></div>
                </div>
				<?php } ?>

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
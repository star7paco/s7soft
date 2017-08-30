<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>キャンセルフォーム  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「キャンセルフォーム」ページです">
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
              <?php echo Asset::img('cancel.svg', array('width'=>'160','alt'=>'キャンセル') ); ?>
              <span>キャンセルフォーム</span>
              </h1>
            </div>
          </div>
          <div class="l-block">
            <div class="step">
              <ul class="step-list">
                <li class="current step-item">キャンセル確認</li>
                <li class="step-item">キャンセル完了</li>
              </ul>
            </div>
          </div>
          <div class="l-block form-cont">
            <div class="l-inner">
                <div class="box">
                  <div class="box-title">ご予約内容</div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">店名</div>
                      <div class="box-table__cont"><?php echo $entry['shop_name'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">コース</div>
                      <div class="box-table__cont"><?php echo $entry['dis_course_type'];?>コース<em class="mincho"><?php echo $entry['course_name'];?></em></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店日</div>
                      <div class="box-table__cont"><?php echo $entry['dis_visit_date'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店時間</div>
                      <div class="box-table__cont"><?php echo $entry['visit_time'];?></div>
                    </div>
                  </div>
                  <div class="box-inner">
                    <div class="box-table">
                      <div class="box-table__head">来店人数</div>
                      <div class="box-table__cont"><?php echo $entry['seat_count'];?>人</div>
                    </div>
                  </div>
                </div>
                <?php if($using_cancel) { ?>

				<div class="form-foot">
                  <p class="form-foot__note">一度キャンセルすると、元に戻すことはできませんので、ご注意ください。</p>
                  <div class="form-foot__btn">
                  <a class="btn btn-ll btn-red js-popup-cancel" href="#popup">キャンセル</a></div>

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
                      <p class="popup-head">キャンセルします。よろしいですか？</p>
                      <div class="popup-btn"><a class="btn btn-l btn-white js-popup-close" href="#">戻る</a>
                        <?php echo Form::submit('submit','はい', array('class'=>'btn btn-l btn-red')); ?>
                      </div>
                    </div>
                  <?php echo Form::close(); ?>

                  </div>
                </div>
                </div>


                <?php }else{ ?>

                 <div class="form-foot">
                  <div class="form-cancel">
                    <p class="form-cancel__head">来店日の直前になるためキャンセルフォームからのキャンセルは承ることができません。<br>直接お店へご連絡ください。</p>
                    <p class="form-cancel__tel">TEL.<em><?= TEL_NUMBER;?></em></p>
                    <div class="form-cancel__rule">
                      <p>なお直前のキャンセルの場合、お店規定のキャンセル料が発生する場合がございます。<br>下記お店のキャンセル規定をご確認ください。</p>
                      <dl>
                        <dt><?php echo $entry['shop_name'];?>のキャンセル規定</dt>
                        <dd><?php echo $entry['dis_cancel_policy'];?></dd>
                      </dl>
                    </div>
                  </div>
                </div>

                <div class="form-foot">
                  <p class="form-foot__note">一度キャンセルすると、元に戻すことはできませんので、ご注意ください。</p>
                  <div class="form-foot__btn">
                  <a class="btn btn-ll btn-red js-popup-cancel disabled" href="#popup">キャンセル</a>

                </div>

                <?php } ?>

            </div>
          </div>
          <?php echo View::forge("entry/$client_agent/parts/footer"); ?>
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

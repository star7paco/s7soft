<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>キャンセル完了  - 東京レストランウィーク</title>
    <meta name="description" content="ぐるなびが提供している東京レストランウィークの「キャンセル完了」ページです">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="sc_page" content="sma">
    <meta property="og:title" content="キャンセル完了  - 東京レストランウィーク">
    <meta property="og:description" content="ぐるなびが提供している東京レストランウィークの「キャンセル完了」ページです">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://jrw.jp/tokyo/entry/cancel_done/">
    <meta property="og:image" content="https://jrw.jp/img/top/main.png">
    <meta property="og:site_name" content="TOKYO RESTAURANT WEEK">
    <meta property="fb:app_id" content="325071304180059">
    <link rel="canonical" href="https://jrw.jp/tokyo/entry/cancel_done/">
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
              <li class="step-item">キャンセル確認</li>
              <li class="current step-item">キャンセル完了</li>
            </ul>
          </div>
          <div class="form-cont">
            <div class="l-inner">
              <div class="form-head form-complete">
                <p>以下のご予約をキャンセル致しました。</p>
              </div>
              <div class="box">
                <div class="box-title">キャンセル内容</div>
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
              <div class="form-foot">
                <div class="form-info">
                  <p class="form-info__txt">公式SNSで最新情報を配信中</p>
                  <ul class="form-social">
                    <li><a href="https://www.facebook.com/JapanRestaurantWeek/" target="blank">
                        <svg class="icon-sns-w icon-sns" viewBox="0 0 450 450">
                          <g>
                            <path d="M259,450.3V244.9H328l10.3-80.1H259v-51.1c0-23.2,6.4-39,39.7-39l42.4,0V3.2c-7.3-1-32.5-3.2-61.8-3.2,c-61.1,0-103,37.3-103,105.8v59h-69.1v80.1h69.1v205.4H259z"></path>
                          </g>
                        </svg></a></li>
                    <li><a href="https://twitter.com/JapanRW" target="blank">
                        <svg class="icon-sns-w icon-sns" viewBox="0 0 450 450">
                          <g>
                            <path d="M450,85.7c-17.7,7.6-35.4,12.4-53.1,14.3c20-12,33.5-28.9,40.5-50.8c-18.3,10.8-37.8,18.3-58.5,22.3,c-18.3-19.4-40.7-29.1-67.4-29.1c-25.5,0-47.2,9-65.2,27s-27,39.7-27,65.2c0,6.9,0.8,13.9,2.3,21.1c-37.7-1.9-73-11.4-106.1-28.4,c-33-17-61.1-39.7-84.1-68.1C23,73.4,18.8,88.9,18.8,105.6c0,15.8,3.7,30.5,11.1,44s17.4,24.5,30,32.8,c-14.8-0.6-28.7-4.5-41.7-11.7v1.1c0,22.3,7,41.8,21,58.7c14,16.8,31.6,27.5,53,31.8c-8,2.1-16.1,3.1-24.3,3.1,c-5.3,0-11.1-0.5-17.4-1.4c5.9,18.5,16.8,33.6,32.5,45.5c15.8,11.9,33.7,18,53.7,18.4c-33.5,26.3-71.7,39.4-114.5,39.4,c-8.2,0-15.6-0.4-22.3-1.1c42.8,27.6,90,41.4,141.6,41.4c32.7,0,63.5-5.2,92.2-15.6s53.3-24.3,73.7-41.7,c20.4-17.4,37.9-37.4,52.7-60.1c14.8-22.7,25.7-46.3,33-70.9c7.2-24.7,10.8-49.3,10.8-74.1c0-5.3-0.1-9.3-0.3-12,C421.8,120.2,437.2,104.3,450,85.7z"></path>
                          </g>
                        </svg></a></li>
                    <li><a href="https://www.instagram.com/tokyorestaurantweek/?hl=ja" target="blank">
                        <svg class="icon-sns-w icon-sns" viewBox="0 0 504 504">
                          <g>
                            <path d="M256,49.5c67.3,0,75.2,0.3,101.8,1.5c24.6,1.1,37.9,5.2,46.8,8.7c11.8,4.6,20.2,10,29,18.8s14.3,17.2,18.8,29,c3.4,8.9,7.6,22.2,8.7,46.8c1.2,26.6,1.5,34.5,1.5,101.8s-0.3,75.2-1.5,101.8c-1.1,24.6-5.2,37.9-8.7,46.8,c-4.6,11.8-10,20.2-18.8,29s-17.2,14.3-29,18.8c-8.9,3.4-22.2,7.6-46.8,8.7c-26.6,1.2-34.5,1.5-101.8,1.5s-75.2-0.3-101.8-1.5,c-24.6-1.1-37.9-5.2-46.8-8.7c-11.8-4.6-20.2-10-29-18.8s-14.3-17.2-18.8-29c-3.4-8.9-7.6-22.2-8.7-46.8,c-1.2-26.6-1.5-34.5-1.5-101.8s0.3-75.2,1.5-101.8c1.1-24.6,5.2-37.9,8.7-46.8c4.6-11.8,10-20.2,18.8-29s17.2-14.3,29-18.8,c8.9-3.4,22.2-7.6,46.8-8.7C180.8,49.7,188.7,49.5,256,49.5 M256,4.1c-68.4,0-77,0.3-103.9,1.5C125.3,6.8,107,11.1,91,17.3,c-16.6,6.4-30.6,15.1-44.6,29.1S23.8,74.5,17.3,91c-6.2,16-10.5,34.3-11.7,61.2C4.4,179,4.1,187.6,4.1,256s0.3,77,1.5,103.9,c1.2,26.8,5.5,45.1,11.7,61.2c6.4,16.6,15.1,30.6,29.1,44.6s28.1,22.6,44.6,29.1c16,6.2,34.3,10.5,61.2,11.7s35.4,1.5,103.9,1.5,s77-0.3,103.9-1.5c26.8-1.2,45.1-5.5,61.2-11.7c16.6-6.4,30.6-15.1,44.6-29.1s22.6-28.1,29.1-44.6c6.2-16,10.5-34.3,11.7-61.2,c1.2-26.9,1.5-35.4,1.5-103.9s-0.3-77-1.5-103.9c-1.2-26.8-5.5-45.1-11.7-61.2c-6.4-16.6-15.1-30.6-29.1-44.6s-28.1-22.6-44.6-29.1,C405.2,11,386.9,6.7,360,5.5C333,4.4,324.4,4.1,256,4.1L256,4.1z"></path>
                            <path d="M256,126.6c-71.4,0-129.4,57.9-129.4,129.4s58,129.4,129.4,129.4s129.4-58,129.4-129.4S327.4,126.6,256,126.6z M256,340,c-46.4,0-84-37.6-84-84s37.6-84,84-84s84,37.6,84,84S302.4,340,256,340z"></path>
                            <circle cx="390.5" cy="121.5" r="30.2"></circle>
                          </g>
                        </svg></a></li>
                  </ul>
                </div>
                <div class="form-btn"><a class="btn btn-ll btn-white" href="<?php echo TOP_URL;?>">トップページへ</a></div>
              </div>
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
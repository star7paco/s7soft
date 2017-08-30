<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>


	<div class="row">
	  <div class="col-sm-2"><img width="200" alt="" src="../assets/img/logo_02_black02.png"></div>
	  <div class="col-sm-7"><h3><?php echo $title; ?></h3> </div>
	  <div class="col-sm-3">
	  	【admin】
	  	<?php
	  	echo Form::open( array('action'=>'./admin/logout', 'method'=>'get') );
	  	echo Form::input('send','ログアウト',array('class'=>'btn','type'=>'submit'));
		echo Form::close();
		?>
	  </div>
	</div>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

			<?php echo View::forge('admin/parts/menu.php') ?>
        </nav>

	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">

	<h1>Tokyo Restaurant Week 2017</h1>
	<h5>開催期間：2017年10月11日～2017年10月24日</h5>

          <h4>レストラン【予約率】ランキング　(Total : 90%)</h3>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="100px">ランキング</th>
                  <th>店舗名</th>
                  <th>予約率</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>amet</td>
                  <td>consectetur</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Integer</td>
                  <td>nec</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>libero</td>
                  <td>Sed</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>dapibus</td>
                  <td>diam</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Nulla</td>
                  <td>quis</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>nibh</td>
                  <td>elementum</td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>sagittis</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>Fusce</td>
                  <td>nec</td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>augue</td>
                  <td>semper</td>
                </tr>
              </tbody>
            </table>
          </div>


          <h4>レストラン【エントリー数】ランキング　(Total : 90件)</h4>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="100px">ランキング</th>
                  <th>店舗名</th>
                  <th>エントリー数</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>amet</td>
                  <td>consectetur</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Integer</td>
                  <td>nec</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>libero</td>
                  <td>Sed</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>dapibus</td>
                  <td>diam</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Nulla</td>
                  <td>quis</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>nibh</td>
                  <td>elementum</td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>sagittis</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>Fusce</td>
                  <td>nec</td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>augue</td>
                  <td>semper</td>
                </tr>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<footer>
	<div class="footer">
		<ul class="footer-list">
			<li class="footer-item">&copy; Gurunavi, Inc.</li>
			<li class="footer-item">主催：ぐるなび　協力：●●●●</li>
		</ul>
	</div>
</footer>
</body>
</html>

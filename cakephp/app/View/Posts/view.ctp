<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>ブログ閲覧</title>
    <style>
        .err {color: red;}
        .cover{
          background:url(/img/blog/bg.jpg);
          background-size: cover;
        }
        .container-bg {
            background: #000;
            color: #fff;
        }
        img.index {
        width: 100%;
        height: 100%;
        }
        .contact-form {
            /* margin: 0 auto; */
        }
        .contact-button {
            margin-left:auto;
            margin-right:auto;
        }

    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
//echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap.min');
//echo $this->Html->css('bootstrap-responsive.min');
echo $this->Html->script('bootstrap');
echo $this->Html->css('bootstrap-social');
?>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
  <header>
          <div class="bg-dark">
          <!-- <div class="container-bg"> -->
            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light">
                    <a href="" class="navbar-brand text-white">Funteam新人研修のブログ</a>
                    <!-- <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                    <div id="menu">
                    <ul class="navbar-nav">
                          <li class="nav-item"><a href="/posts/" class="nav-link text-secondary">Blog</a></li>
                          <li class="nav-item"><a href="" class="nav-link text-muted">Contact</a></li>
                    </ul>
                    </div>
                </nav>
            </div>
          </div>
          <div class="cover text-center text-white py-5 mb-3">
              <h1 class="display-4 mb-4">Blog</h1>
              <p class="font-italic">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
          </div>
  </header>
  <main>
      <section>
          <div class="container">
              <div class="row">
                  <div class="col-md-4 sidebar border-right">
                      <?php echo $this->element('postsidebar'); ?>
                  </div>
                <div class="col-md-8">
                    <div class="container blog">
                      <h1><?php echo h($article['Post']['title']);?></h1>
                      <p><small>Created: <?php echo $article['Post']['created'];?></small></p>
                      <div>
                        <?php
                        echo $this->Html->image("blog/test.jpg", array(
                            "alt" => $article['Post']['title'],
                            'class' => array('img-responsive', 'index')
                        ));
                        ?>
                      </div>
                      <div>
                       <p><pre><?php echo nl2br(h($article['Post']['body'])); ?></pre></p>
                      </div>
                    </div>
                    <div class="sns-icon text-center">
                      <!-- <a class="btn btn-block btn-social btn-twitter text-white">
                        <span class="fa fa-twitter fa-inverse"></span> Sign in with Twitter
                      </a> -->
                      <a class="btn btn-lg btn-social btn-twitter text-white" href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://www.funteam.co.jp/');?>&text=<?php echo urlencode($article['Post']['title']);?>">
                        <span class="fa fa-twitter fa-inverse"></span> ツイートする
                      </a>
                      <a class="btn btn-lg btn-social btn-facebook text-white">
                        <span class="fa fa-facebook fa-inverse"></span> シェアする
                      </a>
                    </div>
                </div>
            </div>
    </section>
</main>
<footer class="text-left text-muted py-4">
  <section>
    <div class="bg-secondary">
    <?php echo $this->Html->link('管理トップへ戻る', array('controller' => 'user', 'action' => 'register'),array('class'=>'text-dark'))?>
    </br>
    <div class="text-white">下記管理者ユーザーなら表示</div>
    <?php echo $this->Html->link('追加', array('action' => 'add'),array('class'=>'text-dark'));?>
    <?php echo $this->Html->link('編集', array('action' => 'edit'),array('class'=>'text-dark'));?>
    <?php echo $this->Html->link('削除', array('action' => 'delete'),array('class'=>'text-dark'));?>
    <?php echo $this->Html->link('投稿', array('action' => 'add'),array('class'=>'text-dark'));?>
    </br>
    </div>
  </section>
  <section>
      <div class="bg-dark text-white">
          <?php  echo $this->element('sql_dump'); ?>
      </div>
  </section>
</footer>
<script>
  $(document).ready(function(){
      $(".error-message").hide();
  });
</script>
</body>
</html>

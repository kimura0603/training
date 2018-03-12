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

        .recommend-box{
            overflow: auto;
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
                      <p><small>Posted: <?php echo $article['Post']['created'];?></small></p>
                      <div>
                        <?php
                        echo $this->Html->image("blog/test.jpg", array(
                            "alt" => $article['Post']['title'],
                            'class' => array('img-responsive', 'index')
                        ));
                        ?>
                      </div>
                      <div class="my-5">
                       <p><?php echo nl2br(h($article['Post']['body'])); ?></p>
                      </div>
                    </div>
                    <div class="container comment">
                        <div>
                            <h5>Comment</h5>
                            <?php echo('<button class="reply-top">返信</button>');?>
                        </div>
                        <div>
                            <?php
                              $check_layer_1 = 0;
                              $check_layer_2 = 0;
                              $check_layer_3 = 0;
                              if(!empty($commentDisplay)){
                                  foreach($commentDisplay as $values){
                                      $divId = $values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3'];
                                      //コメントのレイヤーレベルに合わせて処理を分岐
                                      if($values['PostComment']['layer_2'] == 0 && $values['PostComment']['layer_3'] == 0){
                                            if($check_layer_1 > 0){
                                                echo '</div>';
                                                if($check_layer_2 != 0){
                                                    echo '</div>';
                                                }
                                                if($check_layer_3 != 0){
                                                    echo '</div>';
                                                }
                                            }
                                            echo '<div class="border bg-light my-3 ml-2" id="'.$divId.'">';
                                            echo($values['PostComment']['id']);
                                            echo('名前:'.$values['PostComment']['name'].'<br>');
                                            echo('コメント:'.$values['PostComment']['comment'].'<br>');
                                            echo($values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3']);
                                            //echo('<button class="reply" id="'.$values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3'].'">返信</button>');
                                            echo('<button class="reply" type="submit">返信</button>');
                                            $check_layer_1 = $values['PostComment']['layer_1'];
                                            $check_layer_2 = $values['PostComment']['layer_2'];
                                            $check_layer_3 = $values['PostComment']['layer_3'];
                                            continue;
                                      }
                                      if($values['PostComment']['layer_3'] == 0){
                                          if($check_layer_2 > 0){
                                              echo '</div>';
                                              if($check_layer_3 != 0){
                                                  echo '</div>';
                                              }
                                          }
                                          echo '<div class="border border-secondary my-3 ml-2" id="'.$divId.'">';
                                          echo($values['PostComment']['id']);
                                          echo('名前:'.$values['PostComment']['name'].'<br>');
                                          echo('コメント:'.$values['PostComment']['comment'].'<br>');
                                          echo($values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3']);
                                            echo('<button type="submit" class="reply" id="'.$values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3'].'">返信</button>');
                                          $check_layer_1 = $values['PostComment']['layer_1'];
                                          $check_layer_2 = $values['PostComment']['layer_2'];
                                          $check_layer_3 = $values['PostComment']['layer_3'];
                                          continue;
                                      }
                                      if($check_layer_3 > 0){
                                          echo '</div>';
                                      }
                                      echo '<div class="border border-success my-3 ml-2" id="'.$divId.'">';
                                      echo($values['PostComment']['id']);
                                      echo('名前:'.$values['PostComment']['name'].'<br>');
                                      echo('コメント:'.$values['PostComment']['comment'].'<br>');
                                      echo($values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3']);
                                        // echo('<button class="reply">返信</button>');
                                          echo('<button type="submit" class="reply" id="'.$values['PostComment']['layer_1'].'-'.$values['PostComment']['layer_2'].'-'.$values['PostComment']['layer_3'].'">返信</button>');
                                      $check_layer_1 = $values['PostComment']['layer_1'];
                                      $check_layer_2 = $values['PostComment']['layer_2'];
                                      $check_layer_3 = $values['PostComment']['layer_3'];
                                }//endforeach
                                      if($check_layer_2 == 0 && $check_layer_3 == 0){
                                          echo '</div>';
                                      }elseif($check_layer_3 == 0){
                                          echo '</div>';
                                          echo '</div>';
                                      }else{
                                          echo '</div>';
                                          echo '</div>';
                                          echo '</div>';
                                      }
                                }//end if(!empty($commentDisplay))
                            ?>
                        </div>
                        <div class="text-center">
                            <?php
                            $url = Router::reverse($this->request);
                            ?>
                            <?php
                            echo $this->Form->create('PostComment', ['url' => $url, 'type' => 'post']);
                            ?>
                            <!-- <div class="contact-form row form-group my-1"> -->
                            <div class="form-row form-group my-1">
                                <label class="col-md-4 col-form-label col-form-label-lg">Name</label>
                                <div class="col-md-8">
                                  <?php
                                          echo $this->Form->Input('name', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm', 'placeholder'=>'Name','required'=>false));
                                  ?>
                                </div>
                            </div>
                            <div class="contact-form row form-group my-1">
                                <label class="col-md-4 col-form-label col-form-label-lg">Comment</label>
                                <div class="col-md-8">
                                  <?php
                                  echo $this->Form->Input('comment', array('type' => 'text', 'label'=>false, 'maxlength'=>200, 'rows'=>10,'class'=>'form-control form-control-sm','placeholder'=>'Comment','required'=>false));
                                  ?>
                                </div>
                            </div>
                            <div class="contact-button w-75 my-3 text-center">
                                <?php
                                echo $this->Form->button('Comment', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-dark btn-sm badge-pill', 'name'=>'comment'));
                                echo $this->Form->end();
                                ?>
                            </div>
                            <div class="alert alert-<?php if(isset($msg)){if($msg['result'] == 0){echo 'success';}else{echo 'danger';}}?>" role="alert">
                            <?php if(isset($msg['msg'])){foreach($msg['msg'] as $key){ echo $key;?>
                            <br>
                            <?php }}?>
                            </div>
                        </div>
                    </div>
                    <div class="container recommend">
                        <div class="text-left h3">おすすめ関連記事</div>
                        <div class="row">
                            <?php foreach($recommendPosts as $k){?>
                            <div class="recommend-box col-md-4 border my-3">
                                  <?php
                                        // echo $this->Html->link($k['Post']['title'], array('url'=> 'posts/views/'.$k['Post']['id']));
                                        echo $this->Html->link($k['Post']['title'], array('controller' => 'posts', 'action' => 'view', $k['Post']['id']));
                                        echo $this->Html->image("blog/test.jpg", array(
                                            "alt" => $k['Post']['title'],
                                            'class' => array('mw-100','mh-100')
                                        ));
                                  ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="sns-icon text-center mt-5">
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
    <iframe src="https://widget.similarweb.com/traffic/monoist.atmarkit.co.jp" frameborder="0" width="450" height="200" style="border: solid 1px #D7D7D7;"></iframe>
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
        $(".reply").click(function(){
            var posturl = $("#PostCommentViewForm").attr("action");
            var formstart = '<form action="' + posturl + '" id="PostCommentViewForm" method="post" accept-charset="utf-8">'
            var textarea = '<div class="reply new-comment my-3 ml-2"><textarea cols="50" name="data[PostComment][comment]" placeholder="Comment"></textarea></div>';
            var divname = $(this).parent().attr("id");
            var divname = '<input type="hidden" name="data[PostComment][divname]" value="' + divname + '">';
            var button = '<div class="contact-button w-75 mb-3 text-center"><button type="submit" class="btn btn-dark btn-sm badge-pill" name="comment">Comment</button></div>';
            var formend = '</form>';
            $(this).parent().append(formstart + divname + textarea + button + formend);
            var position = $(".new-comment").offset().top;
            console.log(position);
            $("html, body").animate({
                scrollTop : position
            }, 'slow', 'swing');
                return false;
                // queue : false
            });
        $(".reply-top ").click(function(){
            var posturl = $("#PostCommentViewForm").attr("action");
            var formstart = '<form action="' + posturl + '" id="PostCommentViewForm" method="post" accept-charset="utf-8">'
            var textarea = '<div class="reply new-comment my-3 ml-2"><textarea cols="50" name="data[PostComment][comment]" placeholder="Comment"></textarea></div>';
            var divname = "top"
            var divname = '<input type="hidden" name="data[PostComment][divname]" value="' + divname + '">';
            var button = '<div class="contact-button w-75 mb-3 text-center"><button type="submit" class="btn btn-dark btn-sm badge-pill" name="comment">Comment</button></div>';
            var formend = '</form>';
            $(this).parent().next().append(formstart + divname + textarea + button + formend);
            var position = $(".new-comment").offset().top;
            console.log(position);
            $("html, body").animate({
                scrollTop : position
            }, 'slow', 'swing');
                return false;
                // queue : false
            });
    });
</script>
</body>
</html>

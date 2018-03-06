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
echo $this->Html->css('bootstrap-social');
//echo $this->Html->css('bootstrap-responsive.min');
echo $this->Html->script('bootstrap');
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
                          <li class="nav-item"><a href="#contact" class="nav-link text-muted">Contact</a></li>
                    </ul>
                    </div>
                </nav>
            </div>
          </div>
          <!-- <div class="text-center text-black py-5"　style="background-image:url(/img/blog/bg.png);"> -->
          <div class="cover text-center text-white py-5 mb-3">
          <!-- <div class="cover text-center text-white py-5"　style="background-image:url(/img/blog/bg.png);"> -->
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
                          <!-- <tr>
                              <th>Id</th>
                              <th>Title</th>
                              <th>Created</th>
                          </tr> -->
                        <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->
                        <?php
                        $i = 0;
                        foreach ($posts as $post):
                        ?>
                        <?php if(($i % 2) == 0){?>
                        <div class="row my-5">
                        <?php } ?>
                            <div class="col-md-6 h-100">
                            <h4 class="mb-0">
                            <?php
                                echo $this->Html->link($post['Post']['title'],
                                    array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
                            ?>
                            </h4>
                            </br>
                            <?php
                            echo $this->Html->image("blog/test.jpg", array(
                                "alt" => $post['Post']['title'],
                                'url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                'class' => array('img-responsive', 'index')
                            ));
                            ?>
                            </br>
                            <span class="text-secondary mt-0"><?php echo substr($post['Post']['body'],0, 100); ?></span>
                            </br>
                            <?php
                                echo $this->Html->link('Read more',
                                    array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),array('class' => 'text-secondary')
                                );
                            ?>
                            </br>
                            <p class="text-secondary mt-0"><small><?php echo $post['Post']['created']; ?></small></p>
                            <?php $i += 1;?>
                            </div>
                        <?php if(($i % 2) == 0){?>
                        </div>
                        <?php } ?>
                        <?php endforeach; ?>
                        <?php unset($post); ?>
                        </div>
                        <div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                      <?php
                                      // echo $this->Paginator->prev(__('Prev'), array('tag' => 'li','class'=>'page-item'), null, array('tag' => 'li','class' => 'page-item disabled','disabledTag' => 'a'));
                                      echo $this->Paginator->prev(__('Previous'), array('tag' => 'li'), 'hoge', array('tag' => 'li','class' => array('test', 'disabled')));
                                      // echo $this->Paginator->prev('Previous', null, null, array('class' => 'disabled'));
                                      echo $this->Paginator->numbers(array('currentTag' => 'a', 'class'=>'page-item','currentClass' => 'active','tag' => 'li','first' => 1, 'ellipsis' => '<li class="disabled"><a>...</a></li>'));
                                      echo $this->Paginator->next(__('Next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                      ?>
                                      <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
                                      <!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
                                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                                      <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                                </ul>
                            </nav>
                        </div>
                        <div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                      <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                      <li class="page-item"><a class="page-link" href="/posts/index/page:1">1</a></li>
                                      <li class="page-item"><a class="page-link" href="/posts/index/page:2">2</a></li>
                                      <li class="page-item"><a class="page-link" href="/posts/index/page:3">3</a></li>
                                      <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="container contact" id="contact">
                            <div class="cover-contact text-center text-dark pt-5 my-3">
                                <h2 class="display-4 mb-4">Contact Us</h2>
                            </div>
                            <div class="text-center">
                                <?php
                                // echo $this->Form->create('PostContact', ['url' => ['controller' => 'posts', 'action' => 'contact'], 'type' => 'post']);
                                echo $this->Form->create('PostContact', ['url' => ['controller'=> 'posts', 'action' => 'index'], 'type' => 'post']);
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
                                <div class="form-row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Department</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('department', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Department','required'=>false));
                                      ?>
                                    </div>
                                </div>
                                <div class="form-row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Copmany</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('company', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Company','required'=>false));
                                      ?>
                                    </div>
                                </div>
                                <div class="contact-form row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Email</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('email', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'you@example.com','required'=>false));
                                      ?>
                                    </div>
                                </div>
                                <div class="contact-form row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Message</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('message', array('type' => 'text', 'label'=>false, 'maxlength'=>200, 'rows'=>10,'class'=>'form-control form-control-sm','placeholder'=>'Message','required'=>false));
                                      ?>
                                    </div>
                                </div>
                                <div class="contact-button w-75 my-3 text-center">
                                    <?php
                                    echo $this->Form->button('Submit Message', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-dark btn-lg btn-block badge-pill', 'name'=>'contact'));
                                    // echo $this->Form->submit('Submit Message', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-dark btn-lg btn-block badge-pill', 'name'=>'contact'));
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
                        <div class="sns-icon text-center">
                          <!-- <a class="btn btn-block btn-social btn-twitter text-white">
                            <span class="fa fa-twitter fa-inverse"></span> Sign in with Twitter
                          </a> -->
                          <a class="btn btn-social-icon btn-twitter">
                              <span class="fa fa-twitter fa-inverse"></span>
                          </a>
                          <a class="btn btn-social-icon btn-facebook" href="https://ja-jp.facebook.com/funteam.it/">
                              <span class="fa fa-facebook fa-inverse"></span>
                          </a>
                          <a class="btn btn-social-icon btn-linkedin">
                              <span class="fa fa-linkedin fa-inverse"></span>
                          </a>
                        </div>
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

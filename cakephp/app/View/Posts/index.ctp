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
?>
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
                          <li class="nav-item"><a href="" class="nav-link text-secondary">Blog</a></li>
                          <li class="nav-item"><a href="" class="nav-link text-muted">Contact</a></li>
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
                      <div class="card mt-3">
                          <div class="card-body">
                              <?php
                              echo $this->Form->create('Post', ['url' => ['action' => 'search'], 'type' => 'get', 'class'=>'form-inline']);
                              echo $this->Form->input('searchword', ['label' => false,'placeholder'=>'Search...','class'=>'border-0']);
                              echo $this->Form->button('Search', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-outline-secondary btn-sm pull-right'));
                              echo $this->Form->end();
                              ?>
                          </div>
                      </div>
                      <div class="mt-5">
                          <div class="mb-3">
                          Profile
                          </div>
                          <div class="text-center">
                            <a>Hoge hoge hoge hoge hoge hoge hoge.Hoge hoge hoge hoge hoge hoge hoge.Hoge hoge hoge hoge hoge hoge hoge.</a>
                          </div>
                      </div>
                      <div class="mt-5">
                          <div class="mb-3">Popular posts
                          </div>
                          <div class="text-center">
                          <?php
                          foreach ($posts as $post):
                          ?>
                              <div>
                              <?php
                              echo $this->Html->link($post['Post']['title'],
                              array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
                              ?>
                              </div>
                          <?php
                          endforeach;
                          unset($post);
                          ?>
                          </div>
                    </div>
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
                        <div class="container contact">
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
                                      echo $this->Form->Input('name', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Name'));
                                      ?>
                                    </div>
                                </div>
                                <div class="form-row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Department</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('department', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Department'));
                                      ?>
                                    </div>
                                </div>
                                <div class="form-row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Copmany</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('company', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Company'));
                                      ?>
                                    </div>
                                </div>
                                <div class="contact-form row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Email</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('email', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'you@example.com'));
                                      ?>
                                    </div>
                                </div>
                                <div class="contact-form row form-group my-1">
                                    <label class="col-md-4 col-form-label col-form-label-lg">Message</label>
                                    <div class="col-md-8">
                                      <?php
                                      echo $this->Form->Input('message', array('type' => 'text', 'label'=>false, 'rows'=>10,'class'=>'form-control form-control-sm','placeholder'=>'Message'));
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
                                <?php if(isset($msg['msg'])){echo $msg['msg'];}?>
                                </div>
                            </div>
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
</body>
</html>

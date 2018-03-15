<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>ブログ閲覧</title>
    <style>
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-social');
echo $this->Html->script('bootstrap');
echo $this->Html->css('post-menubar');
echo $this->Html->script('post-menubar');
echo $this->Html->css('post-default');
?>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
  <header>
          <?php echo $this->element('postheader'); ?>
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
                        <?php if(isset($searchPosts)){
                          if(!empty($searchPosts)){
                          $i = 0;
                          foreach ($searchPosts as $post):
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
                        <?php unset($post);
                            }else{
                            echo "いつも当サイトをご覧頂きありがとうございます。検索しましたがページが見つかりませんでした。お手数をおかけしますが、一度目的のページをお探し下さい。";
                        }}//end if if(isset($searchPosts)?>
                        <?php if(isset($posts)){
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
                        <?php unset($post);
                        }?>
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
                                    echo $this->Form->button('Submit Message', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-accent-color btn-lg btn-block badge-pill', 'name'=>'contact'));
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
      <?php echo $this->element('postfooter'); ?>
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

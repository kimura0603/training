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
      <section class="bg-light">
          <div class="container">
              <div class="row">
                <div class="col-md-8">
                    <div class="container blog">
                        <div>
                            <?php
                            if(isset($topPosts)){
                            $i = 0;
                            foreach ($topPosts as $post):
                            ?>
                            <?php if(($i % $toppostRows) == 0){?>
                            <div class="row my-0">
                            <?php } ?>
                                <div class="col-md-<?php echo 12/$toppostRows; ?> article border bg-white py-3">
                                    <h4 class="mb-1" style="height:45px;">
                                    <?php
                                        echo $this->Html->link($post['Post']['title'],
                                            array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),array('class'=>'h5 align-middle'));
                                    ?>
                                    </h4>
                                <?php
                                echo $this->Html->image("blog/test.jpg", array(
                                    "alt" => $post['Post']['title'],
                                    'url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                    'class' => array('img-fluid')
                                ));
                                ?>
                                </br>
                                <spam class="text-black mt-0"><?php
                                    echo substr($post['Post']['body'],0, 100);
                                ?></spam>
                                <br>
                                <?php $i += 1;?>
                                </div>
                            <?php if(($i % $toppostRows) == 0){?>
                            </div>
                            <?php } ?>
                            <?php endforeach; ?>
                            <?php unset($post);
                            }?>
                        </div>
                    </div>
                    <div class="container my-3 py-1 px-1">
                        <div>
                            <h3 style="border-bottom: inset 5px var(--main-color);">最新記事</h3>
                        </div>
                        <div>
                            <?php
                            if(isset($posts)){
                            $i = 0;
                            foreach ($posts as $post):
                            ?>
                            <?php if(($i % $postRows) == 0){?>
                            <div class="row my-0">
                            <?php } ?>
                                <div class="col-md-<?php echo $columLength; ?> article border bg-white py-3">
                                <spam><small><?php echo date('Y-m-d', strtotime($post['Post']['created'])); ?></small></spam>
                                    <h4 class="mb-1" style="height:45px;">
                                    <?php
                                        echo $this->Html->link($post['Post']['title'],
                                            array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),array('class'=>'h5 align-middle'));
                                    ?>
                                    </h4>
                                <?php
                                echo $this->Html->image("blog/test.jpg", array(
                                    "alt" => $post['Post']['title'],
                                    'url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                    'class' => array('img-fluid')
                                ));
                                ?>
                                </br>
                                <spam class="text-black mt-0"><?php
                                    echo substr($post['Post']['body'],0, 100);
                                ?></spam>
                                <br>
                                <?php $i += 1;?>
                                </div>
                            <?php if(($i % $postRows) == 0){?>
                            </div>
                            <?php } ?>
                            <?php endforeach; ?>
                            <?php unset($post);
                            }?>
                            </div>
                            <div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                          <!-- <?php
                                          // echo $this->Paginator->prev(__('Prev'), array('tag' => 'li','class'=>'page-item'), null, array('tag' => 'li','class' => 'page-item disabled','disabledTag' => 'a'));
                                          // echo $this->Paginator->prev(__('Previous'), array('tag' => 'li'), 'hoge', array('tag' => 'li','class' => array('test', 'disabled')));
                                          // // echo $this->Paginator->prev('Previous', null, null, array('class' => 'disabled'));
                                          // echo $this->Paginator->numbers(array('currentTag' => 'a', 'class'=>'page-item','currentClass' => 'active','tag' => 'li','first' => 1, 'ellipsis' => '<li class="disabled"><a>...</a></li>'));
                                          // echo $this->Paginator->next(__('Next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                          ?> -->
                                          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                                          <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                      </div>
                        <?php
                        // echo $this->element('postcontact');
                        ?>
                    <!--
                    ★★★★サイドバー★★★★
                    -->
                  </div>
                  <div class="col-md-4 sidebar border-left">
                      <?php
                        echo $this->element('postsidebar');
                      ?>
                  </div>
                </div>
            </div>
      </section>
</main>
<footer class="text-left text-muted py-4">
  <section>
      <?php echo $this->element('postfooter'); ?>
      <?php echo $this->element('postfooter-admin'); ?>
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
        $(".article").click(function(){
            window.location=$(this).find("a").attr("href");
                return false;
        });
    });
</script>
</body>
</html>

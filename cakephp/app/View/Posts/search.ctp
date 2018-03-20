<!DOCTYPE HTML>
<html lang="ja-JP">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>ブログ閲覧</title>
    <style>
      #thumbnail {
          width: 304px;
          height: 168px;
      }
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
  <main class="bg-light">
      <section>
          <div class="container">
              <div class="row">
                  <div class="col-md-9">
                      <div class="container search">
                          <?php if(isset($searchPosts)){
                            foreach ($searchPosts as $post):
                          ?>
                          <div class="my-3 bg-white border py-4 px-4">
                              <header>
                                  <p><?php
                                  echo date("Y-m-d", strtotime($post['Post']['created']));
                                  ?>
                                  </p>
                                  <ul class="list-inline">タグ
                                  <?php
                                  $tagNumber = count($post['MstPosttag']);
                                  $i = 0;
                                  foreach($post['MstPosttag'] as $v){
                                      ?>
                                      <li　class="inline-block">
                                      <?php
                                      echo $this->Html->link($v['tagname'],
                                          array('controller' => 'posts', 'action' => 'search', '?' => array('search' => $v['tagname']))
                                          // array('url' => 'posts/search?search=' . $v['tagname'])
                                      );
                                      // echo $this->Html->link($v['tagname']);
                                      // array('controller' => 'posts', 'action' => 'search', $post['Post']['id']));
                                      ?>
                                      </li>
                                      <?php
                                      $i += 1;
                                      if($i < $tagNumber){
                                          echo '<span class="separator">/</span>';
                                      }
                                  }
                                  unset($i);?>
                                  </ul>
                                  <br>
                                  <h2>
                                  <?php
                                        echo $this->Html->link($post['Post']['title'],
                                        array('controller' => 'posts', 'action' => 'view', $post['Post']['id']));
                                  ?>
                                  </h2>
                              </header>
                              <section>
                                  <div>
                                      <?php
                                      echo $this->Html->image("blog/test.jpg", array(
                                          "alt" => $post['Post']['title'],
                                          'url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),
                                          'class' => array('img-responsive', 'index'),
                                          'id' => array('thumbnail')
                                      ));
                                      ?>
                                      <p class="float-right">
                                        <?php echo substr($post['Post']['body'],0, 150); ?>
                                      </p>
                                  </div>
                                  <?php
                                        echo $this->Html->link('Read more....',
                                        array('controller' => 'posts', 'action' => 'view', $post['Post']['id']),array('class'=>'btn btn-main-color btn-sm rounded-0 float-right'));
                                  ?>
                              </section>
                          </div>
                          <?php endforeach; ?>
                          <?php unset($post);
                              }else{
                              echo "いつも当サイトをご覧頂きありがとうございます。検索しましたがページが見つかりませんでした。お手数をおかけしますが、一度目的のページをお探し下さい。";
                          }//end if if(isset($searchPosts)?>
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
                  </div>
                  <div class="col-md-3 sidebar border-left">
                        <?php echo $this->element('postsidebar'); ?>
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
  });
</script>
</body>
</html>

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
//echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap.min');
//echo $this->Html->css('bootstrap-responsive.min');
echo $this->Html->script('bootstrap');
echo $this->Html->css('bootstrap-social');
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
  <main class="bg-light mt-0">
      <section>
        <div class="container bg-white text-center my-3 pb-3 border-bottom" style="height: 100px;">
          <div class="search-box mx-auto mt-5" style="width:500px;">
          		<div>
          				<?php
          				echo $this->Form->create('Post', ['url' => ['action' => 'index'], 'type' => 'get', 'class'=>'form-inline']);
                  ?>
                  <p class="mb-0 mr-3">ワード検索して記事を探す</p>
                  <?php
          				echo $this->Form->input('search', ['label' => false,'placeholder'=>'Search...']);
          				echo $this->Form->button('Search', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-outline-accent btn-sm pull-right'));
          				echo $this->Form->end();
          				?>
          		</div>
          </div>
        </div>
          <div class="container"　style="z-index:1;">
              <div class="row">
                  <div class="col-md-9">
                    <div class="container blog bg-white"　style="z-index:2;">
                      <p><small>Posted: <?php echo $article['Post']['created'];?></small></p>
                      <div>
                        <?php
                        echo $this->Html->image("blog/test.jpg", array(
                            "alt" => $article['Post']['title'],
                            'class' => array('img-responsive', 'index')
                        ));
                        ?>
                      </div>
                      <div class="post mt-5">
                       <p><?php echo nl2br(h($article['Post']['body'])); ?></p>
                       <p><?php echo nl2br($article['Post']['body']); ?></p>
                      </div>
                      <div>
                        <p>問い合わせは<a href="/posts/#contact">こちら</a>から</p>
                      </div>
                    </div>
                    <?php
                    //コメント欄
                    // echo $this->element('comment');
                    ?>
                    <div class="container advertise mt-5">
                        <div class="text-left h3">記事に関連するサービス</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div>
                                    <p>営業のAIサービス</p>
                                </div>
                                <div>
                                    <a href="https://datumstudio.jp/">DATTUM STUDIO</a>
                                    <p>ビジネスにおいて、データを最大限活用する際、「そのビジネスに関する経験・知識」「統計解析・設計手法に関する深い理解と知識・経験」「データ処理に関するコーディング経験・知識」の３つの視点でアプローチすることが重要です。当社は、この３つの視点からご提案できる豊富な経験と技術力を有しており、特に、データに合わせた独自のアルゴリズム構築、カスタマイズを得意としております。</p>
                                </div>
                                <div>
                                    <a href="https://mazrica.com/">MAZRICA</a>
                                    <p>組織ナレッジ活用型営業支援ツールSenses（センシーズ）を運営しています。
Sensesは一般的にSFA・CRMと呼ばれる顧客管理、案件管理といった管理機能に加え、蓄積された営業情報からAIアルゴリズムが成功・失敗事例を解析する機能を有しています。
過去の成功・失敗事例から「いつ」「誰に」「何を」「どのように」行うか、Sensesが支援します。</p>
                                </div>
                                <div>
                                    <a href="https://mazrica.com/">MAZRICA</a>
                                    <p>sosiego(ソシエゴ)を運営営業支援やAI分析など新ラインナップの提供を開始</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                  <div>
                                      <p>その他営業のAIサービス</p>
                                  </div>
                                  <div>
                                      <a href="https://datumstudio.jp/">DATTUM STUDIO</a>
                                      <p>ビジネスにおいて、データを最大限活用する際、「そのビジネスに関する経験・知識」「統計解析・設計手法に関する深い理解と知識・経験」「データ処理に関するコーディング経験・知識」の３つの視点でアプローチすることが重要です。当社は、この３つの視点からご提案できる豊富な経験と技術力を有しており、特に、データに合わせた独自のアルゴリズム構築、カスタマイズを得意としております。</p>
                                  </div>
                                  <div>
                                      <a href="http://www.persol-pt.co.jp/">パーセル</a>
                                      <p>AIによる機械学習を活用した営業支援システムを開発し、派遣事業の営業活動における新規顧客開拓において、オートメーション化</p>
                                  </div>
                              </div>
                            <div class="col-md-4">
                              <div>
                                  <p>営業ソリューションのもつAI総合開発</p>
                              </div>
                              <div>
                                  <a href="http://www.fujitsu.com/jp/solutions/business-technology/ai/ai-zinrai/?gclid=CjwKCAjwypjVBRANEiwAJAxlInaJGHOMGA8EJbpssfSSLZbjx_S-mET4dV-TSAfTQqaFluUAor0jABoC7hYQAvD_BwE">FUJITSU ZINRAI</a>
                                  <p>営業活動に必要な情報をAIが収集し、ダッシュボードとして提示。顧客理解にかかる情報探索を効率化。地域の経済状況、法人ネットワーク等の情報を活用することにより顧客理解が深化し、提案力が向上</p>
                              </div>
                              <div>
                                  <a href="http://www.hitachi.co.jp/products/it/lumada/">LUMADA</a>
                                  <p>日立</p>
                                  <p>ウェアラブルセンサーで取得した営業担当者の行動データ、属性情報、情報システムのシステムログから、営業担当者の働き方を見える化し,これらのデータと組織の業績指標との相関営業成績や業務効率など組織の業績指標（KPI）の改善<a href="http://www.hitachi.co.jp/products/it/lumada/usecase/case/lumada_uc_00209.html">http://www.hitachi.co.jp/products/it/lumada/usecase/case/lumada_uc_00209.html</a></p>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="container recommend mt-5">
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
                <div class="col-md-3 sidebar border-left">
                    <?php echo $this->element('postsidebar'); ?>
                </div>
            </div>
    </section>
</main>
<footer class="text-left text-muted py-4">
  <section>
      <?php echo $this->element('postfooter'); ?>
  </section>
  <section>
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

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

        .concept-color{
            background-color: #1d4293;
            background-color: #2C4B94;

        }
        /* .search-box{
          position: absolute;
        	top: 0;
        	right: 0;
        	bottom: 0;
        	left: 0;
        	margin: auto;
        } */
    </style>
<?php
echo $this->Html->script('jquery-3.3.2');
echo $this->Html->script('postnumbers_ajax');
//echo $this->Html->css('bootstrap.min');
echo $this->Html->css('menubar');
echo $this->Html->css('bootstrap.min');
//echo $this->Html->css('bootstrap-responsive.min');
echo $this->Html->script('bootstrap');
echo $this->Html->css('bootstrap-social');
?>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
  <header>
          <div class="concept-color">
          <!-- <div class="container-bg"> -->
            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light">
                    <a href="" class="navbar-brand text-white">AI導入支援メディア</a>
                    <!-- <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                    <div id="menu">
                    <ul class="navbar-nav">
                          <li class="nav-item"><a href="/posts/" class="nav-link text-secondary">Post</a></li>
                          <li class="nav-item"><a href="" class="nav-link text-muted">Contact</a></li>
                    </ul>
                    </div>
                </nav>
            </div>
          </div>
          <div class="cover text-center text-white py-5 mb-0">
              <h1 class="display-4 mb-4">メディア名：HOGEHOGE!	#2C4B94;</h1>
              <p class="font-italic">AIの情報を導入者目線でわかりやすく伝え、AI活用による業績改善をサポートします。</p>
          </div>
          <nav>
              <div class="tabs"> <!-- タブ自体のエレメント -->
                  <div class="warp"> <!-- タブ内の選択要素エレメント -->
                      <div class="menubar tab tab-news^nav current-tab">
                          <ul class="ddmenu">
                              <li id="topmenu1"><a href="/posts/">業務別</a>
                                  <ul>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">マーケティング</a></li>
                                      <li id="menu-item-79891" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79891 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">研究・開発</a></li>
                                      <li id="menu-item-79892" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79892 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">購買・仕入れ</a></li>
                                      <li id="menu-item-79893" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79893 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">生産管理</a></li>
                                      <li id="menu-item-79894" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79894 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">営業</a></li>
                                      <li id="menu-item-79895" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79895 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">総務・法務</a></li>
                                      <li id="menu-item-79896" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79896 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">人事</a></li>
                                      <li id="menu-item-79897" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79897 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">財務・会計</a></li>
                                  </ul>
                              </li>
                              <li id="topmenu2"><a href="/posts/">テーマ別</a>
                                  <ul>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="/posts/">需要予測</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">予兆・異常検知</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">生産省人化・自動化</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">MA・SA</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">コミュニケーション</a></li>
                                  </ul>
                              </li>
                              <li id="topmenu3"><a href="/posts/">業界別</a>
                                  <ul>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="/posts/">広告/ITツール</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">製造業</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">物流</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">飲食・ホテル</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">農業・食品</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">インフラ・建設・エネルギー</a></li>
                                      <li id="menu-item-79890" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-79890 predictive-maintenance"><a href="https://iotnews.jp/smartfactory/predictive-maintenance">金融・保険・不動産</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </nav>
      <div class="container bg-white text-center my-3 pb-3 border-bottom" style="height: 100px;">
        <div class="search-box mx-auto mt-5" style="width:500px;">
        		<div>
        				<?php
        				echo $this->Form->create('Post', ['url' => ['action' => 'search'], 'type' => 'get', 'class'=>'form-inline']);
                ?>
                <p class="mb-0 mr-3">ワード検索して記事を探す</p>
                <?php
        				echo $this->Form->input('searchword', ['label' => false,'placeholder'=>'Search...']);
        				echo $this->Form->button('Search', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-outline-secondary btn-sm pull-right'));
        				echo $this->Form->end();
        				?>
        		</div>
        </div>
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
                    </div>
                    <div class="container advertise">
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
      <div class="concept-color text-white">
          <div class="row">
              <div class="col-md-4 my-1">
              <a href="https://www.funteam.co.jp/" class="pl-3 text-white">会社情報</a>
              </div>
              <div class="col-md-4 my-1">
              <a href="/posts/#contact" class="pl-3 text-white">お問い合わせ</a>
              </div>
              <div class="col-md-4 my-1">
              <a href="/posts/#contact" class="pl-3 text-white">知的財産権について</a>
              </div>
              <div class="col-md-12 text-center my-3">
              ©Copyright2018 人工知能ニュースメディア HOGEHOGE!.All Rights Reserved.
              </div>
          </div>
      </div>
  </section>
  <section>
    <div class="bg-secondary">
    <?php echo $this->Html->link('管理トップへ戻る', array('controller' => 'user', 'action' => 'register'),array('class'=>'text-dark'))?>
    </br>
    <div class="text-white">下記管理者ユーザーなら表示</div>
    <?php echo $this->Html->link('追加', array('action' => 'add'),array('class'=>'text-dark'));?>
    <?php echo $this->Html->link('編集', array('action' => 'edit', $id),array('class'=>'text-dark'));?>
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
        //menubar:マウスが載ったらサブメニューを表示
        $("ul.ddmenu li").mouseenter(function(){
            $(this).siblings().find("ul").hide();  // 兄弟要素に含まれるサブメニューを全部消す。
            // $(this).children().slideDown(150);     // 自分のサブメニューを表示する。
            $(this).children().fadeIn(150);     // 自分のサブメニューを表示する。
        //menubar:どこかがクリックされたらサブメニューを消す
        });
        // $(".menubar").mouseleave(function(){
        // $("ul.ddmenu li").mouseleave(function(){
        $("[id^=topmenu]").mouseleave(function(){
                $('ul.ddmenu ul').fadeOut(150);
        });

        $('html').click(function() {
            // $('ul.ddmenu ul').slideUp(150);
            $('ul.ddmenu ul').fadeOut(150);
        });
    });
</script>
</body>
</html>

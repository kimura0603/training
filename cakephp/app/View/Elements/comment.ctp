<!DOCTYPE HTML>
<html lang="ja-JP">
<div class="container comment" style="z-index:1;">
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

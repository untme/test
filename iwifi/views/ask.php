<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('ask_title'); ?></title>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <div class="main_center">
                <div class="ask_title">
                    <span>您好 <font color="#FF0000"><?php echo $nickname;?></font>，欢迎使用Aiwifi免费无线上网服务</span>
                </div>
				<div class="ask_left">
                &nbsp;<font color="#FF0000">请回答下列问题后，即可开始上网</font>
                	<?php if(empty($question)): ?>
                	<div class="ask_1"><?= $this->lang->line('ask_no_more'); ?></div>
                	<form action="<?= $base; ?>ask/go/" method="POST" id="askGo">
                		<input type="submit" class="button3" value="<?= $this->lang->line('ask_button_submit'); ?>"/>
                	</form>
                	<script type="text/javascript">
						$("#askGo").submit(); //没有问题时，直接提交表单
					</script>
                	<?php else: ?>
                    <script type="text/javascript">
						$(function(){
							$("#askGo").submit(function(){
							
							<?php foreach($question as $key=>$r){
								$_ID = $key + 1;
								if($r['aq_type']==1){
								//下拉框
									echo "if(\$.trim(\$('#question_{$_ID}').val())=='')
									{\$('#question_{$_ID}').focus();alert('请选择答案');return false;}";
								}else{
								//复选框
									echo "if(\$(\"input[name='question_{$_ID}[]']\").is(':checked')){}else
										{alert('请选择答案');return false;}";
								}
							}?>
							});
						});
					</script>
                	<form action="<?= $base; ?>ask/submit_ask/" method="POST" id="askGo">
                    <?php foreach($question as $key => $row): ?>
                    <div class="ask_1"><?= $key+1; ?>. <?= $row['aq_title']; ?> (<?= $row['aq_type'] == 1 ? $this->lang->line('ask_single') : $this->lang->line('ask_mulit'); ?>)</div>
                    <div class="ask_2">
                        <?php $answer = $this->aiwifi->comm_list_where('aiwifi_ask_answer', array('aq_id' => $row['aq_id']), 100, 0, 'aa_id', 'ASC'); ?>
                        <?php if ($row['aq_type'] == 1): ?>
                        <select name="question_<?= $key+1; ?>" id="question_<?= $key+1; ?>">
                        	<option value="" selected>请选择...</option>
							<?php foreach ($answer as $a): ?>
                        	<option value="<?= $a['aa_id']; ?>_<?= $row['aq_id']; ?>"><?= $a['aa_title']; ?></option>
                        	<?php endforeach; ?>
                    	</select>
                        <?php elseif($row['aq_type'] == 2): ?>
                        <?php foreach ($answer as $a): ?>
                        <label class="ask_check"><input name="question_<?= $key+1; ?>[]" type="checkbox" value="<?= $a['aa_id']; ?>_<?= $row['aq_id']; ?>" /><?= $a['aa_title']; ?></label>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                    <input type="submit" class="button3" value="<?= $this->lang->line('ask_button_submit'); ?>"/>
                    <div class="prompt3"></div>
                    </form>
                    <?php endif; ?>
                </div>
                <?php if (!empty($ad['ad_img'])): ?>
                <img src="<?= $base; ?>data/ad/<?= $ad['ad_img']; ?>" class="add2" height="350px;" />
                <?php endif; ?>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>
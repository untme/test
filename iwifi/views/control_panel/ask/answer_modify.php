<script type="text/javascript">
$(document).ready(function(){

    $(".cancel").click(function(){
        $(document).trigger('close.facebox');
    });

    $(".submitModifyAnswer").click(function(){
    	
    	var aq_id = $("#aq_id").val();
    	var aa_id = <?= $ainfo['aa_id']; ?>;
        var aa_title = $("#aa_title").val();
        
        if (aa_title == '') {
        	
        	alert('请输入答案!');
        	return false; 
        	
        }
        
        $.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/ask/modify_answer/<?= $aq_id; ?>/<?= $ainfo['aa_id']; ?>",
        	data: {action: "action", aq_id: aq_id, aa_title: aa_title},
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        		window.location.reload();
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>修改答案</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>答案名称 : </span>
            <input type="hidden" value="<?= $aq_id; ?>" id="aq_id" />
            <label><input id="aa_title" class="text-input medium-input" type="text" name="aa_title" value="<?= $ainfo['aa_title']; ?>" /></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons cancel' href='javascript:void(0);' >取消</a>
      <a class='buttons submitModifyAnswer' href='javascript:void(0);' >确定</a>
  </div>
</div>
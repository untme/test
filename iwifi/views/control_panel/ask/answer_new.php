<script type="text/javascript">
$(document).ready(function(){

    $(".cancel").click(function(){
        $(document).trigger('close.facebox');
    });

    $(".submitNewAnswer").click(function(){
    	
    	var aq_id = $("#aq_id").val();
        var aa_title = $("#aa_title").val();
        
        if (aa_title == '') {
        	
        	alert('请输入答案!');
        	return false; 
        	
        }
        
        $.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/ask/new_answer/<?= $aq_id; ?>/",
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
  <div class='popdiv_title'>添加一个新答案</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>答案名称 : </span>
            <input type="hidden" value="<?= $aq_id; ?>" id="aq_id" />
            <label><input id="aa_title" class="text-input medium-input" type="text" name="aa_title" value="" /></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons cancel' href='javascript:void(0);' >取消</a>
      <a class='buttons submitNewAnswer' href='javascript:void(0);' >确定</a>
  </div>
</div>
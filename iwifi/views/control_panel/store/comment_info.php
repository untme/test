<script type="text/javascript">
$(document).ready(function(){
    $(".closeComment").click(function(){
        $(document).trigger('close.facebox');
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>查看评论详细信息</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>发布人 : </span>
            <label><?= $user; ?></label>
        </p>

        <p>
            <span>发布时间 : </span>
            <label><?= date('Y-m-d H:i:s', $comment_info['post_date']); ?></label>
        </p>
        
        <p>
            <span>发布内容 : </span>
            <label><?= $comment_info['content']; ?></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons closeComment' href='javascript:void(0);' >关 闭</a>
  </div>
</div>
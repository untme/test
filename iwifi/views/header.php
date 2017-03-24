<div class="wrap clearfix">
    <a href="/" class="logo"></a>
<!--     <div class="lang" current_lang="<?= $lang_type; ?>">
        <a href="javascript:void(0);" class="item current">中文</a>
        <a href="javascript:void(0);" class="item">English</a>
        <a href="javascript:void(0);" class="item">日本語</a>
        <a href="javascript:void(0);" class="item">한국어</a>
    </div> -->
</div>
<script type="text/javascript">

    var current_lang_type = $(".lang").attr('current_lang');
    $(".lang a[type="+current_lang_type+"]").addClass('blue');

    $(".lang a").click(function(){

        if ($(this).hasClass("blue")) {

            // Do Nothing

        }else{

            var type = $(this).attr('type');
            var b = $(this);

            $.ajax({
                type: "POST",
                url: "<?= $base; ?>language/index/",
                data: {lang_type: type},
                beforeSend: function(XMLHttpRequest){

                    // Do nothing....
                },
                success: function(data){

                    window.location.reload();

                },
                error: function(){

                    alert('语言切换失败!');
                }
            });

        }

    });

</script>
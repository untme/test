<style type="text/css">
.baidu_ads_top{
    position: fixed;
    z-index: 1;
    width: 125px;
    height: 125px;
}
</style>
<div id="baidu_ads">
    <div style="float:left" id="baidu_ads_u1930925">
        <div class="baidu_ads_top">
        </div>
        <div>
            <script type="text/javascript">
                var cpro_id = "u1930925";
            </script>
            <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
        </div>
    </div>
    <div style="float:left" id="baidu_ads_u1930962">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930962";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <div style="float:left" id="baidu_ads_u1930966">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930966";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <div style="float:left" id="baidu_ads_u1930969">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930969";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
<div style="clear:both"></div>
<!-- -->
    <div style="float:left" id="baidu_ads_u1930051">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930051";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <div style="float:left" id="baidu_ads_u1930913">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930913";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <div style="float:left" id="baidu_ads_u1930986">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930986";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <div style="float:left" id="baidu_ads_u1930988">
        <div class="baidu_ads_top">
        </div>
        <script type="text/javascript">
            var cpro_id = "u1930988";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
<div style="clear:both"></div>
</div>
<script>

window.onload = function(){
//    console.log ($(document.getElementById('cproIframe_u1930925_1').contentWindow.document.body));

    $(".baidu_ads_top").click(function(){
        $(this).hide();
        var ad_id = "baidu_ad";
        $.ajax({
            type:"POST",
            url:"/user/upgrade_ads",
            data:"ad_id="+ad_id
        });
    });
}

</script>
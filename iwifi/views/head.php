			<a class="logo" href="<?= $base; ?>user"></a>
<!--             <div class="top_nav" current_lang="<?= $lang_type; ?>">
                <a href="javascript:void(0);" type="1">中文</a>
                <a href="javascript:void(0);" type="2">English</a>
                <a href="javascript:void(0);" type="3">日本の</a>
                <a href="javascript:void(0);" type="4">한국어</a>
            </div> -->
            <script type="text/javascript">
            	
            	var current_lang_type = $(".top_nav").attr('current_lang');
            	$(".top_nav a[type="+current_lang_type+"]").addClass('blue');
            	
            	$(".top_nav a").click(function(){
            		
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
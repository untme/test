
 
<a href="javascript:;" style="font-size:80px;" onclick="login();">点1击上网</a>
    <script src="/source/js/jquery-1.8.3.min.js"></script>

 	
	<script>
 	  //登录
	  function login()
	  {
	  	var phone = '18888888888';
		var password = '123456';
	
	 
		 
//	  	var data = $("#login form").serializeArray();
        $.post('/sign/user_signin/',{phone:phone,passwd:password},function(data){
			//alert(data);
			 var ipadd,imac = "";
	        		if(GetQueryString("cip")){
	        			ipadd = GetQueryString("cip");
	        		}
	        		if(GetQueryString("mac")){
	        			imac = GetQueryString("mac");
	        		}
	        		var reg = new RegExp(":","g"); //创建正则RegExp对象    
					var newstr = imac.replace(reg,"-").toUpperCase();
					//任我行数据接口
					$.get('http://175.25.30.4:80/client/login.htm?account='+phone+'&username='+phone+'&groupname=technology&mac='+newstr+'&ipaddr='+ipadd+'&type=007');
					if(data == 0){
						alert('您输入的手机号码或密码有误!');
					}else if(data == 1){
						//cexCookie.set('phone', phone, cookieTime); //在cookie中保存手机号码
						//if($('#remember').attr('checked')){cexCookie.set('password', password, cookieTime);} //在cookie中保存密码
						window.location.href = "/ask/";
					}
         })
		/*$.ajax({
	        	type: "POST",
	        	url: "/sign/user_signin/",
	        	data: {phone:phone,passwd:password},
	        	success: function(data){
	        		alert(data);
					var ipadd,imac = "";
	        		if(GetQueryString("cip")){
	        			ipadd = GetQueryString("cip");
	        		}
	        		if(GetQueryString("mac")){
	        			imac = GetQueryString("mac");
	        		}
	        		var reg = new RegExp(":","g"); //创建正则RegExp对象    
					var newstr = imac.replace(reg,"-").toUpperCase();
					//任我行数据接口
					$.get('http://175.25.30.4:80/client/login.htm?account='+phone+'&username='+phone+'&groupname=technology&mac='+newstr+'&ipaddr='+ipadd+'&type=007');
					if(data == 0){
						alert('您输入的手机号码或密码有误!');
					}else if(data == 1){
						cexCookie.set('phone', phone, cookieTime); //在cookie中保存手机号码
						if($('#remember').attr('checked')){cexCookie.set('password', password, cookieTime);} //在cookie中保存密码
						window.location.href = "/ask/";
					}
	        	},
	        	error: function(){
	        		alert('对不起! 服务器出现故障, 请重新尝试');
	        	}
	        });*/
		
	  }
	  
	  //JS获取参数
	function GetQueryString(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
		var r = window.location.search.substr(1).match(reg);
		if (r!=null) return (r[2]); return null;
	}
	

</script>
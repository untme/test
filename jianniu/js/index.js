$(function(){

	var so =$('a');
	$.each(so, function(s, b) {
		 // $('a').eq(s).attr('href','http://pqt.zoosnet.net/LR/Chatpre.aspx?id=PQT68136867&lng=cn');
		 //$('a').eq(s).addClass('hh');
		 // $('a').eq(s).attr('target','_blank');
		 //$('a').eq(s).attr('href','javascript:;');
	});

	//$('.aa').attr('href','javascript:;');
	$('.aa').removeClass('hh');
	$('.aa').click(function() {
		$('.boxs').css('display','none');
	});


	$('.hh').click(function() {
		$('.boxs').css('display','block');
	});

	var ss=$('.box_span')
	$.each(ss, function(i, n) {
		$('.box_span').eq(i).css('background-position-x',-i*280+'px');
	});


	var tt=$('.xiao_img span');
	$.each(tt, function(si, bi) {
		j=si*-200-80;
		// console.log(j);
		$('.xiao_img span').eq(si).css('background-position-y',j+'px')
	});


	$('.ul_box fang').eq(2).addClass('mr');




	$('.fang').hover(function() {
		var a=$(this).parent('.ul_box').attr('lou');
		var b=$(this).index();
		$(this).addClass('jian'+a);
		$(this).parent('.ul_box').find('.box_span').removeClass('bank');
		$(this).parent('.ul_box').find('li').removeClass('wen_cor');
		$(this).parent('.ul_box').find('.li3').removeClass('fang_ban'+a);
		$(this).parent('.ul_box').find('.li3').removeClass('fang_ban'+a);
		$(this).find('.li3').addClass('fang_ban'+a).removeClass('wen_cor');
		$(this).find('.box_span').addClass('bank');
		$(this).find('li').addClass('wen_cor');
		$(this).siblings().removeClass('jian'+a);
	},function(){
		var a=$(this).parent('.ul_box').attr('lou');
		var b=$(this).index();
		console.log($(this).parent('.ul_box').find('li3'));
		$(this).find('li3').removeClass('fang_ban'+a);
		$(this).parent('.ul_box').find('.box_span').removeClass('bank');
		$(this).parent('.ul_box').find('li').removeClass('wen_cor');
		$(this).find('.li3').removeClass('fang_ban'+a);
		$(this).find('.li3').removeClass('wen_cor');
		$(this).removeClass('jian'+a);
	});

	


	$('.zhaopian').hover(function() {
		$(this).find('.touming').css('display','block');
	}, function() {
		$(this).find('.touming').css('display','none');
	});
	
	$('.g_box a').hover(function(e) {
		$(this).parent('.g_box').find('.zhe1').css('display','block');
			$(this).find('.zhe1').css('display','none');
		var cc=$(this).css('width');
		if(cc == '200px'){
			$(this).stop().animate({"width": "485px"}, 1000);
			// $(this).css('width','485px');
			// $(this).prevAll().css('width','200px')
			// $(this).prevAll().css('width','400px')
			$(this).prevAll().animate({"width": "200px"}, 1000)
			$(this).nextAll().animate({"width": "485px"}, 1000);



		}
		// $(this).css('width','200px');
		$(this).prevAll().stop().animate({"width": "200px"}, 1000)
	});
	

	$('.mianfei').hover(function() {
		$(this).css('background','#FD246C');
		$(this).find('a').css('color','#FFFFFF');
	}, function() {
		$(this).css('background','#FFFFFF');
		$(this).find('a').css('color','#ce0000');
	});

	run();
	function run(){
		var time=setInterval(chat,100000)
	}
	
	var st=5;
	var vv=$('.jian_ul li').eq(st).html();
	function chat(){
		
		
		
		if(vv == 9){
			$('.jian_ul li').eq(st).html(0);
			st--
			vv=0
		}
		vv++
		$('.jian_ul li').eq(st).html(vv);
		
		console.log(vv);
	}

	

	ss1();

	function ss1(){
		var bb=setInterval(chat1,10000000);
	}

	function chat1(){
		$('.ss').css('display','block');
	}




	$('.ss a').click(function() {
		$(this).parent('.ss').css('display','none');
	});




	$('.box_wen .img').hover(function(e) {

		$(this).parent('.box_wen').find('.zhe').stop().animate({'top': '0px'}, 1000);
	}, function() {
		$(this).parent('.box_wen').find('.zhe').stop().animate({'top': '442px'}, 1000);
	});




	var win=$(window).width();
	var swin=$('.ss').width();

	var widt=(win-swin)/2
	$('.ss ').css({
		'left': widt+'px'
	});

	var widt2=(win-650)/2;
	$('.boxs').css({
		'left': widt2+'px'
	});


	



})



$(function(){
	bianse()
	function bianse(){
  
	var sb=$('.ul_box');
//	console.log(sb);
	var ll=['#ffab00','#009FE9','#CE0000'];
	$.each(sb, function(c,k) {
		 sb1=$('.ul_box').eq(c).find('.ul .li3');
		if(c !== 0){
		$.each(sb1, function(v,l) {
			$(this).css('background',ll[c])
		});
			
			
		
	}
		
		
	});
}
	
	
	
	
	
	
})

$(function(){
	$('.two').click(function() {
		var xx=['#009fe9','#64c128','#ee7e00','#ee0000'];
		var h1=$(this).index();
		$('.sekuai').css('background','#ffffff');
		$(this).find('.sekuai').css('background',xx[h1])
	});
})
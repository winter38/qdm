
function d_echo(val){
    console.log(val);
}

function mt_rand(max){
    var number = 1 + Math.floor(Math.random() * max);
    return number;
}

var exp = 0;

// ONLOAD calls
$(document).ready(function() {

	// Show hide 
	$('div.debug_div_header').click(function() {
		var a = $(this).parent().children('.debug_div_body').toggle('slow');
		// console.log(a);
	});

    // Show hide 
    $('div.d_block_div_header').click(function() {
        var a = $(this).parent().children('.d_block_div_body').toggle('slow');
        // console.log(a);
    });


    // Sell item 
    $('.js_item_sell').click(function() {
        
        var id = $(this).attr('item_id');
        qdm_shop.sell(id, $(this));
    });

    // Buy item 
    $('.js_item_buy').click(function() {
        
        var id = $(this).attr('item_id');
        qdm_shop.buy(id, $(this));
    });

    // Use item
    $('.js_item_use').click(function() {
        
        var id = $(this).attr('item_id');
        qdm_item.use(id, $(this));
    });

    // Professions
    $('.miner_tr .a_bt').click(function() {
        // return true;
        if( $(this).attr('disabled') ) return false;
        $(this).attr('disabled', 'true');
        var stamina = $('.js_stamina').attr('stamina');
        
        if( stamina < 10 ){
            $('.miner_tr  .a_bt').attr('disabled', false);
            return false;
        } 

        qdm_mining.init(1);

        $('.miner_tr  .meter_prof_line').animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000, function(){
                            $('.miner_tr  .prof_res').css("position", "absolute").
                                            css("margin-left", "155px").
                                            css("margin-top", "20px").
                                            html('+' + exp + ' exp!').
                                            animate({"margin-top": "-=40px", "opacity": "0.9"}, 2000).
                                            animate({"opacity": "0"}, 1000);
                            // $('.miner_meter').animate({"background" : "#0027FF !important"}, 400);
                            $('.miner_tr  .meter_prof_line').delay(2000).animate({"width": "0px"}, 1000, function(){
                                $('.miner_tr  .a_bt').attr('disabled', false);
                            });
                          })

        return false; // disable link
    });

    $('.herbalist_tr .a_bt').click(function() {
        // return true;
        if( $(this).attr('disabled') ) return false;
        $(this).attr('disabled', 'true');
        var stamina = $('.js_stamina').attr('stamina');
        
        if( stamina < 10 ){
            $('.herbalist_tr .a_bt').attr('disabled', false);
            return false;
        } 

        qdm_mining.init(2);

        $('.herbalist_tr .meter_prof_line').animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000, function(){
                            $('.herbalist_tr  .prof_res').css("position", "absolute").
                                            css("margin-left", "155px").
                                            css("margin-top", "20px").
                                            html('+' + exp + ' exp!').
                                            animate({"margin-top": "-=40px", "opacity": "0.9"}, 2000).
                                            animate({"opacity": "0"}, 1000);
                            // $('.miner_meter').animate({"background" : "#0027FF !important"}, 400);
                            $('.herbalist_tr  .meter_prof_line').delay(2000).animate({"width": "0px"}, 1000, function(){
                                $('.herbalist_tr .a_bt').attr('disabled', false);
                            });
                          })

        return false; // disable link
    });

    $('.woodcuter_tr .a_bt').click(function() {
        // return true;
        if( $(this).attr('disabled') ) return false;
        $(this).attr('disabled', 'true');
        var stamina = $('.js_stamina').attr('stamina');
        
        if( stamina < 10 ){
            $('.woodcuter_tr .a_bt').attr('disabled', false);
            return false;
        } 

        qdm_mining.init(3);

        $('.woodcuter_tr .meter_prof_line').animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000).delay(500).
                          animate({"width": "+=50px"}, 1000, function(){
                            $('.woodcuter_tr  .prof_res').css("position", "absolute").
                                            css("margin-left", "155px").
                                            css("margin-top", "20px").
                                            html('+' + exp + ' exp!').
                                            animate({"margin-top": "-=40px", "opacity": "0.9"}, 2000).
                                            animate({"opacity": "0"}, 1000);
                            // $('.miner_meter').animate({"background" : "#0027FF !important"}, 400);
                            $('.woodcuter_tr  .meter_prof_line').delay(2000).animate({"width": "0px"}, 1000, function(){
                                $('.woodcuter_tr .a_bt').attr('disabled', false);
                            });
                          })

        return false; // disable link
    });

	// Counter
// 	$(".countdown").countdown({
// 		htmlTemplate: "%h : %i : %s",
// 		date: "9 13, 2012 01:20",
// 		yearsAndMonths: true,
// 		servertime: function() { 
// 		    var time = null; 
// 		    $.ajax({url: 'get_time.php', 
// 		        async: false, 
// 				dataType: 'text', 
// 		        success: function( data, status, xhr ) {  
// 					time = data; 
// 		        }, 
// 				error: function(xhr, status, err) { 
// 		            time = new Date(); 
// 					time = time.getTime();
// 		    	}
// 			});

// 		    return time; 
// 		},
// 		hoursOnly: false,
// 		onComplete: function( event ) {
// 			alert('a');
// 			$(this).html("Completed");
// 		},
// 		onPause: function( event, timer ) {

// 			$(this).html("Pause");
// 		},
// 		onResume: function( event ) {
		
// 			$(this).html("Resumed");
// 		},
// 		leadingZero: true
// 	});

});


(function($){
	$(window).load(function(){
		/* custom scrollbar fn call */
		$(".content_2").mCustomScrollbar({
			scrollInertia:0
		});
	});
})(jQuery);


//clearInterval(myCounter);
//$('#' + id + ' #jquery4ucounter').html('0');

/* Ajax */
var qdm_arena ={
    
    indCount:       0,
    updInterval:    30000, // 60 sec
    notifyInterval: 6000,  // 1  sec
    
    init: function(){
        
        var self = qdm_arena;
    	setInterval($.proxy(qdm_arena.requestData, self), self.updInterval);
    },

    requestData: function(){
        var self = qdm_arena;

        $.ajax({
            url: 'script/fp.php?s=ajax_check_battle',
            type: 'GET',
            dataType: 'html',
            //cache: false,
            success: function(data){ self.update(data) }
            // TODO: describe what happens if request failed
            // error: ,
        });
    },

    update: function(Data){
        
        var self = qdm_arena;
        console.log*(Data);

        $('.ajax_arena').html(Data);
    },
}


var qdm_mining ={

    init: function(mode){
        
        var self = qdm_mining;
        qdm_mining.requestData(mode);
    },

    requestData: function(mode){

        var self = qdm_mining;
        var link = '';

        switch( mode ){

            case 1: link = 'script/fp.php?s=ajax_mining'; break;
            case 2: link = 'script/fp.php?s=ajax_herbing'; break;
            case 3: link = 'script/fp.php?s=ajax_woodcuting'; break;
        }

        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'json',
            //cache: false,
            success: function(data){ self.update(data) },
            // TODO: describe what happens if request failed
            // error: function(data){ alert('error') },
        });
    },

    update: function(Data){
        
        var self = qdm_mining;
        console.log*(Data);
        exp = Data.exp;
        $('.js_stamina_title').attr('title', 'Выносливость ' + Data.cur + '/' + Data.max);
        $('.js_stamina').css('margin-top', Data.left);
        $('.js_stamina').attr('stamina', Data.cur);
    },
}


var qdm_shop ={

    buy: function(id, el){
        
        // var self = qdm_shop;
        var price = el.attr('price');
        var gold = parseInt($('.gold_val').text());
        if( gold > price ) qdm_shop.requestData_buy(id, el);
        else{
            $('.trader_cloud').fadeOut(300, function() {
                $(this).text('Ты что считать разучился? Этих грошей не хватит, чтобы оплатить этот товар.').fadeIn(300);
            });
        }
    },

    sell: function(id, el){
        
        // var self = qdm_shop;
        var $span = el.find('.div_items_count');
        var count = $span.text();

        if( count > 0 ) qdm_shop.requestData_sell(id, el);
        else{
            $('.trader_cloud').fadeOut(300, function() {
                $(this).text('Похоже, что у тебя больше не осталось вещей на продажу').fadeIn(300);
            });
        }
    },

    requestData_sell: function(id, el){

        
        // var self = qdm_shop;
        var link = 'script/fp.php?s=ajax_item_sell&id=' + id;

        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'json',
            //cache: false,
            success: function(data){ qdm_shop.update_sell(data, el) },
            // TODO: describe what happens if request failed
            // error: function(data){ alert('error') },
        });
    },

    requestData_buy: function(id, el){

        
        // var self = qdm_shop;
        var link = 'script/fp.php?s=ajax_item_buy&id=' + id;

        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'json',
            //cache: false,
            success: function(data){ qdm_shop.update_buy(data, el) },
            // TODO: describe what happens if request failed
            // error: function(data){ alert('error') },
        });
    },

    update_sell: function(Data, el){
        
        console.log*(Data);
        if( Data.gold ){

            var $span = el.find('.div_items_count');
            var count = $span.text()-1;

            $span.fadeOut(300, function() {
                $(this).text(count).fadeIn(300);
            });

            
            var rnd_text = mt_rand(20);
            var text = '';
            switch( rnd_text ){

                case 1: text = '. С тобой приятно иметь дела.'; break;
                case 2: text = '. Это максимум что я могу дать'; break;
                case 3: text = '. И где ты только берешь это барахло?'; break;
                default: text = ''; break;
            }

            $('.trader_cloud').fadeOut(300, function() {
                $(this).html('Держи, <b>' + Data.gold + '</b><span class="gold_coin"></span>' + text).fadeIn(300);
            });
            var gold = parseInt($('.gold_val').text()) + parseInt(Data.gold);
            // $('.gold_val').html(gold);
            $('.gold_val').fadeOut(300, function() {
                $(this).html(gold).fadeIn(300);
            });
            
            // console.log(count);
        }
        else{

            $('.trader_cloud').fadeOut(300, function() {
                $(this).text('Я не покупаю воздух').fadeIn(300);
            });
        }

    },

    update_buy: function(Data, el){
        
        console.log*(Data);
        if( 1 ){

            // var $span = el.find('.div_items_count');
            // var count = $span.text()-1;

            // $span.fadeOut(300, function() {
            //     $(this).text(count).fadeIn(300);
            // });
            
            var price = parseInt(el.attr('price'));
            var gold = parseInt($('.gold_val').text()) - price;
            $('.gold_val').html(gold);
            
            var rnd_text = mt_rand(20);
            var text = '';
            switch( rnd_text ){

                case 1: text = 'Понравилось?'; break;
                case 2: text = 'Золотишко!'; break;
                default: text = 'Держи, <b>' + el.attr('name') + '</b>.'; break;
            }

            $('.trader_cloud').fadeOut(300, function() {
                $(this).html(text).fadeIn(300);
            });
            var gold = parseInt($('.gold_val').text()) + parseInt(Data.gold);
            // $('.gold_val').html(gold);

            // console.log(count);
        }
        else{

            $('.trader_cloud').fadeOut(300, function() {
                $(this).text('Я не покупаю воздух').fadeIn(300);
            });
        }

    },
}


var qdm_item ={

    use: function(id, el){
        
        // var self = qdm_item;
        var count = parseInt(el.find('.div_items_count').text());
        if( count > 0 ) qdm_item.requestData_use(id, el);
        else{
            // remove block?
        }
    },

    requestData_use: function(id, el){

        // var self = qdm_item;
        var link = 'script/fp.php?s=ajax_item_use&id=' + id;

        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'json',
            success: function(data){ qdm_item.update_use(data, el) },
            // TODO: describe what happens if request failed
            // error: function(data){ alert('error') },
        });
    },

    update_use: function(Data, el){
        
        console.log*(Data);

        $('.js_stamina_title').attr('title', 'Выносливость ' + Data.cur + '/' + Data.max);
        $('.js_stamina').css('margin-top', Data.left);
        $('.js_stamina').attr('stamina', Data.cur);



        if( Data.status ){

            var $span = el.find('.div_items_count');
            var count = $span.text()-1;

            $span.fadeOut(300, function() {
                $(this).text(count).fadeIn(300);
            });


            var gold = parseInt($('.gold_val').text()) + parseInt(Data.gold);
            // $('.gold_val').html(gold);
            $('.gold_val').fadeOut(300, function() {
                $(this).html(gold).fadeIn(300);
            });
            
            // console.log(count);
        }
        else{

            $('.trader_cloud').fadeOut(300, function() {
                $(this).text('Я не покупаю воздух').fadeIn(300);
            });
        }

    },
}


var qdm_stamina ={

    updInterval:    60000, // 60 sec
    notifyInterval: 6000,  // 1  sec
    
    init: function(){
        
        var self = qdm_stamina;
        setInterval($.proxy(qdm_stamina.requestData, self), self.updInterval);
    },

    requestData: function(){
        var self = qdm_stamina;

        $.ajax({
            url: 'script/fp.php?s=ajax_stamina_update',
            type: 'GET',
            dataType: 'json',
            //cache: false,
            success: function(data){ self.update(data) }
            // TODO: describe what happens if request failed
            // error: ,
        });
    },

    update: function(Data){
        
        var self = qdm_stamina;
        console.log*(Data);

        $('.js_stamina_title').attr('title', 'Выносливость ' + Data.cur + '/' + Data.max);
        $('.js_stamina').css('margin-top', Data.left);
        $('.js_stamina').attr('stamina', Data.cur);
    },
}
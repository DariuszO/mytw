var Chat = {
	width: 500,
	height: 320,
	active: 0,
	view: function () {
		if (Chat.active===0) {
			$("#chat-contantier").animate({width: Chat.width , height: Chat.height} , 500);
			$("#chat-contantier").html("<b>Loading...</b>");
			Chat.active = 1;
			Chat.init();
		} else {
			$("#chat-contantier").hide("slow");
			$("#chat-contantier").html("Chat is hide :)");
			Chat.active = 0;
		}
	},
	init: function() {
	
		if (Chat.active===1) {
		
		}
	}
}
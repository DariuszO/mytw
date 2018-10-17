	                               		<div id="welcome-page" class="clearfix">
	<div class="col">
		<div class="row" id="welcome-back">
			<h4>
	Witaj ponownie, <?php echo entparse($user['name']); ?> 	<a style="float: right" href="/game.php?village=<?php echo $village['id']; ?>&id=<?php echo $user['id']; ?>&screen=info_player">&raquo; Profil</a>
</h4>
<ul class="welcome-list">
	<li class="list-item a">
		<span class="list-left">
			Ranking:		</span>
		<span class="list-right">
			<?php echo format_number($user['rank']);?>		</span>
	</li>
	<li class="list-item b">
		<span class="list-left">
			Wioski:		</span>
		<span class="list-right">
			<?php echo format_number($user['villages']);?>		</span>
	</li>
	<li class="list-item a">
		<span class="list-left">
			Punkty:		</span>
		<span class="list-right">
			<?php echo format_number($user['points']);?>		</span>
	</li>
</ul>

		</div>
				<div class="row" id="checklist">
			<h4>Lista</h4>

<ul class="welcome-list">
	<li class="list-item b">
		<span class="list-left">
						Znalazłeś plemię?				</span>
		<span class="list-right">
			<?php if ($user['ally'] > "-1") { ?><img  src="<?php echo $cfg['cdn']; ?>/graphic/confirm.png" alt="" /><?php } ?>		</span>
	</li>
	<li class="list-item a">
		<span class="list-left">
						<a href="<?php echo $cfg['forum']['url'];?>" target="_blank">Wypróbowałeś Forum Gry?</a>
					</span>
		<span class="list-right">
					</span>
	</li>
	</ul>

		</div>
				<div class="row" id="stats">
			<h4>Statystyki</h4>

<ul class="widget-tabs">
	<li class="tooltip" title="Twoje punkty"><a class="selected" id="player_points"   href="#"><img  src="<?php echo $cfg['cdn']; ?>/graphic/welcome/player_points.png" alt="" /></a></li>
	<li class="tooltip" title="Własne wioski"><a id="player_villages" href="#"><img  src="<?php echo $cfg['cdn']; ?>/graphic/welcome/player_villages.png" alt="" /></a></li>
	<?php if ($user['ally']>"-1") {?><li class="tooltip" title="Własne wioski"><a id="ally_points" href="#"><img  src="<?php echo $cfg['cdn']; ?>/graphic/welcome/tribe_points.png" alt="" /></a></li><?php } ?>
	<li class="tooltip" title="Profil zewnętrzny"><a href="/game.php?village=<?php echo $village['id']; ?>&id=<?php echo $user['id']; ?>&screen=info_player" target="_blank"><img  src="<?php echo $cfg['cdn']; ?>/graphic/welcome/ext.png" alt="" /></a></li>
	</ul>

<div class="widget-content">
		<div style="background:#F4E4BC;padding: 8px 8px 0 0">
		<div id="chartdiv" style="height:250px"></div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[

var StatsWidget = {
	// graph data assoc
	<?php
	$stats = ["player_points"=>[],"player_villages"=>[]];
	$result = DB::Query("SELECT * FROM `{$DB}`.`stats` WHERE `own_id` = '{$user['id']}' AND `type` = '1' ORDER BY `time` LIMIT 58");
	while($row = DB::Fetch($result)) {
		$stats["player_points"] = [$row['time']*1000 , $row['value']];
	}
	
	$result = DB::Query("SELECT * FROM `{$DB}`.`stats` WHERE `own_id` = '{$user['id']}' AND `type` = '2' ORDER BY `time` LIMIT 58");
	while($row = DB::Fetch($result)) {
		$stats["player_villages"] = [$row['time']*1000 , $row['value']];
	}
	
	if ($user['ally'] > "-1") {
		$stats["ally_points"] = [];
		$result = DB::Query("SELECT * FROM `{$DB}`.`stats` WHERE `own_id` = '{$user['ally']}' AND `type` = '3' ORDER BY `time` LIMIT 58");
		while($row = DB::Fetch($result)) {
			$stats["ally_points"] = [$row['time']*1000 , $row['value']];
		}
	}
	?>
	stats: <?php echo json_encode($stats);?>,

	// chart div - canvas
	chartdiv: $("#chartdiv"),

	// currently shown graph data
	current: null,

	// previous tooltip position
	previousPoint: null,

	// plot settings
	settings: {
		xaxis: {
			mode: "time",
			timeformat: "%m/%d",
			twelveHourClock: false,
			ticks: 5,
			tickLength: 0 // remove vertical grid lines
		},
		yaxis: {
			minTickSize: 1,
			tickDecimals: 0
		},
		grid: {
			hoverable: true,
			autoHighlight: true,
			backgroundColor: "#F4E4BC"
		}
	},

	settings_line: {
		lines : {
			show : true,
			fill : false
		},
		points: {
			show: false,
			radius: 1,
			fill: true
		}
	},

	settings_bar: {
		bars : {
			show : true,
			barWidth:  24 * 60 * 60 * 1000, // one day
			align: "center"
		}
	},

	init: function() {
		// bind events - type is mapping between clientside and server transmitted names in this.stats
		$("#player_points")  .click({ type: "player_points"},   this.switchGraph);
		$("#player_villages").click({ type: "player_villages"}, this.switchGraph);
		<?php 
		if ($user['ally']>"-1") {
			echo "$(\"#ally_points\")    .click({ type: \"ally_points\"},     this.switchGraph);";
		}
		?>
		
		this.current = "player_points";

		// tickformatter can not be assigned in declaration
		this.settings.yaxis.tickFormatter = this.tickFormatter;

		// bind point hovers
		this.chartdiv.bind("plothover", this.plothover);
		StatsWidget.plot();
	},


	/**
	 * plot graph
	 */
	plot: function () {
		switch (this.current) {
			case "looted_res":
			case "enemy_units":
				this.settings.series = this.settings_bar;
				this.settings.yaxis.min = 0;
				break;
			default:
				this.settings.series = this.settings_line;
				if(this.settings.yaxis.hasOwnProperty('min')) {
					delete this.settings.yaxis.min;
				}
		}

		$['plot'](this.chartdiv, [{ data: this.stats[this.current], color:'green'}], this.settings);
	},


	/**
	 * switching graph data and redraw
	 */
	switchGraph: function(event) {
		event.preventDefault();

		$('#stats').find('.widget-tabs > li > a').removeClass('selected');
		$('#' + event.data.type).addClass('selected');

		StatsWidget.current = event.data.type;
		StatsWidget.plot();
	},


	/**
	 * tooltip event bind
	 */
	plothover: function (event, pos, item) {
		$("#x").text(pos.x);
		$("#y").text(pos.y);

		if (item) {
			if (StatsWidget.previousPoint !== item.dataIndex) {
				StatsWidget.previousPoint = item.dataIndex;

				$("#tooltip_graph").remove();
				var timestamp = item.datapoint[0],
					value     = item.datapoint[1];

                var graphs_date_only = ['looted_res', 'enemy_units'];
                var show_time = graphs_date_only.indexOf(StatsWidget.current) === -1;
				StatsWidget.showTooltip(item.pageX, item.pageY, timestamp, value, show_time);
			}
		}
		else {
			$("#tooltip_graph").remove();
			StatsWidget.previousPoint = null;
		}
	},


	/**
	 * tooltip display - triggered by plot event
	 */
	showTooltip: function (x, y, timestamp, value, show_time) {
		var date = new Date(timestamp);
        var time = (show_time) ? Format.time(timestamp, false) : '';
		var tooltipContent =
			'<div class="warstats_popup_date">'+date.toLocaleDateString() + ' ' + time +'</div>'+
			'<div>'+number_format(value, ".")+'</div>';

		$('<span id="tooltip_graph" class="tooltip-style">' + tooltipContent + '</span>').css( {
			position: 'absolute',
			display: 'none',
			top: y - 20,
			left: x + 13,
			border: '1px solid',
			padding: '2px',
			opacity: 0.90,
			'min-width': '0'
		}).appendTo("body").fadeIn(200);
	},

	/**
	 * formatter for y ticks
	 */
	tickFormatter: function(value) {
		if (value >= 1e7) {
			value /= 1e6;
			return (Math.round(value * 100) / 100) + ' M ';
		}
		if (value >= 1e4) {
			value /= 1e3;
			return (Math.round(value * 100) / 100) + ' K ';
		}

		return value;
	}
};

$(window).load(function() {
	StatsWidget.init();
})
//]]>
</script>

		</div>
	</div>
	<div class="col">
		<div class="row" id="news">
				<h4>Najnowsze wiadomości</h4>
	<div class="widget-content">
	<p style="padding-left: 4px">Gra coraz bardziej się rozwija!</p>
		
		</div>

		</div>

		
				<div class="row" id="tribe-activity">
			<h4>Aktywność plemienia</h4>

	<div class="widget-content" style="padding: 6px">
		Żadne <a href="/game.php?village=<?php echo $village['id']; ?>&screen=ally" >plemię</a> jeszcze Cię nie zainteresowało.	</div>

		</div>
			</div>
	<div id="welcome-page-footer-right">
		<a href="/game.php?village=<?php echo $village['id']; ?>&screen=<?php echo $_GET['oscreen']; ?>" class="btn btn-confirm-yes">Przejdź do gry</a>
	</div>
</div>
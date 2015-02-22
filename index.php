<!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		
		<style type="text/css">
			html, body {
				height: 100%;
			}
			table.table {
				height: 100%;
				margin: 0;
				table-layout: fixed;
			}
			thead tr, tfoot tr, thead tr td, tfoot tr td {
				height: 75px;
			}
			tr, tr td {
				height: 10%;
			}
			thead tr th {
				font-size: 20px;
				text-align: center;
				color: #666;
			}
			:not(tfoot) > tr td:first-of-type {
				position: relative;
				width: 300px;
				max-width: 300px;
				min-width: 300px;
			}
			thead tr td:first-of-type div {
				width: 300px;
				height: 75px;
			}
			thead tr td:first-of-type {
				padding: 0;
			}
			tr td .left_corner, tr td .right_corner {
				position: absolute;
				top: 50%;
				transform: rotate(14deg);
				transform-origin: 50%;
				-ms-transform: rotate(14deg);
				-ms-transform-origin: 50%;
				-moz-transform: rotate(14deg);
				-moz-transform-origin: 50%;
				-webkit-transform: rotate(14deg);
				-webkit-transform-origin: 50%;
				text-align: center;
				width: 104%;
				color: #666;
				font-size: 20px;
			}
			tr td .left_corner {
				border-top: 2px solid #ddd;
				margin-top: -2px;
				left: -9px;
			}
			tr td .right_corner {
				margin-top: -30px;
				left: 0;
			}
			tbody tr {
				-webkit-transition: color 0.5s, height 0.5s, background-color 0.5s;
				background-color: #FFFFFF;
				color: #000000;
			}
			.player {
				text-align: right;
				vertical-align: middle !important;
				font-size: 25px;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}
			.table > tbody > tr > td.score {
				padding: 0;
			}
			.score .score_1, .score .score_2, .score .score_3 {
				width: 50%;
				height: 50%;
				display: inline-block;
				box-sizing: border-box;
				float: left;
				border-left: 1px solid #ddd;
			}
			.score .score_1 {
				border-left-width: 0;
			}
			.score .score_1, .score .score_2, .score .score_3, .score .score_tot {
				text-align: center;
				font-size: 25px;
				vertical-align: middle;
				height: 50%;
				line-height: 100%;
				display: table;
			}
			.score.col_9 .score_1, .score.col_9 .score_2, .score.col_9 .score_3 {
				width: 33%;
			}
			.score span {
				display: table-cell;
				vertical-align: middle;
				text-align: center;
			}
			.score .score_tot {
				border-top: 1px solid #ddd;
				clear: both;
				width: 100%;
			}
			
			@media screen {
				tr.current, tr.current td {
					height: 15%;
					background-color: #337ab7;
					color: #FFFFFF;
					text-shadow: 0 -1px 0 rgba(0,0,0,.2);
					-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);
					box-shadow: inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);
					background-image: -webkit-linear-gradient(top,#337ab7 0,#265a88 100%);
					background-image: -o-linear-gradient(top,#337ab7 0,#265a88 100%);
					background-image: -webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#265a88));
					background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);
					filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff265a88', GradientType=0);
					filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
					background-repeat: repeat-x;
					border-color: #245580;
				}
				.score .active {
					border: 3px solid #DDD;
				}
			}
			
			tfoot td .btn:not(#add_player):not(#print) {
				width: 46px;
			}
			
			@media print {
				@page {
					size: landscape;
				}
				thead td div {
					display: none;
				}
				tfoot, #buttons {
					display: none;
				}
				tr td:first-of-type {
					width: 150px !important;
				}
				tr td {
					width: 50px !important;
				}
				table.table {
					border-collapse: collapse;
				}
				table.table tr td, table.table tr th, table.table {
					border: 1px solid black !important;
				}
				.score div {
					border-color: #000000 !important;
				}
				body {
					color: #000 !important;
				}
			}
		</style>
		<script type="text/javascript">
			// Stores the most recent score field for making changes
			var last_score;
			var first = true;
			
			$(function() {
				// Add player button functionality
				$("#add_player").click(function() {
					first = false;
					
					// Maximum of 6 players
					if ($("tbody tr").length >= 6) {
						return false;
					}
					
					// Show the modal box
					$("#player_modal input").val("");
					$("#player_modal").modal('show');
				});
				
				// Modal add button functionality
				$("#modal_form").submit(function(e) {
					e.preventDefault();
					
					$("#player_modal").modal("hide");
					
					// If this is our initial first player
					if (first) {
						var name = $("#player_modal input").val();
						
						// If the name is empty, use a default
						if (name == "") name = "Player 1";
						
						$("tbody tr:first .player").text(name);
						first = false;
					} else {
						// Maximum of 6 players
						if ($("tbody tr").length >= 6) {
							return false;
						}
						
						addPlayer($("#player_modal input").val());
					}
					
					return false;
				})
				
				// Score button functionality
				$("#buttons .btn:not(#add_player):not(#print)").click(function() {
					// Get the current score from the button and update the box
					var score = $(this).text();
					$(".current .score .active span").text(score);
					
					// Get the current box, row and column index
					var active = $(".current .score .active");
					var row = $(".current");
					var col = active.parent("td").index() + 1;
					
					// If it's been selected out of order, update to set the current box
					if (active[0] != last_score[0] && (active.hasClass('score_2') || score == "X")) {
						last_score.addClass('active');
						row.removeClass('current');
						last_score.closest('tr').addClass('current');
					// If it's the last frame and they get a strike or spare
					} else if (active.hasClass('score_2') && col == 11 && (score == "X" || score == "/" || $(".score_1", active.parent()).text() == "X")) {
						$(".score_3", active.parent()).addClass('active');
					// If we're moving to the next frame
					} else if (active.hasClass('score_2') || active.hasClass('score_3') || (score == "X" && col < 11)) {
						// If it's a strike, blank out the second score
						if (score == "X" && col < 11) {
							$(".score_2 span", active.parent()).html("&nbsp;");
						}
						
						// If it's the last player
						if (row.is(":last-child")) {
							row.removeClass('current');
							
							// if it's not the last frame, select the next frame in the first row
							if (col < 11) {
								$("tbody tr:first-child td:nth-child("+(col + 1)+") .score_1").addClass('active');
								$("tbody tr:first-child").addClass('current');
							}
						// Otherwise, select the next row
						} else {
							row.removeClass('current');
							
							row.next().addClass('current');
							$("td:nth-child("+col+") .score_1", row.next()).addClass('active');
						}
					// Otherwise, just get the second score
					} else {
						if (active[0] != last_score[0]) {
							$(".score_2 span", active.parent()).text("0");
						}
						$(".score_2", active.parent()).addClass('active');
					}
					
					// Clear the current selection and update the 'counter'
					active.removeClass("active");
					if (active[0] == last_score[0]) last_score = $(".active");
					
					
					// Update the scores
					calcScore();
					// Update the buttons
					updateButtons();
					// We don't want to add any more players once play has begun
					$("#add_player").addClass('disabled');
					
					if (col == 11 && $(".active").length == 0) {
						var winner = "", max_score = 0;
						
						$("tbody tr").each(function() {
							var score = parseInt($(".col_9 .score_tot", this).text());
							
							if (score > max_score) {
								winner = $(".player", this).text();
								max_score = score;
							}
						});
						
						$("#win_modal .modal-body").text("Congratulations "+winner+"! You have won the game with a total score of "+max_score);
						
						$("#win_modal").modal("show");
					}
				});
				
				// When clicking a box, it should become selected
				$(".score_1, .score_2, .score_3").click(function() {
					// Unselect current box
					$(".active").removeClass('active');
					$(".current").removeClass('current');
					
					// Select new box
					$(this).addClass('active');
					$(this).closest("tr").addClass('current');
					
					// Update the buttons
					updateButtons();
				});
				
				// Bootstrap modal autofocus
				$("#player_modal").on("shown.bs.modal", function() {
					$("#player_modal input").focus();
				});
				
				$("#print").click(function() {
					window.print();
				});
				
				// Initialise the score box 'counter'
				last_score = $(".active");
				updateButtons();
				
				$("#player_modal").modal("show");
			});
			
			// Function to update player scores
			function calcScore() {
				// For each player row
				$("tbody tr").each(function() {
					var score = 0;
					
					// For each frame
					for (var x = 0; x < 10; x++) {
						var col = $(".col_"+x, this);
						var score1 = $(".score_1", col).text();
						
						// If they got a strike, value is 10 + next + next
						if (score1 == "X") {
							score1 = 10;
							
							// Get next score
							var next = nextScore($(".score_1", col));
							
							if (next) {
								var tempscore = next.text();
								
								// If another strike or a spare, add 10, otherwise parse number
								if (tempscore == "X" || tempscore == "/") tempscore = 10;
								else if (tempscore == "-" || tempscore == "\u2013") tempscore = 0;
								else tempscore = parseInt(tempscore);
								
								// Update score and get next
								score1 += tempscore;
								next = nextScore(next);
								
								if (next) {
									tempscore = next.text();
									
									// If another strike or a spare, add 10, otherwise parse number
									if (tempscore == "X" || tempscore == "/") tempscore = 10;
									else if (tempscore == "-" || tempscore == "\u2013") tempscore = 0;
									else tempscore = parseInt(tempscore);
									
									score1 += tempscore;
								}
							}
						} else if (score1 == "-" || score1 == "\u2013") {
							score1 = 0;
						} else {
							// Otherwise, parse number
							score1 = parseInt(score1);
						}
						
						score += score1;
						
						var score2 = $(".score_2", col).text();
						
						// If they got a spare, value is 10 + next
						if (score2 == "/") {
							score2 = 10 - score1;
							
							// Get next score
							var next = nextScore($(".score_2", col));
							
							if (next) {
								var tempscore = next.text();
								
								// If a strike or spare, add 10, otherwise parse number
								if (tempscore == "X" || tempscore == "/") tempscore = 10;
								else if (tempscore == "-" || tempscore == "\u2013") tempscore = 0;
								else tempscore = parseInt(tempscore);
								
								score2 += tempscore;
							}
						} else if (score2 == "" || score2 == " " || score2 == "&nbsp;" || score2 == '\xa0' || score2 == "X" || score2 == "-" || score2 == "\u2013") {
							// If it's empty due to a strike, or a strike in the last frame
							score2 = 0;
						} else {
							// Otherwise, parse number
							score2 = parseInt(score2);
						}
						
						score += score2;
						
						// Display current score total
						$(".score_tot span", col).text(score);
					}
				});
			}
			
			// Function to find the next score container
			function nextScore(current) {
				// If it's the first score
				if (current.hasClass('score_1')) {
					// If it's a strike
					if (current.text() == "X") {
						// If it's the last frame
						if (current.parent().hasClass('col_9')) {
							// Return the second score
							return $(".score_2", current.parent());
						} else {
							// Return the first score of the next frame
							return $(".score_1", current.parent().next());
						}
					} else {
						// Otherwise, return the second score
						return $(".score_2", current.parent());
					}
				// If it's the very final score
				} else if (current.hasClass('score_3')) {
					return false;
				// If it's the second score
				} else {
					// If it's the last frame
					if (current.parent().hasClass('col_9')) {
						// Return the third score
						return $(".score_3", current.parent());
					} else {
						// Always return the first from the next frame
						return $(".score_1", current.parent().next());
					}
				}
			}
			
			// Function to add a new player row
			function addPlayer(name) {
				// If we have fewer than 6 players
				if ($("tbody tr").length < 6) {
					// Clone the template
					var clone = $(".template").clone();
					
					// Update the class and id
					clone.removeClass("template").removeClass('current');
					clone.attr("id", "row_"+$("tbody tr").length);
					
					// If the name is empty, use a default
					if (name == "") {
						name = "Player " + ($("tbody tr").length + 1);
					}
					
					// Change the text
					$(".player", clone).text(name);
					
					// Remove any active classes
					$(".active", clone).removeClass('active');
					
					// Append to table
					$("tbody").append(clone);
				}
				
				if ($("tbody tr").length >= 6) {
					// If we have more than 6 players now disable the add button
					$("#add_player").addClass('disabled');
				}
			}
			
			// Function to update the available score buttons
			function updateButtons() {
				// Enable all buttons to start
				$("#buttons .btn:not(#add_player)").removeClass("disabled");
				
				// Get current box
				var active = $(".active");
				
				// If we've finished, disable all
				if (active.length == 0) {
					$("#buttons .btn").addClass('disabled');
				// If it's the first score, disable the spare button
				} else if (active.hasClass('score_1')) {
					$("#btn_S").addClass("disabled");
				// If it's the second score
				} else if (active.hasClass('score_2')) {
					// Get the previous score
					var score = $(".score_1", active.parent()).text();
					
					// If it was a strike or spare
					if (score == "X" || score == "/") {
						// Disable the spare button
						$("#btn_S").addClass("disabled");
					} else {
						// Otherwise disable a strike
						$("#btn_X").addClass("disabled");
						
						// Check if it's a 0 score
						if (score == "\u2013") score = 0;
						if (score == "\xa0") score = 0;
						if (score == "") score = 0;
						
						// Disable all too-high valued options
						for (var x = 9; x > (9 - score); x--) {
							$("#btn_"+x).addClass("disabled");
						}
					}
				// The third score on the final frame
				} else {
					// Get the previous score
					var score = $(".score_2", active.parent()).text();
					
					// If it was a strike or spare
					if (score == "X" || score == "/") {
						// Disable the spare button
						$("#btn_S").addClass('disabled');
					} else {
						// Otherwise, disable the strike
						$("#btn_X").addClass('disabled');
						
						// Disable all too-high valued options
						for (var x = 9; x > (9 - score); x--) {
							$("#btn_"+x).addClass("disabled");
						}
					}
				}
			}
		</script>
	</head>
	<body>
		<table class="table table-bordered">
			<thead>
				<tr>
					<td>
						<div>
							<div class="left_corner">Players</div>
							<div class="right_corner">Frames</div>
						</div>
					</td>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
				</tr>
			</thead>
			<tbody>
				<tr class="template current" id="row_0">
					<td class="player">Player 1</td>
					<? for ($i = 0; $i < 10; $i++) { ?>
					<td class="score col_<?=$i?>">
						<div class="score_1<?=$i == 0 ? ' active' : ''?>"><span>&ndash;</span></div>
						<div class="score_2"><span>&ndash;</span></div>
						<?=$i == 9 ? '<div class="score_3"><span>&ndash;</span></div>' : '' ?>
						<div class="score_tot"><span>0</span></div>
					</td>
					<? } ?>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="11" class="text-center" id="buttons">
						<div class="btn btn-primary btn-lg" id="btn_D">&ndash;</div>
						<div class="btn btn-primary btn-lg" id="btn_1">1</div>
						<div class="btn btn-primary btn-lg" id="btn_2">2</div>
						<div class="btn btn-primary btn-lg" id="btn_3">3</div>
						<div class="btn btn-primary btn-lg" id="btn_4">4</div>
						<div class="btn btn-primary btn-lg" id="btn_5">5</div>
						<div class="btn btn-primary btn-lg" id="btn_6">6</div>
						<div class="btn btn-primary btn-lg" id="btn_7">7</div>
						<div class="btn btn-primary btn-lg" id="btn_8">8</div>
						<div class="btn btn-primary btn-lg" id="btn_9">9</div>
						<div class="btn btn-primary btn-lg" id="btn_S">/</div>
						<div class="btn btn-primary btn-lg" id="btn_X">X</div>
						<div class="btn btn-primary btn-lg" id="add_player">Add Player</div>
						<div class="btn btn-primary btn-lg" id="print"><i class="fa fa-print"></i></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<div class="modal fade" id="player_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="modal_form">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Add Player</h4>
						</div>
						<div class="modal-body">
							<input type="text" name="name" class="form-control" placeholder="Player Name" />
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add Player</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="modal fade" id="win_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="modal_form">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Game Over</h4>
						</div>
						<div class="modal-body">
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>

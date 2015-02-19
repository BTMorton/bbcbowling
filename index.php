<!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
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
			tr.current, tr.current td {
				height: 15%;
				background-color: #337AB7;
				color: #FFFFFF;
			}
			.table > tbody > tr > td.score {
				padding: 0;
			}
			.score .score_1, .score .score_2 {
				width: 50%;
				height: 50%;
				display: inline-block;
				box-sizing: border-box;
				float: left;
			}
			.score .score_1 {
				border-right: 1px solid #ddd;
			}
			.score .score_1, .score .score_2, .score .score_tot {
				text-align: center;
				font-size: 25px;
				vertical-align: middle;
				height: 50%;
				line-height: 100%;
				display: table;
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
			tfoot td .btn:not(#add_player) {
				width: 46px;
			}
		</style>
		<script type="text/javascript">
			// Stores the most recent score field for making changes
			var last_score;
			
			$(function() {
				// Add player button functionality
				$("#add_player").click(function() {
					// Maximum of 6 players
					if ($("tbody tr").length >= 6) {
						return false;
					}
					
					$(".modal").modal('show');
				});
				
				// Modal add button functionality
				$("#modal_add").click(function() {
					$(".modal").modal("hide");
					
					// Maximum of 6 players
					if ($("tbody tr").length >= 6) {
						return false;
					}
					
					addPlayer($(".modal input").val());
				})
				
				// Score button functionality
				$(".btn:not(#add_player)").click(function() {
					$(".current .score .active span").text($(this).text());
					var active = $(".current .score .active");
					var row = $(".current");
					var col = active.parent("td").index() + 1;
					
					if (active.attr("id") != last_score.attr("id")) {
						last_score.addClass('active');
						row.removeClass('current');
						last_score.closest('tr').addClass('current');
					} else if (active.hasClass('score_2')) {
						if (row.is(":last-child")) {
							if (col < 11) {
								$("tbody tr:first-child td:nth-child("+(col + 1)+") .score_1").addClass('active');
								$("tbody tr:first-child").addClass('current');
							}
						} else {
							row.next().addClass('current');
							$("td:nth-child("+col+") .score_1", row.next()).addClass('active');
						}
						
						row.removeClass('current');
					} else {
						$(".score_2", active.parent()).addClass('active');
					}
					
					active.removeClass("active");
					
					calcScore();
				});
				
				$(".score_1, .score_2").click(function() {
					$(".active").removeClass('active');
					$(".current").removeClass('current');
					$(this).addClass('active');
					$(this).closest("tr").addClass('current');
				});
				
				// Initialise bootstrap modal
				$(".modal").on("shown.bs.modal", function() {
					$(".modal input").focus();
				});
				
				last_score = $(".active");
			});
			
			// Function to update player scores
			function calcScore() {
				$("tbody tr").each(function() {
					var score = 0;
					
					$("td.score", this).each(function() {
						score += parseInt($(".score_1", this).text());
						score += parseInt($(".score_2", this).text());
						$(".score_tot span", this).text(score);
					});
				});
			}
			
			// Function to add a new player row
			function addPlayer(name) {
				// Clone the template
				var clone = $(".template").clone();
				
				// Update the class and id
				clone.removeClass("template").removeClass('current');
				clone.attr("id", "row_"+$("tbody tr").length);
				
				// Change the text
				$(".player", clone).text(name);
				
				// Append to table
				$("tbody").append(clone);
			}
		</script>
	</head>
	<body>
		<table class="table table-bordered">
			<thead>
				<tr>
					<td>
						<div class="left_corner">Players</div>
						<div class="right_corner">Frames</div>
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
					<td class="score" id="score_0_<?=$i?>">
						<div class="score_1<?=$i == 0 ? ' active' : ''?>"><span>0</span></div>
						<div class="score_2"><span>0</span></div>
						<div class="score_tot"><span>0</span></div>
					</td>
					<? } ?>
				</tr>
				<tr class="" id="row_1">
					<td class="player">Player 2</td>
					<? for ($i = 0; $i < 10; $i++) { ?>
					<td class="score" id="score_1_<?=$i?>">
						<div class="score_1"><span>0</span></div>
						<div class="score_2"><span>0</span></div>
						<div class="score_tot"><span>0</span></div>
					</td>
					<? } ?>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="11" class="text-center">
						<div class="btn btn-primary btn-lg">&ndash;</div>
						<div class="btn btn-primary btn-lg">1</div>
						<div class="btn btn-primary btn-lg">2</div>
						<div class="btn btn-primary btn-lg">3</div>
						<div class="btn btn-primary btn-lg">4</div>
						<div class="btn btn-primary btn-lg">5</div>
						<div class="btn btn-primary btn-lg">6</div>
						<div class="btn btn-primary btn-lg">7</div>
						<div class="btn btn-primary btn-lg">8</div>
						<div class="btn btn-primary btn-lg">9</div>
						<div class="btn btn-primary btn-lg">/</div>
						<div class="btn btn-primary btn-lg">X</div>
						<div class="btn btn-primary btn-lg" id="add_player">Add Player</div>
					</td>
				</tr>
			</tfoot>
		</table>
		<div class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add Player</h4>
					</div>
					<div class="modal-body">
						<input type="text" name="name" class="form-control" placeholder="Player Name" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="modal_add">Add Player</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		body{
			background: #212121;
			color: #666;
		}
		h1{
			text-align: center;
			color: #fff;
		}
		.clearfix{
			clear: both;
		}
		#box{
			width: 350px;
			overflow: auto;
			margin: 40px auto;
			background: #666;
			padding-bottom: 40px;
			border-radius: 10px;
		}
		#message{
			background: #333;
			color: #fff;
		}
		#gameBoard li{
			float: left;
			margin: 10px;
			height: 70px;
			width: 70px;
			font-size: 50px;
			background: #333;
			color: #ccc;
			list-style: none;
			text-align: center;
			border-radius: 5px;
		}
		#gameBoard li:hover, #reset:hover{
			cursor: pointer;
			background: #000;
		}
		#reset{
			border: 0;
			background: #444;
			color: #fff;
			width: 70%;
			padding: 15px;
			border-radius: 5px;
		}
		.o{
			color: green !important;
		}
		.x{
			color: red !important;
		}
		footer{
			display: block;
			text-align: center;
			padding-top: 20px;
		}
	</style>
</head>
<body>
<div class="text-center"id="box">
	<header>
		<h1>Play Tic Tac Toe</h1>
	</header>
	<div id="message"></div>
	<ul id="gameBoard">
		<li class="tic"id="0">#</li>
		<li class="tic"id="1">#</li>
		<li class="tic"id="2">#</li>
		<li class="tic"id="3">#</li>
		<li class="tic"id="4">#</li>
		<li class="tic"id="5">#</li>
		<li class="tic"id="6">#</li>
		<li class="tic"id="7">#</li>
		<li class="tic"id="8">#</li>
	</ul>
	<div class="clearfix"></div>
	<footer>
		<button id="reset">Reset</button>
	</footer>
</div>
<script
	src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
	integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
	crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var turns = ["#","#","#","#","#","#","+","#"];
        var computerTurn = "";
        var turn = "";
        var gameOn = false;
        var count = 0;

        var startTurn = prompt("Choose Your Move", "Type X or O").toUpperCase();
        switch (startTurn) {
            case "X":
                computerTurn = "O";
                turn = "X";
                $("#message").html("Player " + turn + " gets to start!");
                break;
            case "O":
                computerTurn = "X";
                turn = "O";
                $("#message").html("Player " + turn + " gets to start!");
                break;
            case null:
                alert("Sorry. Please type X or O");
                window.location.reload(true);
                break;
            default:
                alert("Sorry. Please type X or O");
                window.location.reload(true);
                break;
        }

        function computersTurn() {
            var taken = false;
            while (taken === false && count !== 5) {
                var computerMove = (Math.random() * 10).toFixed();
                var move = $("#" + computerMove).text();
                if (move === "#") {
                    $("#" + computerMove).text(computerTurn);
                    taken = true;
                    turns[computerMove] = computerTurn;
                }
            }
        }

        function playerTurn (turn, id){
            var spotTaken = $("#"+id).text();
            if (spotTaken ==="#"){
                count++;
                turns[id] = turn;
                $("#"+id).text(turn);
                winCondition(turns,turn);
                if (gameOn === false){
                    computersTurn();
                    $("#message").html("It's " + turn +"'s turn.");
                    winCondition(turns, computerTurn);
                }
            }
        }

        function winCondition(trackMoves, currentMove) {
            if (trackMoves[0] === currentMove && trackMoves[1] === currentMove && trackMoves[2] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[2] === currentMove && trackMoves[4] === currentMove && trackMoves[6] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[0] === currentMove && trackMoves[3] === currentMove && trackMoves[6] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[0] === currentMove && trackMoves[4] === currentMove && trackMoves[8] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[1] === currentMove && trackMoves[4] === currentMove && trackMoves[7] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[2] === currentMove && trackMoves[5] === currentMove && trackMoves[8] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[2] === currentMove && trackMoves[5] === currentMove && trackMoves[8] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[3] === currentMove && trackMoves[4] === currentMove && trackMoves[5] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if (trackMoves[6] === currentMove && trackMoves[7] === currentMove && trackMoves[8] === currentMove) {
                gameOn = true;
                reset();
                alert("Player " + currentMove + " wins!");
            } else if(!(trackMoves.includes("#"))){
                gameOn = true;
                reset();
                alert("It is a Draw!");
            }﻿ else {
                gameOn = false;
            }
        }

        $(".tic").click(function(){
            var slot = $(this).attr('id');
            playerTurn(turn,slot);
        });

        function reset(){
            turns = ["#","#","#","#","#","#","+","#"];
            count = 0;
            $(".tic").text("#");
            gameOn = true;
        }

        $("#reset").click(function(){
            reset();
        });

    });
</script>
</body>
</html>
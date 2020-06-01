<?php
include ( 'config.php' );
if (!isset($_SESSION['game_id']) ){
	echo "<script>window.location='index.php'</script>";
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="Tic Tac Toc">
    <meta name="keywords" content="Tic Tac Toc,free ,game">
    <meta name="author" content="Eng.Mikhail">

	<title>Tic Tac Toc</title>
	<style>
        ::selection{
            color: #212121;
        }
		body{
			background: #212121;
			color: #666;
			text-align: center;
		}
		h1,h4,h6{ color: #fff; }
		.clearfix{ clear: both; }
		#box{
			width: 350px;
			overflow: auto;
			margin: 40px auto;
			background: #666;
			padding-bottom: 40px;
			border-radius: 10px;
		}
		input,select{
			background: #444;
			color: #fff;
			border: none;
			padding: 15px 15px;
		}
		input[type="radio"] {
			width: 65px;
			height: 30px;
			border-radius: 15px;
			border: 2px solid #444;
			background-color: white;
			-webkit-appearance: none; /*to disable the default appearance of radio button*/
			-moz-appearance: none;
		}

		input[type="radio"]:focus { /*no need, if you don't disable default appearance*/
			outline-color: transparent; /*to remove the square border on focus*/
		}

		input[type="radio"]:checked { /*no need, if you don't disable default appearance*/
			background-color: #444;
		}

		input[type="radio"]:checked ~ span:first-of-type {
			color: white;
		}

		label span:first-of-type {
			position: relative;
			left: -45px;
			font-size: 15px;
			color: #444;
		}

		label span {
			position: relative;
			top: -10px;
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
			border-radius: 5px;
		}
		#gameBoard li:hover{
			cursor: pointer;
			background: #000;
		}
		#reset,#submit,#create{
			border: 0;
			background: #444;
			color: #fff;
			width: 70%;
			padding: 15px;
			border-radius: 5px;
		}
		footer{
			display: block;
			padding-top: 20px;
		}

		@media (max-width:320px ) {
			#box { width:100%;}
			#gameBoard li{
				margin: 6px;
				height: 65px;
			}
		}
	</style>
    <style>
        .digits div {
            position: relative;
            width: 20px;
            height: 39px;
            display: inline-block;
            margin: 0 0.8em;
        }

        .digits .d1 {
            position: absolute;
            display: block;
            width: 15px;
            height: 5px;
            background: #fff;
        }

        .digits .d1:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            left: -5px;
            border-width: 0 5px 5px 0;
            border-color: transparent #fff transparent transparent;
        }

        .digits .d1:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            right: -5px;
            border-width: 5px 5px 0 0;
            border-color: #fff transparent transparent transparent;
        }

        .digits .d2 {
            left: -7.5px;
            top: 7.5px;
            position: absolute;
            display: block;
            width: 5px;
            height: 15px;
            background: #fff;
        }

        .digits .d2:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            top: -5px;
            border-width: 5px 0 0 5px;
            border-color: transparent transparent transparent #fff;
        }

        .digits .d2:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            bottom: -5px;
            border-width: 5px 5px 0 0;
            border-color: #fff transparent transparent transparent;
        }

        .digits .d3 {
            left: 17.5px;
            top: 7.5px;
            position: absolute;
            display: block;
            width: 5px;
            height: 15px;
            background: #fff;
        }

        .digits .d3:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            top: -5px;
            border-width: 0 0 5px 5px;
            border-color: transparent transparent #fff transparent;
        }

        .digits .d3:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            bottom: -5px;
            border-width: 0 5px 5px 0;
            border-color: transparent #fff transparent transparent;
        }

        .digits .d4 {
            left: -7.5px;
            top: 35px;
            position: absolute;
            display: block;
            width: 5px;
            height: 15px;
            background: #fff;
        }

        .digits .d4:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            top: -5px;
            border-width: 5px 0 0 5px;
            border-color: transparent transparent transparent #fff;
        }

        .digits .d4:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            bottom: -5px;
            border-width: 5px 5px 0 0;
            border-color: #fff transparent transparent transparent;
        }

        .digits .d5 {
            left: 17.5px;
            top: 35px;
            position: absolute;
            display: block;
            width: 5px;
            height: 15px;
            background: #fff;
        }

        .digits .d5:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            top: -5px;
            border-width: 0 0 5px 5px;
            border-color: transparent transparent #fff transparent;
        }

        .digits .d5:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            bottom: -5px;
            border-width: 0 5px 5px 0;
            border-color: transparent #fff transparent transparent;
        }

        .digits .d6 {
            position: absolute;
            display: block;
            top: 26.25px;
            width: 15px;
            height: 5px;
            background: #fff;
        }

        .digits .d6:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            left: -5px;
            border-width: 2.5px 5px 2.5px 0;
            border-color: transparent #fff transparent transparent;
        }

        .digits .d6:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            right: -5px;
            border-width: 2.5px 0 2.5px 5px;
            border-color: transparent transparent transparent #fff;
        }

        .digits .d7 {
            position: absolute;
            display: block;
            top: 52.5px;
            width: 15px;
            height: 5px;
            background: #fff;
        }

        .digits .d7:before {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            left: -5px;
            border-width: 0 0 5px 5px;
            border-color: transparent transparent #fff transparent;
        }

        .digits .d7:after {
            content: " ";
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
            right: -5px;
            border-width: 5px 0 0 5px;
            border-color: transparent transparent transparent #fff;
        }
        /* 0 */
        .digits div.zero .d6 {
            visibility: hidden;
        }

        /* 1 */
        .digits div.one .d1, .digits div.one .d2, .digits div.one .d4, .digits div.one .d6, .digits div.one .d7 {
            visibility: hidden;
        }

        /* 2 */
        .digits div.two .d2, .digits div.two .d5 {
            visibility: hidden;
        }

        /* 3 */
        .digits div.three .d2, .digits div.three .d4 {
            visibility: hidden;
        }

        /* 4 */
        .digits div.four .d1, .digits div.four .d4, .digits div.four .d7 {
            visibility: hidden;
        }

        /* 5 */
        .digits div.five .d3, .digits div.five .d4 {
            visibility: hidden;
        }

        /* 6 */
        .digits div.six .d1, .digits div.six .d3 {
            visibility: hidden;
        }

        /* 7 */
        .digits div.seven .d2, .digits div.seven .d4, .digits div.seven .d6, .digits div.seven .d7 {
            visibility: hidden;
        }

        /* 8 */
        /* 9 */
        .digits div.nine .d4, .digits div.nine .d7 {
            visibility: hidden;
        }

    </style>
</head>
<body>
<div id="box">
	<header>
		<h1>Play Tic Tac Toe</h1>
	</header>
	<div id="message"></div>
	<div id="game">
	</div>
</div>
<!--include jquery -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
<!--end include jquery -->
<!--include ajax-->
<script>
    function createRequest() {
        var myRequest;
        try{
            if (window.XMLHttpRequest) {
                myRequest = new XMLHttpRequest();
            } else {
                myRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }catch (error){
            console.log("There's an error on creating a request");
        }
        return myRequest;
    }
    //start game
    function in_game() {
        myRequest = createRequest();
        myRequest.onreadystatechange = function myDate() {
            var game = document.getElementById("game");
            if (this.readyState == 4 && this.status == 200) {
                game.innerHTML = this.responseText;
            }
        };
        myRequest.open("POST", "code.php?game=in_game", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send();
    }
    in_game();
    setInterval(in_game,1000);


    //game
    function playerTurn(slot){
        myRequest = createRequest();
        myRequest.onreadystatechange = function myDate() {
            if (this.readyState == 4 && this.status == 200) {in_game();}
        };
        myRequest.open("POST", "code.php?game=playerTurn", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send("slot="+slot);
    }

</script>
<!--end include ajax -->
</body>
</html>
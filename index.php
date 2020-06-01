<?php
include ( 'config.php' );
if (isset($_SESSION['game'])){
	session_abort();
	session_destroy();
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
        h1{ color: #fff; }
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
            background-color: #212121;
            border: 1px solid #ffe9e9;
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
        #gameBoard li:hover, #reset:hover, #submit:hover{
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
        .o{ color: green !important; }
        .x{ color: red !important; }
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
</head>
<body>
<div id="box">
    <header>
        <h1>Play Tic Tac Toe</h1>
    </header>
    <div id="message"></div>
    <div id="game">
        <form onsubmit="return loginForm();">
            <div>
                <input type="text" id="username" placeholder="Enter your username" required autocomplete="off">
            </div>
            <br>
            <div>
                <label>
                    <input type="radio" value="0" name="type" required/>
                    <span>O</span>
                </label>
                <label>
                    <input type="radio" value="1" name="type" required/>
                    <span>X</span>
                </label>
            </div>
            <footer>
                <button type="submit" id="submit">submit</button>
            </footer>
        </form>
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
    //login
    function loginForm() {
        myRequest = createRequest();
        var username = document.getElementById("username").value;
        var type = document.querySelector('input[name="type"]:checked').value;
        myRequest.onreadystatechange = function myDate() {
            if (this.readyState == 4 && this.status == 200) { selectUser(type); }
        };
        myRequest.open("POST", "code.php?game=login", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send("type="+type+"&username="+username);
        return false;
    }
    //select selectUser
    function selectUser(type) {
        myRequest = createRequest();
        myRequest.onreadystatechange = function myDate() {
            var game = document.getElementById("game");
            if (this.readyState == 4 && this.status == 200) {
                game.innerHTML = this.responseText;
            }
        };
        myRequest.open("POST", "code.php?game=selectUser", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send("type="+type);
    }
    //start_game
    function start_game() {
        myRequest = createRequest();
        myRequest.onreadystatechange = function myDate() {
            if (this.readyState == 4 && this.status == 200) {
                window.location = "in_game.php";
            }
        };
        myRequest.open("POST", "code.php?game=start", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send();
    }
    //start_game
    function start_game_id() {
        myRequest = createRequest();
        var game_id = document.getElementById("game_id").value;
        myRequest.onreadystatechange = function myDate() {
            if (this.readyState == 4 && this.status == 200) {
                window.location = "in_game.php";
            }
        };
        myRequest.open("POST", "code.php?game=start", true);
        myRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        myRequest.send("game_id="+game_id);
        return false;
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
</script>
<!--end include ajax -->
</body>
</html>
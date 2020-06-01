<?php include ( 'config.php' ); ?>
<?php
function winCondition($turns, $type_tic) {
	if ($turns[0] === $type_tic && $turns[1] === $type_tic && $turns[2] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[2] === $type_tic && $turns[4] === $type_tic && $turns[6] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[0] === $type_tic && $turns[3] === $type_tic && $turns[6] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[0] === $type_tic && $turns[4] === $type_tic && $turns[8] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[1] === $type_tic && $turns[4] === $type_tic && $turns[7] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[2] === $type_tic && $turns[5] === $type_tic && $turns[8] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[2] === $type_tic && $turns[5] === $type_tic && $turns[8] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[3] === $type_tic && $turns[4] === $type_tic && $turns[5] === $type_tic) {
		$gameOn = 1;

	}elseif ($turns[6] === $type_tic && $turns[7] === $type_tic && $turns[8] === $type_tic) {
		$gameOn = 1;

	}elseif(!in_array("-",$turns)){
		$gameOn = 2;
	}else{
		$gameOn = 0;
	}
	return $gameOn;
}
?>
<?php
if (isset($_GET['game']) && $_GET['game'] == 'login') {
	if ($_SERVER['REQUEST_METHOD']=="POST"){
		mysqli_query ( $website, "INSERT INTO user (username, type_tic) VALUES ( '".$_POST['username']."' , '".$_POST['type']."' )") or die( mysqli_error ( $website ) );
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['user_id'] = mysqli_insert_id($website);
		$_SESSION['type_tic'] = $_POST['type'];
	}
}elseif (isset($_GET['game']) && $_GET['game'] == 'selectUser') {
	$stmt_users = mysqli_query ( $website, "SELECT * FROM game INNER JOIN user ON game.player_one = user.user_id WHERE user.type_tic <> '".$_POST['type']."' AND game.player_two IS NULL ORDER BY user_id DESC") or die( mysqli_error ( $website ) );
	$rows_users = mysqli_fetch_all ($stmt_users,MYSQLI_ASSOC);
	?>
    <div>
        <button onclick="start_game()" id="create">Create Room</button>
    </div>
    <br>
	<?php if(isset($rows_users) && !empty($rows_users)){?>
        <fieldset>
            <form onsubmit="return start_game_id();">
                <div>
                    <select id="game_id">
						<?php foreach ($rows_users as $row_users){?>
                            <option value="<?php echo $row_users['game_id']?>"><?php echo $row_users['username']?></option>
						<?php } ?>
                    </select>
                </div>
                <footer>
                    <button type="submit" id="submit">Let's Game Begin</button>
                </footer>
            </form>
        </fieldset>
		<?php
	}
}elseif (isset($_GET['game']) && $_GET['game'] == 'start') {
	if ($_SERVER['REQUEST_METHOD']=="POST"){
		if (isset($_POST['game_id']) && !empty($_POST['game_id'])){
			mysqli_query ( $website, "UPDATE user SET played = 1 WHERE user_id = '".$_SESSION['user_id']."'") or die( mysqli_error ( $website ) );
			mysqli_query ( $website, "UPDATE game SET player_two ='".$_SESSION['user_id']."' WHERE game_id ='".$_POST['game_id']."' ") or die( mysqli_error ( $website ) );
			$_SESSION['game_id'] = $_POST['game_id'];
		}else{
			mysqli_query ( $website, "UPDATE user SET played = 1 WHERE user_id = '".$_SESSION['user_id']."'") or die( mysqli_error ( $website ) );
			mysqli_query ( $website, "INSERT INTO game (player_one) VALUES ( '".$_SESSION['user_id']."' )") or die( mysqli_error ( $website ) );
			$_SESSION['game_id'] = mysqli_insert_id($website);
		}
	}
}elseif (isset($_GET['game']) && $_GET['game'] == 'in_game') {
	if (isset($_SESSION['game_id']) ){

		$player_two = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT username FROM game INNER JOIN user ON game.player_two=user.user_id WHERE game_id = '".$_SESSION['game_id']."' "))['username'];
		if (isset($player_two)){
			$player_id = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT * FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['player_one'];
			if($_SESSION['user_id'] != $player_id){
				$player_two= mysqli_fetch_assoc(mysqli_query ( $website, "SELECT username FROM user WHERE user_id = '".$player_id."' "))['username'];
				$win_two = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT win_one FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['win_one'];
				$win_one = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT win_two FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['win_two'];
			}else{
				$player_id = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT * FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['player_two'];
				$player_two = mysqli_fetch_assoc(mysqli_query ( $website, "SELECT username FROM user WHERE user_id = '".$player_id."' "))['username'];
				$win_one= mysqli_fetch_assoc(mysqli_query ( $website, "SELECT win_one FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['win_one'];
				$win_two= mysqli_fetch_assoc(mysqli_query ( $website, "SELECT win_two FROM game WHERE game_id = '".$_SESSION['game_id']."' "))['win_two'];

			}
			$turns=["-","-","-","-","-","-","-","-","-"];
			$stmt_game = mysqli_query ( $website, "SELECT * FROM in_game WHERE game_id = '".$_SESSION['game_id']."' ") or die( mysqli_error ( $website ) );
			$no_rows=mysqli_num_rows ($stmt_game);
			while ($row_game = mysqli_fetch_assoc($stmt_game)){ $slot=$row_game['slot']; $type_tic=($row_game['type_tic']=='1')?"X":"O"; $turns[$slot]=$type_tic; }
			$game_on[0] = winCondition($turns,'O');
			$game_on[1] = winCondition($turns,'X');
			if ($game_on[0] == 0 && $game_on[1] == 0){
				$type_tic=($_SESSION['type_tic']==0)?"O":"X";
				$type_tic_opp=($_SESSION['type_tic']!=0)?"O":"X";
				?>
                <div><h4><?php echo $_SESSION['username']." (".$type_tic.")";?> VS <?php echo $player_two." (".$type_tic_opp.")";?></h4></div>

                <div class="digits">
                    <div class="<?php if($win_one == 0){echo "zero";}elseif ($win_one == 1){echo "one";}elseif ($win_one == 2){echo "two";}elseif ($win_one == 3){echo "three";}elseif ($win_one == 4){echo "four";}elseif ($win_one == 5){echo "five";}elseif ($win_one == 6){echo "six";}elseif ($win_one == 7){echo "seven";}elseif ($win_one == 8){echo "";}elseif ($win_one == 9){echo "nine";}else{echo "";}?>">
                        <span class="d1"></span>
                        <span class="d2"></span>
                        <span class="d3"></span>
                        <span class="d4"></span>
                        <span class="d5"></span>
                        <span class="d6"></span>
                        <span class="d7"></span>
                    </div>
                    <h1 style="display: inline-block">:</h1>
                    <div class="<?php if($win_two == 0){echo "zero";}elseif ($win_two == 1){echo "one";}elseif ($win_two == 2){echo "two";}elseif ($win_two == 3){echo "three";}elseif ($win_two == 4){echo "four";}elseif ($win_two == 5){echo "five";}elseif ($win_two == 6){echo "six";}elseif ($win_two == 7){echo "seven";}elseif ($win_two == 8){echo "";}elseif ($win_two == 9){echo "nine";}else{echo "";}?>">
                        <span class="d1"></span>
                        <span class="d2"></span>
                        <span class="d3"></span>
                        <span class="d4"></span>
                        <span class="d5"></span>
                        <span class="d6"></span>
                        <span class="d7"></span>
                    </div>
                </div>
                <div>
                    <h6>
						<?php if ($no_rows%2 == 0 && $_SESSION['type_tic'] == 1){
							echo $_SESSION['username']."'s turn."." (".$type_tic.")";
						}elseif ($no_rows%2 == 1 && $_SESSION['type_tic'] == 0){
							echo $_SESSION['username']."'s turn."." (".$type_tic.")";
						}else{
							echo "$player_two's turn."." (".$type_tic_opp.")";
						}?>
                    </h6>
                </div>

                <ul id="gameBoard">
					<?php for ($i=0;$i<9;$i++){ ?>
                        <li class="tic"
							<?php if ($no_rows%2 == 0 && $_SESSION['type_tic'] == 1){
								?> onclick="playerTurn(<?php echo $i;?>)" <?php
							}elseif ($no_rows%2 == 1 && $_SESSION['type_tic'] == 0) {
								?> onclick="playerTurn(<?php echo $i; ?>)" <?php
							}else{
								?> onclick="alert('It\'s opponent\'s turn.')" <?php
							}?>
                        >
							<?php echo $turns[$i];?>
                        </li>
					<?php } ?>
                </ul>
                <div class="clearfix"></div>
				<?php
			}else{
				if ($game_on[0] == 1){
					if ($_SESSION['type_tic'] == 0) {
						?>
                        <h4><?php echo $_SESSION['username'];$win_one++; ?> "O" wins! </h4>
                        <h4>You Win! </h4>
						<?php
					}else{
						?>
                        <h4><?php echo $player_two;$win_two++; ?> "O" wins! </h4>
                        <h4>You lose! </h4>
						<?php
					}
				}elseif ($game_on[1] == 1){
					if ($_SESSION['type_tic'] == 1) {
						?>
                        <h4><?php echo $_SESSION['username'];$win_one++;?> "X" wins! </h4>
                        <h4>You wins!</h4>
						<?php
					}else{
						?>
                        <h4><?php echo $player_two;$win_two++; ?> "X" wins! </h4>
                        <h4>You lose! </h4>
						<?php
					}
				}else{
					?> <h4>The game is a Draw!</h4> <?php
				}
				?>
                <div class="digits">
                    <div class="<?php if($win_one == 0){echo "zero";}elseif ($win_one == 1){echo "one";}elseif ($win_one == 2){echo "two";}elseif ($win_one == 3){echo "three";}elseif ($win_one == 4){echo "four";}elseif ($win_one == 5){echo "five";}elseif ($win_one == 6){echo "six";}elseif ($win_one == 7){echo "seven";}elseif ($win_one == 8){echo "";}elseif ($win_one == 9){echo "nine";}else{echo "";}?>">
                        <span class="d1"></span>
                        <span class="d2"></span>
                        <span class="d3"></span>
                        <span class="d4"></span>
                        <span class="d5"></span>
                        <span class="d6"></span>
                        <span class="d7"></span>
                    </div>
                    <h1 style="display: inline-block">:</h1>
                    <div class="<?php if($win_two == 0){echo "zero";}elseif ($win_two == 1){echo "one";}elseif ($win_two == 2){echo "two";}elseif ($win_two == 3){echo "three";}elseif ($win_two == 4){echo "four";}elseif ($win_two == 5){echo "five";}elseif ($win_two == 6){echo "six";}elseif ($win_two == 7){echo "seven";}elseif ($win_two == 8){echo "";}elseif ($win_two == 9){echo "nine";}else{echo "";}?>">
                        <span class="d1"></span>
                        <span class="d2"></span>
                        <span class="d3"></span>
                        <span class="d4"></span>
                        <span class="d5"></span>
                        <span class="d6"></span>
                        <span class="d7"></span>
                    </div>
                </div>
                <footer>
                    <a href="code.php?game=newGame&win_one=<?php echo $win_one;?>&win_two=<?php echo $win_two;?>" id="submit">New Game!</a>
                    <a href="index.php" id="submit">Game Again!</a>
                </footer>
				<?php
			}
		}else{
			echo "<div><h4>".$_SESSION['username']." , Please wait until opponent join</h4></div>";
		}
	}else{
		echo "<script>window.location='index.php'</script>";

	}
}elseif (isset($_GET['game']) && $_GET['game'] == 'playerTurn') {
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$stmt_slot = mysqli_query ( $website, "SELECT * FROM in_game WHERE slot ='".$_POST['slot']."' AND game_id ='".$_SESSION['game_id']."' ") or die( mysqli_error ( $website ) );
		if ( mysqli_num_rows ($stmt_slot) == 0 ){
			mysqli_query ( $website, "INSERT INTO in_game (user_id, slot, game_id, type_tic) VALUES ( '".$_SESSION['user_id']."' ,'".$_POST['slot']."' , '".$_SESSION['game_id']."' , '".$_SESSION['type_tic']."' )") or die( mysqli_error ( $website ) );
		}
	}
}elseif (isset($_GET['game']) && $_GET['game'] == 'newGame') {
    mysqli_query ( $website, "UPDATE game SET win_two = '".$_GET['win_two']."', win_one ='".$_GET['win_one']."' WHERE game_id = '".$_SESSION['game_id']."' ") or die( mysqli_error ( $website ) );
	mysqli_query ( $website, "DELETE FROM in_game WHERE game_id ='".$_SESSION['game_id']."' ") or die( mysqli_error ( $website ) );
	echo "<script>window.location='in_game.php'</script>";
}
?>
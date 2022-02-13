<?php
require 'lib/functions.php';
$chars = require 'lib/characters.php';
session_start();
if ( isset( $_GET['newBattle'] ) ) {
	unset( $_SESSION['battle'] );
}
$battle = $_SESSION['battle'];
if ( $battle === null && isset( $_GET['player1'], $_GET['player2'] ) ) {
	if ( isset( $chars[$_GET['player1']], $chars[$_GET['player2']] ) ) {
		startBattle( $chars[$_GET['player1']], $chars[$_GET['player2']] );
		$battle = $_SESSION['battle'];
	}
} elseif ( isset( $_POST['attack'], $_POST['block'] ) ) {
	runRound( $_POST['attack'], $_POST['block'] );
}

if ( isset( $_SESSION['battle']['player1'], $_SESSION['battle']['player2'] ) ) {
	$player1 = $_SESSION['battle']['player1'];
	$player2 = $_SESSION['battle']['player2'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Character Battle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="<?php echo $battle !== null ? 'd-none' : '' ?>">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Выберите бойцов</h1>
            </div>
        </div>
        <form action="/battle.php" method="GET">
            <div class="row">
                <div class="col-2 offset-3">
                    <select class="form-select" name="player1">
											<?php
											foreach ( $chars as $key => $char ): ?>
                          <option value="<?php echo $key ?>"><?php echo $char['name'] ?></option>
											<?php
											endforeach; ?>
                    </select>
                </div>
                <div class="col-1 text-center mt-2">VS</div>
                <div class="col-2">
                    <select class="form-select" name="player2">
											<?php
											foreach ( $chars as $key => $char ): ?>
                          <option value="<?php echo $key ?>"><?php echo $char['name'] ?></option>
											<?php
											endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-5 mt-3 mb-3 offset-3">
                    <button type="submit" class="btn btn-secondary w-100">В бой!</button>
                </div>
            </div>
        </form>
    </div>

    <!--    Battle-->
    <div class="row">
        <div class="col-3">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">
                        <strong><?php echo $player1['name'] ?></strong>
                    </h4>
                </div>
                <div class="col-12">
                    <div class="progress mt-2 mb-2">
                        <div class="progress-bar" role="progressbar"
                             style="width: <?php echo $player1['hp_current'] / $player1['hp_max'] * 100 ?>%; background-color: red;"
                             aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="col-12">
                    <img src="<?php echo $player1['image'] ?>" alt="Player1" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="col-6 pt-5">
					<?php if ( $player1['hp_current'] >= 0 && $player2['hp_current'] >= 0 ): ?>
              <form action="#" method="post">
                  <div class="row">
                      <div class="col-6">
                          <div class="row">
                              <div class="col-12">
                                  <h5>Атака</h5>
                              </div>
                              <div class="col-12">
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="attack" value="head"
                                             id="attack-head">
                                      <label class="form-check-label" for="attack-head">
                                          Голова
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="attack" value="body"
                                             id="attack-body">
                                      <label class="form-check-label" for="attack-body">
                                          Тело
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="attack" value="waist"
                                             id="attack-waist">
                                      <label class="form-check-label" for="attack-waist">
                                          Пояс
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="attack" value="legs"
                                             id="attack-legs">
                                      <label class="form-check-label" for="attack-legs">
                                          Ноги
                                      </label>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-6">
                          <div class="row">
                              <div class="col-12">
                                  <h5>Блок</h5>
                              </div>
                              <div class="col-12">
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="block" value="head"
                                             id="block-head">
                                      <label class="form-check-label" for="block-head">
                                          Голова
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="block" value="body"
                                             id="block-body">
                                      <label class="form-check-label" for="block-body">
                                          Тело
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="block" value="waist"
                                             id="block-waist">
                                      <label class="form-check-label" for="block-waist">
                                          Пояс
                                      </label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="block" value="legs"
                                             id="block-legs">
                                      <label class="form-check-label" for="block-legs">
                                          Ноги
                                      </label>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-12 mt-2">
                          <button type="submit" class="btn btn-danger w-100">Ударить</button>
                      </div>
                  </div>
              </form>
					<?php else: ?>
              <div class="col-12">
                  <div class="alert alert-success text-center">
										<?php if ( $player1['hp_current'] <= 0 && $player2['hp_current'] <= 0 ): ?>
                        Ничья!
										<?php elseif ( $player1['hp_current'] <= 0 ): ?>
                        Победил <strong><?php echo $player2['name'] ?></strong>
										<?php else: ?>
                        Победил <strong><?php echo $player1['name'] ?></strong>
										<?php endif ?>
                  </div>
              </div>
					<?php endif; ?>

            <div class="col-12">
							<?php
							foreach ( $_SESSION['battle']['rounds'] as $round ): ?>
                  <p><?php echo $round ?></p>
							<?php
							endforeach; ?>
            </div>
            <div class="col-12 mt-5">
                <form action="#" method="get">
                    <input type="hidden" name="newBattle">
                    <button type="submit" class="btn btn-success">Новая битва!</button>
                </form>
            </div>
        </div>

        <div class="col-3">
            <div class="col-12">
                <h4 class="text-center">
                    <strong><?php echo $player2['name'] ?></strong>
                </h4>
            </div>
            <div class="col-12">
                <div class="progress mt-2 mb-2">
                    <div class="progress-bar" role="progressbar"
                         style="width: <?php echo $player2['hp_current'] / $player2['hp_max'] * 100 ?>%; background-color: red;"
                         aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-12">
                <img src="<?php echo $player2['image'] ?>" alt="Player2" class="img-fluid">
            </div>
        </div>
    </div>
</div>
</body>
</html>

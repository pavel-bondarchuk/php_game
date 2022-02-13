<?php
$chars       = require 'lib/characters.php';
$charName    = $_GET['char'];
$currentChar = $chars[$charName];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Template page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
					<?php if ( $currentChar !== null ): ?>
                        <div class="row">
                            <div class="col-12">
                                <h2 class="text-center mt-2 mb-2"><?php echo $currentChar['name'];?></h2>
                            </div>
                            <div class="col-4">
                                <img src="<?php echo $currentChar['image'];?>" class="img-fluid">
                            </div>
                            <div class="col-8">
                                <div class="row stats">
                                    <div class="col-12">
                                        <h4>Характеристики</h4>
                                    </div>
                                    <div class="col-12 mt-2 mb-2">
                                        <div class="row">
                                            <div class="col">Сила:</div>
                                            <div class="col">
                                                <strong><?php echo $currentChar['stats']['force'];?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 mb-2">
                                        <div class="row">
                                            <div class="col">Ловкость:</div>
                                            <div class="col">
                                                <strong><?php echo $currentChar['stats']['agility'];?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 mb-2">
                                        <div class="row">
                                            <div class="col">Интуиция:</div>
                                            <div class="col">
                                                <strong><?php echo $currentChar['stats']['instinct'];?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 mb-2">
                                        <div class="row">
                                            <div class="col">Стойкость:</div>
                                            <div class="col">
                                                <strong><?php echo $currentChar['stats']['stamina'];?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 mb-2">
                                        <div class="row">
                                            <div class="col">История:</div>
                                            <div class="col">
                                                <strong><?php echo $currentChar['history'];?></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php else: ?>
<div class="row">
    <div class="col-12 mt-3">
        <div class="alert alert-danger" role="alert">
            Такого персонажа не существует!
        </div>
    </div>
</div>
					<?php endif; ?>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-12 mt-3">
                    <h4>Другие бойцы</h4>
                </div>
							<?php foreach ( $chars as $key => $char ): ?>
                  <div class="col-12">
                      <a href="/char.php?char=<?php echo $key ?>"><?php echo $char['name']; ?></a>
                  </div>
							<?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php

const BODY_PARTS = [ 'head', 'body', 'weist', 'legs' ];

function startBattle( array $player1, array $player2 ) {
	$player1['hp_max']             = calculateMaxHp( $player1 );
	$player1['hp_current']         = $player1['hp_max'];
	$player2['hp_max']             = calculateMaxHp( $player2 );
	$player2['hp_current']         = $player2['hp_max'];
	$_SESSION['battle']['player1'] = $player1;
	$_SESSION['battle']['player2'] = $player2;
	$_SESSION['battle']['rounds']  = [];
}

function calculateMaxHp( array $player ) {
	return $player['stats']['stamina'] * 10;
}

function runRound( string $attack, string $block ) {
	$player1                       = $_SESSION['battle']['player1'];
	$player2                       = $_SESSION['battle']['player2'];
	$player2Attack                 = BODY_PARTS[array_rand( BODY_PARTS )];
	$player2Block                  = BODY_PARTS[array_rand( BODY_PARTS )];
	$player2                       = kick( $player1, $player2, $attack, $player2Block );
	$player1                       = kick( $player2, $player1, $player2Attack, $block );
	$_SESSION['battle']['player1'] = $player1;
	$_SESSION['battle']['player2'] = $player2;
	if ( count( $_SESSION['battle']['rounds'] ) > 20 ) {
		$_SESSION['battle']['rounds'] = array_slice( $_SESSION['battle']['rounds'], 0, 20 );
	}
}

function kick( array $attacker, array $blocker, string $attack, string $block ) {
	if ( $attack === $block ) {
		array_unshift(
				$_SESSION['battle']['rounds'],
				sprintf(
						'<strong>%s</strong> пытался нанести удар, но <strong>%s</strong> успешно заблокировал',
						$attacker['name'],
						$blocker['name']
				)
		);
		return $blocker;
	}
	if ( isDodged( $attacker['stats']['agility'], $blocker['stats']['agility'] ) ) {
		array_unshift(
				$_SESSION['battle']['rounds'],
				sprintf(
						'<strong>%s</strong> успешно уклоняется от удара <strong>%s</strong>',
						$blocker['name'],
						$attacker['name']
				)
		);
		return $blocker;
	}
	$damage                = calculateDamage( $attacker, $blocker );
	$blocker['hp_current'] -= $damage;
	array_unshift(
			$_SESSION['battle']['rounds'],
			sprintf(
					'<strong>%s</strong> наносит ошеломляющий удар по <strong>%s</strong>, нанося <strong style="color: red">%d</strong>',
					$attacker['name'],
					$blocker['name'],
					$damage
			)
	);
	return $blocker;
}

function isDodged( int $attackerAgility, int $blockerAgility ) {
	if ( $attackerAgility >= $blockerAgility ) {
		return mt_rand( 0, 100 ) <= 1;
	}

	return mt_rand( 0, 10 ) < $blockerAgility - $attackerAgility;
}

function isCritical( int $attackerInstinct, int $blockerInstinct ) {
	if ( $attackerInstinct <= $blockerInstinct ) {
		return mt_rand( 0, 20 ) <= 1;
	}

	return mt_rand( 0, 10 ) < $attackerInstinct - $blockerInstinct;
}

function calculateDamage( array $attacker, array $blocker ) {
	$damage = (int) ( $attacker['stats']['force'] * rand( 9, 15 ) / 10 );
	if ( isCritical( $attacker['stats']['instinct'], $blocker['stats']['instinct'] ) ) {
		$damage = (int) ( $damage * rand( 11, 15 ) / 10 );
	}
	return $damage;
}
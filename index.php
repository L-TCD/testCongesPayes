<?php

//0. Données de départ
$debutTravail = new DateTime('2021-01-01');
$finTravail = new DateTime('2022-12-31');
$interruptionTravail = [
	[true, "2022-04-07", "2022-04-10"],
	[true, "2022-10-01", "2022-11-15"],
	[false, "2022-04-17", "2022-04-20"]
];

echo "Date de début: ".$debutTravail->format('Y-m-d')." (premier jour travaillé)<br>";
echo "Date de fin: ".$finTravail->format('Y-m-d')." (dernier jour travaillé)<br>";
echo "Interruptions temps de travail:<br>";

foreach($interruptionTravail as $value) {
	if ($value[0] === true) {
		echo "- du $value[1] au $value[2] avec interruption acquisition CP.<br>";
	} else {
		echo "- du $value[1] au $value[2] sans interruption acquisition CP.<br>";
	}
}
echo "<br> -------------- <br>";

//1. Lister les jours entre début et fin travail
$dateEnCours = clone $debutTravail;
$listeJoursTravailles = [];
$unJour = new DateInterval('P1D');

do {
	$listeJoursTravailles[] = $dateEnCours->format('Y-m-d');
	$dateEnCours->add($unJour);
} while ($dateEnCours <= $finTravail);

//2. Supprimer les jours avec interruption travail ET interruption CP
foreach ($interruptionTravail as $key => $value) {
	if ($value[0] === true) {
		$d1 = new DateTime($value[1]);
		$d2 = new DateTime($value[2]);
		do {
			if (in_array($d1->format('Y-m-d'), $listeJoursTravailles)) {
				$k = array_search($d1->format('Y-m-d'), $listeJoursTravailles);
				unset($listeJoursTravailles[$k]);
			}
			$d1->add($unJour);
		} while ($d1 <= $d2);
	}
}

//3. Trier les jours travaillés par mois
$tableauJoursTriesParMois = [];

foreach ($listeJoursTravailles as $key => $value) {
	$jourEnCours = new DateTime($value);
	$moisEnCours = $jourEnCours->format("m");
	$annéeEnCours = $jourEnCours->format("Y");
	$tableauJoursTriesParMois[$annéeEnCours][$moisEnCours][] = $value;
}

//4. Calculer les jours pour chaque mois.
for($y = 2020; $y <= 2022; $y++) {
	$cpAnnee = 0;
	$reste = 0;
	for ($m = 1; $m <= 12; $m++) {
		$year = sprintf("%04d", $y);
		$month = sprintf("%02d", $m);
		if (array_key_exists($year, $tableauJoursTriesParMois))
		{
			if (array_key_exists($month, $tableauJoursTriesParMois[$year]))
			{
				$nombreDeJoursTravailles = count($tableauJoursTriesParMois[$year][$month]);
				$nombreJoursMois = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$calc = $nombreDeJoursTravailles/$nombreJoursMois*(25/12);
				$cpDuMois = round($calc*2, 0)/2;
				$reste += $calc - $cpDuMois;
				if ($reste >= 0.5) {
					$cpDuMois += 0.5;
					$reste -= 0.5;
				}
				$cpAnnee += $cpDuMois;
				$resteArrondis = round($reste, 2);


				$texte = "Pour la période $year-$month: Il y a " . $nombreDeJoursTravailles ." jours travaillés et $nombreJoursMois jours dans le mois. Ce qui donne + $cpDuMois CP pour le mois (reste: $resteArrondis)<br> -------------- <br>";
				echo $texte;
			}
		}
	}
	if ($cpAnnee != 0) {echo "*** Soit $cpAnnee CP pour l'année $year. *** <br> -------------- <br><br>";}
}

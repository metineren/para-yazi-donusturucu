<?php
function bigNumberFormat($number)
{
	$exp = explode('.', $number);

	$int = str_split($exp[0]);
	krsort($int);
	$int = array_values($int);
	krsort($int);
	ksort($int);

	$nint = '';
	foreach ($int as $key => $val)
	{
		$nint = $val.(($key)%3 == 0 ? ',' : '').$nint;
	}
	$nint = trim($nint, ',');
	$dec = str_pad($exp[1], 2, 0, STR_PAD_LEFT);

	return $nint.'.'.$dec;
}

function priceToTextTR($price = 0, $currency_symbol = 'TÜRK LİRASI', $decimal_symbol = 'KURUŞ', $prefix = 'YALNIZ', $seperator = '#')
{
	$price = static::bigNumberFormat(strval($price));

	$exp = explode('.', $price);

	$int = explode(',', $exp[0]);
	foreach ($int as $key => $part)
	{
		$int[$key] = str_pad($part, 3, 0, STR_PAD_LEFT);
	}
	krsort($int);
	$int = array_values($int);
	krsort($int);
	ksort($int);

	$dec = number_format('0.'.(isset($exp[1]) && is_numeric($exp[1]) ? (int)$exp[1] : 0), 2, '.', '');
	$dec = substr_replace($dec, '', 0, 2);

	$o = array(
		'birlik' => array('bir', 'iki', 'üç', 'dört', 'beş', 'altı', 'yedi', 'sekiz', 'dokuz'),
		'onluk' => array('on', 'yirmi', 'otuz', 'kırk', 'elli', 'altmış', 'yetmiş', 'seksen', 'doksan'),
		'basamak' => array('yüz', 'bin', 'milyon', 'milyar', 'trilyon', 'katrilyon', 'kentilyon', 'seksilyon', 'septilyon', 'oktilyon', 'nonilyon ', 'desilyon', 'undesilyon', 'dodesilyon', 'tredesilyon', 'kattuordesilyon', 'kendesilyon', 'sexdesilyon', 'septendesilyon', 'oktodesilyon', 'novemdesilyon ', 'vigintilyon', 'unvigintilyon', 'dovigintilyon', 'trevigintilyon', 'kattuorvigintilyon', 'kenvigintilyon', 'sexvigintilyon', 'septenvigintilyon', 'oktovigintilyon', 'novemvigintilyon ', 'trigintilyon', 'untrigintilyon', 'dotrigintilyon', 'tretrigintilyon', 'kattuortrigintilyon', 'kentrigintilyon', 'sextrigintilyon', 'septentrigintilyon', 'oktotrigintilyon', 'novemtrigintilyon ', 'katragintilyon', 'unkatragintilyon', 'dokatragintilyon', 'trekatragintilyon', 'kattuorkatragintilyon', 'kenkatragintilyon', 'sexkatragintilyon', 'septenkatragintilyon', 'oktokatragintilyon', 'novemkatragintilyon ', 'kenquagintilyon', 'unkenquagintilyon', 'dokenquagintilyon', 'trekenquagintilyon', 'kattuorkenquagintilyon', 'kenkenquagintilyon', 'sexkenquagintilyon', 'septenkenquagintilyon', 'oktokenquagintilyon', 'novemkenquagintilyon ', 'sexagintilyon', 'unsexagintilyon', 'dosexagintilyon', 'tresexagintilyon', 'kattuorsexagintilyon', 'kensexagintilyon', 'sexsexagintilyon', 'septensexagintilyon', 'oktosexagintilyon', 'novemsexagintilyon ', 'septuagintilyon', 'unseptuagintilyon', 'doseptuagintilyon', 'treseptuagintilyon', 'kattuorseptuagintilyon', 'kenseptuagintilyon', 'sexseptuagintilyon', 'septenseptuagintilyon', 'oktoseptuagintilyon', 'novemseptuagintilyon ', 'oktogintilyon', 'unoktogintilyon', 'dooktogintilyon', 'treoktogintilyon', 'kattuoroktogintilyon', 'kenoktogintilyon', 'sexoktogintilyon', 'septenoktogintilyon', 'oktooktogintilyon', 'novemoktogintilyon ', 'nonagintilyon', 'unnonagintilyon', 'dononagintilyon', 'trenonagintilyon', 'kattuornonagintilyon', 'kennonagintilyon', 'sexnonagintilyon', 'septennonagintilyon', 'oktononagintilyon', 'novemnonagintilyon ', 'sentilyon', 'senuntilyon', 'sendotilyon', 'sentretilyon', 'senkattuortilyon', 'senkentilyon', 'sensextilyon', 'senseptentilyon', 'senoktotilyon', 'sennovemtilyon ', 'sendesilyon', 'senundesilyon', 'sendodesilyon', 'sentredesilyon', 'senkattuordesilyon', 'senkendesilyon', 'sensexdesilyon', 'senseptendesilyon', 'senoktodesilyon', 'sennovemdesilyon ', 'senvigintilyon', 'senunvigintilyon', 'sendovigintilyon', 'sentrevigintilyon', 'senkattuorvigintilyon', 'senkenvigintilyon', 'sensexvigintilyon', 'senseptenvigintilyon', 'senoktovigintilyon', 'sennovemvigintilyon ', 'sentrigintilyon', 'senuntrigintilyon', 'sendotrigintilyon', 'sentretrigintilyon', 'senkattuortrigintilyon', 'senkentrigintilyon', 'sensextrigintilyon', 'senseptentrigintilyon', 'senoktotrigintilyon', 'sennovemtrigintilyon ', 'senkatragintilyon', 'senunkatragintilyon', 'sendokatragintilyon', 'sentrekatragintilyon', 'senkattuorkatragintilyon', 'senkenkatragintilyon', 'sensexkatragintilyon', 'senseptenkatragintilyon', 'senoktokatragintilyon')
	);

	$text = '';

	foreach ($int as $key => $val)
	{
		$exp = str_split($val);
		if ($key == 0)
		{
			$prepend = '';
			if ($exp[0] && $exp[0] > 1)
				$prepend .= $o['birlik'][$exp[0]-1].' ';
			if ($exp[0] > 0)
				$prepend .= $o['basamak'][$key].' ';
			if ($exp[1])
				$prepend .= $o['onluk'][$exp[1]-1].' ';
			if ($exp[2])
				$prepend .= $o['birlik'][$exp[2]-1].' ';
			$text = $prepend.$text;
		}
		else
		{
			$prepend = '';
			if ($exp[0] && $exp[0] > 1)
				$prepend .= $o['birlik'][$exp[0]-1].' ';
			if ($exp[0] > 0)
				$prepend .= $o['basamak'][0].' ';
			if ($exp[1])
				$prepend .= $o['onluk'][$exp[1]-1].' ';
			if ($exp[2])
				$prepend .= $o['birlik'][$exp[2]-1].' ';
			$prepend .= $o['basamak'][$key].' ';
			$text = $prepend.$text;
		}
	}

	$text = trim(preg_replace('/\s\s+/', ' ', $text));

	$text .= ' '.$currency_symbol;

	if ($dec)
	{
		$dt = ' ';
		$d = str_split($dec);
		if ($d[0])
			$dt .= $o['onluk'][$d[0]-1];
		if ($d[1])
			$dt .= $o['birlik'][$d[0]-1];

		if ($dt != ' ')
			$text .= $dt.' '.$decimal_symbol;
	}
	return $prefix.' '.$seperator.$text.$seperator;
}

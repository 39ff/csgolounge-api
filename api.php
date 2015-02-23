<?php
require_once ('simple_html_dom.php');

$html = @file_get_html('http://csgolounge.com/');
$output = array();

if(!$html) exit(json_encode(array("error" => "Unable to connect to CSGO Lounge")));

// Source: http://php.net/manual/en/function.strip-tags.php#86964
function strip_tags_content($text, $tags = '', $invert = FALSE) {
	preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	$tags = array_unique($tags[1]);

	if(is_array($tags) AND count($tags) > 0) {
		if($invert == FALSE)
			return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		else
			return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
	} elseif($invert == FALSE) {
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	}

	return $text;
}

foreach($html->find('.matchmain') as $match) {
	$when = $match->find('.whenm')[0];
	$status = trim($when->find('span')[0]->plaintext) == "LIVE" ? true : false;
	$event = $match->find('.eventm')[0]->plaintext;
	$time = trim(strip_tags_content($when->innertext));
	$id = substr($match->find('a')[0]->href, 8);
        $additional = substr(trim($when->find('span')[$status ? 1 : 0]->plaintext), 4);
	$result;

	$output[$id]["live"] = $status;
	$output[$id]["time"] = $time;
	$output[$id]["event"] = $event;

	foreach($match->find('.teamtext') as $key => $team) {
		$output[$id]["teams"][$key] = array(
			"name" => $team->find('b')[0]->plaintext,
			"percent" => $team->find('i')[0]->plaintext
		);

		if(@$team->parent()->find('img')[0])
			$result = array("status" => "won", "team" => $key);
	}

	if($additional)
		$result = $additional;

	if(isset($result))
		$output[$id]["result"] = $result;
}

echo json_encode($output);

<?php
/*
*共通の関数などを記述
*
 */

	/*
	*定数設定を読み込み
	*
	*/
	require_once 'defines.php';

        /*
        *設定
	*/
        require_once 'config.php';
	
	/*
	*デバック関数
	*デバックしたい配列を入れる
	*/
	function debug(&$var, $title = '')
	{
		echo _preprint_r($var, $title);
	}
	function &_preprint_r(&$var, $title = '')
	{
		/*if (!defined('UNOH_DEV') && UNOH_DEV) {
			return '';
		}*/

		$html = '<table>';
		if ($title) {
			$html .= "<tr><th align=\"left\">$title:</th></tr>";
		}
		$html .= '<tr><td><pre>';
		$html .= htmlspecialchars(print_r($var, true));
		$html .= "</pre></td></tr></table>\n";

		return $html;
	}
	
?>

<?php declare(strict_types = 1);

namespace Nettrine\DBAL\Utils;

final class QueryUtils
{

	/**
	 * @copyright https://github.com/nextras/dbal/blob/master/src/Bridges/NetteTracy/ConnectionPanel.php#L112
	 * @copyright Nextras DBAL
	 *
	 * @param string $sql
	 * @return string
	 */
	public static function highlight(string $sql): string
	{
		static $keywords1 = 'SELECT|(?:ON\s+DUPLICATE\s+KEY)?UPDATE|INSERT(?:\s+INTO)?|REPLACE(?:\s+INTO)?|SHOW|DELETE|CALL|UNION|FROM|WHERE|HAVING|GROUP\s+BY|ORDER\s+BY|LIMIT|OFFSET|SET|VALUES|LEFT\s+JOIN|INNER\s+JOIN|TRUNCATE|START\s+TRANSACTION|COMMIT|ROLLBACK|(?:RELEASE\s+|ROLLBACK\s+TO\s+)?SAVEPOINT';
		static $keywords2 = 'ALL|DISTINCT|DISTINCTROW|IGNORE|AS|USING|ON|AND|OR|IN|IS|NOT|NULL|[RI]?LIKE|REGEXP|TRUE|FALSE';
		$sql = ' ' . $sql . ' ';
		$sql = htmlspecialchars($sql, ENT_IGNORE, 'UTF-8');
		$sql = preg_replace_callback(sprintf('#(/\\*.+?\\*/)|(?<=[\\s,(])(%s)(?=[\\s,)])|(?<=[\\s,(=])(%s)(?=[\\s,)=])#is', $keywords1, $keywords2), function ($matches) {
			if (!empty($matches[1])) { // comment
				return '<em style="color:gray">' . $matches[1] . '</em>';
			} elseif (!empty($matches[2])) { // most important keywords
				return '<strong style="color:#2D44AD">' . $matches[2] . '</strong>';
			} elseif (!empty($matches[3])) { // other keywords
				return '<strong>' . $matches[3] . '</strong>';
			}
		}, $sql);

		return trim($sql);
	}

}

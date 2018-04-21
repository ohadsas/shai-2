<?php


namespace Appthis\Model;

class Stat extends AbstractModel{
	protected static $table = 'stats';
	const COLUMN_DAY = 'day';
	const COLUMN_COUNTRY_ISO = 'country_iso';
	const COLUMN_PLATFORM_ID = 'platform_id';
	const COLUMN_PUBLISHER_ID = 'publisher_id';
	const COLUMN_IMPRESSIONS = 'impressions';
	const COLUMN_CONVERSIONS = 'conversions';

	protected static $column_map = [
		self::COLUMN_DAY => \PDO::PARAM_STR,
		self::COLUMN_COUNTRY_ISO => \PDO::PARAM_STR,
		self::COLUMN_PLATFORM_ID => \PDO::PARAM_INT,
		self::COLUMN_PUBLISHER_ID => \PDO::PARAM_INT,
		self::COLUMN_IMPRESSIONS => \PDO::PARAM_INT,
		self::COLUMN_CONVERSIONS => \PDO::PARAM_INT,
	];

	public function getByPublishers() {
		$qb = $this->getQueryBuilder();
		$qb->select(self::COLUMN_PUBLISHER_ID
			. ', SUM('. self::COLUMN_IMPRESSIONS .') AS impressions '
			. ', SUM('. self::COLUMN_CONVERSIONS .') AS conversions '
		);
		$qb->from(static::$table);
		$qb->addGroupBy(self::COLUMN_PUBLISHER_ID);
		$qb->addOrderBy('impressions', 'DESC');
		$result = $this->execute($qb);
		$result = array_map(function($entry) {
			$entry['rate'] = $entry['impressions'] == 0 ? 0 :number_format($entry['conversions'] / $entry['impressions'] * 100, 2);
			return $entry;
		}, $result);

		return $result;
	}

	public function getByDate($start = null, $end = null) {
		$qb = $this->getQueryBuilder();
		$qb->select(self::COLUMN_DAY
			. ', SUM('. self::COLUMN_IMPRESSIONS .') AS impressions '
			. ', SUM('. self::COLUMN_CONVERSIONS .') AS conversions '
		);
		$qb->from(static::$table);
		$qb->addGroupBy(self::COLUMN_DAY);
		$qb->addOrderBy(self::COLUMN_DAY, 'ASC');
		if (!empty($start)) {
			$qb->andWhere(self::COLUMN_DAY . ' >= :start');
			$qb->setParameter('start', $start, static::$columnMap[self::COLUMN_DAY]);
		}
		if (!empty($end)) {
			$qb->andWhere(self::COLUMN_DAY . ' <= :end');
			$qb->setParameter('end', $end, static::$columnMap[self::COLUMN_DAY]);
		}
		$result = $this->execute($qb);
		$result = array_map(function($entry) {
			$entry['rate'] = $entry['impressions'] == 0 ? 0 :number_format($entry['conversions'] / $entry['impressions'] * 100, 2);
			return $entry;
		}, $result);

		return $result;
	}

	public function getByPlatform($publisherId  = null) {
		$qb = $this->getQueryBuilder();
		$qb->select(self::COLUMN_DAY
			. ', ' . self::COLUMN_PLATFORM_ID
			. ', ' . self::COLUMN_COUNTRY_ISO
			. ', SUM('. self::COLUMN_IMPRESSIONS .') AS impressions '
			. ', SUM('. self::COLUMN_CONVERSIONS .') AS conversions '
		);
		$qb->from(static::$table);
		$qb->addGroupBy(self::COLUMN_DAY);
		$qb->addGroupBy(self::COLUMN_PLATFORM_ID);
		$qb->addGroupBy(self::COLUMN_COUNTRY_ISO);
		$qb->addOrderBy(self::COLUMN_DAY);
		$qb->addOrderBy(self::COLUMN_PLATFORM_ID);
		if (!empty($publisherId)) {
			$qb->where(self::COLUMN_PUBLISHER_ID . ' = :publisher_id');
			$qb->setParameter('publisher_id', $publisherId , static::$columnMap[self::COLUMN_PUBLISHER_ID]);
		}
		$result = $this->execute($qb);

		return $result;
	}
}
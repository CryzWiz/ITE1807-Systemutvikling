<?php

namespace Base;

use \Calendar as ChildCalendar;
use \CalendarQuery as ChildCalendarQuery;
use \Exception;
use \PDO;
use Map\CalendarTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'calendar' table.
 *
 * 
 *
 * @method     ChildCalendarQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCalendarQuery orderByProjectId($order = Criteria::ASC) Order by the Project_id column
 * @method     ChildCalendarQuery orderByUserId($order = Criteria::ASC) Order by the User_id column
 * @method     ChildCalendarQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildCalendarQuery orderByRegards($order = Criteria::ASC) Order by the Regards column
 * @method     ChildCalendarQuery orderByLocation($order = Criteria::ASC) Order by the Location column
 * @method     ChildCalendarQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildCalendarQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 *
 * @method     ChildCalendarQuery groupById() Group by the id column
 * @method     ChildCalendarQuery groupByProjectId() Group by the Project_id column
 * @method     ChildCalendarQuery groupByUserId() Group by the User_id column
 * @method     ChildCalendarQuery groupByName() Group by the Name column
 * @method     ChildCalendarQuery groupByRegards() Group by the Regards column
 * @method     ChildCalendarQuery groupByLocation() Group by the Location column
 * @method     ChildCalendarQuery groupByStartDate() Group by the start_date column
 * @method     ChildCalendarQuery groupByEndDate() Group by the end_date column
 *
 * @method     ChildCalendarQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCalendarQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCalendarQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCalendarQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCalendarQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCalendarQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCalendarQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method     ChildCalendarQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method     ChildCalendarQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method     ChildCalendarQuery joinWithProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Project relation
 *
 * @method     ChildCalendarQuery leftJoinWithProject() Adds a LEFT JOIN clause and with to the query using the Project relation
 * @method     ChildCalendarQuery rightJoinWithProject() Adds a RIGHT JOIN clause and with to the query using the Project relation
 * @method     ChildCalendarQuery innerJoinWithProject() Adds a INNER JOIN clause and with to the query using the Project relation
 *
 * @method     ChildCalendarQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildCalendarQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildCalendarQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildCalendarQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildCalendarQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildCalendarQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildCalendarQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     \ProjectQuery|\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCalendar findOne(ConnectionInterface $con = null) Return the first ChildCalendar matching the query
 * @method     ChildCalendar findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCalendar matching the query, or a new ChildCalendar object populated from the query conditions when no match is found
 *
 * @method     ChildCalendar findOneById(int $id) Return the first ChildCalendar filtered by the id column
 * @method     ChildCalendar findOneByProjectId(int $Project_id) Return the first ChildCalendar filtered by the Project_id column
 * @method     ChildCalendar findOneByUserId(int $User_id) Return the first ChildCalendar filtered by the User_id column
 * @method     ChildCalendar findOneByName(string $Name) Return the first ChildCalendar filtered by the Name column
 * @method     ChildCalendar findOneByRegards(string $Regards) Return the first ChildCalendar filtered by the Regards column
 * @method     ChildCalendar findOneByLocation(string $Location) Return the first ChildCalendar filtered by the Location column
 * @method     ChildCalendar findOneByStartDate(string $start_date) Return the first ChildCalendar filtered by the start_date column
 * @method     ChildCalendar findOneByEndDate(string $end_date) Return the first ChildCalendar filtered by the end_date column *

 * @method     ChildCalendar requirePk($key, ConnectionInterface $con = null) Return the ChildCalendar by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOne(ConnectionInterface $con = null) Return the first ChildCalendar matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCalendar requireOneById(int $id) Return the first ChildCalendar filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByProjectId(int $Project_id) Return the first ChildCalendar filtered by the Project_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByUserId(int $User_id) Return the first ChildCalendar filtered by the User_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByName(string $Name) Return the first ChildCalendar filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByRegards(string $Regards) Return the first ChildCalendar filtered by the Regards column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByLocation(string $Location) Return the first ChildCalendar filtered by the Location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByStartDate(string $start_date) Return the first ChildCalendar filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCalendar requireOneByEndDate(string $end_date) Return the first ChildCalendar filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCalendar[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCalendar objects based on current ModelCriteria
 * @method     ChildCalendar[]|ObjectCollection findById(int $id) Return ChildCalendar objects filtered by the id column
 * @method     ChildCalendar[]|ObjectCollection findByProjectId(int $Project_id) Return ChildCalendar objects filtered by the Project_id column
 * @method     ChildCalendar[]|ObjectCollection findByUserId(int $User_id) Return ChildCalendar objects filtered by the User_id column
 * @method     ChildCalendar[]|ObjectCollection findByName(string $Name) Return ChildCalendar objects filtered by the Name column
 * @method     ChildCalendar[]|ObjectCollection findByRegards(string $Regards) Return ChildCalendar objects filtered by the Regards column
 * @method     ChildCalendar[]|ObjectCollection findByLocation(string $Location) Return ChildCalendar objects filtered by the Location column
 * @method     ChildCalendar[]|ObjectCollection findByStartDate(string $start_date) Return ChildCalendar objects filtered by the start_date column
 * @method     ChildCalendar[]|ObjectCollection findByEndDate(string $end_date) Return ChildCalendar objects filtered by the end_date column
 * @method     ChildCalendar[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CalendarQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CalendarQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Calendar', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCalendarQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCalendarQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCalendarQuery) {
            return $criteria;
        }
        $query = new ChildCalendarQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id, $Project_id, $User_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCalendar|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CalendarTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CalendarTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCalendar A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, Project_id, User_id, Name, Regards, Location, start_date, end_date FROM calendar WHERE id = :p0 AND Project_id = :p1 AND User_id = :p2';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);            
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCalendar $obj */
            $obj = new ChildCalendar();
            $obj->hydrate($row);
            CalendarTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCalendar|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CalendarTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(CalendarTableMap::COL_USER_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CalendarTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CalendarTableMap::COL_PROJECT_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(CalendarTableMap::COL_USER_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CalendarTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CalendarTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectId(1234); // WHERE Project_id = 1234
     * $query->filterByProjectId(array(12, 34)); // WHERE Project_id IN (12, 34)
     * $query->filterByProjectId(array('min' => 12)); // WHERE Project_id > 12
     * </code>
     *
     * @see       filterByProject()
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the User_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE User_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE User_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE User_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(CalendarTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(CalendarTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the Regards column
     *
     * Example usage:
     * <code>
     * $query->filterByRegards('fooValue');   // WHERE Regards = 'fooValue'
     * $query->filterByRegards('%fooValue%', Criteria::LIKE); // WHERE Regards LIKE '%fooValue%'
     * </code>
     *
     * @param     string $regards The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByRegards($regards = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($regards)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_REGARDS, $regards, $comparison);
    }

    /**
     * Filter the query on the Location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE Location = 'fooValue'
     * $query->filterByLocation('%fooValue%', Criteria::LIKE); // WHERE Location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Filter the query on the start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE start_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(CalendarTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(CalendarTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(CalendarTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(CalendarTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CalendarTableMap::COL_END_DATE, $endDate, $comparison);
    }

    /**
     * Filter the query by a related \Project object
     *
     * @param \Project|ObjectCollection $project The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof \Project) {
            return $this
                ->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CalendarTableMap::COL_PROJECT_ID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type \Project or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function joinProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Project');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Project');
        }

        return $this;
    }

    /**
     * Use the Project relation Project object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\ProjectQuery');
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCalendarQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(CalendarTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CalendarTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCalendar $calendar Object to remove from the list of results
     *
     * @return $this|ChildCalendarQuery The current query, for fluid interface
     */
    public function prune($calendar = null)
    {
        if ($calendar) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CalendarTableMap::COL_ID), $calendar->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CalendarTableMap::COL_PROJECT_ID), $calendar->getProjectId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(CalendarTableMap::COL_USER_ID), $calendar->getUserId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the calendar table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CalendarTableMap::clearInstancePool();
            CalendarTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CalendarTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CalendarTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CalendarTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CalendarQuery

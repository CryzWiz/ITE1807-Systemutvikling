<?php

namespace Base;

use \Project as ChildProject;
use \ProjectQuery as ChildProjectQuery;
use \Exception;
use \PDO;
use Map\ProjectTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'project' table.
 *
 * 
 *
 * @method     ChildProjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProjectQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildProjectQuery orderByStart($order = Criteria::ASC) Order by the Start column
 * @method     ChildProjectQuery orderByEnd($order = Criteria::ASC) Order by the End column
 * @method     ChildProjectQuery orderByStatusId($order = Criteria::ASC) Order by the Status_id column
 *
 * @method     ChildProjectQuery groupById() Group by the id column
 * @method     ChildProjectQuery groupByName() Group by the Name column
 * @method     ChildProjectQuery groupByStart() Group by the Start column
 * @method     ChildProjectQuery groupByEnd() Group by the End column
 * @method     ChildProjectQuery groupByStatusId() Group by the Status_id column
 *
 * @method     ChildProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProjectQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProjectQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProjectQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProjectQuery leftJoinWorkStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkStatus relation
 * @method     ChildProjectQuery rightJoinWorkStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkStatus relation
 * @method     ChildProjectQuery innerJoinWorkStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkStatus relation
 *
 * @method     ChildProjectQuery joinWithWorkStatus($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkStatus relation
 *
 * @method     ChildProjectQuery leftJoinWithWorkStatus() Adds a LEFT JOIN clause and with to the query using the WorkStatus relation
 * @method     ChildProjectQuery rightJoinWithWorkStatus() Adds a RIGHT JOIN clause and with to the query using the WorkStatus relation
 * @method     ChildProjectQuery innerJoinWithWorkStatus() Adds a INNER JOIN clause and with to the query using the WorkStatus relation
 *
 * @method     ChildProjectQuery leftJoinCalendar($relationAlias = null) Adds a LEFT JOIN clause to the query using the Calendar relation
 * @method     ChildProjectQuery rightJoinCalendar($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Calendar relation
 * @method     ChildProjectQuery innerJoinCalendar($relationAlias = null) Adds a INNER JOIN clause to the query using the Calendar relation
 *
 * @method     ChildProjectQuery joinWithCalendar($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Calendar relation
 *
 * @method     ChildProjectQuery leftJoinWithCalendar() Adds a LEFT JOIN clause and with to the query using the Calendar relation
 * @method     ChildProjectQuery rightJoinWithCalendar() Adds a RIGHT JOIN clause and with to the query using the Calendar relation
 * @method     ChildProjectQuery innerJoinWithCalendar() Adds a INNER JOIN clause and with to the query using the Calendar relation
 *
 * @method     ChildProjectQuery leftJoinTeamProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the TeamProject relation
 * @method     ChildProjectQuery rightJoinTeamProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TeamProject relation
 * @method     ChildProjectQuery innerJoinTeamProject($relationAlias = null) Adds a INNER JOIN clause to the query using the TeamProject relation
 *
 * @method     ChildProjectQuery joinWithTeamProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TeamProject relation
 *
 * @method     ChildProjectQuery leftJoinWithTeamProject() Adds a LEFT JOIN clause and with to the query using the TeamProject relation
 * @method     ChildProjectQuery rightJoinWithTeamProject() Adds a RIGHT JOIN clause and with to the query using the TeamProject relation
 * @method     ChildProjectQuery innerJoinWithTeamProject() Adds a INNER JOIN clause and with to the query using the TeamProject relation
 *
 * @method     ChildProjectQuery leftJoinProjectInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectInfo relation
 * @method     ChildProjectQuery rightJoinProjectInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectInfo relation
 * @method     ChildProjectQuery innerJoinProjectInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectInfo relation
 *
 * @method     ChildProjectQuery joinWithProjectInfo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ProjectInfo relation
 *
 * @method     ChildProjectQuery leftJoinWithProjectInfo() Adds a LEFT JOIN clause and with to the query using the ProjectInfo relation
 * @method     ChildProjectQuery rightJoinWithProjectInfo() Adds a RIGHT JOIN clause and with to the query using the ProjectInfo relation
 * @method     ChildProjectQuery innerJoinWithProjectInfo() Adds a INNER JOIN clause and with to the query using the ProjectInfo relation
 *
 * @method     \WorkStatusQuery|\CalendarQuery|\TeamProjectQuery|\ProjectInfoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProject findOne(ConnectionInterface $con = null) Return the first ChildProject matching the query
 * @method     ChildProject findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProject matching the query, or a new ChildProject object populated from the query conditions when no match is found
 *
 * @method     ChildProject findOneById(int $id) Return the first ChildProject filtered by the id column
 * @method     ChildProject findOneByName(string $Name) Return the first ChildProject filtered by the Name column
 * @method     ChildProject findOneByStart(string $Start) Return the first ChildProject filtered by the Start column
 * @method     ChildProject findOneByEnd(string $End) Return the first ChildProject filtered by the End column
 * @method     ChildProject findOneByStatusId(string $Status_id) Return the first ChildProject filtered by the Status_id column *

 * @method     ChildProject requirePk($key, ConnectionInterface $con = null) Return the ChildProject by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOne(ConnectionInterface $con = null) Return the first ChildProject matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProject requireOneById(int $id) Return the first ChildProject filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByName(string $Name) Return the first ChildProject filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByStart(string $Start) Return the first ChildProject filtered by the Start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByEnd(string $End) Return the first ChildProject filtered by the End column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByStatusId(string $Status_id) Return the first ChildProject filtered by the Status_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProject[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProject objects based on current ModelCriteria
 * @method     ChildProject[]|ObjectCollection findById(int $id) Return ChildProject objects filtered by the id column
 * @method     ChildProject[]|ObjectCollection findByName(string $Name) Return ChildProject objects filtered by the Name column
 * @method     ChildProject[]|ObjectCollection findByStart(string $Start) Return ChildProject objects filtered by the Start column
 * @method     ChildProject[]|ObjectCollection findByEnd(string $End) Return ChildProject objects filtered by the End column
 * @method     ChildProject[]|ObjectCollection findByStatusId(string $Status_id) Return ChildProject objects filtered by the Status_id column
 * @method     ChildProject[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProjectQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ProjectQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Project', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProjectQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProjectQuery) {
            return $criteria;
        }
        $query = new ChildProjectQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProject|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProjectTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProjectTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProject A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, Name, Start, End, Status_id FROM project WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildProject $obj */
            $obj = new ChildProject();
            $obj->hydrate($row);
            ProjectTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProject|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the Start column
     *
     * Example usage:
     * <code>
     * $query->filterByStart('2011-03-14'); // WHERE Start = '2011-03-14'
     * $query->filterByStart('now'); // WHERE Start = '2011-03-14'
     * $query->filterByStart(array('max' => 'yesterday')); // WHERE Start > '2011-03-13'
     * </code>
     *
     * @param     mixed $start The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByStart($start = null, $comparison = null)
    {
        if (is_array($start)) {
            $useMinMax = false;
            if (isset($start['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_START, $start['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($start['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_START, $start['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_START, $start, $comparison);
    }

    /**
     * Filter the query on the End column
     *
     * Example usage:
     * <code>
     * $query->filterByEnd('2011-03-14'); // WHERE End = '2011-03-14'
     * $query->filterByEnd('now'); // WHERE End = '2011-03-14'
     * $query->filterByEnd(array('max' => 'yesterday')); // WHERE End > '2011-03-13'
     * </code>
     *
     * @param     mixed $end The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByEnd($end = null, $comparison = null)
    {
        if (is_array($end)) {
            $useMinMax = false;
            if (isset($end['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_END, $end['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($end['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_END, $end['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_END, $end, $comparison);
    }

    /**
     * Filter the query on the Status_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStatusId('fooValue');   // WHERE Status_id = 'fooValue'
     * $query->filterByStatusId('%fooValue%', Criteria::LIKE); // WHERE Status_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $statusId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByStatusId($statusId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($statusId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_STATUS_ID, $statusId, $comparison);
    }

    /**
     * Filter the query by a related \WorkStatus object
     *
     * @param \WorkStatus|ObjectCollection $workStatus The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByWorkStatus($workStatus, $comparison = null)
    {
        if ($workStatus instanceof \WorkStatus) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_STATUS_ID, $workStatus->getId(), $comparison);
        } elseif ($workStatus instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectTableMap::COL_STATUS_ID, $workStatus->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWorkStatus() only accepts arguments of type \WorkStatus or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WorkStatus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinWorkStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WorkStatus');

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
            $this->addJoinObject($join, 'WorkStatus');
        }

        return $this;
    }

    /**
     * Use the WorkStatus relation WorkStatus object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WorkStatusQuery A secondary query class using the current class as primary query
     */
    public function useWorkStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWorkStatus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WorkStatus', '\WorkStatusQuery');
    }

    /**
     * Filter the query by a related \Calendar object
     *
     * @param \Calendar|ObjectCollection $calendar the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByCalendar($calendar, $comparison = null)
    {
        if ($calendar instanceof \Calendar) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_ID, $calendar->getProjectId(), $comparison);
        } elseif ($calendar instanceof ObjectCollection) {
            return $this
                ->useCalendarQuery()
                ->filterByPrimaryKeys($calendar->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCalendar() only accepts arguments of type \Calendar or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Calendar relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinCalendar($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Calendar');

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
            $this->addJoinObject($join, 'Calendar');
        }

        return $this;
    }

    /**
     * Use the Calendar relation Calendar object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CalendarQuery A secondary query class using the current class as primary query
     */
    public function useCalendarQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCalendar($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Calendar', '\CalendarQuery');
    }

    /**
     * Filter the query by a related \TeamProject object
     *
     * @param \TeamProject|ObjectCollection $teamProject the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByTeamProject($teamProject, $comparison = null)
    {
        if ($teamProject instanceof \TeamProject) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_ID, $teamProject->getProjectId(), $comparison);
        } elseif ($teamProject instanceof ObjectCollection) {
            return $this
                ->useTeamProjectQuery()
                ->filterByPrimaryKeys($teamProject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTeamProject() only accepts arguments of type \TeamProject or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TeamProject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinTeamProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TeamProject');

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
            $this->addJoinObject($join, 'TeamProject');
        }

        return $this;
    }

    /**
     * Use the TeamProject relation TeamProject object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamProjectQuery A secondary query class using the current class as primary query
     */
    public function useTeamProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeamProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TeamProject', '\TeamProjectQuery');
    }

    /**
     * Filter the query by a related \ProjectInfo object
     *
     * @param \ProjectInfo|ObjectCollection $projectInfo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByProjectInfo($projectInfo, $comparison = null)
    {
        if ($projectInfo instanceof \ProjectInfo) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_ID, $projectInfo->getProjectId(), $comparison);
        } elseif ($projectInfo instanceof ObjectCollection) {
            return $this
                ->useProjectInfoQuery()
                ->filterByPrimaryKeys($projectInfo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectInfo() only accepts arguments of type \ProjectInfo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectInfo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinProjectInfo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectInfo');

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
            $this->addJoinObject($join, 'ProjectInfo');
        }

        return $this;
    }

    /**
     * Use the ProjectInfo relation ProjectInfo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectInfoQuery A secondary query class using the current class as primary query
     */
    public function useProjectInfoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectInfo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectInfo', '\ProjectInfoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProject $project Object to remove from the list of results
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function prune($project = null)
    {
        if ($project) {
            $this->addUsingAlias(ProjectTableMap::COL_ID, $project->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the project table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProjectTableMap::clearInstancePool();
            ProjectTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProjectTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ProjectTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ProjectTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProjectQuery

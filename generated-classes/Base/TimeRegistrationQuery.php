<?php

namespace Base;

use \TimeRegistration as ChildTimeRegistration;
use \TimeRegistrationQuery as ChildTimeRegistrationQuery;
use \Exception;
use \PDO;
use Map\TimeRegistrationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'timeregistration' table.
 *
 * 
 *
 * @method     ChildTimeRegistrationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTimeRegistrationQuery orderByUserId($order = Criteria::ASC) Order by the User_id column
 * @method     ChildTimeRegistrationQuery orderByTeamId($order = Criteria::ASC) Order by the Team_id column
 * @method     ChildTimeRegistrationQuery orderByTaskId($order = Criteria::ASC) Order by the Task_id column
 * @method     ChildTimeRegistrationQuery orderByStart($order = Criteria::ASC) Order by the Start column
 * @method     ChildTimeRegistrationQuery orderByStop($order = Criteria::ASC) Order by the Stop column
 * @method     ChildTimeRegistrationQuery orderByPlace($order = Criteria::ASC) Order by the Place column
 * @method     ChildTimeRegistrationQuery orderByPredefinedtask($order = Criteria::ASC) Order by the PredefinedTask column
 * @method     ChildTimeRegistrationQuery orderByComment($order = Criteria::ASC) Order by the Comment column
 * @method     ChildTimeRegistrationQuery orderByApproved($order = Criteria::ASC) Order by the Approved column
 * @method     ChildTimeRegistrationQuery orderByActive($order = Criteria::ASC) Order by the Active column
 *
 * @method     ChildTimeRegistrationQuery groupById() Group by the id column
 * @method     ChildTimeRegistrationQuery groupByUserId() Group by the User_id column
 * @method     ChildTimeRegistrationQuery groupByTeamId() Group by the Team_id column
 * @method     ChildTimeRegistrationQuery groupByTaskId() Group by the Task_id column
 * @method     ChildTimeRegistrationQuery groupByStart() Group by the Start column
 * @method     ChildTimeRegistrationQuery groupByStop() Group by the Stop column
 * @method     ChildTimeRegistrationQuery groupByPlace() Group by the Place column
 * @method     ChildTimeRegistrationQuery groupByPredefinedtask() Group by the PredefinedTask column
 * @method     ChildTimeRegistrationQuery groupByComment() Group by the Comment column
 * @method     ChildTimeRegistrationQuery groupByApproved() Group by the Approved column
 * @method     ChildTimeRegistrationQuery groupByActive() Group by the Active column
 *
 * @method     ChildTimeRegistrationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTimeRegistrationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTimeRegistrationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTimeRegistrationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTimeRegistrationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTimeRegistrationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTimeRegistrationQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildTimeRegistrationQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildTimeRegistrationQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildTimeRegistrationQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildTimeRegistrationQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildTimeRegistrationQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildTimeRegistrationQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildTimeRegistrationQuery leftJoinTask($relationAlias = null) Adds a LEFT JOIN clause to the query using the Task relation
 * @method     ChildTimeRegistrationQuery rightJoinTask($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Task relation
 * @method     ChildTimeRegistrationQuery innerJoinTask($relationAlias = null) Adds a INNER JOIN clause to the query using the Task relation
 *
 * @method     ChildTimeRegistrationQuery joinWithTask($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Task relation
 *
 * @method     ChildTimeRegistrationQuery leftJoinWithTask() Adds a LEFT JOIN clause and with to the query using the Task relation
 * @method     ChildTimeRegistrationQuery rightJoinWithTask() Adds a RIGHT JOIN clause and with to the query using the Task relation
 * @method     ChildTimeRegistrationQuery innerJoinWithTask() Adds a INNER JOIN clause and with to the query using the Task relation
 *
 * @method     ChildTimeRegistrationQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildTimeRegistrationQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildTimeRegistrationQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildTimeRegistrationQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildTimeRegistrationQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildTimeRegistrationQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildTimeRegistrationQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \UserQuery|\TaskQuery|\TeamQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTimeRegistration findOne(ConnectionInterface $con = null) Return the first ChildTimeRegistration matching the query
 * @method     ChildTimeRegistration findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTimeRegistration matching the query, or a new ChildTimeRegistration object populated from the query conditions when no match is found
 *
 * @method     ChildTimeRegistration findOneById(int $id) Return the first ChildTimeRegistration filtered by the id column
 * @method     ChildTimeRegistration findOneByUserId(int $User_id) Return the first ChildTimeRegistration filtered by the User_id column
 * @method     ChildTimeRegistration findOneByTeamId(int $Team_id) Return the first ChildTimeRegistration filtered by the Team_id column
 * @method     ChildTimeRegistration findOneByTaskId(int $Task_id) Return the first ChildTimeRegistration filtered by the Task_id column
 * @method     ChildTimeRegistration findOneByStart(string $Start) Return the first ChildTimeRegistration filtered by the Start column
 * @method     ChildTimeRegistration findOneByStop(string $Stop) Return the first ChildTimeRegistration filtered by the Stop column
 * @method     ChildTimeRegistration findOneByPlace(string $Place) Return the first ChildTimeRegistration filtered by the Place column
 * @method     ChildTimeRegistration findOneByPredefinedtask(string $PredefinedTask) Return the first ChildTimeRegistration filtered by the PredefinedTask column
 * @method     ChildTimeRegistration findOneByComment(string $Comment) Return the first ChildTimeRegistration filtered by the Comment column
 * @method     ChildTimeRegistration findOneByApproved(boolean $Approved) Return the first ChildTimeRegistration filtered by the Approved column
 * @method     ChildTimeRegistration findOneByActive(string $Active) Return the first ChildTimeRegistration filtered by the Active column *

 * @method     ChildTimeRegistration requirePk($key, ConnectionInterface $con = null) Return the ChildTimeRegistration by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOne(ConnectionInterface $con = null) Return the first ChildTimeRegistration matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTimeRegistration requireOneById(int $id) Return the first ChildTimeRegistration filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByUserId(int $User_id) Return the first ChildTimeRegistration filtered by the User_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByTeamId(int $Team_id) Return the first ChildTimeRegistration filtered by the Team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByTaskId(int $Task_id) Return the first ChildTimeRegistration filtered by the Task_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByStart(string $Start) Return the first ChildTimeRegistration filtered by the Start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByStop(string $Stop) Return the first ChildTimeRegistration filtered by the Stop column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByPlace(string $Place) Return the first ChildTimeRegistration filtered by the Place column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByPredefinedtask(string $PredefinedTask) Return the first ChildTimeRegistration filtered by the PredefinedTask column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByComment(string $Comment) Return the first ChildTimeRegistration filtered by the Comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByApproved(boolean $Approved) Return the first ChildTimeRegistration filtered by the Approved column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTimeRegistration requireOneByActive(string $Active) Return the first ChildTimeRegistration filtered by the Active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTimeRegistration[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTimeRegistration objects based on current ModelCriteria
 * @method     ChildTimeRegistration[]|ObjectCollection findById(int $id) Return ChildTimeRegistration objects filtered by the id column
 * @method     ChildTimeRegistration[]|ObjectCollection findByUserId(int $User_id) Return ChildTimeRegistration objects filtered by the User_id column
 * @method     ChildTimeRegistration[]|ObjectCollection findByTeamId(int $Team_id) Return ChildTimeRegistration objects filtered by the Team_id column
 * @method     ChildTimeRegistration[]|ObjectCollection findByTaskId(int $Task_id) Return ChildTimeRegistration objects filtered by the Task_id column
 * @method     ChildTimeRegistration[]|ObjectCollection findByStart(string $Start) Return ChildTimeRegistration objects filtered by the Start column
 * @method     ChildTimeRegistration[]|ObjectCollection findByStop(string $Stop) Return ChildTimeRegistration objects filtered by the Stop column
 * @method     ChildTimeRegistration[]|ObjectCollection findByPlace(string $Place) Return ChildTimeRegistration objects filtered by the Place column
 * @method     ChildTimeRegistration[]|ObjectCollection findByPredefinedtask(string $PredefinedTask) Return ChildTimeRegistration objects filtered by the PredefinedTask column
 * @method     ChildTimeRegistration[]|ObjectCollection findByComment(string $Comment) Return ChildTimeRegistration objects filtered by the Comment column
 * @method     ChildTimeRegistration[]|ObjectCollection findByApproved(boolean $Approved) Return ChildTimeRegistration objects filtered by the Approved column
 * @method     ChildTimeRegistration[]|ObjectCollection findByActive(string $Active) Return ChildTimeRegistration objects filtered by the Active column
 * @method     ChildTimeRegistration[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TimeRegistrationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TimeRegistrationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\TimeRegistration', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTimeRegistrationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTimeRegistrationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTimeRegistrationQuery) {
            return $criteria;
        }
        $query = new ChildTimeRegistrationQuery();
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
     * @return ChildTimeRegistration|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TimeRegistrationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TimeRegistrationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTimeRegistration A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, User_id, Team_id, Task_id, Start, Stop, Place, PredefinedTask, Comment, Approved, Active FROM timeregistration WHERE id = :p0';
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
            /** @var ChildTimeRegistration $obj */
            $obj = new ChildTimeRegistration();
            $obj->hydrate($row);
            TimeRegistrationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTimeRegistration|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the Team_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamId(1234); // WHERE Team_id = 1234
     * $query->filterByTeamId(array(12, 34)); // WHERE Team_id IN (12, 34)
     * $query->filterByTeamId(array('min' => 12)); // WHERE Team_id > 12
     * </code>
     *
     * @see       filterByTeam()
     *
     * @param     mixed $teamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Filter the query on the Task_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTaskId(1234); // WHERE Task_id = 1234
     * $query->filterByTaskId(array(12, 34)); // WHERE Task_id IN (12, 34)
     * $query->filterByTaskId(array('min' => 12)); // WHERE Task_id > 12
     * </code>
     *
     * @see       filterByTask()
     *
     * @param     mixed $taskId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByTaskId($taskId = null, $comparison = null)
    {
        if (is_array($taskId)) {
            $useMinMax = false;
            if (isset($taskId['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_TASK_ID, $taskId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($taskId['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_TASK_ID, $taskId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_TASK_ID, $taskId, $comparison);
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
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByStart($start = null, $comparison = null)
    {
        if (is_array($start)) {
            $useMinMax = false;
            if (isset($start['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_START, $start['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($start['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_START, $start['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_START, $start, $comparison);
    }

    /**
     * Filter the query on the Stop column
     *
     * Example usage:
     * <code>
     * $query->filterByStop('2011-03-14'); // WHERE Stop = '2011-03-14'
     * $query->filterByStop('now'); // WHERE Stop = '2011-03-14'
     * $query->filterByStop(array('max' => 'yesterday')); // WHERE Stop > '2011-03-13'
     * </code>
     *
     * @param     mixed $stop The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByStop($stop = null, $comparison = null)
    {
        if (is_array($stop)) {
            $useMinMax = false;
            if (isset($stop['min'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_STOP, $stop['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stop['max'])) {
                $this->addUsingAlias(TimeRegistrationTableMap::COL_STOP, $stop['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_STOP, $stop, $comparison);
    }

    /**
     * Filter the query on the Place column
     *
     * Example usage:
     * <code>
     * $query->filterByPlace('fooValue');   // WHERE Place = 'fooValue'
     * $query->filterByPlace('%fooValue%', Criteria::LIKE); // WHERE Place LIKE '%fooValue%'
     * </code>
     *
     * @param     string $place The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByPlace($place = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($place)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_PLACE, $place, $comparison);
    }

    /**
     * Filter the query on the PredefinedTask column
     *
     * Example usage:
     * <code>
     * $query->filterByPredefinedtask('fooValue');   // WHERE PredefinedTask = 'fooValue'
     * $query->filterByPredefinedtask('%fooValue%', Criteria::LIKE); // WHERE PredefinedTask LIKE '%fooValue%'
     * </code>
     *
     * @param     string $predefinedtask The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByPredefinedtask($predefinedtask = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($predefinedtask)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_PREDEFINEDTASK, $predefinedtask, $comparison);
    }

    /**
     * Filter the query on the Comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE Comment = 'fooValue'
     * $query->filterByComment('%fooValue%', Criteria::LIKE); // WHERE Comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the Approved column
     *
     * Example usage:
     * <code>
     * $query->filterByApproved(true); // WHERE Approved = true
     * $query->filterByApproved('yes'); // WHERE Approved = true
     * </code>
     *
     * @param     boolean|string $approved The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByApproved($approved = null, $comparison = null)
    {
        if (is_string($approved)) {
            $approved = in_array(strtolower($approved), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_APPROVED, $approved, $comparison);
    }

    /**
     * Filter the query on the Active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive('fooValue');   // WHERE Active = 'fooValue'
     * $query->filterByActive('%fooValue%', Criteria::LIKE); // WHERE Active LIKE '%fooValue%'
     * </code>
     *
     * @param     string $active The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($active)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TimeRegistrationTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
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
     * Filter the query by a related \Task object
     *
     * @param \Task|ObjectCollection $task The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByTask($task, $comparison = null)
    {
        if ($task instanceof \Task) {
            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_TASK_ID, $task->getId(), $comparison);
        } elseif ($task instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_TASK_ID, $task->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTask() only accepts arguments of type \Task or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Task relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function joinTask($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Task');

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
            $this->addJoinObject($join, 'Task');
        }

        return $this;
    }

    /**
     * Use the Task relation Task object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TaskQuery A secondary query class using the current class as primary query
     */
    public function useTaskQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTask($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Task', '\TaskQuery');
    }

    /**
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TimeRegistrationTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTeam() only accepts arguments of type \Team or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Team relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function joinTeam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Team');

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
            $this->addJoinObject($join, 'Team');
        }

        return $this;
    }

    /**
     * Use the Team relation Team object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamQuery A secondary query class using the current class as primary query
     */
    public function useTeamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Team', '\TeamQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTimeRegistration $timeRegistration Object to remove from the list of results
     *
     * @return $this|ChildTimeRegistrationQuery The current query, for fluid interface
     */
    public function prune($timeRegistration = null)
    {
        if ($timeRegistration) {
            $this->addUsingAlias(TimeRegistrationTableMap::COL_ID, $timeRegistration->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the timeregistration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TimeRegistrationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TimeRegistrationTableMap::clearInstancePool();
            TimeRegistrationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TimeRegistrationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TimeRegistrationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TimeRegistrationTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TimeRegistrationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TimeRegistrationQuery

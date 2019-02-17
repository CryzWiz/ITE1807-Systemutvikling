<?php

namespace Base;

use \Task as ChildTask;
use \TaskQuery as ChildTaskQuery;
use \Exception;
use \PDO;
use Map\TaskTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'task' table.
 *
 * 
 *
 * @method     ChildTaskQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTaskQuery orderByProjectId($order = Criteria::ASC) Order by the Project_id column
 * @method     ChildTaskQuery orderByTeamId($order = Criteria::ASC) Order by the Team_id column
 * @method     ChildTaskQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildTaskQuery orderByStart($order = Criteria::ASC) Order by the Start column
 * @method     ChildTaskQuery orderByEnd($order = Criteria::ASC) Order by the End column
 * @method     ChildTaskQuery orderByPlannedhours($order = Criteria::ASC) Order by the PlannedHours column
 * @method     ChildTaskQuery orderByDependentId($order = Criteria::ASC) Order by the Dependent_id column
 * @method     ChildTaskQuery orderByStatusId($order = Criteria::ASC) Order by the Status_id column
 *
 * @method     ChildTaskQuery groupById() Group by the id column
 * @method     ChildTaskQuery groupByProjectId() Group by the Project_id column
 * @method     ChildTaskQuery groupByTeamId() Group by the Team_id column
 * @method     ChildTaskQuery groupByName() Group by the Name column
 * @method     ChildTaskQuery groupByStart() Group by the Start column
 * @method     ChildTaskQuery groupByEnd() Group by the End column
 * @method     ChildTaskQuery groupByPlannedhours() Group by the PlannedHours column
 * @method     ChildTaskQuery groupByDependentId() Group by the Dependent_id column
 * @method     ChildTaskQuery groupByStatusId() Group by the Status_id column
 *
 * @method     ChildTaskQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTaskQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTaskQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTaskQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTaskQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTaskQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTaskQuery leftJoinWorkStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkStatus relation
 * @method     ChildTaskQuery rightJoinWorkStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkStatus relation
 * @method     ChildTaskQuery innerJoinWorkStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkStatus relation
 *
 * @method     ChildTaskQuery joinWithWorkStatus($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkStatus relation
 *
 * @method     ChildTaskQuery leftJoinWithWorkStatus() Adds a LEFT JOIN clause and with to the query using the WorkStatus relation
 * @method     ChildTaskQuery rightJoinWithWorkStatus() Adds a RIGHT JOIN clause and with to the query using the WorkStatus relation
 * @method     ChildTaskQuery innerJoinWithWorkStatus() Adds a INNER JOIN clause and with to the query using the WorkStatus relation
 *
 * @method     ChildTaskQuery leftJoinTeamProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the TeamProject relation
 * @method     ChildTaskQuery rightJoinTeamProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TeamProject relation
 * @method     ChildTaskQuery innerJoinTeamProject($relationAlias = null) Adds a INNER JOIN clause to the query using the TeamProject relation
 *
 * @method     ChildTaskQuery joinWithTeamProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TeamProject relation
 *
 * @method     ChildTaskQuery leftJoinWithTeamProject() Adds a LEFT JOIN clause and with to the query using the TeamProject relation
 * @method     ChildTaskQuery rightJoinWithTeamProject() Adds a RIGHT JOIN clause and with to the query using the TeamProject relation
 * @method     ChildTaskQuery innerJoinWithTeamProject() Adds a INNER JOIN clause and with to the query using the TeamProject relation
 *
 * @method     ChildTaskQuery leftJoinTimeRegistration($relationAlias = null) Adds a LEFT JOIN clause to the query using the TimeRegistration relation
 * @method     ChildTaskQuery rightJoinTimeRegistration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TimeRegistration relation
 * @method     ChildTaskQuery innerJoinTimeRegistration($relationAlias = null) Adds a INNER JOIN clause to the query using the TimeRegistration relation
 *
 * @method     ChildTaskQuery joinWithTimeRegistration($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TimeRegistration relation
 *
 * @method     ChildTaskQuery leftJoinWithTimeRegistration() Adds a LEFT JOIN clause and with to the query using the TimeRegistration relation
 * @method     ChildTaskQuery rightJoinWithTimeRegistration() Adds a RIGHT JOIN clause and with to the query using the TimeRegistration relation
 * @method     ChildTaskQuery innerJoinWithTimeRegistration() Adds a INNER JOIN clause and with to the query using the TimeRegistration relation
 *
 * @method     \WorkStatusQuery|\TeamProjectQuery|\TimeRegistrationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTask findOne(ConnectionInterface $con = null) Return the first ChildTask matching the query
 * @method     ChildTask findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTask matching the query, or a new ChildTask object populated from the query conditions when no match is found
 *
 * @method     ChildTask findOneById(int $id) Return the first ChildTask filtered by the id column
 * @method     ChildTask findOneByProjectId(int $Project_id) Return the first ChildTask filtered by the Project_id column
 * @method     ChildTask findOneByTeamId(int $Team_id) Return the first ChildTask filtered by the Team_id column
 * @method     ChildTask findOneByName(string $Name) Return the first ChildTask filtered by the Name column
 * @method     ChildTask findOneByStart(string $Start) Return the first ChildTask filtered by the Start column
 * @method     ChildTask findOneByEnd(string $End) Return the first ChildTask filtered by the End column
 * @method     ChildTask findOneByPlannedhours(int $PlannedHours) Return the first ChildTask filtered by the PlannedHours column
 * @method     ChildTask findOneByDependentId(int $Dependent_id) Return the first ChildTask filtered by the Dependent_id column
 * @method     ChildTask findOneByStatusId(string $Status_id) Return the first ChildTask filtered by the Status_id column *

 * @method     ChildTask requirePk($key, ConnectionInterface $con = null) Return the ChildTask by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOne(ConnectionInterface $con = null) Return the first ChildTask matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTask requireOneById(int $id) Return the first ChildTask filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByProjectId(int $Project_id) Return the first ChildTask filtered by the Project_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByTeamId(int $Team_id) Return the first ChildTask filtered by the Team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByName(string $Name) Return the first ChildTask filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByStart(string $Start) Return the first ChildTask filtered by the Start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByEnd(string $End) Return the first ChildTask filtered by the End column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByPlannedhours(int $PlannedHours) Return the first ChildTask filtered by the PlannedHours column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByDependentId(int $Dependent_id) Return the first ChildTask filtered by the Dependent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTask requireOneByStatusId(string $Status_id) Return the first ChildTask filtered by the Status_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTask[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTask objects based on current ModelCriteria
 * @method     ChildTask[]|ObjectCollection findById(int $id) Return ChildTask objects filtered by the id column
 * @method     ChildTask[]|ObjectCollection findByProjectId(int $Project_id) Return ChildTask objects filtered by the Project_id column
 * @method     ChildTask[]|ObjectCollection findByTeamId(int $Team_id) Return ChildTask objects filtered by the Team_id column
 * @method     ChildTask[]|ObjectCollection findByName(string $Name) Return ChildTask objects filtered by the Name column
 * @method     ChildTask[]|ObjectCollection findByStart(string $Start) Return ChildTask objects filtered by the Start column
 * @method     ChildTask[]|ObjectCollection findByEnd(string $End) Return ChildTask objects filtered by the End column
 * @method     ChildTask[]|ObjectCollection findByPlannedhours(int $PlannedHours) Return ChildTask objects filtered by the PlannedHours column
 * @method     ChildTask[]|ObjectCollection findByDependentId(int $Dependent_id) Return ChildTask objects filtered by the Dependent_id column
 * @method     ChildTask[]|ObjectCollection findByStatusId(string $Status_id) Return ChildTask objects filtered by the Status_id column
 * @method     ChildTask[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TaskQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TaskQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\Task', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTaskQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTaskQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTaskQuery) {
            return $criteria;
        }
        $query = new ChildTaskQuery();
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
     * @return ChildTask|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TaskTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TaskTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTask A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, Project_id, Team_id, Name, Start, End, PlannedHours, Dependent_id, Status_id FROM task WHERE id = :p0';
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
            /** @var ChildTask $obj */
            $obj = new ChildTask();
            $obj->hydrate($row);
            TaskTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTask|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TaskTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TaskTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_ID, $id, $comparison);
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
     * @see       filterByTeamProject()
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_PROJECT_ID, $projectId, $comparison);
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
     * @see       filterByTeamProject()
     *
     * @param     mixed $teamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_TEAM_ID, $teamId, $comparison);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByStart($start = null, $comparison = null)
    {
        if (is_array($start)) {
            $useMinMax = false;
            if (isset($start['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_START, $start['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($start['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_START, $start['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_START, $start, $comparison);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByEnd($end = null, $comparison = null)
    {
        if (is_array($end)) {
            $useMinMax = false;
            if (isset($end['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_END, $end['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($end['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_END, $end['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_END, $end, $comparison);
    }

    /**
     * Filter the query on the PlannedHours column
     *
     * Example usage:
     * <code>
     * $query->filterByPlannedhours(1234); // WHERE PlannedHours = 1234
     * $query->filterByPlannedhours(array(12, 34)); // WHERE PlannedHours IN (12, 34)
     * $query->filterByPlannedhours(array('min' => 12)); // WHERE PlannedHours > 12
     * </code>
     *
     * @param     mixed $plannedhours The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByPlannedhours($plannedhours = null, $comparison = null)
    {
        if (is_array($plannedhours)) {
            $useMinMax = false;
            if (isset($plannedhours['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_PLANNEDHOURS, $plannedhours['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($plannedhours['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_PLANNEDHOURS, $plannedhours['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_PLANNEDHOURS, $plannedhours, $comparison);
    }

    /**
     * Filter the query on the Dependent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDependentId(1234); // WHERE Dependent_id = 1234
     * $query->filterByDependentId(array(12, 34)); // WHERE Dependent_id IN (12, 34)
     * $query->filterByDependentId(array('min' => 12)); // WHERE Dependent_id > 12
     * </code>
     *
     * @param     mixed $dependentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByDependentId($dependentId = null, $comparison = null)
    {
        if (is_array($dependentId)) {
            $useMinMax = false;
            if (isset($dependentId['min'])) {
                $this->addUsingAlias(TaskTableMap::COL_DEPENDENT_ID, $dependentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dependentId['max'])) {
                $this->addUsingAlias(TaskTableMap::COL_DEPENDENT_ID, $dependentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_DEPENDENT_ID, $dependentId, $comparison);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function filterByStatusId($statusId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($statusId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TaskTableMap::COL_STATUS_ID, $statusId, $comparison);
    }

    /**
     * Filter the query by a related \WorkStatus object
     *
     * @param \WorkStatus|ObjectCollection $workStatus The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterByWorkStatus($workStatus, $comparison = null)
    {
        if ($workStatus instanceof \WorkStatus) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_STATUS_ID, $workStatus->getId(), $comparison);
        } elseif ($workStatus instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TaskTableMap::COL_STATUS_ID, $workStatus->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTaskQuery The current query, for fluid interface
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
     * Filter the query by a related \TeamProject object
     *
     * @param \TeamProject $teamProject The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterByTeamProject($teamProject, $comparison = null)
    {
        if ($teamProject instanceof \TeamProject) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_PROJECT_ID, $teamProject->getProjectId(), $comparison)
                ->addUsingAlias(TaskTableMap::COL_TEAM_ID, $teamProject->getTeamId(), $comparison);
        } else {
            throw new PropelException('filterByTeamProject() only accepts arguments of type \TeamProject');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TeamProject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function joinTeamProject($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTeamProjectQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTeamProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TeamProject', '\TeamProjectQuery');
    }

    /**
     * Filter the query by a related \TimeRegistration object
     *
     * @param \TimeRegistration|ObjectCollection $timeRegistration the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTaskQuery The current query, for fluid interface
     */
    public function filterByTimeRegistration($timeRegistration, $comparison = null)
    {
        if ($timeRegistration instanceof \TimeRegistration) {
            return $this
                ->addUsingAlias(TaskTableMap::COL_ID, $timeRegistration->getTaskId(), $comparison);
        } elseif ($timeRegistration instanceof ObjectCollection) {
            return $this
                ->useTimeRegistrationQuery()
                ->filterByPrimaryKeys($timeRegistration->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTimeRegistration() only accepts arguments of type \TimeRegistration or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TimeRegistration relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function joinTimeRegistration($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TimeRegistration');

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
            $this->addJoinObject($join, 'TimeRegistration');
        }

        return $this;
    }

    /**
     * Use the TimeRegistration relation TimeRegistration object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TimeRegistrationQuery A secondary query class using the current class as primary query
     */
    public function useTimeRegistrationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTimeRegistration($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TimeRegistration', '\TimeRegistrationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTask $task Object to remove from the list of results
     *
     * @return $this|ChildTaskQuery The current query, for fluid interface
     */
    public function prune($task = null)
    {
        if ($task) {
            $this->addUsingAlias(TaskTableMap::COL_ID, $task->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the task table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TaskTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TaskTableMap::clearInstancePool();
            TaskTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TaskTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TaskTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TaskTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TaskTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TaskQuery

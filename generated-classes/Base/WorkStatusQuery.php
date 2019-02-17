<?php

namespace Base;

use \WorkStatus as ChildWorkStatus;
use \WorkStatusQuery as ChildWorkStatusQuery;
use \Exception;
use \PDO;
use Map\WorkStatusTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'work_status' table.
 *
 * 
 *
 * @method     ChildWorkStatusQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWorkStatusQuery orderByStatus($order = Criteria::ASC) Order by the Status column
 *
 * @method     ChildWorkStatusQuery groupById() Group by the id column
 * @method     ChildWorkStatusQuery groupByStatus() Group by the Status column
 *
 * @method     ChildWorkStatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWorkStatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWorkStatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWorkStatusQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWorkStatusQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWorkStatusQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWorkStatusQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method     ChildWorkStatusQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method     ChildWorkStatusQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method     ChildWorkStatusQuery joinWithProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Project relation
 *
 * @method     ChildWorkStatusQuery leftJoinWithProject() Adds a LEFT JOIN clause and with to the query using the Project relation
 * @method     ChildWorkStatusQuery rightJoinWithProject() Adds a RIGHT JOIN clause and with to the query using the Project relation
 * @method     ChildWorkStatusQuery innerJoinWithProject() Adds a INNER JOIN clause and with to the query using the Project relation
 *
 * @method     ChildWorkStatusQuery leftJoinTask($relationAlias = null) Adds a LEFT JOIN clause to the query using the Task relation
 * @method     ChildWorkStatusQuery rightJoinTask($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Task relation
 * @method     ChildWorkStatusQuery innerJoinTask($relationAlias = null) Adds a INNER JOIN clause to the query using the Task relation
 *
 * @method     ChildWorkStatusQuery joinWithTask($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Task relation
 *
 * @method     ChildWorkStatusQuery leftJoinWithTask() Adds a LEFT JOIN clause and with to the query using the Task relation
 * @method     ChildWorkStatusQuery rightJoinWithTask() Adds a RIGHT JOIN clause and with to the query using the Task relation
 * @method     ChildWorkStatusQuery innerJoinWithTask() Adds a INNER JOIN clause and with to the query using the Task relation
 *
 * @method     \ProjectQuery|\TaskQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWorkStatus findOne(ConnectionInterface $con = null) Return the first ChildWorkStatus matching the query
 * @method     ChildWorkStatus findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWorkStatus matching the query, or a new ChildWorkStatus object populated from the query conditions when no match is found
 *
 * @method     ChildWorkStatus findOneById(string $id) Return the first ChildWorkStatus filtered by the id column
 * @method     ChildWorkStatus findOneByStatus(string $Status) Return the first ChildWorkStatus filtered by the Status column *

 * @method     ChildWorkStatus requirePk($key, ConnectionInterface $con = null) Return the ChildWorkStatus by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkStatus requireOne(ConnectionInterface $con = null) Return the first ChildWorkStatus matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkStatus requireOneById(string $id) Return the first ChildWorkStatus filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkStatus requireOneByStatus(string $Status) Return the first ChildWorkStatus filtered by the Status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkStatus[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWorkStatus objects based on current ModelCriteria
 * @method     ChildWorkStatus[]|ObjectCollection findById(string $id) Return ChildWorkStatus objects filtered by the id column
 * @method     ChildWorkStatus[]|ObjectCollection findByStatus(string $Status) Return ChildWorkStatus objects filtered by the Status column
 * @method     ChildWorkStatus[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WorkStatusQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\WorkStatusQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\WorkStatus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWorkStatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWorkStatusQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWorkStatusQuery) {
            return $criteria;
        }
        $query = new ChildWorkStatusQuery();
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
     * @return ChildWorkStatus|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WorkStatusTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WorkStatusTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildWorkStatus A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, Status FROM work_status WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildWorkStatus $obj */
            $obj = new ChildWorkStatus();
            $obj->hydrate($row);
            WorkStatusTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildWorkStatus|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WorkStatusTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WorkStatusTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById('fooValue');   // WHERE id = 'fooValue'
     * $query->filterById('%fooValue%', Criteria::LIKE); // WHERE id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $id The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkStatusTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE Status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE Status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkStatusTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \Project object
     *
     * @param \Project|ObjectCollection $project the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof \Project) {
            return $this
                ->addUsingAlias(WorkStatusTableMap::COL_ID, $project->getStatusId(), $comparison);
        } elseif ($project instanceof ObjectCollection) {
            return $this
                ->useProjectQuery()
                ->filterByPrimaryKeys($project->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
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
     * Filter the query by a related \Task object
     *
     * @param \Task|ObjectCollection $task the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkStatusQuery The current query, for fluid interface
     */
    public function filterByTask($task, $comparison = null)
    {
        if ($task instanceof \Task) {
            return $this
                ->addUsingAlias(WorkStatusTableMap::COL_ID, $task->getStatusId(), $comparison);
        } elseif ($task instanceof ObjectCollection) {
            return $this
                ->useTaskQuery()
                ->filterByPrimaryKeys($task->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildWorkStatus $workStatus Object to remove from the list of results
     *
     * @return $this|ChildWorkStatusQuery The current query, for fluid interface
     */
    public function prune($workStatus = null)
    {
        if ($workStatus) {
            $this->addUsingAlias(WorkStatusTableMap::COL_ID, $workStatus->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the work_status table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkStatusTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WorkStatusTableMap::clearInstancePool();
            WorkStatusTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkStatusTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WorkStatusTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            WorkStatusTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            WorkStatusTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WorkStatusQuery

<?php

namespace Base;

use \TeamProject as ChildTeamProject;
use \TeamProjectQuery as ChildTeamProjectQuery;
use \Exception;
use \PDO;
use Map\TeamProjectTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'team_project' table.
 *
 * 
 *
 * @method     ChildTeamProjectQuery orderByProjectId($order = Criteria::ASC) Order by the Project_id column
 * @method     ChildTeamProjectQuery orderByTeamId($order = Criteria::ASC) Order by the Team_id column
 *
 * @method     ChildTeamProjectQuery groupByProjectId() Group by the Project_id column
 * @method     ChildTeamProjectQuery groupByTeamId() Group by the Team_id column
 *
 * @method     ChildTeamProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTeamProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTeamProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTeamProjectQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTeamProjectQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTeamProjectQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTeamProjectQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method     ChildTeamProjectQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method     ChildTeamProjectQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method     ChildTeamProjectQuery joinWithProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Project relation
 *
 * @method     ChildTeamProjectQuery leftJoinWithProject() Adds a LEFT JOIN clause and with to the query using the Project relation
 * @method     ChildTeamProjectQuery rightJoinWithProject() Adds a RIGHT JOIN clause and with to the query using the Project relation
 * @method     ChildTeamProjectQuery innerJoinWithProject() Adds a INNER JOIN clause and with to the query using the Project relation
 *
 * @method     ChildTeamProjectQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildTeamProjectQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildTeamProjectQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildTeamProjectQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildTeamProjectQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildTeamProjectQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildTeamProjectQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     ChildTeamProjectQuery leftJoinTask($relationAlias = null) Adds a LEFT JOIN clause to the query using the Task relation
 * @method     ChildTeamProjectQuery rightJoinTask($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Task relation
 * @method     ChildTeamProjectQuery innerJoinTask($relationAlias = null) Adds a INNER JOIN clause to the query using the Task relation
 *
 * @method     ChildTeamProjectQuery joinWithTask($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Task relation
 *
 * @method     ChildTeamProjectQuery leftJoinWithTask() Adds a LEFT JOIN clause and with to the query using the Task relation
 * @method     ChildTeamProjectQuery rightJoinWithTask() Adds a RIGHT JOIN clause and with to the query using the Task relation
 * @method     ChildTeamProjectQuery innerJoinWithTask() Adds a INNER JOIN clause and with to the query using the Task relation
 *
 * @method     \ProjectQuery|\TeamQuery|\TaskQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTeamProject findOne(ConnectionInterface $con = null) Return the first ChildTeamProject matching the query
 * @method     ChildTeamProject findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTeamProject matching the query, or a new ChildTeamProject object populated from the query conditions when no match is found
 *
 * @method     ChildTeamProject findOneByProjectId(int $Project_id) Return the first ChildTeamProject filtered by the Project_id column
 * @method     ChildTeamProject findOneByTeamId(int $Team_id) Return the first ChildTeamProject filtered by the Team_id column *

 * @method     ChildTeamProject requirePk($key, ConnectionInterface $con = null) Return the ChildTeamProject by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTeamProject requireOne(ConnectionInterface $con = null) Return the first ChildTeamProject matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTeamProject requireOneByProjectId(int $Project_id) Return the first ChildTeamProject filtered by the Project_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTeamProject requireOneByTeamId(int $Team_id) Return the first ChildTeamProject filtered by the Team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTeamProject[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTeamProject objects based on current ModelCriteria
 * @method     ChildTeamProject[]|ObjectCollection findByProjectId(int $Project_id) Return ChildTeamProject objects filtered by the Project_id column
 * @method     ChildTeamProject[]|ObjectCollection findByTeamId(int $Team_id) Return ChildTeamProject objects filtered by the Team_id column
 * @method     ChildTeamProject[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TeamProjectQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TeamProjectQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\TeamProject', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTeamProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTeamProjectQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTeamProjectQuery) {
            return $criteria;
        }
        $query = new ChildTeamProjectQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$Project_id, $Team_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTeamProject|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TeamProjectTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TeamProjectTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildTeamProject A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT Project_id, Team_id FROM team_project WHERE Project_id = :p0 AND Team_id = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTeamProject $obj */
            $obj = new ChildTeamProject();
            $obj->hydrate($row);
            TeamProjectTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildTeamProject|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(TeamProjectTableMap::COL_PROJECT_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(TeamProjectTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $projectId, $comparison);
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
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Filter the query by a related \Project object
     *
     * @param \Project|ObjectCollection $project The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof \Project) {
            return $this
                ->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
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
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
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
     * Filter the query by a related \Task object
     *
     * @param \Task|ObjectCollection $task the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTeamProjectQuery The current query, for fluid interface
     */
    public function filterByTask($task, $comparison = null)
    {
        if ($task instanceof \Task) {
            return $this
                ->addUsingAlias(TeamProjectTableMap::COL_PROJECT_ID, $task->getProjectId(), $comparison)
                ->addUsingAlias(TeamProjectTableMap::COL_TEAM_ID, $task->getTeamId(), $comparison);
        } else {
            throw new PropelException('filterByTask() only accepts arguments of type \Task');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Task relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function joinTask($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTaskQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTask($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Task', '\TaskQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTeamProject $teamProject Object to remove from the list of results
     *
     * @return $this|ChildTeamProjectQuery The current query, for fluid interface
     */
    public function prune($teamProject = null)
    {
        if ($teamProject) {
            $this->addCond('pruneCond0', $this->getAliasedColName(TeamProjectTableMap::COL_PROJECT_ID), $teamProject->getProjectId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(TeamProjectTableMap::COL_TEAM_ID), $teamProject->getTeamId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the team_project table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamProjectTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TeamProjectTableMap::clearInstancePool();
            TeamProjectTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TeamProjectTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TeamProjectTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TeamProjectTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TeamProjectTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TeamProjectQuery

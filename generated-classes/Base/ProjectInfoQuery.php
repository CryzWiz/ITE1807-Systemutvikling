<?php

namespace Base;

use \ProjectInfo as ChildProjectInfo;
use \ProjectInfoQuery as ChildProjectInfoQuery;
use \Exception;
use \PDO;
use Map\ProjectInfoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'projectinfo' table.
 *
 * 
 *
 * @method     ChildProjectInfoQuery orderByProjectId($order = Criteria::ASC) Order by the Project_id column
 * @method     ChildProjectInfoQuery orderByCostumername($order = Criteria::ASC) Order by the CostumerName column
 * @method     ChildProjectInfoQuery orderByAddress($order = Criteria::ASC) Order by the Address column
 * @method     ChildProjectInfoQuery orderByContactperson($order = Criteria::ASC) Order by the ContactPerson column
 * @method     ChildProjectInfoQuery orderByEmail($order = Criteria::ASC) Order by the Email column
 *
 * @method     ChildProjectInfoQuery groupByProjectId() Group by the Project_id column
 * @method     ChildProjectInfoQuery groupByCostumername() Group by the CostumerName column
 * @method     ChildProjectInfoQuery groupByAddress() Group by the Address column
 * @method     ChildProjectInfoQuery groupByContactperson() Group by the ContactPerson column
 * @method     ChildProjectInfoQuery groupByEmail() Group by the Email column
 *
 * @method     ChildProjectInfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProjectInfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProjectInfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProjectInfoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProjectInfoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProjectInfoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProjectInfoQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method     ChildProjectInfoQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method     ChildProjectInfoQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method     ChildProjectInfoQuery joinWithProject($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Project relation
 *
 * @method     ChildProjectInfoQuery leftJoinWithProject() Adds a LEFT JOIN clause and with to the query using the Project relation
 * @method     ChildProjectInfoQuery rightJoinWithProject() Adds a RIGHT JOIN clause and with to the query using the Project relation
 * @method     ChildProjectInfoQuery innerJoinWithProject() Adds a INNER JOIN clause and with to the query using the Project relation
 *
 * @method     \ProjectQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProjectInfo findOne(ConnectionInterface $con = null) Return the first ChildProjectInfo matching the query
 * @method     ChildProjectInfo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProjectInfo matching the query, or a new ChildProjectInfo object populated from the query conditions when no match is found
 *
 * @method     ChildProjectInfo findOneByProjectId(int $Project_id) Return the first ChildProjectInfo filtered by the Project_id column
 * @method     ChildProjectInfo findOneByCostumername(string $CostumerName) Return the first ChildProjectInfo filtered by the CostumerName column
 * @method     ChildProjectInfo findOneByAddress(string $Address) Return the first ChildProjectInfo filtered by the Address column
 * @method     ChildProjectInfo findOneByContactperson(string $ContactPerson) Return the first ChildProjectInfo filtered by the ContactPerson column
 * @method     ChildProjectInfo findOneByEmail(string $Email) Return the first ChildProjectInfo filtered by the Email column *

 * @method     ChildProjectInfo requirePk($key, ConnectionInterface $con = null) Return the ChildProjectInfo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProjectInfo requireOne(ConnectionInterface $con = null) Return the first ChildProjectInfo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProjectInfo requireOneByProjectId(int $Project_id) Return the first ChildProjectInfo filtered by the Project_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProjectInfo requireOneByCostumername(string $CostumerName) Return the first ChildProjectInfo filtered by the CostumerName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProjectInfo requireOneByAddress(string $Address) Return the first ChildProjectInfo filtered by the Address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProjectInfo requireOneByContactperson(string $ContactPerson) Return the first ChildProjectInfo filtered by the ContactPerson column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProjectInfo requireOneByEmail(string $Email) Return the first ChildProjectInfo filtered by the Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProjectInfo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProjectInfo objects based on current ModelCriteria
 * @method     ChildProjectInfo[]|ObjectCollection findByProjectId(int $Project_id) Return ChildProjectInfo objects filtered by the Project_id column
 * @method     ChildProjectInfo[]|ObjectCollection findByCostumername(string $CostumerName) Return ChildProjectInfo objects filtered by the CostumerName column
 * @method     ChildProjectInfo[]|ObjectCollection findByAddress(string $Address) Return ChildProjectInfo objects filtered by the Address column
 * @method     ChildProjectInfo[]|ObjectCollection findByContactperson(string $ContactPerson) Return ChildProjectInfo objects filtered by the ContactPerson column
 * @method     ChildProjectInfo[]|ObjectCollection findByEmail(string $Email) Return ChildProjectInfo objects filtered by the Email column
 * @method     ChildProjectInfo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProjectInfoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ProjectInfoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\ProjectInfo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProjectInfoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProjectInfoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProjectInfoQuery) {
            return $criteria;
        }
        $query = new ChildProjectInfoQuery();
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
     * @return ChildProjectInfo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProjectInfoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProjectInfoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProjectInfo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT Project_id, CostumerName, Address, ContactPerson, Email FROM projectinfo WHERE Project_id = :p0';
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
            /** @var ChildProjectInfo $obj */
            $obj = new ChildProjectInfo();
            $obj->hydrate($row);
            ProjectInfoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProjectInfo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $keys, Criteria::IN);
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
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the CostumerName column
     *
     * Example usage:
     * <code>
     * $query->filterByCostumername('fooValue');   // WHERE CostumerName = 'fooValue'
     * $query->filterByCostumername('%fooValue%', Criteria::LIKE); // WHERE CostumerName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $costumername The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByCostumername($costumername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($costumername)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectInfoTableMap::COL_COSTUMERNAME, $costumername, $comparison);
    }

    /**
     * Filter the query on the Address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE Address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE Address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectInfoTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the ContactPerson column
     *
     * Example usage:
     * <code>
     * $query->filterByContactperson('fooValue');   // WHERE ContactPerson = 'fooValue'
     * $query->filterByContactperson('%fooValue%', Criteria::LIKE); // WHERE ContactPerson LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contactperson The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByContactperson($contactperson = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contactperson)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectInfoTableMap::COL_CONTACTPERSON, $contactperson, $comparison);
    }

    /**
     * Filter the query on the Email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE Email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE Email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectInfoTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query by a related \Project object
     *
     * @param \Project|ObjectCollection $project The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProjectInfoQuery The current query, for fluid interface
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof \Project) {
            return $this
                ->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildProjectInfo $projectInfo Object to remove from the list of results
     *
     * @return $this|ChildProjectInfoQuery The current query, for fluid interface
     */
    public function prune($projectInfo = null)
    {
        if ($projectInfo) {
            $this->addUsingAlias(ProjectInfoTableMap::COL_PROJECT_ID, $projectInfo->getProjectId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the projectinfo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectInfoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProjectInfoTableMap::clearInstancePool();
            ProjectInfoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectInfoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProjectInfoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ProjectInfoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ProjectInfoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProjectInfoQuery

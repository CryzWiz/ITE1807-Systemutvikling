<?php

namespace Base;

use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Exception;
use \PDO;
use Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user' table.
 *
 * 
 *
 * @method     ChildUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserQuery orderByUsername($order = Criteria::ASC) Order by the UserName column
 * @method     ChildUserQuery orderByPassword($order = Criteria::ASC) Order by the Password column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the Email column
 * @method     ChildUserQuery orderByFirstname($order = Criteria::ASC) Order by the FirstName column
 * @method     ChildUserQuery orderByLastname($order = Criteria::ASC) Order by the LastName column
 * @method     ChildUserQuery orderByValidated($order = Criteria::ASC) Order by the Validated column
 * @method     ChildUserQuery orderByActive($order = Criteria::ASC) Order by the Active column
 * @method     ChildUserQuery orderByRole($order = Criteria::ASC) Order by the Role column
 * @method     ChildUserQuery orderByPermanent($order = Criteria::ASC) Order by the Permanent column
 * @method     ChildUserQuery orderByPassExpiresAt($order = Criteria::ASC) Order by the pass_expires_at column
 * @method     ChildUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserQuery groupById() Group by the id column
 * @method     ChildUserQuery groupByUsername() Group by the UserName column
 * @method     ChildUserQuery groupByPassword() Group by the Password column
 * @method     ChildUserQuery groupByEmail() Group by the Email column
 * @method     ChildUserQuery groupByFirstname() Group by the FirstName column
 * @method     ChildUserQuery groupByLastname() Group by the LastName column
 * @method     ChildUserQuery groupByValidated() Group by the Validated column
 * @method     ChildUserQuery groupByActive() Group by the Active column
 * @method     ChildUserQuery groupByRole() Group by the Role column
 * @method     ChildUserQuery groupByPermanent() Group by the Permanent column
 * @method     ChildUserQuery groupByPassExpiresAt() Group by the pass_expires_at column
 * @method     ChildUserQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserQuery leftJoinTimeRegistration($relationAlias = null) Adds a LEFT JOIN clause to the query using the TimeRegistration relation
 * @method     ChildUserQuery rightJoinTimeRegistration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TimeRegistration relation
 * @method     ChildUserQuery innerJoinTimeRegistration($relationAlias = null) Adds a INNER JOIN clause to the query using the TimeRegistration relation
 *
 * @method     ChildUserQuery joinWithTimeRegistration($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TimeRegistration relation
 *
 * @method     ChildUserQuery leftJoinWithTimeRegistration() Adds a LEFT JOIN clause and with to the query using the TimeRegistration relation
 * @method     ChildUserQuery rightJoinWithTimeRegistration() Adds a RIGHT JOIN clause and with to the query using the TimeRegistration relation
 * @method     ChildUserQuery innerJoinWithTimeRegistration() Adds a INNER JOIN clause and with to the query using the TimeRegistration relation
 *
 * @method     ChildUserQuery leftJoinUserInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserInfo relation
 * @method     ChildUserQuery rightJoinUserInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserInfo relation
 * @method     ChildUserQuery innerJoinUserInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the UserInfo relation
 *
 * @method     ChildUserQuery joinWithUserInfo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserInfo relation
 *
 * @method     ChildUserQuery leftJoinWithUserInfo() Adds a LEFT JOIN clause and with to the query using the UserInfo relation
 * @method     ChildUserQuery rightJoinWithUserInfo() Adds a RIGHT JOIN clause and with to the query using the UserInfo relation
 * @method     ChildUserQuery innerJoinWithUserInfo() Adds a INNER JOIN clause and with to the query using the UserInfo relation
 *
 * @method     ChildUserQuery leftJoinCalendar($relationAlias = null) Adds a LEFT JOIN clause to the query using the Calendar relation
 * @method     ChildUserQuery rightJoinCalendar($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Calendar relation
 * @method     ChildUserQuery innerJoinCalendar($relationAlias = null) Adds a INNER JOIN clause to the query using the Calendar relation
 *
 * @method     ChildUserQuery joinWithCalendar($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Calendar relation
 *
 * @method     ChildUserQuery leftJoinWithCalendar() Adds a LEFT JOIN clause and with to the query using the Calendar relation
 * @method     ChildUserQuery rightJoinWithCalendar() Adds a RIGHT JOIN clause and with to the query using the Calendar relation
 * @method     ChildUserQuery innerJoinWithCalendar() Adds a INNER JOIN clause and with to the query using the Calendar relation
 *
 * @method     ChildUserQuery leftJoinUserTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserTeam relation
 * @method     ChildUserQuery rightJoinUserTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserTeam relation
 * @method     ChildUserQuery innerJoinUserTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the UserTeam relation
 *
 * @method     ChildUserQuery joinWithUserTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserTeam relation
 *
 * @method     ChildUserQuery leftJoinWithUserTeam() Adds a LEFT JOIN clause and with to the query using the UserTeam relation
 * @method     ChildUserQuery rightJoinWithUserTeam() Adds a RIGHT JOIN clause and with to the query using the UserTeam relation
 * @method     ChildUserQuery innerJoinWithUserTeam() Adds a INNER JOIN clause and with to the query using the UserTeam relation
 *
 * @method     ChildUserQuery leftJoinValidLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the ValidLink relation
 * @method     ChildUserQuery rightJoinValidLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ValidLink relation
 * @method     ChildUserQuery innerJoinValidLink($relationAlias = null) Adds a INNER JOIN clause to the query using the ValidLink relation
 *
 * @method     ChildUserQuery joinWithValidLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ValidLink relation
 *
 * @method     ChildUserQuery leftJoinWithValidLink() Adds a LEFT JOIN clause and with to the query using the ValidLink relation
 * @method     ChildUserQuery rightJoinWithValidLink() Adds a RIGHT JOIN clause and with to the query using the ValidLink relation
 * @method     ChildUserQuery innerJoinWithValidLink() Adds a INNER JOIN clause and with to the query using the ValidLink relation
 *
 * @method     \TimeRegistrationQuery|\UserInfoQuery|\CalendarQuery|\UserTeamQuery|\ValidLinkQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneById(int $id) Return the first ChildUser filtered by the id column
 * @method     ChildUser findOneByUsername(string $UserName) Return the first ChildUser filtered by the UserName column
 * @method     ChildUser findOneByPassword(string $Password) Return the first ChildUser filtered by the Password column
 * @method     ChildUser findOneByEmail(string $Email) Return the first ChildUser filtered by the Email column
 * @method     ChildUser findOneByFirstname(string $FirstName) Return the first ChildUser filtered by the FirstName column
 * @method     ChildUser findOneByLastname(string $LastName) Return the first ChildUser filtered by the LastName column
 * @method     ChildUser findOneByValidated(boolean $Validated) Return the first ChildUser filtered by the Validated column
 * @method     ChildUser findOneByActive(boolean $Active) Return the first ChildUser filtered by the Active column
 * @method     ChildUser findOneByRole(int $Role) Return the first ChildUser filtered by the Role column
 * @method     ChildUser findOneByPermanent(boolean $Permanent) Return the first ChildUser filtered by the Permanent column
 * @method     ChildUser findOneByPassExpiresAt(string $pass_expires_at) Return the first ChildUser filtered by the pass_expires_at column
 * @method     ChildUser findOneByCreatedAt(string $created_at) Return the first ChildUser filtered by the created_at column
 * @method     ChildUser findOneByUpdatedAt(string $updated_at) Return the first ChildUser filtered by the updated_at column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneById(int $id) Return the first ChildUser filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUsername(string $UserName) Return the first ChildUser filtered by the UserName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassword(string $Password) Return the first ChildUser filtered by the Password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $Email) Return the first ChildUser filtered by the Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByFirstname(string $FirstName) Return the first ChildUser filtered by the FirstName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLastname(string $LastName) Return the first ChildUser filtered by the LastName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByValidated(boolean $Validated) Return the first ChildUser filtered by the Validated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByActive(boolean $Active) Return the first ChildUser filtered by the Active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRole(int $Role) Return the first ChildUser filtered by the Role column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPermanent(boolean $Permanent) Return the first ChildUser filtered by the Permanent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassExpiresAt(string $pass_expires_at) Return the first ChildUser filtered by the pass_expires_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByCreatedAt(string $created_at) Return the first ChildUser filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUpdatedAt(string $updated_at) Return the first ChildUser filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findById(int $id) Return ChildUser objects filtered by the id column
 * @method     ChildUser[]|ObjectCollection findByUsername(string $UserName) Return ChildUser objects filtered by the UserName column
 * @method     ChildUser[]|ObjectCollection findByPassword(string $Password) Return ChildUser objects filtered by the Password column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $Email) Return ChildUser objects filtered by the Email column
 * @method     ChildUser[]|ObjectCollection findByFirstname(string $FirstName) Return ChildUser objects filtered by the FirstName column
 * @method     ChildUser[]|ObjectCollection findByLastname(string $LastName) Return ChildUser objects filtered by the LastName column
 * @method     ChildUser[]|ObjectCollection findByValidated(boolean $Validated) Return ChildUser objects filtered by the Validated column
 * @method     ChildUser[]|ObjectCollection findByActive(boolean $Active) Return ChildUser objects filtered by the Active column
 * @method     ChildUser[]|ObjectCollection findByRole(int $Role) Return ChildUser objects filtered by the Role column
 * @method     ChildUser[]|ObjectCollection findByPermanent(boolean $Permanent) Return ChildUser objects filtered by the Permanent column
 * @method     ChildUser[]|ObjectCollection findByPassExpiresAt(string $pass_expires_at) Return ChildUser objects filtered by the pass_expires_at column
 * @method     ChildUser[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUser objects filtered by the created_at column
 * @method     ChildUser[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUser objects filtered by the updated_at column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, UserName, Password, Email, FirstName, LastName, Validated, Active, Role, Permanent, pass_expires_at, created_at, updated_at FROM user WHERE id = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the UserName column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE UserName = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE UserName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the Password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE Password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE Password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASSWORD, $password, $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the FirstName column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE FirstName = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE FirstName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the LastName column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE LastName = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE LastName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the Validated column
     *
     * Example usage:
     * <code>
     * $query->filterByValidated(true); // WHERE Validated = true
     * $query->filterByValidated('yes'); // WHERE Validated = true
     * </code>
     *
     * @param     boolean|string $validated The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByValidated($validated = null, $comparison = null)
    {
        if (is_string($validated)) {
            $validated = in_array(strtolower($validated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_VALIDATED, $validated, $comparison);
    }

    /**
     * Filter the query on the Active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE Active = true
     * $query->filterByActive('yes'); // WHERE Active = true
     * </code>
     *
     * @param     boolean|string $active The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the Role column
     *
     * Example usage:
     * <code>
     * $query->filterByRole(1234); // WHERE Role = 1234
     * $query->filterByRole(array(12, 34)); // WHERE Role IN (12, 34)
     * $query->filterByRole(array('min' => 12)); // WHERE Role > 12
     * </code>
     *
     * @param     mixed $role The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (is_array($role)) {
            $useMinMax = false;
            if (isset($role['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ROLE, $role['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($role['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ROLE, $role['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ROLE, $role, $comparison);
    }

    /**
     * Filter the query on the Permanent column
     *
     * Example usage:
     * <code>
     * $query->filterByPermanent(true); // WHERE Permanent = true
     * $query->filterByPermanent('yes'); // WHERE Permanent = true
     * </code>
     *
     * @param     boolean|string $permanent The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPermanent($permanent = null, $comparison = null)
    {
        if (is_string($permanent)) {
            $permanent = in_array(strtolower($permanent), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_PERMANENT, $permanent, $comparison);
    }

    /**
     * Filter the query on the pass_expires_at column
     *
     * Example usage:
     * <code>
     * $query->filterByPassExpiresAt('2011-03-14'); // WHERE pass_expires_at = '2011-03-14'
     * $query->filterByPassExpiresAt('now'); // WHERE pass_expires_at = '2011-03-14'
     * $query->filterByPassExpiresAt(array('max' => 'yesterday')); // WHERE pass_expires_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $passExpiresAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassExpiresAt($passExpiresAt = null, $comparison = null)
    {
        if (is_array($passExpiresAt)) {
            $useMinMax = false;
            if (isset($passExpiresAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_PASS_EXPIRES_AT, $passExpiresAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($passExpiresAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_PASS_EXPIRES_AT, $passExpiresAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASS_EXPIRES_AT, $passExpiresAt, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \TimeRegistration object
     *
     * @param \TimeRegistration|ObjectCollection $timeRegistration the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTimeRegistration($timeRegistration, $comparison = null)
    {
        if ($timeRegistration instanceof \TimeRegistration) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $timeRegistration->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \UserInfo object
     *
     * @param \UserInfo|ObjectCollection $userInfo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserInfo($userInfo, $comparison = null)
    {
        if ($userInfo instanceof \UserInfo) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $userInfo->getUserId(), $comparison);
        } elseif ($userInfo instanceof ObjectCollection) {
            return $this
                ->useUserInfoQuery()
                ->filterByPrimaryKeys($userInfo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserInfo() only accepts arguments of type \UserInfo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserInfo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinUserInfo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserInfo');

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
            $this->addJoinObject($join, 'UserInfo');
        }

        return $this;
    }

    /**
     * Use the UserInfo relation UserInfo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserInfoQuery A secondary query class using the current class as primary query
     */
    public function useUserInfoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserInfo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserInfo', '\UserInfoQuery');
    }

    /**
     * Filter the query by a related \Calendar object
     *
     * @param \Calendar|ObjectCollection $calendar the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByCalendar($calendar, $comparison = null)
    {
        if ($calendar instanceof \Calendar) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $calendar->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \UserTeam object
     *
     * @param \UserTeam|ObjectCollection $userTeam the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserTeam($userTeam, $comparison = null)
    {
        if ($userTeam instanceof \UserTeam) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $userTeam->getUserId(), $comparison);
        } elseif ($userTeam instanceof ObjectCollection) {
            return $this
                ->useUserTeamQuery()
                ->filterByPrimaryKeys($userTeam->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserTeam() only accepts arguments of type \UserTeam or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserTeam relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinUserTeam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserTeam');

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
            $this->addJoinObject($join, 'UserTeam');
        }

        return $this;
    }

    /**
     * Use the UserTeam relation UserTeam object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserTeamQuery A secondary query class using the current class as primary query
     */
    public function useUserTeamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserTeam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserTeam', '\UserTeamQuery');
    }

    /**
     * Filter the query by a related \ValidLink object
     *
     * @param \ValidLink|ObjectCollection $validLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByValidLink($validLink, $comparison = null)
    {
        if ($validLink instanceof \ValidLink) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $validLink->getId(), $comparison);
        } elseif ($validLink instanceof ObjectCollection) {
            return $this
                ->useValidLinkQuery()
                ->filterByPrimaryKeys($validLink->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByValidLink() only accepts arguments of type \ValidLink or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ValidLink relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinValidLink($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ValidLink');

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
            $this->addJoinObject($join, 'ValidLink');
        }

        return $this;
    }

    /**
     * Use the ValidLink relation ValidLink object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ValidLinkQuery A secondary query class using the current class as primary query
     */
    public function useValidLinkQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinValidLink($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ValidLink', '\ValidLinkQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior
    
    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by update date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }
    
    /**
     * Order by update date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }
    
    /**
     * Order by create date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }
    
    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }
    
    /**
     * Order by create date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }

} // UserQuery

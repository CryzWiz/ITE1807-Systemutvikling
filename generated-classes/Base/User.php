<?php

namespace Base;

use \Calendar as ChildCalendar;
use \CalendarQuery as ChildCalendarQuery;
use \TimeRegistration as ChildTimeRegistration;
use \TimeRegistrationQuery as ChildTimeRegistrationQuery;
use \User as ChildUser;
use \UserInfo as ChildUserInfo;
use \UserInfoQuery as ChildUserInfoQuery;
use \UserQuery as ChildUserQuery;
use \UserTeam as ChildUserTeam;
use \UserTeamQuery as ChildUserTeamQuery;
use \ValidLink as ChildValidLink;
use \ValidLinkQuery as ChildValidLinkQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\CalendarTableMap;
use Map\TimeRegistrationTableMap;
use Map\UserTableMap;
use Map\UserTeamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'user' table.
 *
 * 
 *
 * @package    propel.generator..Base
 */
abstract class User implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the username field.
     * 
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     * 
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * The value for the firstname field.
     * 
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     * 
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the validated field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $validated;

    /**
     * The value for the active field.
     * 
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the role field.
     * 
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $role;

    /**
     * The value for the permanent field.
     * 
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $permanent;

    /**
     * The value for the pass_expires_at field.
     * 
     * @var        DateTime
     */
    protected $pass_expires_at;

    /**
     * The value for the created_at field.
     * 
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * 
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildTimeRegistration[] Collection to store aggregation of ChildTimeRegistration objects.
     */
    protected $collTimeRegistrations;
    protected $collTimeRegistrationsPartial;

    /**
     * @var        ChildUserInfo one-to-one related ChildUserInfo object
     */
    protected $singleUserInfo;

    /**
     * @var        ObjectCollection|ChildCalendar[] Collection to store aggregation of ChildCalendar objects.
     */
    protected $collCalendars;
    protected $collCalendarsPartial;

    /**
     * @var        ObjectCollection|ChildUserTeam[] Collection to store aggregation of ChildUserTeam objects.
     */
    protected $collUserTeams;
    protected $collUserTeamsPartial;

    /**
     * @var        ChildValidLink one-to-one related ChildValidLink object
     */
    protected $singleValidLink;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTimeRegistration[]
     */
    protected $timeRegistrationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCalendar[]
     */
    protected $calendarsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserTeam[]
     */
    protected $userTeamsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->validated = false;
        $this->active = true;
        $this->role = 1;
        $this->permanent = true;
    }

    /**
     * Initializes internal state of Base\User object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|User The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [username] column value.
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [firstname] column value.
     * 
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     * 
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [validated] column value.
     * 
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Get the [validated] column value.
     * 
     * @return boolean
     */
    public function isValidated()
    {
        return $this->getValidated();
    }

    /**
     * Get the [active] column value.
     * 
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [active] column value.
     * 
     * @return boolean
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get the [role] column value.
     * 
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the [permanent] column value.
     * 
     * @return boolean
     */
    public function getPermanent()
    {
        return $this->permanent;
    }

    /**
     * Get the [permanent] column value.
     * 
     * @return boolean
     */
    public function isPermanent()
    {
        return $this->getPermanent();
    }

    /**
     * Get the [optionally formatted] temporal [pass_expires_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPassExpiresAt($format = NULL)
    {
        if ($format === null) {
            return $this->pass_expires_at;
        } else {
            return $this->pass_expires_at instanceof \DateTimeInterface ? $this->pass_expires_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     * 
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [firstname] column.
     * 
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[UserTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     * 
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[UserTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Sets the value of the [validated] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setValidated($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->validated !== $v) {
            $this->validated = $v;
            $this->modifiedColumns[UserTableMap::COL_VALIDATED] = true;
        }

        return $this;
    } // setValidated()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[UserTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [role] column.
     * 
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setRole($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role !== $v) {
            $this->role = $v;
            $this->modifiedColumns[UserTableMap::COL_ROLE] = true;
        }

        return $this;
    } // setRole()

    /**
     * Sets the value of the [permanent] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPermanent($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->permanent !== $v) {
            $this->permanent = $v;
            $this->modifiedColumns[UserTableMap::COL_PERMANENT] = true;
        }

        return $this;
    } // setPermanent()

    /**
     * Sets the value of [pass_expires_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPassExpiresAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->pass_expires_at !== null || $dt !== null) {
            if ($this->pass_expires_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->pass_expires_at->format("Y-m-d H:i:s.u")) {
                $this->pass_expires_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_PASS_EXPIRES_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setPassExpiresAt()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->validated !== false) {
                return false;
            }

            if ($this->active !== true) {
                return false;
            }

            if ($this->role !== 1) {
                return false;
            }

            if ($this->permanent !== true) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('Validated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->validated = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserTableMap::translateFieldName('Role', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserTableMap::translateFieldName('Permanent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->permanent = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UserTableMap::translateFieldName('PassExpiresAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->pass_expires_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UserTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UserTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTimeRegistrations = null;

            $this->singleUserInfo = null;

            $this->collCalendars = null;

            $this->collUserTeams = null;

            $this->singleValidLink = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }
 
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                
                if (!$this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->timeRegistrationsScheduledForDeletion !== null) {
                if (!$this->timeRegistrationsScheduledForDeletion->isEmpty()) {
                    \TimeRegistrationQuery::create()
                        ->filterByPrimaryKeys($this->timeRegistrationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->timeRegistrationsScheduledForDeletion = null;
                }
            }

            if ($this->collTimeRegistrations !== null) {
                foreach ($this->collTimeRegistrations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleUserInfo !== null) {
                if (!$this->singleUserInfo->isDeleted() && ($this->singleUserInfo->isNew() || $this->singleUserInfo->isModified())) {
                    $affectedRows += $this->singleUserInfo->save($con);
                }
            }

            if ($this->calendarsScheduledForDeletion !== null) {
                if (!$this->calendarsScheduledForDeletion->isEmpty()) {
                    \CalendarQuery::create()
                        ->filterByPrimaryKeys($this->calendarsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->calendarsScheduledForDeletion = null;
                }
            }

            if ($this->collCalendars !== null) {
                foreach ($this->collCalendars as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userTeamsScheduledForDeletion !== null) {
                if (!$this->userTeamsScheduledForDeletion->isEmpty()) {
                    \UserTeamQuery::create()
                        ->filterByPrimaryKeys($this->userTeamsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userTeamsScheduledForDeletion = null;
                }
            }

            if ($this->collUserTeams !== null) {
                foreach ($this->collUserTeams as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleValidLink !== null) {
                if (!$this->singleValidLink->isDeleted() && ($this->singleValidLink->isNew() || $this->singleValidLink->isModified())) {
                    $affectedRows += $this->singleValidLink->save($con);
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'UserName';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'Password';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'Email';
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'FirstName';
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'LastName';
        }
        if ($this->isColumnModified(UserTableMap::COL_VALIDATED)) {
            $modifiedColumns[':p' . $index++]  = 'Validated';
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'Active';
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'Role';
        }
        if ($this->isColumnModified(UserTableMap::COL_PERMANENT)) {
            $modifiedColumns[':p' . $index++]  = 'Permanent';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASS_EXPIRES_AT)) {
            $modifiedColumns[':p' . $index++]  = 'pass_expires_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'UserName':                        
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'Password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'Email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'FirstName':                        
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'LastName':                        
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'Validated':
                        $stmt->bindValue($identifier, (int) $this->validated, PDO::PARAM_INT);
                        break;
                    case 'Active':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case 'Role':                        
                        $stmt->bindValue($identifier, $this->role, PDO::PARAM_INT);
                        break;
                    case 'Permanent':
                        $stmt->bindValue($identifier, (int) $this->permanent, PDO::PARAM_INT);
                        break;
                    case 'pass_expires_at':                        
                        $stmt->bindValue($identifier, $this->pass_expires_at ? $this->pass_expires_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'created_at':                        
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':                        
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUsername();
                break;
            case 2:
                return $this->getPassword();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getFirstname();
                break;
            case 5:
                return $this->getLastname();
                break;
            case 6:
                return $this->getValidated();
                break;
            case 7:
                return $this->getActive();
                break;
            case 8:
                return $this->getRole();
                break;
            case 9:
                return $this->getPermanent();
                break;
            case 10:
                return $this->getPassExpiresAt();
                break;
            case 11:
                return $this->getCreatedAt();
                break;
            case 12:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getFirstname(),
            $keys[5] => $this->getLastname(),
            $keys[6] => $this->getValidated(),
            $keys[7] => $this->getActive(),
            $keys[8] => $this->getRole(),
            $keys[9] => $this->getPermanent(),
            $keys[10] => $this->getPassExpiresAt(),
            $keys[11] => $this->getCreatedAt(),
            $keys[12] => $this->getUpdatedAt(),
        );
        if ($result[$keys[10]] instanceof \DateTime) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }
        
        if ($result[$keys[11]] instanceof \DateTime) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }
        
        if ($result[$keys[12]] instanceof \DateTime) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collTimeRegistrations) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'timeRegistrations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'timeregistrations';
                        break;
                    default:
                        $key = 'TimeRegistrations';
                }
        
                $result[$key] = $this->collTimeRegistrations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleUserInfo) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userInfo';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'userinfo';
                        break;
                    default:
                        $key = 'UserInfo';
                }
        
                $result[$key] = $this->singleUserInfo->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCalendars) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'calendars';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'calendars';
                        break;
                    default:
                        $key = 'Calendars';
                }
        
                $result[$key] = $this->collCalendars->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserTeams) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userTeams';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_teams';
                        break;
                    default:
                        $key = 'UserTeams';
                }
        
                $result[$key] = $this->collUserTeams->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleValidLink) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'validLink';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'valid_link';
                        break;
                    default:
                        $key = 'ValidLink';
                }
        
                $result[$key] = $this->singleValidLink->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setFirstname($value);
                break;
            case 5:
                $this->setLastname($value);
                break;
            case 6:
                $this->setValidated($value);
                break;
            case 7:
                $this->setActive($value);
                break;
            case 8:
                $this->setRole($value);
                break;
            case 9:
                $this->setPermanent($value);
                break;
            case 10:
                $this->setPassExpiresAt($value);
                break;
            case 11:
                $this->setCreatedAt($value);
                break;
            case 12:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPassword($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFirstname($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLastname($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setValidated($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setActive($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRole($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPermanent($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setPassExpiresAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUpdatedAt($arr[$keys[12]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\User The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $criteria->add(UserTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $criteria->add(UserTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(UserTableMap::COL_VALIDATED)) {
            $criteria->add(UserTableMap::COL_VALIDATED, $this->validated);
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVE)) {
            $criteria->add(UserTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $criteria->add(UserTableMap::COL_ROLE, $this->role);
        }
        if ($this->isColumnModified(UserTableMap::COL_PERMANENT)) {
            $criteria->add(UserTableMap::COL_PERMANENT, $this->permanent);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASS_EXPIRES_AT)) {
            $criteria->add(UserTableMap::COL_PASS_EXPIRES_AT, $this->pass_expires_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
            $criteria->add(UserTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
            $criteria->add(UserTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setValidated($this->getValidated());
        $copyObj->setActive($this->getActive());
        $copyObj->setRole($this->getRole());
        $copyObj->setPermanent($this->getPermanent());
        $copyObj->setPassExpiresAt($this->getPassExpiresAt());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTimeRegistrations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTimeRegistration($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getUserInfo();
            if ($relObj) {
                $copyObj->setUserInfo($relObj->copy($deepCopy));
            }

            foreach ($this->getCalendars() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCalendar($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserTeams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserTeam($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getValidLink();
            if ($relObj) {
                $copyObj->setValidLink($relObj->copy($deepCopy));
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('TimeRegistration' == $relationName) {
            return $this->initTimeRegistrations();
        }
        if ('Calendar' == $relationName) {
            return $this->initCalendars();
        }
        if ('UserTeam' == $relationName) {
            return $this->initUserTeams();
        }
    }

    /**
     * Clears out the collTimeRegistrations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTimeRegistrations()
     */
    public function clearTimeRegistrations()
    {
        $this->collTimeRegistrations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTimeRegistrations collection loaded partially.
     */
    public function resetPartialTimeRegistrations($v = true)
    {
        $this->collTimeRegistrationsPartial = $v;
    }

    /**
     * Initializes the collTimeRegistrations collection.
     *
     * By default this just sets the collTimeRegistrations collection to an empty array (like clearcollTimeRegistrations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTimeRegistrations($overrideExisting = true)
    {
        if (null !== $this->collTimeRegistrations && !$overrideExisting) {
            return;
        }

        $collectionClassName = TimeRegistrationTableMap::getTableMap()->getCollectionClassName();

        $this->collTimeRegistrations = new $collectionClassName;
        $this->collTimeRegistrations->setModel('\TimeRegistration');
    }

    /**
     * Gets an array of ChildTimeRegistration objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTimeRegistration[] List of ChildTimeRegistration objects
     * @throws PropelException
     */
    public function getTimeRegistrations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTimeRegistrationsPartial && !$this->isNew();
        if (null === $this->collTimeRegistrations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTimeRegistrations) {
                // return empty collection
                $this->initTimeRegistrations();
            } else {
                $collTimeRegistrations = ChildTimeRegistrationQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTimeRegistrationsPartial && count($collTimeRegistrations)) {
                        $this->initTimeRegistrations(false);

                        foreach ($collTimeRegistrations as $obj) {
                            if (false == $this->collTimeRegistrations->contains($obj)) {
                                $this->collTimeRegistrations->append($obj);
                            }
                        }

                        $this->collTimeRegistrationsPartial = true;
                    }

                    return $collTimeRegistrations;
                }

                if ($partial && $this->collTimeRegistrations) {
                    foreach ($this->collTimeRegistrations as $obj) {
                        if ($obj->isNew()) {
                            $collTimeRegistrations[] = $obj;
                        }
                    }
                }

                $this->collTimeRegistrations = $collTimeRegistrations;
                $this->collTimeRegistrationsPartial = false;
            }
        }

        return $this->collTimeRegistrations;
    }

    /**
     * Sets a collection of ChildTimeRegistration objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $timeRegistrations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTimeRegistrations(Collection $timeRegistrations, ConnectionInterface $con = null)
    {
        /** @var ChildTimeRegistration[] $timeRegistrationsToDelete */
        $timeRegistrationsToDelete = $this->getTimeRegistrations(new Criteria(), $con)->diff($timeRegistrations);

        
        $this->timeRegistrationsScheduledForDeletion = $timeRegistrationsToDelete;

        foreach ($timeRegistrationsToDelete as $timeRegistrationRemoved) {
            $timeRegistrationRemoved->setUser(null);
        }

        $this->collTimeRegistrations = null;
        foreach ($timeRegistrations as $timeRegistration) {
            $this->addTimeRegistration($timeRegistration);
        }

        $this->collTimeRegistrations = $timeRegistrations;
        $this->collTimeRegistrationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TimeRegistration objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TimeRegistration objects.
     * @throws PropelException
     */
    public function countTimeRegistrations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTimeRegistrationsPartial && !$this->isNew();
        if (null === $this->collTimeRegistrations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTimeRegistrations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTimeRegistrations());
            }

            $query = ChildTimeRegistrationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collTimeRegistrations);
    }

    /**
     * Method called to associate a ChildTimeRegistration object to this object
     * through the ChildTimeRegistration foreign key attribute.
     *
     * @param  ChildTimeRegistration $l ChildTimeRegistration
     * @return $this|\User The current object (for fluent API support)
     */
    public function addTimeRegistration(ChildTimeRegistration $l)
    {
        if ($this->collTimeRegistrations === null) {
            $this->initTimeRegistrations();
            $this->collTimeRegistrationsPartial = true;
        }

        if (!$this->collTimeRegistrations->contains($l)) {
            $this->doAddTimeRegistration($l);

            if ($this->timeRegistrationsScheduledForDeletion and $this->timeRegistrationsScheduledForDeletion->contains($l)) {
                $this->timeRegistrationsScheduledForDeletion->remove($this->timeRegistrationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTimeRegistration $timeRegistration The ChildTimeRegistration object to add.
     */
    protected function doAddTimeRegistration(ChildTimeRegistration $timeRegistration)
    {
        $this->collTimeRegistrations[]= $timeRegistration;
        $timeRegistration->setUser($this);
    }

    /**
     * @param  ChildTimeRegistration $timeRegistration The ChildTimeRegistration object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTimeRegistration(ChildTimeRegistration $timeRegistration)
    {
        if ($this->getTimeRegistrations()->contains($timeRegistration)) {
            $pos = $this->collTimeRegistrations->search($timeRegistration);
            $this->collTimeRegistrations->remove($pos);
            if (null === $this->timeRegistrationsScheduledForDeletion) {
                $this->timeRegistrationsScheduledForDeletion = clone $this->collTimeRegistrations;
                $this->timeRegistrationsScheduledForDeletion->clear();
            }
            $this->timeRegistrationsScheduledForDeletion[]= clone $timeRegistration;
            $timeRegistration->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TimeRegistrations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTimeRegistration[] List of ChildTimeRegistration objects
     */
    public function getTimeRegistrationsJoinTask(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTimeRegistrationQuery::create(null, $criteria);
        $query->joinWith('Task', $joinBehavior);

        return $this->getTimeRegistrations($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related TimeRegistrations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTimeRegistration[] List of ChildTimeRegistration objects
     */
    public function getTimeRegistrationsJoinTeam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTimeRegistrationQuery::create(null, $criteria);
        $query->joinWith('Team', $joinBehavior);

        return $this->getTimeRegistrations($query, $con);
    }

    /**
     * Gets a single ChildUserInfo object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildUserInfo
     * @throws PropelException
     */
    public function getUserInfo(ConnectionInterface $con = null)
    {

        if ($this->singleUserInfo === null && !$this->isNew()) {
            $this->singleUserInfo = ChildUserInfoQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleUserInfo;
    }

    /**
     * Sets a single ChildUserInfo object as related to this object by a one-to-one relationship.
     *
     * @param  ChildUserInfo $v ChildUserInfo
     * @return $this|\User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserInfo(ChildUserInfo $v = null)
    {
        $this->singleUserInfo = $v;

        // Make sure that that the passed-in ChildUserInfo isn't already associated with this object
        if ($v !== null && $v->getUser(null, false) === null) {
            $v->setUser($this);
        }

        return $this;
    }

    /**
     * Clears out the collCalendars collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCalendars()
     */
    public function clearCalendars()
    {
        $this->collCalendars = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCalendars collection loaded partially.
     */
    public function resetPartialCalendars($v = true)
    {
        $this->collCalendarsPartial = $v;
    }

    /**
     * Initializes the collCalendars collection.
     *
     * By default this just sets the collCalendars collection to an empty array (like clearcollCalendars());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCalendars($overrideExisting = true)
    {
        if (null !== $this->collCalendars && !$overrideExisting) {
            return;
        }

        $collectionClassName = CalendarTableMap::getTableMap()->getCollectionClassName();

        $this->collCalendars = new $collectionClassName;
        $this->collCalendars->setModel('\Calendar');
    }

    /**
     * Gets an array of ChildCalendar objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCalendar[] List of ChildCalendar objects
     * @throws PropelException
     */
    public function getCalendars(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCalendarsPartial && !$this->isNew();
        if (null === $this->collCalendars || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCalendars) {
                // return empty collection
                $this->initCalendars();
            } else {
                $collCalendars = ChildCalendarQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCalendarsPartial && count($collCalendars)) {
                        $this->initCalendars(false);

                        foreach ($collCalendars as $obj) {
                            if (false == $this->collCalendars->contains($obj)) {
                                $this->collCalendars->append($obj);
                            }
                        }

                        $this->collCalendarsPartial = true;
                    }

                    return $collCalendars;
                }

                if ($partial && $this->collCalendars) {
                    foreach ($this->collCalendars as $obj) {
                        if ($obj->isNew()) {
                            $collCalendars[] = $obj;
                        }
                    }
                }

                $this->collCalendars = $collCalendars;
                $this->collCalendarsPartial = false;
            }
        }

        return $this->collCalendars;
    }

    /**
     * Sets a collection of ChildCalendar objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $calendars A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCalendars(Collection $calendars, ConnectionInterface $con = null)
    {
        /** @var ChildCalendar[] $calendarsToDelete */
        $calendarsToDelete = $this->getCalendars(new Criteria(), $con)->diff($calendars);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->calendarsScheduledForDeletion = clone $calendarsToDelete;

        foreach ($calendarsToDelete as $calendarRemoved) {
            $calendarRemoved->setUser(null);
        }

        $this->collCalendars = null;
        foreach ($calendars as $calendar) {
            $this->addCalendar($calendar);
        }

        $this->collCalendars = $calendars;
        $this->collCalendarsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Calendar objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Calendar objects.
     * @throws PropelException
     */
    public function countCalendars(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCalendarsPartial && !$this->isNew();
        if (null === $this->collCalendars || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCalendars) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCalendars());
            }

            $query = ChildCalendarQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collCalendars);
    }

    /**
     * Method called to associate a ChildCalendar object to this object
     * through the ChildCalendar foreign key attribute.
     *
     * @param  ChildCalendar $l ChildCalendar
     * @return $this|\User The current object (for fluent API support)
     */
    public function addCalendar(ChildCalendar $l)
    {
        if ($this->collCalendars === null) {
            $this->initCalendars();
            $this->collCalendarsPartial = true;
        }

        if (!$this->collCalendars->contains($l)) {
            $this->doAddCalendar($l);

            if ($this->calendarsScheduledForDeletion and $this->calendarsScheduledForDeletion->contains($l)) {
                $this->calendarsScheduledForDeletion->remove($this->calendarsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCalendar $calendar The ChildCalendar object to add.
     */
    protected function doAddCalendar(ChildCalendar $calendar)
    {
        $this->collCalendars[]= $calendar;
        $calendar->setUser($this);
    }

    /**
     * @param  ChildCalendar $calendar The ChildCalendar object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeCalendar(ChildCalendar $calendar)
    {
        if ($this->getCalendars()->contains($calendar)) {
            $pos = $this->collCalendars->search($calendar);
            $this->collCalendars->remove($pos);
            if (null === $this->calendarsScheduledForDeletion) {
                $this->calendarsScheduledForDeletion = clone $this->collCalendars;
                $this->calendarsScheduledForDeletion->clear();
            }
            $this->calendarsScheduledForDeletion[]= clone $calendar;
            $calendar->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Calendars from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCalendar[] List of ChildCalendar objects
     */
    public function getCalendarsJoinProject(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCalendarQuery::create(null, $criteria);
        $query->joinWith('Project', $joinBehavior);

        return $this->getCalendars($query, $con);
    }

    /**
     * Clears out the collUserTeams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserTeams()
     */
    public function clearUserTeams()
    {
        $this->collUserTeams = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserTeams collection loaded partially.
     */
    public function resetPartialUserTeams($v = true)
    {
        $this->collUserTeamsPartial = $v;
    }

    /**
     * Initializes the collUserTeams collection.
     *
     * By default this just sets the collUserTeams collection to an empty array (like clearcollUserTeams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserTeams($overrideExisting = true)
    {
        if (null !== $this->collUserTeams && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserTeamTableMap::getTableMap()->getCollectionClassName();

        $this->collUserTeams = new $collectionClassName;
        $this->collUserTeams->setModel('\UserTeam');
    }

    /**
     * Gets an array of ChildUserTeam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserTeam[] List of ChildUserTeam objects
     * @throws PropelException
     */
    public function getUserTeams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserTeamsPartial && !$this->isNew();
        if (null === $this->collUserTeams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserTeams) {
                // return empty collection
                $this->initUserTeams();
            } else {
                $collUserTeams = ChildUserTeamQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserTeamsPartial && count($collUserTeams)) {
                        $this->initUserTeams(false);

                        foreach ($collUserTeams as $obj) {
                            if (false == $this->collUserTeams->contains($obj)) {
                                $this->collUserTeams->append($obj);
                            }
                        }

                        $this->collUserTeamsPartial = true;
                    }

                    return $collUserTeams;
                }

                if ($partial && $this->collUserTeams) {
                    foreach ($this->collUserTeams as $obj) {
                        if ($obj->isNew()) {
                            $collUserTeams[] = $obj;
                        }
                    }
                }

                $this->collUserTeams = $collUserTeams;
                $this->collUserTeamsPartial = false;
            }
        }

        return $this->collUserTeams;
    }

    /**
     * Sets a collection of ChildUserTeam objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userTeams A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setUserTeams(Collection $userTeams, ConnectionInterface $con = null)
    {
        /** @var ChildUserTeam[] $userTeamsToDelete */
        $userTeamsToDelete = $this->getUserTeams(new Criteria(), $con)->diff($userTeams);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userTeamsScheduledForDeletion = clone $userTeamsToDelete;

        foreach ($userTeamsToDelete as $userTeamRemoved) {
            $userTeamRemoved->setUser(null);
        }

        $this->collUserTeams = null;
        foreach ($userTeams as $userTeam) {
            $this->addUserTeam($userTeam);
        }

        $this->collUserTeams = $userTeams;
        $this->collUserTeamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserTeam objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserTeam objects.
     * @throws PropelException
     */
    public function countUserTeams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserTeamsPartial && !$this->isNew();
        if (null === $this->collUserTeams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserTeams) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserTeams());
            }

            $query = ChildUserTeamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserTeams);
    }

    /**
     * Method called to associate a ChildUserTeam object to this object
     * through the ChildUserTeam foreign key attribute.
     *
     * @param  ChildUserTeam $l ChildUserTeam
     * @return $this|\User The current object (for fluent API support)
     */
    public function addUserTeam(ChildUserTeam $l)
    {
        if ($this->collUserTeams === null) {
            $this->initUserTeams();
            $this->collUserTeamsPartial = true;
        }

        if (!$this->collUserTeams->contains($l)) {
            $this->doAddUserTeam($l);

            if ($this->userTeamsScheduledForDeletion and $this->userTeamsScheduledForDeletion->contains($l)) {
                $this->userTeamsScheduledForDeletion->remove($this->userTeamsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserTeam $userTeam The ChildUserTeam object to add.
     */
    protected function doAddUserTeam(ChildUserTeam $userTeam)
    {
        $this->collUserTeams[]= $userTeam;
        $userTeam->setUser($this);
    }

    /**
     * @param  ChildUserTeam $userTeam The ChildUserTeam object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeUserTeam(ChildUserTeam $userTeam)
    {
        if ($this->getUserTeams()->contains($userTeam)) {
            $pos = $this->collUserTeams->search($userTeam);
            $this->collUserTeams->remove($pos);
            if (null === $this->userTeamsScheduledForDeletion) {
                $this->userTeamsScheduledForDeletion = clone $this->collUserTeams;
                $this->userTeamsScheduledForDeletion->clear();
            }
            $this->userTeamsScheduledForDeletion[]= clone $userTeam;
            $userTeam->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related UserTeams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserTeam[] List of ChildUserTeam objects
     */
    public function getUserTeamsJoinTeam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserTeamQuery::create(null, $criteria);
        $query->joinWith('Team', $joinBehavior);

        return $this->getUserTeams($query, $con);
    }

    /**
     * Gets a single ChildValidLink object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildValidLink
     * @throws PropelException
     */
    public function getValidLink(ConnectionInterface $con = null)
    {

        if ($this->singleValidLink === null && !$this->isNew()) {
            $this->singleValidLink = ChildValidLinkQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleValidLink;
    }

    /**
     * Sets a single ChildValidLink object as related to this object by a one-to-one relationship.
     *
     * @param  ChildValidLink $v ChildValidLink
     * @return $this|\User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setValidLink(ChildValidLink $v = null)
    {
        $this->singleValidLink = $v;

        // Make sure that that the passed-in ChildValidLink isn't already associated with this object
        if ($v !== null && $v->getUser(null, false) === null) {
            $v->setUser($this);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->validated = null;
        $this->active = null;
        $this->role = null;
        $this->permanent = null;
        $this->pass_expires_at = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTimeRegistrations) {
                foreach ($this->collTimeRegistrations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleUserInfo) {
                $this->singleUserInfo->clearAllReferences($deep);
            }
            if ($this->collCalendars) {
                foreach ($this->collCalendars as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserTeams) {
                foreach ($this->collUserTeams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleValidLink) {
                $this->singleValidLink->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->collTimeRegistrations = null;
        $this->singleUserInfo = null;
        $this->collCalendars = null;
        $this->collUserTeams = null;
        $this->singleValidLink = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior
    
    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildUser The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[UserTableMap::COL_UPDATED_AT] = true;
    
        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

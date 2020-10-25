CREATE TABLE {prefix} _{dirname} _mailjob (
    mailjob_id INT(
    10
) NOT NULL AUTO_INCREMENT,
    title VARCHAR (
    255
) NOT NULL DEFAULT '',
    BODY TEXT NOT NULL,
    from_name VARCHAR (
    255
) DEFAULT NULL,
    from_email VARCHAR (
    255
) DEFAULT NULL,
    is_pm TINYINT (
    1
) NOT NULL DEFAULT '0',
    is_mail TINYINT (
    1
) NOT NULL DEFAULT '0',
    create_unixtime INT (
    10
) NOT NULL DEFAULT '0',
    PRIMARY KEY (
    mailjob_id
)
    ) ENGINE = ISAM;

CREATE TABLE {prefix} _{dirname} _mailjob_link (
    mailjob_id INT(
    10
) NOT NULL DEFAULT '0',
    uid MEDIUMINT (
    8
) NOT NULL DEFAULT '0',
    retry TINYINT (
    3
) NOT NULL DEFAULT '0',
    message VARCHAR (
    255
) DEFAULT NULL,
    PRIMARY KEY (
    mailjob_id,
    uid
)
    ) ENGINE = ISAM;

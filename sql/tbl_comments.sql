CREATE TABLE tbl_comments (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullname varchar(50) NOT NULL,
    comment text NOT NULL,
    comment_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
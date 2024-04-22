CREATE TABLE tblMails (
    mailId int primary key AUTO_INCREMENT,
    mailToEmail varchar(1024) not null,
    mailToName varchar(1024) not null,
    mailFromEmail varchar(255) not null,
    mailFromName varchar(255) not null,
    mailSubject varchar(255) not null,
    mailContent longtext,
    mailType char(1) not null default '0',
    mailTime datetime default CURRENT_TIMESTAMP,
    mailIsDeleted char(1) default '0',
    mailHasAttachment char(1),
    mailIsRead char(1)
);

CREATE TABLE tblAttachment (
    atcId int primary key AUTO_INCREMENT,
    atcMailId int not null,
    FOREIGN KEY (atcMailId) REFERENCES tblMails (mailId),
    atcLocation varchar(1024) not null,
    atcIsDeleted char(1) default '0'
);

CREATE TABLE tblUserRole (
    userRoleId int primary key AUTO_INCREMENT,
    userRoleName varchar(255) not null,
    userRoleDescription varchar(255) not null,
    userRoleMailReadAccess char(1) not null,
    userRoleMailSendAccess char(1) not null,
    userRoleIsDeleted char(1) not null default '0'
);

CREATE TABLE tblUser (
    userId int primary key AUTO_INCREMENT,
    userFirstName varchar(255) not null,
    userLastName varchar(255) not null,
    userName varchar(16) not null,
    userPassword char(128) not null,
    userEmail varchar(255) not null,
    userPhone char(10) not null,
    userRole int not null,
    FOREIGN KEY (userRole) REFERENCES tblUserRole (userRoleId),
    userIsEmailVerified char(1) not null default '0',
    userIsContactNumberVerified char(1) not null default '0',
    userIsDeleted char(1) not null default '0'
);

INSERT INTO tblUserRole (userRoleName, userRoleDescription, userRoleMailReadAccess, userRoleMailSendAccess, userRoleIsDeleted) VALUES ('admin', 'System Admin', '1', '1', '0');
INSERT INTO tblUser (userFirstName,userLastName,userName,userPassword,userEmail,userPhone,userRole,userIsEmailVerified,userIsContactNumberVerified,userIsDeleted) VALUES ('Jay', 'Chauhan', 'admin_jay', 'fcd99081360cc7ac32aa752097931b57537a0bf4026ac923953e0039e821a3872cc492d1e15fe68b7f78fa2dce94648687445d6ee15d2f3766d62d9bc2af173c', 'contact@dj-jay.in', '9313440532', 1, '1', '1', '0');
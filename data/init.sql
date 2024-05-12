
CREATE TABLE user (
    id int AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    created_at varchar(255) NOT NULL,
    is_enabled boolean NOT NULL DEFAULT true,
    PRIMARY KEY(id)
);

INSERT INTO user ( username, password, created_at, is_enabled ) VALUES("admin", "unhashed-password", "2021-01-05", 0);


CREATE TABLE post (
    id int AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    body varchar(255),
    user_id int NOT NULL,
    created_at date,
    updated_at date,
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES user (id)
);

INSERT INTO post ( title, body, user_id, created_at)
VALUES("Here's our first post","This is the body of the first post.It is split into paragraphs.",1,"2014-11-11");
INSERT INTO post ( title, body, user_id, created_at) 
VALUES("Now for a second article","This is the body of the second post.This is another paragraph.",1,"2015-01-01");
INSERT INTO post ( title, body, user_id, created_at) 
VALUES("The third article","This is the body of the 3th post.This is another paragraph of the 3th article.",1,"2017-05-11");



CREATE TABLE comment (
    id int AUTO_INCREMENT,
    post_id int NOT NULL,
    created_at date,
    name varchar(255) NOT NULL,
    website varchar(255),
    text varchar(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (post_id) REFERENCES post (id)
);

INSERT INTO comment (post_id, created_at ,name,website,text)
VALUES (1,"2014-12-05","Amin","www.amin.com","This is a good job");
INSERT INTO comment (post_id, created_at ,name,website,text)
VALUES (1,"2015-1-25","Leo","www.leo.com","Agree with amin");
INSERT INTO comment (post_id, created_at ,name,website,text)
VALUES (2,"2016-2-25","Leo","www.leo.com","like this post");

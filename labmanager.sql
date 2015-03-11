CREATE TABLE users (id integer primary key autoincrement, username, password);
CREATE TABLE settings (id integer primary key autoincrement, set1, set2);
CREATE TABLE groups (id integer primary key autoincrement, groupname, members);
CREATE TABLE locations (id integer primary key autoincrement, name, labs, devices, details);
CREATE TABLE labs (id integer primary key autoincrement, name, location, devices, details);
CREATE TABLE racks (id integer primary key autoincrement, name, lab, location, devices, deviceorder, details);
CREATE TABLE devices (id integer primary key autoincrement, name, image, rack, lab, location, devices, details);
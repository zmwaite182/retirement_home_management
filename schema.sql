DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS rosters;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS groups;

CREATE TABLE users (
    user_id bigint AUTO_INCREMENT PRIMARY KEY,
    job varchar(15),
    f_name varchar(25),
    l_name varchar(25),
    email varchar(50) UNIQUE,
    phone  char(10),
    user_password varchar(25),
    dob date,
    reg_approval char(1)
);

CREATE TABLE patients (
    user_id integer REFERENCES users(user_id),
    group_id integer REFERENCES groups(group_id),
    admission_date date,
    family_code integer,
    emergency_contact varchar(50),
    relation_ec varchar(25)
);

CREATE TABLE roles (
    job varchar(15),
    access_level integer
);

CREATE TABLE employees (
    user_id integer REFERENCES users(user_id),
    f_name varchar(25) REFERENCES users(fName),
    l_name varchar(25) REFERENCES users(lName),
    job varchar(15) REFERENCES users(job),
    salary integer,
    group_id integer REFERENCES groups(group_id)
);

CREATE TABLE rosters (
    roster_date date PRIMARY KEY,
    supervisor_id varchar(25) REFERENCES users(user_id),
    doctor_id varchar(25) REFERENCES users(user_id),
    care_giver_1 varchar(25) REFERENCES users(user_id),
    patient_group_1 varchar(25) REFERENCES groups(group_id),
    care_giver_2 varchar(25) REFERENCES users(user_id),
    patient_group_2 varchar(25) REFERENCES groups(group_id),
    care_giver_3 varchar(25) REFERENCES users(user_id),
    patient_group_3 varchar(25) REFERENCES groups(group_id),
    care_giver_4 varchar(25) REFERENCES users(user_id),
    patient_group_4 varchar(25) REFERENCES groups(group_id)
);

CREATE TABLE appointments (
    patient_id integer REFERENCES patients(patient_id),
    app_date date,
    comment varchar(100),
    morning_med boolean,
    afternoon_med boolean,
    night_med boolean,
    doctor_id integer REFERENCES employees(employee_id)
);

CREATE TABLE groups (
    group_id bigint PRIMARY KEY
);


-- MOCK DATA
INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob, reg_approval) VALUES ('admin', 'Zane', 'Witman', 'ad@min', '818-334-1234', 'admin', '2014-11-10', 1), ('caregiver', 'Zach', 'Fitman', 'c@c', '717-666-6666', 'c', '2015-10-10', 2), ('caregiver', 'Zyzz', 'Brah', 'c2@c', '717-666-6666', 'c', '2015-10-10', 2), ('caregiver', 'Henry', 'Apple', 'c3@c', '717-666-6666', 'c', '2015-10-10', 2), ('caregiver', 'Review', 'Brah', 'c4@c', '717-666-6666', 'c', '2015-10-10', 2), ('doctor', 'Dr.Ya', 'Motha', 'd@d', '717-666-6666', 'd', '2015-10-10', 2), ('supervisor', 'Mary', 'Evil', 's@s', '717-666-6666', 's', '2015-10-10', 2);
INSERT INTO `employees` (user_id, f_name, l_name, job) VALUES ('1', 'Zane', 'Witman', 'admin');
INSERT INTO `groups` (group_id) VALUES ('1'), ('2'), ('3'), ('4');

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS reg_approval;
DROP TABLE IF EXISTS rosters;
DROP TABLE IF EXISTS appointments;

CREATE TABLE users (
    user_id bigint AUTO_INCREMENT PRIMARY KEY,
    job varchar(15),
    f_name varchar(25),
    l_name varchar(25),
    email varchar(50) UNIQUE,
    phone  char(10),
    user_password varchar(25),
    dob date
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

CREATE TABLE reg_approval (
    f_name varchar(25) REFERENCES users(f_name),
    l_name varchar(25) REFERENCES users(l_name),
    job varchar(25) REFERENCES jobs(job)
);

CREATE TABLE rosters (
    supervisor_name varchar(25) REFERENCES users(f_name),
    doctor_name varchar(25) REFERENCES users(job),
    care_giver_1 varchar(25) REFERENCES users(f_name),
    patient_group_1 varchar(25) REFERENCES groups(group_id),
    care_giver_2 varchar(25) REFERENCES users(f_name),
    patient_group_2 varchar(25) REFERENCES groups(group_id),
    care_giver_3 varchar(25) REFERENCES users(f_name),
    patient_group_3 varchar(25) REFERENCES groups(group_id),
    care_giver_4 varchar(25) REFERENCES users(f_name),
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

INSERT INTO users (job, f_name, l_name, email, phone, user_password, dob) VALUES ('admin', 'Zane', 'Witman', 'ad@min', '717-666-6666', 'admin', '2015-10-10');
INSERT INTO `employees` (user_id, f_name, l_name, job) VALUES ('1', 'Zane', 'Witman', 'admin');

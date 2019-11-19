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
    user_password varchar(255),
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
    care_giver_2 varchar(25) REFERENCES users(user_id),
    care_giver_3 varchar(25) REFERENCES users(user_id),
    care_giver_4 varchar(25) REFERENCES users(user_id)
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

-- Passwords: admin = 'admin' care1-4 = 'c' doctor = 'd' supervisor = 's'
INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob, reg_approval) VALUES ('admin', 'Zane', 'Witman', 'ad@min', '717-666-6666', '$2y$10$WL.sbnzHlkoodv6hhUbD6ehKYZ3cggoyqKJTYA7DT5Bcazg.l4IHq', '2015-10-10', 1);
INSERT INTO `employees` (user_id, f_name, l_name, job) VALUES ('1', 'Zane', 'Witman', 'admin');
INSERT INTO `groups` (group_id) VALUES ('1'), ('2'), ('3'), ('4');
INSERT INTO `roles` (job, access_level) VALUES ('patient', '6'), ('family_member', '6'), ('caregiver', '5'),('doctor', '4'),('supervisor', '2'),('admin', '1');
-- Mock data \/
INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob, reg_approval) VALUES ('caregiver', 'Zane', 'Witman', 'c@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Zyzz', 'Brah', 'c2@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Henry', 'Apple', 'c3@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Review', 'Brah', 'c4@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('doctor', 'Dr.Ya', 'Motha', 'd@d', '717-666-6666', '$2y$10$HpsaYH7/4O0s/OYTYaxhE.hMewdb3OUixiKecbMIKyevyrjnlu1Be', '2015-10-10', 2), ('supervisor', 'Mary', 'Evil', 's@s', '717-666-6666', '$2y$10$mmXJleIvQ2MNHs2ceN53nO80Ewh4r9OcvvtEpa0nlgMF.mdMVV0S2', '2015-10-10', 2);

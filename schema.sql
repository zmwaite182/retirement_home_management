DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS rosters;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS activities;

CREATE TABLE users (
    user_id bigint AUTO_INCREMENT PRIMARY KEY,
    job varchar(15),
    f_name varchar(25),
    l_name varchar(25),
    email varchar(50) UNIQUE,
    phone  char(12),
    user_password varchar(255),
    dob date,
    reg_approval char(1)
);

CREATE TABLE patients (
    patient_id bigint AUTO_INCREMENT PRIMARY KEY,
    user_id integer REFERENCES users(user_id),
    group_id integer REFERENCES groups(group_id),
    admission_date date,
    family_code integer,
    emergency_contact varchar(50),
    relation_ec varchar(25),
    payment_due integer,
    last_payment date
);

CREATE TABLE employees (
    employee_id bigint AUTO_INCREMENT PRIMARY KEY,
    user_id integer REFERENCES users(user_id),
    salary integer
);

CREATE TABLE roles (
    job varchar(15),
    access_level integer
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
    patient_user_id integer REFERENCES users(user_id),
    app_date date,
    comment varchar(100),
    morning_med varchar(25),
    afternoon_med varchar(25),
    night_med varchar(25),
    doctor_id integer REFERENCES users(user_id),
    confirm_appt boolean
);

CREATE TABLE activities (
    patient_id integer REFERENCES users(user_id),
    activity_date date,
    morning_med boolean,
    afternoon_med boolean,
    night_med boolean,
    breakfast boolean,
    lunch boolean,
    dinner boolean
);

-- Passwords: admin = 'admin' care1-4 = 'c' doctor = 'd' supervisor = 's'

-- patient1 = 'p1' patient2 = 'p2'
INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob, reg_approval) VALUES ('admin', 'Zane', 'Witman', 'ad@min', '717-666-6666', '$2y$10$WL.sbnzHlkoodv6hhUbD6ehKYZ3cggoyqKJTYA7DT5Bcazg.l4IHq', '2015-10-10', 1), ('caregiver', 'Caregiver', 'One', 'c@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Caregiver', 'Two', 'c2@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Caregiver', 'Three', 'c3@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('caregiver', 'Caregiver', 'Four', 'c4@c', '717-666-6666', '$2y$10$MCYQk24SbukOiEkmCbLn/.s2RE55DaGsxK.GjVR4CGfVy/1mEJ1Aq', '2015-10-10', 2), ('doctor', 'Dr.', 'Doctor', 'd@d', '717-666-6666', '$2y$10$HpsaYH7/4O0s/OYTYaxhE.hMewdb3OUixiKecbMIKyevyrjnlu1Be', '2015-10-10', 2), ('supervisor', 'Supervisor', 'One', 's@s', '717-666-6666', '$2y$10$mmXJleIvQ2MNHs2ceN53nO80Ewh4r9OcvvtEpa0nlgMF.mdMVV0S2', '2015-10-10', 2), ('patient', 'Patient', 'One', 'p@1', '111-111-1111', '$2y$10$07mXBu5ee9DfvvR6MRr74.jwR1VghGDaOZnW39oPgqbz52fFcqpSG', '2013-03-26', 2), ('patient', 'Patient', 'Two', 'p@2', '222-222-2222', '$2y$10$TtSkWlXDNZtVwkiw86txsODt0pvGGI3ngCLIli/PoN83cQ.e/DGPO', '2004-11-11', 2);
INSERT INTO `employees` (user_id) VALUES ('1'), ('2'), ('3'), ('4'), ('5'), ('6'), ('7');
INSERT INTO `patients` (user_id, family_code, emergency_contact, relation_ec, payment_due, last_payment) VALUES ('8', 123, 'Regina', 'Mom', 10, '2019-11-22'), ('9', 321, 'Richard', 'Dad', 20, '2019-11-21');
INSERT INTO `roles` (job, access_level) VALUES ('patient', '6'), ('family_member', '6'), ('caregiver', '5'),('doctor', '4'),('supervisor', '2'),('admin', '1');
INSERT INTO `appointments` (patient_user_id, app_date, comment, morning_med, afternoon_med, night_med, doctor_id, confirm_appt) VALUES (8, CURDATE(), null, null, null, null, 6, null), (9, CURDATE(), 'Excellent Condition!', 'Pennicillin', 'Isotretinoine', 'Pepto Bismol', 6, 1), (8, CURDATE()-1, 'Recovering Quickly', 'Pepto Bismol', 'Pepto Bismol', 'Pepto Bismol', 6, 1), (9, CURDATE()+1, null, null, null, null, 6, null);

Create database FitStudio;

Use FitStudio;

CREATE TABLE Admin (
    a_name VARCHAR(255),
    a_email VARCHAR(255) PRIMARY KEY,
    a_password VARCHAR(255),
    a_phone VARCHAR(20)
);


CREATE TABLE Member_details_1 (
    username VARCHAR(255) PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    birth_date DATE,
    sex VARCHAR(10),
    address VARCHAR(255),
    email VARCHAR(255)
);

CREATE TABLE Member_details_2 (
    email VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255)
);

CREATE TABLE member_phn_details (
    mem_username VARCHAR(255),
    phone VARCHAR(11),
    PRIMARY KEY (mem_username, phone),
    FOREIGN KEY (mem_username) REFERENCES Member_details_1(username)
);

CREATE TABLE Notifies (
    supervisor_ad_email VARCHAR(255),
    mem_email VARCHAR(255),
    sent_time TIMESTAMP,
    message TEXT,
    PRIMARY KEY (supervisor_ad_email, mem_email,sent_time),
    FOREIGN KEY (mem_email) REFERENCES Member_details_2(email),
    FOREIGN KEY (supervisor_ad_email) REFERENCES Admin(a_email)
);

CREATE TABLE Purchases (
    wplan_id INT,
    customer_username VARCHAR(255),
    payment_type VARCHAR(50),
    PRIMARY KEY (wplan_id, customer_username)
);

CREATE TABLE Workout_plan_1 (
    plan_id INT,
    video_name VARCHAR(255),
    wp_videos VARCHAR(255),
    PRIMARY KEY (plan_id, video_name),
    FOREIGN KEY (plan_id) REFERENCES Purchases(wplan_id)
);

CREATE TABLE Workout_plan_2 (
    SN INT PRIMARY KEY,
    article_links VARCHAR(255) ,
    plan_id INT,
    meal_plan TEXT,
    FOREIGN KEY (plan_id) REFERENCES Purchases(wplan_id)
);

CREATE TABLE Daily_Challenges (
    dc_id INT PRIMARY KEY,
    challenge_name VARCHAR(255),
    dc_links VARCHAR(255)
);

CREATE TABLE Follows (
    fmem_username VARCHAR(255),
    fdc_id INT,
    PRIMARY KEY (fmem_username, fdc_id),
    FOREIGN KEY (fmem_username) REFERENCES Member_details_1(username),
    FOREIGN KEY (fdc_id) REFERENCES Daily_Challenges(dc_id)
);


CREATE TABLE Inventory (
    equipment_name VARCHAR(255) PRIMARY KEY,
    quantity INT);

CREATE TABLE Manages (
    ad_email VARCHAR(255),
    in_equipment_name VARCHAR(255),
    purchased_date date,
    purchased_quantity INT,
    PRIMARY KEY (ad_email, in_equipment_name, purchased_date),
    FOREIGN KEY (ad_email) REFERENCES Admin(a_email),
    FOREIGN KEY (in_equipment_name) REFERENCES Inventory(equipment_name)    
    );


CREATE TABLE Progress_Report (
    last_visit_date DATE,
    Attendance INT,
    Streak INT,
    received_username VARCHAR(255) PRIMARY KEY,
    FOREIGN KEY (received_username) REFERENCES Member_details_1(username)
);


CREATE TABLE BMI_Calculator(
    mem_username VARCHAR(255),
    height DECIMAL(5,2),
    weight DECIMAL(5,2),
    FOREIGN KEY (mem_username) REFERENCES Member_details_1(username)
);



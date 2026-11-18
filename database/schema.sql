-- Schema for the Activity Details CRUD application.
-- Run this once against a MySQL/MariaDB server to create the database used by
-- ActivityDetailsCRUD.php. Matches the Activity and Feedback model classes exactly.

CREATE DATABASE IF NOT EXISTS activity_details_app
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE activity_details_app;

CREATE TABLE IF NOT EXISTS activity_details (
    Id            INT PRIMARY KEY,
    user_id       INT NOT NULL,
    start_date    DATE NOT NULL,
    end_date      DATE NOT NULL,
    Activity_Name VARCHAR(222) NOT NULL,
    attachment    VARCHAR(222) NOT NULL DEFAULT '',
    Major         VARCHAR(222) NOT NULL
);

CREATE TABLE IF NOT EXISTS feedback (
    Id            INT AUTO_INCREMENT PRIMARY KEY,
    FullName      VARCHAR(222) NOT NULL,
    email         VARCHAR(222) NOT NULL,
    Instructor_id INT NOT NULL,
    Message       VARCHAR(500) NOT NULL
);

-- Sample data matching the demo rows shown in the original activitydetails.php
INSERT INTO activity_details (Id, user_id, start_date, end_date, Activity_Name, attachment, Major) VALUES
    (1, 1, '2026-01-10', '2026-02-10', 'Data Analysis Workshop', '', 'Data Analysis'),
    (2, 2, '2026-01-15', '2026-02-15', 'Mobile App Bootcamp', '', 'Mobile Programming'),
    (3, 3, '2026-01-20', '2026-02-20', 'Web Dev Sprint', '', 'Web Development'),
    (4, 4, '2026-01-25', '2026-02-25', 'Digital Marketing Clinic', '', 'Digital Marketing')
ON DUPLICATE KEY UPDATE Id = Id;

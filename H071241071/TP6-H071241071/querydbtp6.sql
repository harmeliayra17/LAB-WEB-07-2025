CREATE DATABASE db_manajemen_proyek;
USE db_manajemen_proyek;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    project_manager_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, role, project_manager_id) 
VALUES ('superadmin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', NULL);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_proyek VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NULL,
    manager_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_tugas VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    status VARCHAR(20) DEFAULT 'belum',
    project_id INT NOT NULL,
    assigned_to INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE projects 
ADD CONSTRAINT fk_projects_manager 
FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE tasks 
ADD CONSTRAINT fk_tasks_project 
FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE;

ALTER TABLE tasks 
ADD CONSTRAINT fk_tasks_user 
FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE CASCADE;
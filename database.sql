-- EduBridge Platform Database Schema
-- Comprehensive database for youth opportunities platform

-- 1. Users Table - Central user management
CREATE TABLE IF NOT EXISTS users (
    userid SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) CHECK (role IN ('Youth','Organization','Admin')),
    datecreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(10) DEFAULT 'Active'
);

-- 2. YouthProfiles Table - Youth-specific information
CREATE TABLE IF NOT EXISTS youthprofiles (
    youthid INT PRIMARY KEY REFERENCES users(userid),
    fullname VARCHAR(150) NOT NULL,
    dateofbirth DATE,
    educationlevel VARCHAR(100),
    interests TEXT,
    availability VARCHAR(50),
    bio TEXT,
    verified BOOLEAN DEFAULT FALSE
);

-- 3. Organizations Table - Organization details
CREATE TABLE IF NOT EXISTS organizations (
    orgid INT PRIMARY KEY REFERENCES users(userid),
    orgname VARCHAR(150) NOT NULL,
    orgtype VARCHAR(100),
    contactperson VARCHAR(100),
    contactemail VARCHAR(100),
    location VARCHAR(150),
    verified BOOLEAN DEFAULT FALSE
);

-- 4. Opportunities Table - Available opportunities
CREATE TABLE IF NOT EXISTS opportunities (
    opportunityid SERIAL PRIMARY KEY,
    orgid INT REFERENCES organizations(orgid),
    title VARCHAR(150) NOT NULL,
    description TEXT,
    requirements TEXT,
    deadline DATE,
    duration VARCHAR(50),
    status VARCHAR(20) DEFAULT 'Open',
    dateposted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Applications Table - Youth applications
CREATE TABLE IF NOT EXISTS applications (
    applicationid SERIAL PRIMARY KEY,
    opportunityid INT REFERENCES opportunities(opportunityid),
    youthid INT REFERENCES youthprofiles(youthid),
    applicationdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',
    feedback TEXT
);

-- 6. Certificates Table - Achievement certificates
CREATE TABLE IF NOT EXISTS certificates (
    certificateid SERIAL PRIMARY KEY,
    youthid INT REFERENCES youthprofiles(youthid),
    opportunityid INT REFERENCES opportunities(opportunityid),
    issuedate DATE DEFAULT CURRENT_DATE,
    filepath VARCHAR(255)
);

-- 7. Skills Table - Available skills
CREATE TABLE IF NOT EXISTS skills (
    skillid SERIAL PRIMARY KEY,
    skillname VARCHAR(100) UNIQUE NOT NULL
);

-- 8. YouthSkills Table - Youth skill associations
CREATE TABLE IF NOT EXISTS youthskills (
    youthid INT REFERENCES youthprofiles(youthid),
    skillid INT REFERENCES skills(skillid),
    PRIMARY KEY (youthid, skillid)
);

-- 9. OpportunitySkills Table - Opportunity skill requirements
CREATE TABLE IF NOT EXISTS opportunityskills (
    opportunityid INT REFERENCES opportunities(opportunityid),
    skillid INT REFERENCES skills(skillid),
    PRIMARY KEY (opportunityid, skillid)
);

-- 10. Verifications Table - User verification system
CREATE TABLE IF NOT EXISTS verifications (
    verificationid SERIAL PRIMARY KEY,
    userid INT REFERENCES users(userid),
    verifiedby INT REFERENCES users(userid),
    verificationtype VARCHAR(100),
    status VARCHAR(20) DEFAULT 'Pending',
    dateverified TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 11. Notifications Table - User notifications
CREATE TABLE IF NOT EXISTS notifications (
    notificationid SERIAL PRIMARY KEY,
    userid INT REFERENCES users(userid),
    message TEXT,
    status VARCHAR(10) DEFAULT 'Unread',
    datesent TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. Reports Table - System reports
CREATE TABLE IF NOT EXISTS reports (
    reportid SERIAL PRIMARY KEY,
    title VARCHAR(150),
    description TEXT,
    generatedon TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    filepath VARCHAR(255)
);

-- Insert sample skills
INSERT INTO skills (skillname) VALUES 
('Programming'), ('Web Development'), ('Graphic Design'), 
('Public Speaking'), ('Leadership'), ('Teamwork'),
('Problem Solving'), ('Communication'), ('Project Management');

-- Insert sample admin user (password is "password")
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin');

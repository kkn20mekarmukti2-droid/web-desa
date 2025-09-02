-- Visitor Counter Database Tables
-- Execute this SQL to create visitor tracking tables

-- Table for storing visitor statistics summary
CREATE TABLE IF NOT EXISTS visitor_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date DATE NOT NULL UNIQUE,
    total_visitors INTEGER DEFAULT 0,
    unique_visitors INTEGER DEFAULT 0,
    page_views INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for detailed visitor logs
CREATE TABLE IF NOT EXISTS visitor_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    page_url VARCHAR(500) NOT NULL,
    referer_url VARCHAR(500),
    session_id VARCHAR(100),
    is_unique_today BOOLEAN DEFAULT 0,
    browser VARCHAR(50),
    device VARCHAR(50),
    country VARCHAR(50),
    city VARCHAR(100),
    visit_duration INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for tracking online users (real-time)
CREATE TABLE IF NOT EXISTS visitors_online (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    session_id VARCHAR(100) NOT NULL UNIQUE,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    page_url VARCHAR(500) NOT NULL,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for popular pages tracking
CREATE TABLE IF NOT EXISTS popular_pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    page_url VARCHAR(500) NOT NULL,
    page_title VARCHAR(200),
    visit_count INTEGER DEFAULT 1,
    last_visited TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(page_url)
);

-- Insert initial data for today if not exists
INSERT OR IGNORE INTO visitor_stats (date, total_visitors, unique_visitors, page_views) 
VALUES (DATE('now'), 0, 0, 0);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_visitor_logs_ip_date ON visitor_logs(ip_address, date(created_at));
CREATE INDEX IF NOT EXISTS idx_visitor_logs_session ON visitor_logs(session_id);
CREATE INDEX IF NOT EXISTS idx_visitors_online_session ON visitors_online(session_id);
CREATE INDEX IF NOT EXISTS idx_visitors_online_activity ON visitors_online(last_activity);
CREATE INDEX IF NOT EXISTS idx_popular_pages_url ON popular_pages(page_url);
CREATE INDEX IF NOT EXISTS idx_visitor_stats_date ON visitor_stats(date);

-- Test data insertion
-- You can uncomment these lines to test the tables
-- INSERT INTO visitor_logs (ip_address, user_agent, page_url, session_id, is_unique_today) 
-- VALUES ('127.0.0.1', 'Mozilla/5.0 Test Browser', '/', 'test_session_123', 1);

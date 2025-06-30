-- Insert age categories
INSERT INTO age_categories (category_name, min_age, max_age, description) VALUES
('U6', 5, 6, 'Basic football skills and coordination'),
('U8', 7, 8, 'Game controlling and personality development'),
('U10', 9, 10, 'Advanced basic skills and rules understanding'),
('U12', 11, 12, 'Position training and team tactics'),
('U14', 13, 14, 'Individual improvement and physical training'),
('U16', 15, 16, 'Advanced tactics and team building'),
('U18', 17, 18, 'Professional preparation and 11v11 play');

-- Insert training schedules
INSERT INTO training_schedules (category_id, day_of_week, start_time) VALUES
(1, 'Tuesday', '16:00:00'),
(1, 'Saturday', '09:00:00'),
(2, 'Tuesday', '16:00:00'),
(2, 'Saturday', '09:00:00'),
(3, 'Tuesday', '17:10:00'),
(3, 'Saturday', '10:10:00'),
(4, 'Wednesday', '16:00:00'),
(4, 'Saturday', '10:10:00'),
(5, 'Wednesday', '17:10:00'),
(5, 'Saturday', '11:30:00'),
(6, 'Thursday', '16:00:00'),
(6, 'Saturday', '13:00:00'),
(7, 'Monday', '16:00:00'),
(7, 'Saturday', '14:30:00');

INSERT IGNORE INTO instrument_families (name) VALUES
  ('Strings'), ('Woodwind'), ('Brass'), ('Percussion'), ('Keyboard');

INSERT IGNORE INTO users (full_name, email) VALUES
  ('Alice Smith','alice@example.com'),
  ('Bob Jones','bob@example.com');

INSERT IGNORE INTO instruments (family_id, name, brand, price, quantity, is_active) VALUES
  (1,'Acoustic Guitar','Yamaha',249.99,10,1),
  (2,'Flute','Gemeinhardt',399.00,5,1),
  (3,'Trumpet','Bach',1200.00,2,1);

INSERT IGNORE INTO orders (user_id, status) VALUES
  (1,'pending'), (2,'paid');

INSERT IGNORE INTO order_items (order_id, instrument_id, unit_price, quantity) VALUES
  (1,1,249.99,1), (2,3,1200.00,1);
-- instrument_families: at least 4 (e.g. Strings, Keys, Percussion, Woodwinds)
INSERT IGNORE INTO instrument_families (name) VALUES
  ('Strings'), ('Woodwinds'), ('Percussion'), ('Keyboard'), ('Brass');

-- users: at least 3 distinct users
INSERT IGNORE INTO users (full_name, email) VALUES
  ('Alice Smith', 'alice@example.com'),
  ('Bob Jones', 'bob@example.com'),
  ('Carol White', 'carol@example.com');

-- instruments: at least 5 across at least 3 families; vary price/quantity; at least one low-stock
INSERT IGNORE INTO instruments (family_id, name, brand, price, quantity, is_active) VALUES
  (1, 'Acoustic Guitar', 'Yamaha', 249.99, 10, 1),
  (1, 'Electric Bass', 'Fender', 599.00, 3, 1),
  (2, 'Flute', 'Gemeinhardt', 399.00, 5, 1),
  (3, 'Snare Drum', 'Pearl', 189.00, 1, 1),
  (4, 'Digital Piano', 'Roland', 899.00, 2, 1),
  (5, 'Trumpet', 'Bach', 1200.00, 0, 1);

-- orders (status: PENDING, PAID, CANCELLED)
INSERT IGNORE INTO orders (user_id, status) VALUES
  (1, 'PENDING'), (2, 'PAID');

INSERT IGNORE INTO order_items (order_id, instrument_id, unit_price, quantity) VALUES
  (1, 1, 249.99, 1), (2, 6, 1200.00, 1);
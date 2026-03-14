Instrument Shop (PHP + MySQL)


This is a small PHP + MySQL project for a university web programming assignment.  
It shows a basic backend API and a simple HTML page to test it.
## Requirements
- PHP 8+
- MySQL
- A web browser
## Setup
1. Create a MySQL database (for example `instrument`).
2. Update `config/database.php` with your MySQL host, database name, user and password.
3. From the project root, run:
```bash
php migration/migrate.php   # create tables
php migration/seed.php      # insert sample data
php -S localhost:8000 -t public


MySQL: Instrument Store

0) Setup
Start MySQL via XAMPP and open the MySQL client.
Create a database named instrument_store.
1) Schema Design (DDL)
Create the following tables with appropriate data types, primary keys,
foreign keys, NOT NULLs, UNIQUEs, sensible defaults.
1. users
• Fields: id, full_name, email, created_at
• Requirements: email must be unique; created_at defaults to current
timestamp.
2. instrument_families
• Fields: id, name
• Requirements: name must be unique.
3. instruments
• Fields: id, family_id, name, brand, price, quantity, is_active, created_at
• Requirements: family_id references instrument_families; price &gt; 0;
quantity ≥ 0; is_active defaults to true/1.
4. orders
• Fields: id, user_id, order_date, status
• Requirements: user_id references users; status limited to a fixed set (e.g.,
PENDING, PAID, CANCELLED); order_date defaults to now.
5. order_items
• Fields: id, order_id, instrument_id, unit_price, quantity
• Requirements: order_id references orders (on delete cascade);
instrument_id references instruments; quantity &gt; 0.

2) Seed Data (DML)
instrument_families: at least 4 rows (e.g., Strings, Keys, Percussion,
Woodwinds).
users: at least 3 distinct users with different emails.
instruments: at least 5 products across at least 3 families; vary price and
quantity; include at least one low-stock item.
3) Basic CRUD on One Table
On instruments:
Read: list all instruments.
Update: increase the price of all instruments in one chosen family by a
percentage (e.g., +5%).
Update: mark one product as inactive.
Delete: remove inactive products.
4) Joins &amp; Derived Columns
Return instruments with their family name, brand, price, and a computed
label:
If quantity &gt; 0 → “In Stock”, else “Out of Stock”.
Sort by family, then by name.
5) Order Creation Workflow
Insert a new row in orders for one existing user (status starts as PENDING).
Insert at least two rows in order_items for that order, each referencing a
different instrument.
Ensure unit_price in order_items captures the current price from
instruments at the time of insertion (not a hard-coded literal).
6) Aggregation &amp; Reporting
Return per-order totals: number of items and total amount (sum of
unit_price × quantity).

Filter to show only orders whose total exceeds a given threshold.
Show, per family, the average instrument price, the number of active
products, and the total stock on hand.
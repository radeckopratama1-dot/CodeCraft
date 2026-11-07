# CodeCraft ⚡ 
### Web-Based Interactive Coding & Computer Network Lab for Junior High Students (SMP)
**Inovasi Karya Mahasiswa STT WASTUKANCANA**

CodeCraft is an interactive educational web platform engineered for junior high school students (SMP) to learn basic programming logic and computer networking concepts (TCP/IP, routing, and packets). Developed as an innovation project by students of **STT WASTUKANCANA**, it is built with **Laravel**, **MySQL (XAMPP)**, **Tailwind CSS**, and **Alpine.js**, featuring a playful editorial/bento design interface inspired by modern creative learning standards.

---

## 🎨 Color Palette & Design Identity

- **Editorial Cream (Background):** `#F4F3EF`
- **Electric Royal Blue (Primary Brand):** `#312ECB`
- **Neon Lime / Chartreuse (Accent & CTAs):** `#D4FF33`
- **Charcoal Matte (Typography & Dark Contrast):** `#1E1E1E`
- **Typography:** *Plus Jakarta Sans* & *Space Grotesk*

---

## 🌟 Key Features

1. **Gamified Real-Time Experience (MySQL-Backed):**
   - Floating live badge on the navbar tracking student XP, Level (auto-calculated per 300 XP), and Daily Streak.
   - Asynchronous AJAX updates (`fetch` to `/lab/complete`) without page reloads.

2. **1:1 Playful Editorial Hero Section:**
   - Bold uppercase headline with an inline neon-lime arrow pill `[ → ]`.
   - Continuous spinning 8-arm blue asterisk and glowing 4-point lime sparkle ornaments.
   - Animated count-up metrics for **2.4K+ Members** and **500+ Lab Simulations**.
   - Interactive `Join us ↗` and `Contact Us ↗` trigger buttons.

3. **5-Card Vertical Staggered Showcase:**
   - 5 rounded cards with staggered heights (center card is tallest, adjacent tall, outer medium).
   - Distinct alternating colorway: **Blue ➔ Black ➔ Blue ➔ Black ➔ Blue**.
   - Custom vector illustrations (Logic blocks, Pen probe, Student avatar with laptop, Tool palette, and Syntax box) with smooth hover-lift effects.

4. **Dynamic "Our Classes" Bento Cards:**
   - Data fetched directly from MySQL `learning_paths` and `lab_modules` tables.
   - 3 Curated Classes:
     - **Beginner Class:** Logic & Basic Coding
     - **Expert Class (Featured Default):** Network & Packet Routing
     - **Pro Class:** Cyber & Algorithm Lab
   - Alpine.js dynamic hover state: middle card active by default (electric blue background, white text, neon lime arrow button), switching automatically to whichever card is hovered.

5. **Interactive Mini-Lab Simulators (Modal):**
   - **Network Packet Simulator:** Visualizes packet flow across `PC (192.168.1.10) ➔ Switch Lab ➔ Gateway Router (10.0.0.1) ➔ Cloud Server (104.21.55.2)`. Features a live packet transmission progress bar, realistic terminal log, latency calculation (ms), and `+25 XP` reward synced to MySQL.
   - **Logic Block Puzzle:** Drag-and-click logic block builder (`[REPEAT 3X] ➔ [MOVE_FORWARD] ➔ [SEND_DATA]`) with syntax validation and `+50 XP` reward.
   - **Caesar Cipher Decoder:** Real-time key shift slider decoding ciphertext into `CODECRAFT` with `+40 XP` reward.

---

## 🗄️ Database Architecture (MySQL)

- `users`: Stores user profile, `xp`, `level`, `streak_days`, and authentication tokens.
- `learning_paths`: Stores syllabus paths, metadata, featured flags, and preview types.
- `lab_modules`: Stores interactive simulator modules, difficulties, initial configs, and XP rewards.
- `user_progress`: Audit logs of student module completions, scores, earned XP, and telemetry (latency, hops, solution keys).

---

## 🚀 Getting Started with XAMPP (Local Environment)

### Prerequisites
- **XAMPP** (Apache & MySQL running on default port `3306`).
- **PHP 8.2+** with `pdo_mysql` extension enabled.
- **Composer**.

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/radeckopratama1-dot/CodeCraft.git
   cd CodeCraft
   ```

2. **Ensure MySQL is running in XAMPP:**
   Make sure the MySQL module in the XAMPP Control Panel is started (green). Default credentials:
   - Host: `127.0.0.1`
   - Port: `3306`
   - User: `root`
   - Password: `(blank)`

3. **Configure Environment:**
   Ensure `.env` matches your XAMPP configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=codecraft_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Install Dependencies (if not already installed):**
   ```bash
   composer install
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(If your default system PHP points to a non-functional installation, use XAMPP PHP explicitly: `C:\xampp\php\php.exe artisan migrate:fresh --seed`)*

6. **Start the Laravel Development Server:**
   ```bash
   php artisan serve
   ```
   Open your browser and navigate to: `http://127.0.0.1:8000`

---

## 🧪 Running Automated Tests

Run the built-in test suite to verify routing, blade compilation, and asynchronous XP sync:
```bash
php artisan test --filter=LabTest
```

---

## 📄 License
Open-source under the [MIT License](LICENSE). Developed for SMP Computer Science & Informatics Education.

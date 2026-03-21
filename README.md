# IoT Workstation Access Control

An IoT-based workstation monitoring system that uses **RFID tapping** to **log in / log out** a user on a workstation PC. The system validates the RFID UID through a **Student API** (server-to-server) and stores usage logs in a **Laravel** backend with an **admin panel**.

## Main Features
- **Tap-to-Log In / Tap-to-Log Out** (RFID UID)
- **Server-side UID validation** (Laravel → Student API)
- **Workstations with slots** (example: 1 workstation = 2 PCs)
- **Device approval** (pending / active / disabled)
- **Session + tap logging** for utilization reports
- **Duplicate protection** using `request_id` (UUID)

## Architecture (Option 1)
**C# Client (per PC)** → **Laravel API** → **Student API** → **MySQL**

### Basic Flow
1. Student taps RFID card.
2. The PC client sends to Laravel:
   - `device_uid`, `workstation_slot_id`, `uid`, `request_id`, `tapped_at`
3. Laravel validates the request, checks the UID with the Student API, and saves logs.
4. The client shows login/logout status.

---

## Roadmap & Progress

### Phase 1 — Core System 📌 (In Progress)
| Feature | Status | Description |
|---|---|---|
| Database Schema & Migrations | ✅ | Tables, foreign keys, indexes for devices, workstations, slots, students, snapshots, sessions, taps |
| Admin Authentication | ⏳ | Admin login and access control |
| Device Management | ⏳ | Register/approve/disable devices, track device status |
| Workstation Management | ⏳ | Create workstations, link device, status control |
| Slot Management | ⏳ | Create/manage slots per workstation (e.g., PC-A / PC-B) |
| Basic UI/UX | ⏳ | Admin pages for CRUD and list views |

---

### Phase 2 — Integration 📌 (Planned)
| Feature | Status | Description |
|---|---|---|
| Student API Integration | 📋 | Server-to-server lookup by UID, error handling, timeouts |
| Device Authentication | 📋 | Token-based auth (store token hash in database) |
| Device Heartbeat (Optional) | 📋 | Update `last_seen_at`, IP logging, auto-register pending devices |
| Environment Configuration | 📋 | `.env` settings for database + Student API configuration |

---

### Phase 3 — Core Functionality (Tap System) 📌 (Planned)
| Feature | Status | Description |
|---|---|---|
| Tap Endpoint | 📋 | `POST /api/rfid/tap` validation + logging |
| Tap Idempotency | 📋 | `request_id` unique to prevent duplicates on retries |
| Tap-to-Login/Logout | 📋 | Toggle session per slot (tap starts/ends session) |
| Rejection Handling | 📋 | Store rejected taps with reasons (invalid UID, device inactive, API down) |
| Concurrency Safety | 📋 | Prevent double sessions per slot (transactions/locking) |

---

### Phase 4 — Client Application (C#) 📌 (Planned)
| Feature | Status | Description |
|---|---|---|
| Client Configuration | 📋 | `api_base_url`, `device_uid`, `workstation_slot_id` |
| Tap Submission | 📋 | Generate `request_id`, send payload, show result |
| UI Feedback | 📋 | Login/logout status and rejection messages |
| Retry & Timeout Handling | 📋 | Safe retries with idempotency |
| Offline Queue (Optional) | 📋 | Store taps locally and resend when online |

---

### Phase 5 — Monitoring & Reporting 📌 (Planned)
| Feature | Status | Description |
|---|---|---|
| Active Sessions View | 📋 | Show who is logged in and which slot is active |
| Utilization Reports | 📋 | Daily/weekly/monthly usage per workstation/slot |
| Tap Audit Log | 📋 | Filter/search accepted + rejected taps |
| Export | 📋 | CSV/PDF export for sessions and taps |

---

### Phase 6 — Security & Deployment 📌 (Planned)
| Feature | Status | Description |
|---|---|---|
| HTTPS Setup | 📋 | Secure API calls (LAN certificate if needed) |
| Rate Limiting | 📋 | Protect tap endpoint per device/IP |
| Backup Plan | 📋 | Scheduled MySQL backups + restore testing |
| Deployment Checklist | 📋 | Device labeling, slot mapping, test cards, maintenance schedule |
| Hardening | 📋 | Admin security, audit logs, workstation PC hardening |

---

### Phase 7 — Future Enhancements 📋 (Planned)
| Feature | Status | Description |
|---|---|---|
| Multi-site Support | 📋 | Support multiple facilities with centralized reporting |
| Advanced Analytics | 📋 | Peak hours, trends, and usage insights |
| Remote Device Management | 📋 | Remote status and firmware update workflow (future work) |
| Cross-platform Client | 📋 | macOS/Linux support (new client or alternative approach) |
| External Integrations | 📋 | SIS/HR/SSO integration (future work) |

---

## Quick Start (Backend - Laravel)
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Tap Rules (Toggle)
- If there is **no active session** on the slot → create session (**log in**).
- If there is an **active session** on the slot → end session (**log out**).

## License
This project is licensed under the **MIT License**. See `LICENSE` for details.

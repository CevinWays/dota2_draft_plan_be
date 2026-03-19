# API Endpoints

## Authentication

### Public Endpoints
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| POST | `/api/register` | Register a new user |
| POST | `/api/login` | Login and receive a token |

### Protected Endpoints
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| POST | `/api/logout` | Revoke current token |
| GET | `/api/me` | Get authenticated user info |

---

## Heroes
| Method | Endpoint | Note |
| :--- | :--- | :--- |
| GET | `/api/heroes` | List all heroes (searchable by `localized_name`, filterable by `primary_attr`) |
| GET | `/api/heroes/{id}` | Get details for a specific hero |

---

## Draft Plans
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| GET | `/api/draft-plans` | List all user's draft plans |
| POST | `/api/draft-plans` | Create a new draft plan |
| GET | `/api/draft-plans/{id}` | Get a specific draft plan |
| PUT | `/api/draft-plans/{id}` | Update a draft plan |
| DELETE | `/api/draft-plans/{id}` | Delete a draft plan |
| GET | `/api/draft-plans/{id}/summary` | Get a summarized view of a draft plan |

---

## Sub-domain Endpoints (Draft Plan Components)

### Bans
| Method | Endpoint |
| :--- | :--- |
| GET | `/api/draft-plans/{id}/bans` |
| POST | `/api/draft-plans/{id}/bans` |
| PUT | `/api/draft-plans/{id}/bans/{banId}` |
| DELETE | `/api/draft-plans/{id}/bans/{banId}` |

### Preferred Picks
| Method | Endpoint |
| :--- | :--- |
| GET | `/api/draft-plans/{id}/preferred-picks` |
| POST | `/api/draft-plans/{id}/preferred-picks` |
| PUT | `/api/draft-plans/{id}/preferred-picks/{pickId}` |
| DELETE | `/api/draft-plans/{id}/preferred-picks/{pickId}` |

### Enemy Threats
| Method | Endpoint |
| :--- | :--- |
| GET | `/api/draft-plans/{id}/enemy-threats` |
| POST | `/api/draft-plans/{id}/enemy-threats` |
| PUT | `/api/draft-plans/{id}/enemy-threats/{threatId}` |
| DELETE | `/api/draft-plans/{id}/enemy-threats/{threatId}` |

### Item Timings
| Method | Endpoint |
| :--- | :--- |
| GET | `/api/draft-plans/{id}/item-timings` |
| POST | `/api/draft-plans/{id}/item-timings` |
| PUT | `/api/draft-plans/{id}/item-timings/{timingId}` |
